![alt text](https://image.prntscr.com/image/P8uLsWSVRveE50LjT3l8og.png "Project Requirements")

## task runner requirements:
- Node => `7.7.3`
- NPM => `4.6.1`
- Gulp => `4.0`
- ECMA6

## prerequisite process:
Are you a new developer to the company? If so, following the instruction guide here:
- http://wiki.jellyfish.tmp/index.php/Sass_Set_Up_on_a_Dev_Container


## "task runner" install:
```bash
cd /home/sites/{repository_name}/task_runner
npm install
gulp
```

## functions.php custom partials:
Files that define how elements are parsed and painted within the DOM.
```bash
nano /home/sites/{repository_name}/public_html/wp-content/themes/{theme_name}/jf_addons/*.php
```

## templates partials:
Files that define individual construct elements of a page _(parts, includes, globals, etc.)_.
```bash
cd /home/sites/{repository_name}/public_html/wp-content/themes/{theme_name}/jf_blocks/*.php
```

## troubleshooting guide:
- Help! Looks like the `wp_debug` definition is no longer in the functions.php file! 
  - Formerly, the `define('WP_DEBUG', true);` was controlled within the WordPress `wp-config.php` file. We've modified that approach and defined the `wp-config.php` definitions within a **project specific** `.ini` file, located in your jellyfish container's `/etc/jellyfish` directory:
```bash
cd /etc/jellyfish; ll
```
- Error: Cannot find module 'es6-promise'
```bash
cd /home/sites/{repository_name}/task_runner
npm install es6-promise
```
- Trying to run `gulp` is spitting out the following error:
```bash
/usr/local/lib/node_modules/gulp/bin/gulp.js:129
    gulpInst.start.apply(gulpInst, toRun);
```
- 
  - You will need to verify that gulp-cli is installed at the global level and not the project level by running `npm i -g gulp-cli`
  
- Gulp series is not a function error
```bash
/home/sites/wp_silverscript/task_runner/gulpfile.js:95
gulp.task('javascript', gulp.series('js_lint', () => {
```
-
  - `gulp.series` is a `>=gulp 4.0.x` function
  - You **must** install a local _(to the project)_ instance of Gulp 4.0
  - See: https://www.liquidlight.co.uk/blog/article/how-do-i-update-to-gulp-4/
![alt text](https://image.prntscr.com/image/EzGVQ3sxRS_m89UVX2EHYQ.png "Gulp global vs Gulp local")
