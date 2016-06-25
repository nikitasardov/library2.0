/*var minifyCss   = require('gulp-minify-css');
	less        = require('gulp-less');
	notify      = require('gulp-notify');
	autoprefix = require('gulp-autoprefixer');
	browserSync = require('browser-sync');
	reload      = browserSync.reload;
	concat = require('gulp-concat');*/
var gulp        = require('gulp');
	gulpLoadPlugins = require('gulp-load-plugins');
	plugins = gulpLoadPlugins();
    pngquant = require('imagemin-pngquant');
	browserSync = require('browser-sync');
	reload  = browserSync.reload;

	pathToPublish = '../../../xampp/htdocs/library';
	pathToBuild = 'build/library';
	
	ht = {
		library:['dev/library/**/*.ht*']
	};

	html = {
		cosmos:['dev/cosmos/index.html'],
		psd_1:['dev/psd-1/index.html'],
		final:['dev/final/index.html'],
		library:['dev/library/index.html']
	};
	
	php = {
		library:['dev/library/**/*.php']
	};	
	
	js = {
		library:['dev/library/js/*.*']
	};
	
	css	= {
		cosmos:['dev/cosmos/**/*.*ss'],
		header_cosmos: ['dev/cosmos/css/header/header.les_s'],
		psd_1:['dev/psd-1/**/*.*ss'],
		header_psd_1: ['dev/psd-1/css/header/header.les_s'],
		final:['dev/final/**/*.*ss'],
		header_final: ['dev/final/css/1_header/header.les_s'],
		library: ['dev/library/css/styles.css']
	};
	
	img	= {
		cosmos:['dev/cosmos/img/*.*'],
		psd_1:['dev/psd-1/img/*.*'],
		final:['dev/final/img/*.*'],
		library: ['dev/library/img/*.*']
	};

//////////
// HTML //
//////////
gulp.task('html_cosmos', function(){
  return gulp.src(html.cosmos)
    .pipe(gulp.dest('build/cosmos'))
    // .pipe(reload({stream:true}))
	.pipe(plugins.notify('cosmos HTML built! Check new files'));
});
gulp.task('html_psd_1', function(){
  return gulp.src(html.psd_1)
    .pipe(gulp.dest('build/psd-1'))
    .pipe(reload({stream:true}))
	.pipe(plugins.notify('psd-1 HTML built! Check new files'));
});
gulp.task('html_final', function(){
  return gulp.src(html.final)
    .pipe(gulp.dest('build/final'))
    .pipe(reload({stream:true}))
	.pipe(plugins.notify('FINAL HTML built! Check new files'));
});
gulp.task('html_library', function(){
  return gulp.src(html.library)
    .pipe(gulp.dest('build/library'))
	.pipe(gulp.dest(pathToPublish))
    .pipe(reload({stream:true}))
	.pipe(plugins.notify('Library HTML built.'));
});

//////////
// PHP  //
//////////
gulp.task('php_library', function(){
  return gulp.src(php.library)
    .pipe(gulp.dest(pathToBuild))
    .pipe(gulp.dest(pathToPublish))
    .pipe(reload({stream:true}))
	.pipe(plugins.notify('Library PHP built.'));
});

//////////
// .ht*  //
//////////
gulp.task('ht_library', function(){
  return gulp.src(ht.library)
    .pipe(gulp.dest(pathToBuild))
    .pipe(gulp.dest(pathToPublish))
    .pipe(reload({stream:true}))
	.pipe(plugins.notify('Library *.ht* built.'));
});

//////////
// .ttf  //
//////////
gulp.task('ttf_library', function(){
  return gulp.src('dev/library/fonts/*.*')
    .pipe(gulp.dest(pathToBuild+'/fonts'))
    .pipe(gulp.dest(pathToPublish+'/fonts'))
    .pipe(reload({stream:true}))
	.pipe(plugins.notify('Library FONT built.'));
});

//////////
// JS   //
//////////
gulp.task('js_library', function(){
  return gulp.src(js.library)
    .pipe(gulp.dest('build/library/js'))
    .pipe(gulp.dest(pathToPublish+'/js'))
    .pipe(reload({stream:true}))
	.pipe(plugins.notify('Library JS built.'));
});

