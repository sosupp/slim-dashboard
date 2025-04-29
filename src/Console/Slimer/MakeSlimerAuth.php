<?php
namespace Sosupp\SlimDashboard\Console\Slimer;

use Illuminate\Support\Str;
use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;

class MakeSlimerAuth extends Command
{

    protected $signature = 'slimer:auth {model} {--guard= : what should the guard be called}';
    protected $description = 'Create a new multi-auth guard files
                            (model, migration, controller, routes and views.
                            Also update your apps auth.php to add settings)';

    protected Filesystem $files;

    public function __construct(Filesystem $files)
    {
        parent::__construct();
        $this->files = $files;
    }

    public function handle()
    {
        $name = $this->argument('model');
        $model = Str::studly($name);
        $guard = $this->option('guard') ?: $name;
        $guard = Str::snake($guard);
        $table = Str::plural(Str::snake($name));

        $this->createModel($model, $table);
        $this->createMigration($model, $table);

        // Controllers
        $this->createAuthController($model, $guard);
        $this->createVerifyEmailController($model, $guard);
        $this->createPasswordController($model, $guard);
        $this->createPasswordResetLinkController($model, $guard);
        $this->createEmailVerificationNatificationController($model, $guard);

        $this->createAuthRouteFile($model, $guard);

        $this->updateAppAuthFile();

    }

    protected function makeDirectory($path)
    {
        $directory = dirname($path);
        if (!$this->files->isDirectory($directory)) {
            $this->files->makeDirectory($directory, 0755, true);
        }
    }

    protected function createModel($model, $table)
    {
        $modelPath = app_path("Models/{$model}.php");

        if (!file_exists($modelPath)) {
            file_put_contents($modelPath, <<<PHP
            <?php

            namespace App\Models;

            use Illuminate\Foundation\Auth\User as Authenticatable;

            class {$model} extends Authenticatable
            {
                protected \$table = '{$table}';

                protected \$fillable = [];

                /**
                 * The attributes that should be hidden for serialization.
                 *
                 * @var array<int, string>
                 */
                protected \$hidden = [
                    'password',
                    'remember_token',
                    'telegram_token',
                ];

                /**
                 * The attributes that should be cast.
                 *
                 * @var array<string, string>
                 */
                protected \$casts = [
                    'email_verified_at' => 'datetime',
                    'password' => 'hashed',
                ];
            }
            PHP);

            return $this->info($model.' created.');
        }

        $this->info($model.' exist');
    }

    protected function createMigration($model, $table)
    {
        $timestamp = '2025_04_27_000000';

        $migrationPath = database_path("migrations/{$timestamp}_create_{$table}_table.php");

        if (!file_exists($migrationPath)) {
            file_put_contents($migrationPath, <<<PHP
            <?php

            use Illuminate\Database\Migrations\Migration;
            use Illuminate\Database\Schema\Blueprint;
            use Illuminate\Support\Facades\Schema;

            return new class extends Migration {
                public function up()
                {
                    Schema::create('{$table}', function (Blueprint \$table) {
                        \$table->id();
                        \$table->string('name');
                        \$table->string('email')->unique();
                        \$table->string('password');
                        \$table->rememberToken();
                        \$table->timestamps();
                    });

                    Schema::create('{$table}_password_reset_tokens', function (Blueprint \$table) {
                        \$table->string('email')->primary();
                        \$table->string('token');
                        \$table->timestamp('created_at')->nullable();
                    });
                }

                public function down()
                {
                    Schema::dropIfExists('{$table}');
                    Schema::dropIfExists('{$table}_password_reset_tokens');
                }
            };
            PHP
            );

            $this->info($model.' migration created');
            return;
        }

        return $this->info("The table $table exist");
    }

