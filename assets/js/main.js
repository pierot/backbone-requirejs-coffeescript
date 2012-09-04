/*global requirejs,require*/

requirejs.config({
  enforceDefine: true,
  shim: {
    'backbone': {
      deps: ['underscore', 'jquery'],
      exports: 'Backbone'
    },
    'ich': {
      deps: ['jquery'],
      exports: 'ich'
    }
  },
  paths: {
    cs: 'libs/cs',
    jquery: [
      'http://ajax.googleapis.com/ajax/libs/jquery/1.8/jquery.min',
      'libs/jquery-min'
    ],
    underscore: 'libs/underscore-min',
    backbone: 'libs/backbone-min',
    ich: 'libs/ICanHaz'
  }
});

require([
  'jquery',
  'underscore',
  'backbone',
  'ich',
  'cs!app'
]);
