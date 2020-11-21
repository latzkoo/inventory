let mix = require('laravel-mix');

mix.sass('resources/sass/app.scss', 'public/css')
	.scripts([
		'~/jquery/dist/jquery.js',
		'resources/js/numeric.js',
		'resources/js/app.js'
	], 'public/js/app.js')
	.copyDirectory('resources/images', 'public/images')
	.browserSync({proxy: 'http://raktar.test'})
	.disableNotifications();

if (mix.inProduction()) {
	mix.version();
}