    protected function createAuthController($model, $guard)
    {
        $controller = $model.'AuthController.php';
        $useGuard = str($guard)->ucfirst()->value;
        $controllerPath = app_path("Http/Controllers/Auth/Slimer/$useGuard/$controller");

        $this->makeDirectory($controllerPath);

        if (!file_exists($controllerPath)) {
            file_put_contents($controllerPath, <<<PHP
            <?php

            namespace App\Http\Controllers\Auth\Slimer\\$useGuard;

            use Illuminate\Http\Request;
            use App\Http\Controllers\Controller;
            use Illuminate\Support\Facades\Auth;

            class {$model}AuthController extends Controller
            {
                public function showLoginForm()
                {
                    return view('auth.{$guard}.login');
                }

                public function login(Request \$request)
                {
                    \$credentials = \$request->only('email', 'password');

                    if (Auth::guard('{$guard}')->attempt(\$credentials)) {
                        return redirect()->intended('/');
                    }

                    return back()->withErrors(['email' => 'Invalid credentials.']);
                }

                public function logout()
                {
                    Auth::guard('{$guard}')->logout();
                    return redirect('/');
                }
            }
            PHP
            );

            $content = <<<HTML
            <x-guest-layout>
                <div class="login-form-wrapper">
                    <div class="logo-and-domain">
                        <x-application-logo />
                        <b>Platform</b>
                    </div>
                    <form class="login-form"
                        method="POST"
                        action="#">
                        @csrf
    
                        <x-inputs.special.text
                            type="email" label="Email" id="email"
                            name="email" :value="old('email')" autocomplete="email"
                            placeholder=""
                        />
    
                        <x-inputs.special.text
                            type="password" label="password" id="password"
                            name="password" :value="old('password')" placeholder=""
                            required
                        />
    
                        <button type="submit"
                            id="registerBtn">
                            login
                        </button>
    
                        <span class="footer-message">Contact admin if you have challenges.</span>
                    </form>
                </div>
            </x-guest-layout>
    
            HTML;
    
            $this->generateViewFile(model: $model, base: 'auth', filename: 'login', content: $content);

            return $this->info($controller.' created');
        }

        $this->info($controller . ' exist');

    }

    protected function createVerifyEmailController($model, $guard)
    {
        $controller = "{$model}VerifyEmailController.php";
        $useGuard = str($guard)->ucfirst()->value;
        $controllerPath = app_path("Http/Controllers/Auth/Slimer/$useGuard/$controller");

        if (!file_exists($controllerPath)) {
            file_put_contents($controllerPath, <<<PHP
            <?php

            namespace App\Http\Controllers\Auth\Slimer\\$useGuard;

            use App\Http\Controllers\Controller;
            use Illuminate\Auth\Events\Verified;
            use Illuminate\Foundation\Auth\EmailVerificationRequest;
            use Illuminate\Http\RedirectResponse;

            class {$model}VerifyEmailController extends Controller
            {
                public function __invoke(EmailVerificationRequest \$request): RedirectResponse
                {
                    if (\$request->user('{$guard}')->hasVerifiedEmail()) {
                        return redirect()->intended(route('dashboard', absolute: false).'?verified=1');
                    }

                    if (\$request->user('{$guard}')->markEmailAsVerified()) {
                        event(new Verified(\$request->user('{$guard}')));
                    }

                    return redirect()->intended(route('dashboard', absolute: false).'?verified=1');
                }
            }
            PHP
            );

            $this->info("$controller created");
            return;
        }

        return $this->info("$controller exist");
    }

    protected function createPasswordController($model, $guard)
    {
        $controller = "{$model}PasswordController.php";
        $useGuard = str($guard)->ucfirst()->value;
        $controllerPath = app_path("Http/Controllers/Auth/Slimer/$useGuard/$controller");

        if (!file_exists($controllerPath)) {
            file_put_contents($controllerPath, <<<PHP
            <?php

            namespace App\Http\Controllers\Auth\Slimer\\$useGuard;

            use App\Http\Controllers\Controller;
            use Illuminate\Http\RedirectResponse;
            use Illuminate\Http\Request;
            use Illuminate\Support\Facades\Hash;
            use Illuminate\Validation\Rules\Password;

            class {$model}PasswordController extends Controller
            {
                public function update(Request \$request): RedirectResponse
                {
                    \$validated = \$request->validateWithBag('updatePassword', [
                        'current_password' => ['required', 'current_password'],
                        'password' => ['required', Password::defaults(), 'confirmed'],
                    ]);

                    \$request->user('{$guard}')->update([
                        'password' => Hash::make(\$validated['password']),
                    ]);

                    return back()->with('status', 'password-updated');
                }
            }
            PHP
            );

            return $this->info("$controller created");
        }

        return $this->info($controller . ' exist');
    }

