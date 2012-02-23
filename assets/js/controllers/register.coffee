define (require, exports, module) ->
  Backbone = require 'backbone'
  _ = require 'underscore'
  $ = require 'jquery'
  ich = require 'ich'

  class RegisterView extends Backbone.View
    initialize: ->
      _.bindAll @

      @template = ich.register
      
      @model.clear()
      @model.bind 'change', @render
      @model.bind 'remove', @unrender

    render: ->
      $(@el).html @template(@model.toJSON())

      @

    unrender: ->
      $(@el).remove()

    submit: ->
      # @model.
      # app.navigate('team/' + @model.id, true)

    events:
      'click button': 'submit'