//////////////	
// LESS+CSS //
//////////////
gulp.task('header_cosmos', function(){
  return gulp.src(css.header_cosmos)
	.pipe(plugins.less())
	.pipe(plugins.autoprefixer({
		browsers: ['last 2 version'],
		cascade: false
	}))
    .pipe(plugins.minifyCss())
    .pipe(gulp.dest('build/cosmos/css'))
    // .pipe(reload({stream:true}))
	.pipe(plugins.notify('cosmos CSS for header built! Check new files'));
});

gulp.task('css_cosmos', function(){
  return gulp.src(css.cosmos)
	.pipe(plugins.concat('css/style.css'))
	.pipe(plugins.less())
	.pipe(plugins.autoprefixer({
		browsers: ['last 2 version'],
		cascade: false
	}))
    .pipe(plugins.minifyCss())
    .pipe(gulp.dest('build/cosmos'))
    // .pipe(reload({stream:true}))
	.pipe(plugins.notify('cosmos CSS built! Check new files'));
});

gulp.task('header_psd_1', function(){
  return gulp.src(css.header_psd_1)
	.pipe(plugins.less())
	.pipe(plugins.autoprefixer({
		browsers: ['last 2 version'],
		cascade: false
	}))
    .pipe(plugins.minifyCss())
    .pipe(gulp.dest('build/psd-1/css'))
    .pipe(reload({stream:true}))
	.pipe(plugins.notify('psd-1 CSS for header built! Check new files'));
});

gulp.task('css_psd_1', function(){
  return gulp.src(css.psd_1)
	.pipe(plugins.less())
	.pipe(plugins.autoprefixer({
		browsers: ['last 2 version'],
		cascade: false
	}))
    .pipe(plugins.minifyCss())
	.pipe(plugins.concat('css/style.css'))
    .pipe(gulp.dest('build/psd-1'))
    .pipe(reload({stream:true}))
	.pipe(plugins.notify('psd-1 CSS built! Check new files'));
});



gulp.task('header_final', function(){
  return gulp.src(css.header_final)
	.pipe(plugins.less())
	.pipe(plugins.autoprefixer({
		browsers: ['last 2 version'],
		cascade: false
	}))
    .pipe(plugins.minifyCss())
    .pipe(gulp.dest('build/final/css'))
    .pipe(reload({stream:true}))
	.pipe(plugins.notify('FINAL CSS for header built! Check new files'));
});

gulp.task('css_final', function(){
  return gulp.src(css.final)
	.pipe(plugins.concat('css/style.css'))
// 				.pipe(gulp.dest('dev/css'))
	.pipe(plugins.less())
	.pipe(plugins.autoprefixer({
		browsers: ['last 2 version'],
		cascade: false
	}))
    .pipe(plugins.minifyCss())
    .pipe(gulp.dest('build/final'))
    .pipe(reload({stream:true}))
	.pipe(plugins.notify('FINAL CSS built! Check new files'));
});




gulp.task('css_library', function(){
  return gulp.src(css.library)
//	.pipe(plugins.concat('css/styles.css'))
// 				.pipe(gulp.dest('dev/css'))
	.pipe(plugins.less())
	.pipe(plugins.autoprefixer({
		browsers: ['last 2 version'],
		cascade: false
	}))
    .pipe(plugins.minifyCss())
    .pipe(gulp.dest('build/library/css'))
    .pipe(gulp.dest(pathToPublish+'/css'))
    .pipe(reload({stream:true}))
	.pipe(plugins.notify('Library CSS built.'));
});

/////////	
// IMG //
/////////
gulp.task('img_cosmos', function(){
  return gulp.src(img.cosmos)
	.pipe(plugins.imagemin({
		progressive: true,
		svgoPlugins: [{removeViewBox:false}],
		use: [pngquant()],
		interlaced: true
	}))
    .pipe(gulp.dest('build/cosmos/img'))
    // .pipe(reload({stream:true}))
	/* .pipe(plugins.notify('cosmos IMG built! Check new files')); */
});

gulp.task('img_psd_1', function(){
  return gulp.src(img.psd_1)
  	.pipe(plugins.imagemin({
		progressive: true,
		svgoPlugins: [{removeViewBox:false}],
		use: [pngquant()],
		interlaced: true
	}))
    .pipe(gulp.dest('build/psd-1/img'))
    .pipe(reload({stream:true}))
/* 	.pipe(plugins.notify('psd-1 IMG built! Check new files')); */
});

