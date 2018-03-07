/* eslint-disable */

// constant requirements
const gulp              = require('gulp');
const uglify            = require('gulp-uglify');
const concat            = require('gulp-concat');
const sass              = require('gulp-sass');
const cssmin            = require('gulp-clean-css');
const jshint            = require('gulp-jshint');
const jsstyle           = require('jshint-stylish');
const del               = require('del');
const newer             = require('gulp-newer');
const cached            = require('gulp-cached');
const remember          = require('gulp-remember');
const sourcemaps        = require('gulp-sourcemaps');
const through2          = require('through2');
const source            = require('vinyl-source-stream');
const buffer            = require('vinyl-buffer');
const tinify            = require('gulp-tinify');
const util              = require('gulp-util');
const debug             = require('gulp-debug');
const svgo              = require('gulp-svgo');
const autoprefixer      = require('gulp-autoprefixer');
const inlinesource      = require('gulp-inline-source'); //https://www.npmjs.com/package/gulp-inline-source

// create a boolean for development mode trigger (used for sourcemaps)
var devMode = true;

// define shorthand configuration variables
var config = {
  production:   !!util.env.production,
  tinypng: {
    APIKEY:     'NepNXlL2RKHNHVAz9MJReWcBDFMUzohu'
  }
};
// https://tinypng.com/ --> 500 images uploads per month
// not sure who's api that is but it was poached from silverscript

// define shorthand path variable references
var paths = {
  dist:  {
    src:            '../wordpress/wp-content/themes/espnplus/',
    styles:         '../wordpress/wp-content/themes/espnplus/css',
    scripts:        '../wordpress/wp-content/themes/espnplus/js',
    images:         '../wordpress/wp-content/themes/espnplus/imgs',
    svgs:           '../wordpress/wp-content/themes/espnplus/svgs',
    svgpng:         '../public_html/wp-content/themes/ssic-deo/imgs/svgs/pngs'
  },
  src: {
    styles:         '_theme/espnplus/scss/style.scss',
    scripts:        '_theme/espnplus/js/scripts.js',
    images:         '_images/*.{png,gif,jpg}',
    svgs:           '_svgs/*.svg',
    svgpng:         '_svgs/_fallback/*.png',
    vendor: {
      styles:       '_sass/vendor/**/*.scss',
      jquery:       '_javascript/vendor/jquery/3.2.1/jquery.min.js',
      pholder:      '_javascript/vendor/jquery_placeholder/2.3.1/jquery.placeholder.js',
      validate:     '_javascript/vendor/jquery_validate/1.14.0/jquery.validate.js',
      smpl_val:     '_javascript/vendor/jquery_simple-validate/0.3/jquery.simpleValidate.js',
      bstrap:       '_javascript/vendor/bootstrap/3.3.5/bootstrap.js',
      tblstack:     '_javascript/vendor/stackable/1.0.2/stacktable_aria.js',
      unveil:       '_javascript/vendor/jquery_unveil/1.3.0/jquery.unveil.js',
      // resizer:      '_javascript/vendor/wanker/0.1.2/jquery.wanker.min.js'
    }
  },
  watch: {
    cms:            '_sass/theme/cms/*.scss',
    styles:         '_sass/**/*.scss',
    scripts:        '_javascript/*.js',
    images:         '_images/*.{png,gif,jpg}',
    svgs:           '_svgs/*.svg',
    svgpng:         '_svgs/_fallback/*.png'
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
  if(devMode) {
    return fn;
  } else {
    return passthrough();
  }
}

// javascript validation
gulp.task('js_lint', () => {
  return gulp.src(['_javascript/*.js', '!_javascript/vendor/**/*.js'], {
      since: gulp.lastRun('js_lint')
    })
    .pipe(jshint())
    .pipe(jshint.reporter('default'))
    .pipe(jshint.reporter('jshint-stylish', { beep: true }))
});

// javascript pipeline
gulp.task('javascript', gulp.series('js_lint', () => {
    return gulp.src([
        paths.src.vendor.jquery,
        paths.src.vendor.bstrap,
        // paths.src.vendor.pholder,
        // paths.src.vendor.validate,
        paths.src.vendor.smpl_val,
        paths.src.vendor.tblstack,
        // paths.src.ssic_forms,
        // paths.src.vendor.resizer,
        paths.src.vendor.unveil,
        paths.src.scripts,
        paths.src.scriptsTealium
        ])
      // .pipe(debug({title: '[1] Files in Stream:'}))
      .pipe(isDev(sourcemaps.init()))
      .pipe(cached('javascript'))
      .pipe(uglify())
      .pipe(remember('javascript'))
      // .pipe(debug({title: '[2] Files in Stream:'}))
      .pipe(concat('ssic-deo.min.js'))
      .pipe(config.production ? util.noop() : (sourcemaps.write('.')))
      // .pipe(debug({title: '[3] Files in Stream:'}))
      .pipe(gulp.dest(paths.dist.scripts))
}));

// sass/css pipeline
gulp.task('sass', () => {
  return gulp.src([paths.src.styles, paths.src.vendor.styles])
    .pipe(isDev(sourcemaps.init()))
    // .pipe(debug({title: '[1] Files in Stream:'}))
    .pipe(sass().on('error', sass.logError))
    .pipe(cssmin(sassOptions))
    // .pipe(debug({title: '[2] Files in Stream:'}))
    .pipe(concat('ssic-deo.min.css'))
    .pipe(config.production ? util.noop() : (sourcemaps.write('.')))
    // .pipe(debug({title: '[3] Files in Stream:'}))
    .pipe(gulp.dest(paths.dist.styles))
});

// cms specific styling
gulp.task('cms', () => {
  return gulp.src(paths.src.cms)
    .pipe(isDev(sourcemaps.init()))
    // .pipe(debug({title: 'Files in the stream before gulp-sass:'}))
    .pipe(sass())
    .pipe(cssmin())
    // .pipe(debug({title: 'Files in the stream after gulp-cssmin:'}))
    .pipe(concat('cms_custom.min.css'))
    .pipe(config.production ? util.noop() : (sourcemaps.write('.')))
    // .pipe(debug({title: 'Files in the stream before gulp-dest:'}))
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

// inform gulp to run through a series of watchers for its default task
gulp.task('default', gulp.series(
  gulp.parallel('images', 'svgs', 'svgpng', 'cms', 'sass', 'javascript'), (done) => {
    gulp.watch([paths.watch.styles, '!_sass/theme/cms/*.scss'],   
    gulp.parallel('sass')),
    gulp.watch(paths.watch.cms,                                   gulp.parallel('cms')),
    gulp.watch(paths.watch.images,                                gulp.parallel('images')),
    gulp.watch(paths.watch.svgs,                                  gulp.parallel('svgs')),
    gulp.watch(paths.watch.svgpng,                                gulp.parallel('svgpng')),
    gulp.watch([paths.watch.scripts],                              
    gulp.parallel('js_lint', 'javascript')),
    done();
  }
));