    protected function createPasswordResetLinkController($model, $guard)
    {
        $controller = "{$model}PasswordResetLinkController.php";
        $useGuard = str($guard)->ucfirst()->value;
        $controllerPath = app_path("Http/Controllers/Auth/Slimer/$useGuard/$controller");

        if (!file_exists($controllerPath)) {
            file_put_contents($controllerPath, <<<PHP
            <?php

            namespace App\Http\Controllers\Auth\Slimer\\$useGuard;

            use App\Http\Controllers\Controller;
            use Illuminate\Http\RedirectResponse;
            use Illuminate\Http\Request;
            use Illuminate\Support\Facades\Password;
            use Illuminate\View\View;

            class {$model}PasswordResetLinkController extends Controller
            {
                public function create(): View
                {
                    return view('auth.{$guard}.forgot-password');
                }

                public function store(Request \$request): RedirectResponse
                {
                    \$request->validate([
                        'email' => ['required', 'email'],
                    ]);

                    // We will send the password reset link to this user. Once we have attempted
                    // to send the link, we will examine the response then see the message we
                    // need to show to the user. Finally, we'll send out a proper response.
                    \$status = Password::sendResetLink(
                        \$request->only('email')
                    );

                    return \$status == Password::RESET_LINK_SENT
                        ? back()->with('status', __(\$status))
                        : back()->withInput(\$request->only('email'))
                            ->withErrors(['email' => __(\$status)]);
                }
            }
            PHP
            );

            $content = <<<HTML
            <x-guest-layout>
                <div class="register-form-wrapper">
                    <div class="register-logo">
                        <x-application-logo />
                    </div>
    
    
                    <form class="form-wrapper" method="POST" action="#">
                        <x-auth-session-status class="mb-4 success-bg" :status="session('status')" />
                        <p class="form-heading">Reset password</p>
                        @csrf
                        <div class="text-sm text-gray-600">
                            {{ __('Forgot your password? No problem. Please enter your email address used for the account and we will email you a password reset link.') }}
                        </div>
    
                        <x-inputs.text
                            type="email" label="Email" :allowlabel="false"
                            id="email" name="email" :value="old('email')"
                            autocomplete="email" required autofocus
                            placeholder="Email address"
                        />
    
                        <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="#">
                            {{ __('Already registered?') }}
                        </a>
    
                        <button type="submit"
                            id="registerBtn">
                            {{ __('Email Password Reset Link') }}
                        </button>
    
                    </form>
    
                </div>
            </x-guest-layout>
    
    
            HTML;
    
            $this->generateViewFile(model: $guard, base: 'auth', filename: 'forgot-password', content: $content);

            return $this->info("$controller created");
        }

        return $this->info("$controller exist");

    }

    protected function createEmailVerificationNatificationController($model, $guard)
    {
        $controller = "{$model}EmailVerificationNotificationController.php";
        $useGuard = str($guard)->ucfirst()->value;
        $controllerPath = app_path("Http/Controllers/Auth/Slimer/$useGuard/$controller");

        if (!file_exists($controllerPath)) {
            file_put_contents($controllerPath, <<<PHP
            <?php

            namespace App\Http\Controllers\Auth\Slimer\\$useGuard;

            use App\Http\Controllers\Controller;
            use Illuminate\Http\RedirectResponse;
            use Illuminate\Http\Request;

            class {$model}EmailVerificationNotificationController extends Controller
            {
                public function store(Request \$request): RedirectResponse
                {
                    if (\$request->user('{$guard}')->hasVerifiedEmail()) {
                        return redirect()->intended(route('dashboard', absolute: false));
                    }

                    \$request->user('{$guard}')->sendEmailVerificationNotification();

                    return back()->with('status', 'verification-link-sent');
                }
            }
            PHP
            );

            return $this->info("$controller created");
        }

        return $this->info("$controller exist");
    }

