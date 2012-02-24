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

    submit: (e) ->
      e?.preventDefault()

      @model.save {
        name: $(@el).find('#name').val()
        members: $(@el).find('#members').val()
      }, success: (model, resp) =>
        console.log(model)
        console.log(resp)

        @model = model

        app.navigate('team/' + @model.id, true)
      , error: (err) =>
        console.log(err)
      
      return false

    events:
      'click button': 'submit'
