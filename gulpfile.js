const elixir = require('laravel-elixir');


elixir(function(mix) {
    mix.sass('app.scss')
        .webpack('app.js')
        .copy('resources/assets/images', 'public/images')
        .version(['css/app.css', 'js/app.js','public/images']);

});


console.log(elixir);
