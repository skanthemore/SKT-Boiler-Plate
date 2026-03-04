const { src, dest, watch, series, parallel } = require('gulp');
const sass         = require('gulp-sass')(require('sass'));
const postcss      = require('gulp-postcss');
const autoprefixer = require('autoprefixer');
const cssnano      = require('cssnano');
const terser       = require('gulp-terser');
const rename       = require('gulp-rename');
const sourcemaps   = require('gulp-sourcemaps');

// === CONFIG ===
const paths = {
	styles: {
		src: 'sass/style.scss',
		watch: 'sass/**/*.scss',
		dest: 'assets/css'
	},
	scripts: {
		src: ['assets/js/**/*.js', '!assets/js/min/**/*.js'],
		dest: 'assets/js/min'
	}

};

// === CSS ===
function buildStyles() {
	return src(paths.styles.src)
		.pipe(sourcemaps.init())
		.pipe(sass().on('error', sass.logError))
		.pipe(postcss([autoprefixer(), cssnano()]))
		.pipe(sourcemaps.write('.'))
		.pipe(dest(paths.styles.dest));
}

// === JS ===
function buildScripts() {
	return src(paths.scripts.src)
		.pipe(sourcemaps.init())
		.pipe(terser())
		.pipe(rename({ suffix: '.min' }))
		.pipe(sourcemaps.write('.'))
		.pipe(dest(paths.scripts.dest));
}

// === WATCH ===
function watchTask() {
	watch(paths.styles.watch, buildStyles);
	watch(paths.scripts.src, buildScripts);
}

// === TASKS ===
exports.styles = buildStyles;
exports.scripts = buildScripts;
exports.build = parallel(buildStyles, buildScripts);
exports.default = series(
	parallel(buildStyles, buildScripts),
	watchTask
);
