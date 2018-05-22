#!/usr/bin/env node
var grunt = require("grunt");
var updater = require('../lib/plugins/updater.js');

// Preload all custom tasks.
require('grunt').npmTasks([
  "grunt-contrib-coffee",
  "grunt-contrib-less",
  "grunt-contrib-clean",
  "grunt-contrib-compress",
  "grunt-jasmine-task",
  // "grunt-contrib-copy",
  // "grunt-contrib-handlebars",
  // "grunt-contrib-jst",
  // "grunt-contrib-mincss",
  "grunt-contrib-requirejs",
  // "grunt-contrib-stylus",
  // "grunt-contrib-yuidoc",
  'toast'
]);

function displayHelp() {
  var pkg = require(__dirname + "/../package.json");
  grunt.log.writeln();
  grunt.log.writeln(pkg.description);
  grunt.log.writeln((" " + pkg.name + " ").green.inverse
    + " Version - " + pkg.version);

  // Borrowed heavily from the Grunt help source.
  var col1len = 0;

  var opts = Object.keys(grunt.cli.optlist).map(function(long) {
    var o = grunt.cli.optlist[long];
    var col1 = '--' + (o.negate ? 'no-' : '') + long + (o.short ? ', -' + o.short : '');
    col1len = Math.max(col1len, col1.length);
    return [col1, o.info];
  });

  var widths = [1, col1len, 2, 76 - col1len];

  var gruntTasks = Object.keys(grunt.task._tasks).slice(0, 8);
  var tasksList = Object.keys(grunt.task._tasks).slice(8);

  if (tasksList.length) {
    displayTasks("Toast", tasksList);
  }
  
  if (gruntTasks.length) {
    displayTasks("Grunt", gruntTasks);
  }

  function displayTasks(name, tasksList) {
    var tasks = tasksList.map(function(name) {
      col1len = Math.max(col1len, name.length);
      var info = grunt.task._tasks[name].info;

      return [name, info.blue];
    });

    grunt.log.header((name + " tasks:").yellow);
    grunt.log.writeln();

    tasks.forEach(function(a) {
      grunt.log.writetableln(widths,
        ['', grunt.utils._.pad(a[0], col1len), '', a[1]]
      );
    });
  }

  grunt.log.writeln();
}

var pkg = require(__dirname + "/../package.json");
updater.getUpdate({ name: 'toast', version: pkg.version }, function( error, update ) {
  // Immediately display help screen if no arguments.
  if (process.argv.length === 2) {
    // Initialize task system so that the tasks can be listed.
    grunt.task.init([], {help: true});

    // Do not proceed further.
    return displayHelp();
  }

  // Otherwise, invoke the CLI.
  grunt.cli();
});