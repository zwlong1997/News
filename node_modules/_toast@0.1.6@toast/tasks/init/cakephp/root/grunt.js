module.exports = function(grunt){

  grunt.initConfig({

    // Coffee task
    coffee: {
      compile: {
        files: {
          'app/webroot_src/js/*.js': 'app/webroot_src/coffee/**/*.coffee'
        },
        options: {
          flatten: false
        }
      }
    },

    // Less task
    less: {
      development: {
        options: {
          compress: false
        },
        files: {
          "app/webroot/css/main.css": 'app/webroot/less/main.less'
        }
      },
      production: {
        options: {
          compress: true
        },
        files: {
          "app/webroot/css/main.min.css": 'app/webroot/less/main.less'
        }
      }
    },

    clean: {
      tmp_files: [
        'app/tmp/cache/models/*',
        'app/tmp/cache/models/*',
        'app/tmp/cache/persistent/*',
        'app/tmp/cache/views/*',
        'app/tmp/sessions/*'
      ]
    },

    // Watch task
    watch: {
      coffee: {
        // files: 'app/webroot/coffee/**/*.coffee',
        files: 'app/webroot_src/coffee/**/*.coffee',
        tasks: 'coffee:compile'
      },
      less: {
        files: 'app/webroot_src/less/**/*.less',
        tasks: 'less:development'
      }
    },

    // compress: {
    //   zip: {
    //     files: {
    //       'AllOfIt.zip': 'app/webroot/coffee/*'
    //     }
    //   }
    // },

    jasmine: {
      all: {
        src: ['test/SpecRunner.html'],
        errorReporting: true
      }
    },

    lint: {
      all: ['app/webroot/js/**/*.js']
    },

    // min: {
    //   dist: {
    //     src: ['app/webroot_src/js/*.js'],
    //     dest: 'app/webroot/js/*'
    //   }
    // },

    requirejs: {
      compile: {
        options: {
          baseUrl: "app/webroot_src/js",
          mainConfigFile: "app/webroot_src/js/config.js",
          out: "app/webroot/js/main.min.js",
          include: 'libs/require',
          insertRequire: ["main"],
          optimize: "none"
        }
      }
    },

    requirejss: {
      include: "app",
      // Include the main configuration file
      mainConfigFile: "app/webroot_src/js/config.js",

      // Output file
      out: "app/webroot/js/main.min.js",

      // Root application module

      // Do not wrap everything in an IIFE
      wrap: false,

      optimize: 'uglify',

      uglify: {
        toplevel: true,
        ascii_only: true,
        beautify: true,
        max_line_length: 1000,

        //How to pass uglifyjs defined symbols for AST symbol replacement,
        //see "defines" options for ast_mangle in the uglifys docs.
        defines: {
            DEBUG: ['name', 'false']
        },

        //Custom value supported by r.js but done differently
        //in uglifyjs directly:
        //Skip the processor.ast_mangle() part of the uglify call (r.js 2.0.5+)
        no_mangle: true
      }
    }

  });

  // Override test task with jasmine version
  grunt.registerTask('test', 'jasmine');

  grunt.registerTask('cas', 'dfdf', function() {
    
  });

  grunt.registerTask('clearcache', 'Clear the CakePHP Cache files', function() {
    grunt.task.run('clean:tmp_files writetmpfiles');
  });

  grunt.registerTask('writetmpfiles', 'Write out empty tmp files', function() {
    grunt.file.write('app/tmp/cache/models/empty', '');
    grunt.file.write('app/tmp/cache/persistent/empty', '');
    grunt.file.write('app/tmp/cache/views/empty', '');
    grunt.file.write('app/tmp/sessions/empty', '');
  });

  // Task to create a local config file, if none is present
  grunt.registerTask('localconfig', "Generate a local config file if you don't have one", function() {
    grunt.log.writeln('Checking for local configuration file .. ');

    if( grunt.file.findup('app/Config/Environment', 'local.php') ) {
      grunt.log.writeln();
      grunt.log.error("app/Config/Environment/local.php already exists. " + ("Refusing to overwrite.").bold.red);
    } else {

      var localConfigData = "<?php\n";
      localConfigData += "\n";
      localConfigData += "$config['debug'] = 2;\n";
      localConfigData += "\n";
      localConfigData += "$config['App.database'] = array(\n";
      localConfigData += "\t'host'       => 'localhost',\n";
      localConfigData += "\t'login'      => '',\n";
      localConfigData += "\t'password'   => '',\n";
      localConfigData += "\t'database'   => '',\n";
      localConfigData += ");\n\n";
      localConfigData += "$config['App.phpunit_db'] = array(\n";
      localConfigData += "\t'database' => 'testcake'\n";
      localConfigData += ");";

      grunt.file.write("app/Config/Environment/local.php", localConfigData);

      grunt.log.writeln("app/Config/Environment/local.php " + ("created").green);
    }

  });
   
};