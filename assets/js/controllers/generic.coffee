define (require, exports, module) ->
  Backbone = require 'backbone'
  _ = require 'underscore'
  $ = require 'jquery'
  ich = require 'ich'

  class GenericView extends Backbone.View
    initialize: ->
      _.bindAll @

      @template = ich[@model.get 'template']
      
    render: ->
      $(@el).html @template()

      @

