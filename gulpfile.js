var elixir = require('laravel-elixir');

require('laravel-elixir-vueify');

/*
 |--------------------------------------------------------------------------
 | Elixir Asset Management
 |--------------------------------------------------------------------------
 |
 | Elixir provides a clean, fluent API for defining some basic Gulp tasks
 | for your Laravel application. By default, we are compiling the Sass
 | file for our application, as well as publishing vendor resources.
 |
 */

 elixir.config.js.browserify.watchify = {
    enabled: true,
    options: {
        poll: true
    }
}

elixir(function(mix) {
    mix.browserify([
        'app.js'
    ], 'public/js/app.js');
    mix.version([
        'public/js/app.js'
    ]);
});
