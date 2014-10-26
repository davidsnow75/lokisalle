module.exports = function(grunt) {
  grunt.initConfig({

    less: {
      development: {
        options: {
          paths: ["public/css"],
          compress: true
        },
        files: {"public/css/lokisalle.min.css": "public/css/lokisalle.less"}
      }
    },
    watch: {
      styles: {
        files: ['public/css/**/*.less'],
        tasks: ['less'],
        options: {
          nospawn: true
        }
      }
    }

  });

  grunt.loadNpmTasks('grunt-contrib-less');
  grunt.loadNpmTasks('grunt-contrib-watch');

  grunt.registerTask('default', ['watch']);
};
