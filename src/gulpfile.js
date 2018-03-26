/* eslint-disable */

// constant requirements
const gulp = require('gulp');
const uglify = require('gulp-uglify');
const concat = require('gulp-concat');
const sass = require('gulp-sass');
const cssmin = require('gulp-clean-css');
const jshint = require('gulp-jshint');
const jsstyle = require('jshint-stylish');
const del = require('del');
const newer = require('gulp-newer');
const cached = require('gulp-cached');
const remember = require('gulp-remember');
const sourcemaps = require('gulp-sourcemaps');
const through2 = require('through2');
const source = require('vinyl-source-stream');
const buffer = require('vinyl-buffer');
const tinify = require('gulp-tinify');
const util = require('gulp-util');
const debug = require('gulp-debug');
const svgo = require('gulp-svgo');
const autoprefixer = require('gulp-autoprefixer');
const inlinesource = require('gulp-inline-source');
//const browserSync       = require('browser-sync').create();
//https://www.npmjs.com/package/gulp-inline-source

// create a boolean for development mode trigger (used for sourcemaps)
var devMode = true;

// define shorthand configuration variables
var config = {
    production: !!util.env.production,
    tinypng: {
        APIKEY: 'NepNXlL2RKHNHVAz9MJReWcBDFMUzohu'
    }
};
// TINYPNC::
// https://tinypng.com/ --> 500 images uploads per month
// not sure who's api that is but it was poached from silverscript

// define shorthand path variable references
var paths = {
    dist: {
        src: '../wordpress/wp-content/themes/espnplus',
        styles: '../wordpress/wp-content/themes/espnplus/css',
        scripts: '../wordpress/wp-content/themes/espnplus/js',
        images: '../wordpress/wp-content/themes/espnplus/imgs',
        svgs: '../wordpress/wp-content/themes/espnplus/svgs',
        svgpng: '../wordpress/wp-content/themes/espnplus/imgs/svgs/pngs'

        /*  preset for AMP theme -- Add to src and watch if we get there.
            amp-src:            '../wordpress/wp-content/themes/espnplus-amp/',
            amp-styles:         '../wordpress/wp-content/themes/espnplus-amp/css',
            amp-scripts:        '../wordpress/wp-content/themes/espnplus-amp/js',
            amp-images:         '../wordpress/wp-content/themes/espnplus-amp/imgs',
            amp-svgs:           '../wordpress/wp-content/themes/espnplus-amp/svgs',
            amp-svgpng:         '../wordpress/wp-content/themes/espnplus-amp/imgs/svgs/pngs'
        */
    },
    src: {
        critical_styles: '_themes/espnplus/scss/espnplus-critical.scss',
        non_critical_styles: '_themes/espnplus/scss/espnplus-non-critical.scss',
        top_scripts: '_themes/espnplus/js/espnplus-top.js',
        bottom_scripts: '_themes/espnplus/js/espnplus-bottom.js',
        images: '_images/*.{png,gif,jpg}',
        svgs: '_svgs/*.svg',
        svgpng: '_svgs/_fallback/*.png',
        unmin: {
            styles: '_unmin/scss/',
            scripts: '_unmin/js/'
        },
        vendor: {
            styles: '_vendor/scss/**/*.scss',
            // jquery: '_vendor/js/jquery.min.js',
            navigation: '_themes/espnplus/js/navigation.js',
            // jquery: './node_modules/jquery/dist/jquery.js',
            popper: '_vendor/js/popper.js',
            // bstrap: '_vendor/js/bootstrap.js',
            bstrap: './node_modules/bootstrap/dist/js/bootstrap.js',
            // pholder: '_vendor/js/jquery.placeholder.js',
            utils: './node_modules/bootstrap/js/dist/util.js',
            // collapse: '_vendor/js/bootstrap/src/collapse.js',
            bstrapindex:'./node_modules/bootstrap/js/dist/index.js',
            button: './node_modules/bootstrap/js/dist/button.js',
            dropdown: './node_modules/bootstrap/js/dist/dropdown.js',
            collapse: './node_modules/bootstrap/js/dist/collapse.js',
            // validate: '_vendor/js/jquery.validate.js',
            // easing: '_vendor/js/jquery.easing.js',
            skiplink: '_vendor/js/skip-link-focus-fix.js'
            // unveil: '_vendor/js/jquery_unveil/jquery.unveil.js' //https://luis-almeida.github.io/unveil/
        }
    },
    watch: {
        styles: '_themes/**/scss/**/*.scss',
        scripts: '_themes/**/js/*.js',
        images: '_images/*.{png,gif,jpg}',
        svgs: '_svgs/*.svg',
        svgpng: '_svgs/_fallback/*.png'
    }
};

