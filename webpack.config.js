const Encore = require('@symfony/webpack-encore');
const path = require('path');

// Configure runtime environment if not already set
if (!Encore.isRuntimeEnvironmentConfigured()) {
    Encore.configureRuntimeEnvironment(process.env.NODE_ENV || 'dev');
}

Encore
    // Directory where compiled assets will be stored
    .setOutputPath('public/build/')
    // Public path used by the web server to access the output path
    .setPublicPath('/build')

    // Entry configuration: app.js will generate app.js and app.css
    .addEntry('app', './assets/app.js')

    // Split files into smaller chunks for optimization
    .splitEntryChunks()

    // Enable single runtime chunk (recommended for most apps)
    .enableSingleRuntimeChunk()

    // Clean output directory before build
    .cleanupOutputBeforeBuild()

    // Enable source maps in dev
    .enableSourceMaps(!Encore.isProduction())

    .enablePostCssLoader()
    // Enable hashed filenames in prod
    .enableVersioning(Encore.isProduction())

    // Babel configuration
    .configureBabelPresetEnv((config) => {
        config.useBuiltIns = 'usage';
        config.corejs = '3.38';
    })

    // Enable Sass/SCSS support (uncomment if you need)
    //.enableSassLoader()

    // Add Webpack alias for controllers.json to fix Stimulus Bridge error
    .addAliases({
        '@symfony/stimulus-bridge/controllers.json': path.resolve(__dirname, 'assets/controllers.json')
    });

// Export the final configuration
module.exports = Encore.getWebpackConfig();
