module.exports = function(grunt) {

    // Load all grunt tasks.
    require("matchdep").filterDev("grunt-*").forEach(grunt.loadNpmTasks);

    // Project configuration.
    grunt.initConfig({
        "pkg": grunt.file.readJSON("package.json"),

        "browserDependencies": grunt.file.readJSON('package.json').browserDependencies,

        "concat": {
            "app": {
                "src": "public/js/app/**/*.js",
                "dest": "public/js/app.js"
            }
        },

        "emberTemplates": {
            "compile": {
                "options": {
                    "templateBasePath": /public\/js\/app\/templates\//
                },
                "files": {
                    "public/js/templates.js": "public/js/app/templates/**/*.hbs"
                }
            }
        },

        "jshint": {
            "files": [
                "public/js/**/*.js",
                "!public/js/lib/**/*.js"
            ]
        },

        "sass": {
            "dist": {
                "files": {
                    "public/css/main.css": "public/css/sass/main.scss"
                }
            }
        },

        "watch": {
            "concat": {
                "files": ["public/js/**/*.js", "!public/js/app.js", "!public/js/templates.js"],
                "tasks": ["concat"]
            },
            "emberTemplates": {
                "files": "public/js/app/templates/**/*.hbs",
                "tasks": ["emberTemplates"]
            },
            "css": {
                "files": "public/css/**/*.scss",
                "tasks": ["sass"]
            }
        },
    });

    grunt.registerTask("browser-deps", ["browserDependencies"]);
    grunt.registerTask("default", ["concat", "emberTemplates", "sass"]);

};