// css minification options
var sassOptions = {
    // format: 'beautify',
    // format: 'keep-breaks'
};

// create a function for the object pass-through
function passthrough() {
    return through2.obj();
}

// create a function testing the boolean and pass a return depending on result
function isDev(fn) {
    if (devMode) {
        return fn;
    } else {
        return passthrough();
    }
}

// javascript validation
gulp.task('js_lint', () => {
    return gulp.src([paths.src.scripts, !paths.src.vendor], {
            since: gulp.lastRun('js_lint')
        })
        .pipe(jshint())
        .pipe(jshint.reporter('default'))
        .pipe(jshint.reporter('jshint-stylish', { beep: true }))
});

/* force del of older files
gulp.task('clean-js', function(cb) {
  del([
      '../Front-End/js/*.js',
      '../Front-End/js/*.map'
  ], { force: true }, cb)
});
*/

// javascript series
gulp.task('javascript', (done) => {
    gulp.parallel(
        //'clean-js',
        'top-javascript',
        'bottom-javascript'
    );
    done();
});
// javascript pipeline - top
//gulp.task('top-javascript', gulp.series('js_lint', () => {
gulp.task('top-javascript', () => {
    return gulp.src([
           //  paths.src.vendor.jquery,
            paths.src.vendor.navigation,
            // paths.src.vendor.bstrap,
            paths.src.top_scripts
        ])
        // .pipe(debug({title: '[1] Files in Stream:'}))
        .pipe(isDev(sourcemaps.init()))
        .pipe(concat('espnplus-top.js'))
        .pipe(gulp.dest(paths.src.unmin.scripts))
        .pipe(cached('top-javascript'))
        .pipe(uglify())
        .pipe(remember('top-javascript'))
        // .pipe(debug({title: '[2] Files in Stream:'}))
        .pipe(concat('espnplus-top.min.js'))
        .pipe(config.production ? util.noop() : (sourcemaps.write('.')))
        // .pipe(debug({title: '[3] Files in Stream:'}))
        .pipe(gulp.dest(paths.dist.scripts))
});
// javascript pipeline - bottom
//gulp.task('bottom-javascript', gulp.series('js_lint', () => {
gulp.task('bottom-javascript', () => {
    return gulp.src([
            //paths.src.vendor.unveil,
            //paths.src.vendor.pholder,
            
            paths.src.vendor.popper,
            paths.src.vendor.bstrap,
           // paths.src.vendor.bstrapindex,
            paths.src.vendor.utils,
           // paths.src.vendor.button,
           // paths.src.vendor.dropdown,
            paths.src.vendor.collapse,
            paths.src.vendor.skiplink,
            paths.src.bottom_scripts
        ])
        // .pipe(debug({title: '[1] Files in Stream:'}))
        .pipe(isDev(sourcemaps.init()))
        .pipe(concat('espnplus-bottom.js'))
        .pipe(gulp.dest(paths.src.unmin.scripts))
        .pipe(cached('bottom-javascript'))
        .pipe(uglify())
        .pipe(remember('bottom-avascript'))
        // .pipe(debug({title: '[2] Files in Stream:'}))
        .pipe(concat('espnplus-bottom.min.js'))
        .pipe(config.production ? util.noop() : (sourcemaps.write('.')))
        // .pipe(debug({title: '[3] Files in Stream:'}))
        .pipe(gulp.dest(paths.dist.scripts))
});

