const elixir = require('laravel-elixir');
elixir(function(mix) {
    mix.scriptsIn('resources/assets/js');
    mix.styles([
        'app.css',
        'bootstrap.min.css',
        'ekko-lightbox.min.css',
        'jquery.dynatable.css',
        'tanks.css',
        'ubuntufont.css',
    ]);
    mix.copy('resources/assets/images', 'public/images');
    mix.version(['css/all.css', 'js/all.js','public/images']);
});


