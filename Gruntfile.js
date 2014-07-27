module.exports = function (grunt) {
    var 
    debug = false
        , _be, _ma, _co;

    if (debug) {
        _be = !0, _ma = false, _co = false;
    } else {
        _be = !1, _ma = !0, _co = !0;
    }
    grunt.initConfig({
        pkg: grunt.file.readJSON('package.json'),
        jsdir: 'src/assets/javascripts',
        dest: '../public/v2',
        sass: {
            dist: {
                options: {
                    style: 'compressed'
                },
                files: {
                    '<%= dest %>/stylesheets/base.css': 'src/assets/sass/base.scss'
                }
            }
        },
        concat: {
            options: {
                separator: ';'
            },
            dist: {
                src: [
                    '<%= jsdir %>/application.js'
                ],
                dest: '<%= jsdir %>/build/application.js'
            }
        },
        uglify: {
            options: {
                beautify: _be,
                mangle: _ma,
                compress: _co,
                banner: '/*! Copyright zmjdc.com <%= grunt.template.today("yyyy-mm-dd") %> */\n'
            },
            build: {
                files: {
                    '<%= dest %>/javascripts/application.min.js': ['<%= jsdir %>/build/application.js'],
                    '<%= dest %>/javascripts/login.min.js': ['<%= jsdir %>/login.js'],
                    '<%= dest %>/javascripts/home.min.js': ['<%= jsdir %>/home.js'],
                    '<%= dest %>/javascripts/words.min.js': ['<%= jsdir %>/words.js']
                }
            }
        },
        watch: {
            sass: {
                files: ['Gruntfile.js', 'src/assets/sass/*.scss', 'src/assets/sass/lib/*.scss'],
                tasks: ['sass'],
                options: {
                    spawn: false,
                    reload: true,
                    debounceDelay: 250,
                }
            },
            script: {
                files: ['<%= jsdir %>/*.js'],
                tasks: ['concat', 'uglify'],
                options: {
                    spawn: false,
                    debounceDelay: 250
                }
            }
        }
    });

    grunt.loadNpmTasks('grunt-contrib-watch');
    grunt.loadNpmTasks('grunt-contrib-sass');
    grunt.loadNpmTasks('grunt-contrib-concat');
    grunt.loadNpmTasks('grunt-contrib-uglify');

    grunt.registerTask('default', ['sass', 'watch']);
    grunt.registerTask('concat' ['concat']);
}