    protected function generateViewFile($model, $base, $filename, $content)
    {
        $viewName = $filename;
        $model = str($model)->lower()->value;

        if($filename = null){
            $viewName = str($model)->replace('\\', '.')->explode('.')->map(function($item){
                return str($item)->kebab();
            })->implode('\\');
        }

        $filePath = resource_path("views/$base/$model/$viewName.blade.php");

        // Ensure directory exists
        if (!file_exists(($filePath))) {
            // mkdir(dirname($filePath), 0777, true);

            $this->makeDirectory($filePath);

            // Write the file
            file_put_contents($filePath, $content);
            $this->info("View file created at: $filePath");
            return;
        }

        $this->warn("The {$viewName} file exist");
        return;

        // dd($base, $filePath, $viewName);
    }

    protected function createAuthRouteFile($model, $guard)
    {
        $routeFile = Str::snake($model) . '.php';
        $routePath = base_path("routes/{$routeFile}");
        $content = <<<PHP
        <?php
        use Illuminate\Support\Facades\Route;
        use App\Http\Controllers\\Auth\\Slimer\\{$model}AuthController;
        use App\Http\Controllers\\Auth\\Slimer\\{$model}VerifyEmailController;
        use App\Http\Controllers\\Auth\\Slimer\\{$model}PasswordResetLinkController;
        use App\Http\Controllers\\Auth\\Slimer\\{$model}PasswordController;
        use App\Http\Controllers\\Auth\\Slimer\\{$model}EmailVerificationPromptController;
        use App\Http\Controllers\\Auth\\Slimer\\{$model}EmailVerificationNotificationController;
        use App\Http\Controllers\\Auth\\Slimer\\{$model}ConfirmablePasswordController;

        Route::prefix('{$guard}')->group(function () {
            Route::middleware('guest')->group(function () {
                Route::get('/login', [{$model}AuthController::class, 'showLoginForm'])->name('{$guard}.login');

                Route::post('/login', [{$model}AuthController::class, 'login'])->name('{$guard}.login.store');

                Route::get('forgot-password', [{$model}PasswordResetLinkController::class, 'create'])
                    ->name('{$guard}.password.request');

                Route::post('forgot-password', [{$model}PasswordResetLinkController::class, 'store'])
                    ->name('{$guard}.password.email');
            });

            Route::middleware('auth:{$guard}')->group(function () {
                Route::get('verify-email', {$model}EmailVerificationPromptController::class)
                    ->name('{$guard}.verification.notice');

                Route::get('verify-email/{id}/{hash}', {$model}VerifyEmailController::class)
                    ->middleware(['signed', 'throttle:6,1'])
                    ->name('{$guard}.verification.verify');

                Route::post('email/verification-notification', [{$model}EmailVerificationNotificationController::class, 'store'])
                    ->middleware('throttle:6,1')
                    ->name('{$guard}.verification.send');

                Route::get('confirm-password', [{$model}ConfirmablePasswordController::class, 'show'])
                    ->name('{$guard}.password.confirm');

                Route::post('confirm-password', [{$model}ConfirmablePasswordController::class, 'store']);

                Route::put('password', [{$model}PasswordController::class, 'update'])->name('{$guard}.password.update');
                Route::post('/logout', [{$model}AuthController::class, 'logout'])->name('{$guard}.logout');
            });



        });
        PHP;

        // Ensure directory exists
        if (!file_exists($routePath)) {
            $this->makeDirectory($routePath);
            // Write the file
            file_put_contents($routePath, $content);
            $this->info("Route file created at: $routePath");
            return;
        }

        $this->warn("The route $routeFile file exist");
        return;
    }

    protected function updateAppAuthFile()
    {
        $this->line('');
        $this->alert('Remember to update auth.php config file to add guards and providers');
    }

}
