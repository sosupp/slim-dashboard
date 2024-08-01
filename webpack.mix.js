const mix = require('laravel-mix');

mix.setPublicPath('public')
    .js('resources/js/app.js', 'public/js')
    .postCss('resources/css/dashboard/dashboard.css', 'public/css/dashboard')
    .postCss('resources/css/dashboard/form.css', 'public/css/dashboard')
    .postCss('resources/css/dashboard/inputs.css', 'public/css/dashboard')
    .postCss('resources/css/dashboard/modal.css', 'public/css/dashboard')
    .postCss('resources/css/dashboard/table.css', 'public/css/dashboard')
    .postCss('resources/css/dashboard/utilities.css', 'public/css/dashboard')
    .postCss('resources/css/dashboard/wrappers.css', 'public/css/dashboard')
    .version();

mix.options({
    postCss: [
        require('postcss-minify')
    ]
})
