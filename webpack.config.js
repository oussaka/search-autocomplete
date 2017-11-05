var Encore = require('@symfony/webpack-encore');

Encore
  // directory where all compiled assets will be stored
  .setOutputPath('web/assets/')

  // what's the public path to this directory (relative to your project's document root dir)
  .setPublicPath('/assets')

  // empty the outputPath dir before each build
  .cleanupOutputBeforeBuild()

  // will output as web/build/app.js
  .addEntry('app', './assets/js/app.js')

  // will output as web/build/global.css
  .addStyleEntry('style', './assets/sass/app.scss')

  // allow sass/scss files to be processed
  .enableSassLoader(function(loaderOptions) {
      // this is our special option
      loaderOptions.resolve_url_loader = false

      // this is an option to be passed to sass-loader
      // loaderOptions.includePaths = []
  })

  // allow legacy applications to use $/jQuery as a global variable
  .autoProvidejQuery()

  // allow legacy applications to use Tether as a global variable
  .autoProvideVariables({
    'Tether': 'tether'
  })

  .enableSourceMaps(!Encore.isProduction())

  // create hashed filenames (e.g. app.abc123.css)
  // .enableVersioning()
;

const config = Encore.getWebpackConfig();
config.watchOptions = {
    poll: true,
};

// export the final configuration
module.exports = config;