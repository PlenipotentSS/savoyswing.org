// Node stuff
var exec = require('child_process').exec,
    sys = require('sys');


// Gulp Requires
var gulp = require('gulp'),
    gutil = require('gulp-util'),
    notify = require('gulp-notify'),
    sass = require('gulp-sass'),
    scsslint = require('gulp-scss-lint'),
    livereload = require('gulp-livereload');


// Directories
var SRC = 'app',
    DIST = 'public';


// SCSS Compiling and Minification
gulp.task('scss', function(){
  return gulp.src([SRC + '/scss/application.scss'])
    .pipe(scsslint({
      'config': '.scsslint.yml'
    }))
    .pipe(
      sass({
        outputStyle: 'expanded',
        debugInfo: true,
        lineNumbers: true,
        errLogToConsole: false,
        onError: function(err) {
          gutil.beep();
          notify().write(err);
        }
      })
    )
    .pipe( gulp.dest(DIST + '/') )
    .pipe(livereload());
});

// Gulp Watcher
gulp.task('watch', function() {
  gulp.watch(SRC + '/scss/**/*.scss', ['scss']);
  gulp.watch(SRC + '/scss/*.scss', ['scss']);
});


// Gulp Default Task
gulp.task('default', ['scss', 'watch']);
