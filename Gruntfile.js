/* jshint node:true */
module.exports = function (grunt) {
	'use strict';

	var sass = require('node-sass');

	grunt.initConfig({

		// Sass linting with Stylelint.
		stylelint: {
			options: {
				configFile: '.stylelintrc'
			},
			all: [
				'assets/scss/**/*.scss'
			]
		},

		// Compile all .scss files.
		sass: {
			dist: {
				options: {
					implementation: sass,
					require: 'susy',
					sourceMap: true
				},
				files: [{
					'assets/css/style.css': 'assets/scss/style.scss'
				}]
			}
		},

		// Autoprefixer.
		postcss: {
			options: {
				processors: [
					require('autoprefixer')
				]
			},
			dist: {
				src: [
					'assets/css/style.css'
				]
			}
		},

		// Minify all .css files.
		cssmin: {
			options: {
				sourceMap: false,
				mergeIntoShorthands: false,
				roundingPrecision: -1
			},
			minify: {
				expand: true,
				cwd: 'assets/css/',
				src: ['*.css'],
				dest: 'assets/css/',
				ext: '.css'
			}
		},
		// JavaScript linting with JSHint.
		jshint: {
			options: {
				jshintrc: '.jshintrc'
			},
			all: [
				'Gruntfile.js',
				'assets/js/scripts.js',
				'!assets/js/bundle.js',
				'!assets/js/*.min.js'
			]
		},
		// Minify .js files.
		uglify: {
			options: {
				ie8: true,
				parse: {
					strict: false
				},
				output: {
					comments : /@license|@preserve|^!/
				}
			},
			dev:{
				files: [{
					'assets/js/bundle.js' :[
						'assets/js/scripts.js',
						'assets/vendor/bootstrap/js/bootstrap.js'
					]
				}]
			}
		},
		//optimize

		// PHP Code Sniffer.
		phpcs: {
			options: {
				bin: 'vendor/bin/phpcs'
			},
			dist: {
				src: [
					'**/**/*.php',
					'!vendor/**'
				]
			}
		},
		//versioning
		version: {
			assets: {
				options: {
					algorithm: 'sha1',
					length: 4,
					format: false,
					rename: true
				},
				files: {
					'inc/enqueue.php': ['assets/css/style.css', 'assets/js/bundle.js']
				}
			}
		},
		// Watch changes for assets.
		watch: {
			css: {
				files: [
					'assets/scss/**/*.scss',
					'assets/vendors/**/*.scss'
				],
				tasks: [
					'css'
				]
			},
			js: {
				files: [
					// main js
					'assets/js/scripts.js',
					'!assets/js/**/*.min.js'
				],
				tasks: [
					'jshint',
					'uglify'
				]
			}
			// php: {
			// 	files: ['**/**/*.php', '!inc/enqueue.php'],
			// 	tasks: ['phpcs']
			// }
		}
	});

	// Load NPM tasks to be used here
	grunt.loadNpmTasks('grunt-contrib-jshint');
	grunt.loadNpmTasks('grunt-contrib-uglify');
	grunt.loadNpmTasks('grunt-sass');
	grunt.loadNpmTasks('grunt-contrib-cssmin');
	grunt.loadNpmTasks('grunt-contrib-watch');
	grunt.loadNpmTasks('grunt-postcss');
	grunt.loadNpmTasks('grunt-contrib-compress');
	grunt.loadNpmTasks('grunt-stylelint');
	grunt.loadNpmTasks('grunt-phpcs');
	grunt.loadNpmTasks('grunt-wp-assets');

	// Register tasks
	grunt.registerTask('default', [
		'css',
		'jshint',
		'uglify'
	]);

	grunt.registerTask('css', [
		// 'stylelint',
		'sass',
		'postcss',
		'cssmin'
	]);

	grunt.registerTask('dev', [
		'default'
	]);
};