gulp.task('img_final', function(){
  return gulp.src(img.final)
  	.pipe(plugins.imagemin({
		progressive: true,
		svgoPlugins: [{removeViewBox:false}],
		use: [pngquant()],
		interlaced: true
	}))
    .pipe(gulp.dest('build/final/img'))
    .pipe(reload({stream:true}))
/* 	.pipe(plugins.notify('psd-1 IMG built! Check new files')); */
});

gulp.task('img_library', function(){
  return gulp.src(img.library)
  	.pipe(plugins.imagemin({
		progressive: true,
		svgoPlugins: [{removeViewBox:false}],
		use: [pngquant()],
		interlaced: true
	}))
    .pipe(gulp.dest('build/library/img'))
    .pipe(gulp.dest(pathToPublish+'/img'))
    .pipe(reload({stream:true}))
/* 	.pipe(plugins.notify('psd-1 IMG built! Check new files')); */
});

// ////////////////////////////////////////////////
// Browser-Sync
// // /////////////////////////////////////////////
gulp.task('bsync_cosmos', function() {
  browserSync({
    server: {
      baseDir: "./build/cosmos"
    },
    port: 8080,
    open: true,
    notify: true
  });
});

gulp.task('bsync_psd_1', function() {
  browserSync({
    server: {
      baseDir: "./build/psd-1"
    },
    port: 8080,
    open: true,
    notify: true
  });
});

gulp.task('bsync_final', function() {
  browserSync({
    server: {
      baseDir: "./build/final"
    },
    port: 8080,
    open: true,
    notify: true
  });
});

gulp.task('bsync_library', function() {
  browserSync({
    server: {
      baseDir: "./build/library"
    },
    port: 8080,
    open: true,
    notify: true
  });
});


gulp.task('watcher_cosmos', function(){
  gulp.watch(html.cosmos, ['html_cosmos']);
  gulp.watch(css.cosmos, ['css_cosmos']);
  gulp.watch(css.header_cosmos, ['header_cosmos']);
  gulp.watch(img.cosmos, ['img_cosmos']);
});


gulp.task('watcher_psd_1', function(){
  gulp.watch(html.psd_1, ['html_psd_1']);
  gulp.watch(css.psd_1, ['css_psd_1']);
  gulp.watch(css.header_psd_1, ['header_psd_1']);
  gulp.watch(img.psd_1, ['img_psd_1']);
});


gulp.task('watcher_final', function(){
  gulp.watch(html.final, ['html_final']);
  /*gulp.watch(js.final, ['js_final']);*/
  gulp.watch(css.final, ['css_final']);
  gulp.watch(css.header_final, ['header_final']);
  gulp.watch(img.final, ['img_final']);
});

gulp.task('watcher_library', function(){
  gulp.watch(html.library, ['html_library']);
  gulp.watch(php.library, ['php_library']);
  gulp.watch(ht.library, ['ht_library']);
  gulp.watch(js.library, ['js_library']);
  gulp.watch(css.library, ['css_library']);
//  gulp.watch(img.library, ['img_library']);
});


gulp.task('compile_cosmos', ['html_cosmos', 'header_cosmos', 'css_cosmos', 'img_cosmos']);

gulp.task('compile_psd_1', ['html_psd_1', 'header_psd_1', 'css_psd_1', 'img_psd_1']);

gulp.task('compile_final', ['html_final', 'header_final', 'css_final', 'img_final']);

gulp.task('compile_library', ['html_library', 'php_library', 'ht_library', 'js_library', 'css_library', 'img_library']);

//gulp.task('default', ['html_cosmos', 'header_cosmos', 'css_cosmos', 'img_cosmos', 'watcher_cosmos', 'bsync_cosmos']); 

//gulp.task('default', ['html_psd_1', 'header_psd_1', 'css_psd_1', 'img_psd_1', 'watcher_psd_1', 'bsync_psd_1']); 

//gulp.task('default', ['html_final', /*'js_final',*/ 'header_final', 'css_final', 'img_final', 'watcher_final', 'bsync_final']); 

gulp.task('default', ['html_library', 'php_library', 'ht_library', 'ttf_library', 'js_library', 'css_library', 'img_library', 'watcher_library' /*, 'bsync_library'*/]); 