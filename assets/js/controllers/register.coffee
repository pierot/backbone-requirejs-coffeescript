define (require, exports, module) ->
  Backbone = require 'backbone'
  _ = require 'underscore'
  $ = require 'jquery'
  ich = require 'ich'

  utils = require 'cs!utils'
  BaseView = utils.BaseView

  class RegisterView extends BaseView
    initialize: ->
      _.bindAll @

      @template = ich.register
      
      @bind_to @model, 'change', @render
      @bind_to @model, 'remove', @unrender

    render: ->
      $(@el).html @template(@model.toJSON())

      @

    unrender: ->
      $(@el).remove()

    submit: (e) ->
      e?.preventDefault()

      attributes = {
        name: $(@el).find('#name').val()
        members: $(@el).find('#members').val()
      }

      options = {
        success: (model, resp) =>
          console.log('success')

          console.log(model)
          console.log(resp)

          @model = model
          window.app.team_list.add @model

          app.navigate('team/' + @model.id, true)

        error: (model, error) =>
          console.log('error')

          if error.status in [400..599]
            alert('Error registering')
          else
            alert(error)
      }

      @model.save attributes, options
      
      return false

    events:
      'click button': 'submit'
