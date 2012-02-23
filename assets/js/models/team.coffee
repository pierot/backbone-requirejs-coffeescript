define (require, exports, module) ->
  Backbone = require 'backbone'

  class Team extends Backbone.Model
    defaults:
      id: 0
      name: 'Ploeg'
      members: 2
