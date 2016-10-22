const elixir = require('laravel-elixir');

/*
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
*/

// gulpfile.js

elixir(function(mix) {
    mix.sass('app.scss')
        .webpack('app.js')
        .copy('resources/assets/images', 'public/images')
        .version(['css/app.css', 'js/app.js','public/images']);

});


console.log(elixir);
