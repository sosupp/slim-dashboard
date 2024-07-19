const mix = require('laravel-mix');

mix.js('resources/assets/js/app.js', 'public/js')
    .postCss('resources/assets/css/dashboard/dashboard.css', 'public/css/dashboard')
    .postCss('resources/assets/css/dashboard/form.css', 'public/css/dashboard')
    .postCss('resources/assets/css/dashboard/inputs.css', 'public/css/dashboard')
    .postCss('resources/assets/css/dashboard/modal.css', 'public/css/dashboard')
    .postCss('resources/assets/css/dashboard/table.css', 'public/css/dashboard')
    .postCss('resources/assets/css/dashboard/utilities.css', 'public/css/dashboard')
    .postCss('resources/assets/css/dashboard/wrappers.css', 'public/css/dashboard')
    .version();

mix.options({
    postCss: [
        require('postcss-minify')
    ]
})
