'use strict';

var gulp = require('gulp'),
    pkg = require('./package.json'),
    toolkit = require('gulp-wp-plugin-toolkit');

toolkit.extendConfig({
    project: {
        name: 'RA Widgets Animate',
        version: pkg.version,
        textdomain: pkg.name,
        watch: {
            php: [
                '**/*.php'
            ],
            scss: [
                'develop/admin/css/**/*.css', 
                'develop/public/css/*.css',
                '!node_modules/**'
            ],
            js: [
                'develop/admin/js/**/*.js', 
                'develop/public/js/*.js',
                '!node_modules/**'
            ]
        }
    },
    scss: {
        'aos': {
            src: 'node_modules/aos/dist/aos.css',
            dest: 'public/css/',
            outputStyle: 'compressed'
        },
        'rawa-admin': {
            src: 'develop/admin/css/rawa-admin.css',
            dest: 'admin/css/',
            outputStyle: 'compressed'
        }
    },
    js: {
        'aos': {
            src: 'node_modules/aos/dist/aos.js',
            dest: 'public/js/'
        },
        'rawa': {
            src: 'develop/public/js/*.js',
            dest: 'public/js/'
        },
        'rawa-admin': {
            src: 'develop/admin/js/rawa-admin.js',
            dest: 'admin/js/'
        },
        'rawa-settings': {
            src: 'develop/admin/js/rawa-settings.js',
            dest: 'admin/js/'
        },
        'siteorigin-admin': {
            src: 'develop/admin/js/siteorigin-admin.js',
            dest: 'admin/js/'
        }
    }
});

toolkit.extendTasks(gulp, {

});