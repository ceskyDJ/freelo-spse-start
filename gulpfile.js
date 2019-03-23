const gulp         = require('gulp');
const browserSync  = require('browser-sync').create();
const sass         = require('gulp-sass');
const autoprefixer = require('gulp-autoprefixer');

const srcRoot = 'src-front';
const outputRoot = 'www';

// Compile Sass & Inject Into Browser
gulp.task('sass', function() {
    return gulp.src([srcRoot + '/scss/*.scss'])
        .pipe(sass())
        .pipe(autoprefixer({
            browsers: ['last 2 versions'],
            cascade: false
        }))
        .pipe(gulp.dest("www/css"))
        .pipe(browserSync.stream());
});


// Watch Sass & Serve
gulp.task('serve', ['sass'], function() {
    browserSync.init({
        server: {
            baseDir: "./",
            index: srcRoot + "/html/index.html"
        },
        files: [
            outputRoot + "/css/*.css",
            outputRoot + "/images/**/*"
        ]
    });

    gulp.watch([srcRoot + '/scss/*.scss'], ['sass']);
    gulp.watch(srcRoot + "/html/*.html").on('change', browserSync.reload);
});

// Default Task
gulp.task('default', ['serve']);