// scss series
gulp.task('scss', (done) => {
    gulp.parallel(
        'critical-scss',
        'non-critical-scss'
    );
    done();
});
// sass/css pipeline - critical
gulp.task('critical-scss', () => {
    return gulp.src([paths.src.critical_styles])
        .pipe(isDev(sourcemaps.init()))
        // .pipe(debug({title: '[1] Files in Stream:'}))
        .pipe(sass().on('error', sass.logError))
        .pipe(concat('espnplus-critical.css'))
        .pipe(gulp.dest(paths.src.unmin.styles))
        .pipe(cssmin(sassOptions))
        // .pipe(debug({title: '[2] Files in Stream:'}))
        .pipe(concat('espnplus-critical.min.css'))
        .pipe(config.production ? util.noop() : (sourcemaps.write('.')))
        // .pipe(debug({title: '[3] Files in Stream:'}))
        .pipe(gulp.dest(paths.dist.styles));
});
// sass/css pipeline - non-critical
gulp.task('non-critical-scss', () => {
    return gulp.src([paths.src.non_critical_styles])
        .pipe(isDev(sourcemaps.init()))
        // .pipe(debug({title: '[1] Files in Stream:'}))
        .pipe(sass().on('error', sass.logError))
        .pipe(concat('espnplus-non-critical.css'))
        .pipe(gulp.dest(paths.src.unmin.styles))
        .pipe(cssmin(sassOptions))
        // .pipe(debug({title: '[2] Files in Stream:'}))
        .pipe(concat('espnplus-non-critical.min.css'))
        .pipe(config.production ? util.noop() : (sourcemaps.write('.')))
        // .pipe(debug({title: '[3] Files in Stream:'}))
        .pipe(gulp.dest(paths.dist.styles))
});

// images compression
gulp.task('images', () => {
    return gulp.src(paths.src.images)
        .pipe(newer(paths.dist.images))
        .pipe(tinify(config.tinypng.APIKEY))
        .pipe(gulp.dest(paths.dist.images))
});

// svg compression
gulp.task('svgs', () => {
    return gulp.src(paths.src.svgs)
        .pipe(newer(paths.dist.svgs))
        .pipe(svgo())
        .pipe(gulp.dest(paths.dist.svgs))
});

// svg fallback creation
gulp.task('svgpng', () => {
    return gulp.src(paths.src.svgpng)
        .pipe(newer(paths.dist.svgpng))
        .pipe(tinify(config.tinypng.APIKEY))
        .pipe(gulp.dest(paths.dist.svgpng))
});

/*
// AMP'd Tasks :: From WALDEN :: Needs to be updated with paths and functions//
// ampd css file generation
gulp.task('espnplus-amp-css', function() {

  var postCssOpts = [
      autoprefixer({ browsers: ['last 2 versions', '> 2%'] }),
      cssnano
      //mqpacker
  ];
  return gulp.src('infosite/ampd/scss/amp-style.scss')
      .pipe(sourcemaps.init())
      .pipe(sass().on('error', sass.logError))
      .pipe(postcss(postCssOpts))
      .pipe(rename('amp-style.min.css'))
      .pipe(development(sourcemaps.write('.')))
      .pipe(development(gulp.dest('../Front-End/styles/infosite/')))
      .pipe(development(gulp.dest('../Front-End/css/')))
      .pipe(development(gulp.dest('../public_html/src/Project/Infosite/code/Styles/Infosite/')))
      .pipe(production(gulp.dest('../public_html/src/Project/Infosite/code/Styles/Infosite/')));
});
// ampd inline css into *amp*.html pages	
gulp.task('inlinesource', function() {
/ *  var options = { //https://github.com/popeindustries/inline-source#usage
      attribute: 'amp-custom'
};
* /

  //  this will apply any css changes to all amp pages in the directory and rewrite them to the Front-End directory
  return gulp.src('/ampd/*amp*.html')
      .pipe(inlinesource())
      .pipe(gulp.dest('../Front-End/'));
});

// ampd sequencer
gulp.task('ampinfo', function() {
  runSequence(
      //'clean-js',
      'espnplus-amp-css',
      'inlinesource'
  );
});
*/

// inform gulp to run through a series of watchers for its default task
gulp.task('default', gulp.series(
    gulp.parallel('critical-scss', 'non-critical-scss', 'top-javascript', 'bottom-javascript'),
    (done) => {
        //gulp.parallel('scss', 'javascript'), (done) => {
        gulp.watch(paths.watch.styles, gulp.parallel('critical-scss')),
            gulp.watch(paths.watch.styles, gulp.parallel('non-critical-scss')),
            // gulp.watch(paths.watch.images, gulp.parallel('images')),
            // gulp.watch(paths.watch.svgs, gulp.parallel('svgs')),
            // gulp.watch(paths.watch.svgpng, gulp.parallel('svgpng')),
            //gulp.watch(paths.watch.scripts,         gulp.parallel('js_lint', 'top-javascript')),
            //gulp.watch(paths.watch.scripts,         gulp.parallel('js_lint', 'bottom-javascript')),
            gulp.watch(paths.watch.scripts, gulp.parallel('top-javascript')),
            gulp.watch(paths.watch.scripts, gulp.parallel('bottom-javascript')),
            //gulp.watch(paths.watch.scripts,         gulp.parallel('javascript')),
            done();
    }));