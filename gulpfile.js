const elixir = require('laravel-elixir');
elixir(function(mix) {
    mix.scriptsIn('resources/assets/js');
});
elixir(function(mix) {
    mix.styles([
        'app.css',
        'bootstrap.min.css',
        'ekko-lightbox.min.css',
        'jquery.dynatable.css',
        'tanks.css'
    ]);
    mix.copy('resources/assets/images', 'public/images');
});
elixir(function (mix) {
    mix.version(['css/all.css', 'js/all.js','public/images']);
});


