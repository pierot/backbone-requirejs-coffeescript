define (require, exports, module) ->
  Backbone = require 'backbone'

  class Generic extends Backbone.Model
    defaults:
      template: 'empty'
