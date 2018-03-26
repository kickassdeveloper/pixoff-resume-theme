const { mix } = require('laravel-mix');

mix.setPublicPath('./dist/')

mix.js('js/app.js', './');
mix.sass('sass/app.scss', './');
mix.disableNotifications();
mix.browserSync({
	proxy: 'http://zivorad.test',
	files: ["./sass/", "./js/", "./template-parts/", "./piklist/", "./*.php"]
});

if (mix.inProduction()) {
	mix.version();
}