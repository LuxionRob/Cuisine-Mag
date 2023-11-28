const mix = require('laravel-mix')

mix
  .js('resources/js/app.js', 'public/js')
  .react()
  .postCss('resources/css/app.css', 'public/css', [require('tailwindcss'), require('autoprefixer')])

mix.copy('node_modules/@fortawesome/fontawesome-free/webfonts', 'public/fonts')
