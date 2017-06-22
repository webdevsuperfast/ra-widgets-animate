var gulp = require('gulp'),
    sass = require('gulp-sass'),
    autoprefixer = require('gulp-autoprefixer'),
    rename = require('gulp-rename'),
    concat = require('gulp-concat'),
    notify = require('gulp-notify'),
    cache = require('gulp-cache'),
    vinylpaths = require('vinyl-paths'),
    cleancss = require('gulp-clean-css'),
    cmq = require('gulp-combine-mq'),
    prettify = require('gulp-jsbeautifier'),
    concatcss = require('gulp-concat-css'),
    uglify = require('gulp-uglify'),
    foreach = require('gulp-flatmap'),
    changed = require('gulp-changed'),
    vinylpaths = require('vinyl-paths'),
    merge = require('merge-stream'),
    del = require('del');

// CSS
gulp.task('styles', function(){
    var cssStream = gulp.src('bower_components/aos/dist/aos.css')
        .pipe(concat('aos.css'))
    
    var mergeStream = merge(cssStream)
        .pipe(concat('app.css'))
        .pipe(autoprefixer('last 2 version', 'safari 5', 'ie 8', 'ie 9', 'opera 12.1', 'ios 6', 'android 4'))
        .pipe(cmq())
        .pipe(gulp.dest('temp/css'))
        .pipe(rename('app.css'))
        .pipe(cleancss())
        .pipe(gulp.dest('assets/css'))
        .pipe(notify({ message: 'Styles task complete' }));
    
    return mergeStream;
} );

// Vendor JS
gulp.task('scripts', function(){
    return gulp.src([
        'bower_components/aos/dist/aos.js'
    ])
    .pipe(foreach(function(stream, file){
        return stream
            .pipe(changed('temp/js'))
            .pipe(uglify())
            .pipe(rename({suffix: '.min'}))
            .pipe(gulp.dest('temp/js'))
    }))
    .pipe(gulp.dest('public/js'))
    .pipe(notify({ message: 'Scripts task complete' }));
});

// Clean temp folder
gulp.task('clean:temp', function(){
    return gulp.src('temp/*')
    .pipe(vinylpaths(del))
});

// Default task
gulp.task('default', ['clean:temp'], function() {
    gulp.start('styles', 'watch');
    gulp.start('scripts', 'watch');
});

// Watch
gulp.task('watch', function() {
    // Watch .scss files
    gulp.watch(['assets/scss/*.scss', 'assets/sass/**/*.scss'], ['styles']);
    gulp.watch(['assets/js/sources/*.js'], ['scripts']);
});
