define (require, exports, module) ->
  Backbone = require 'backbone'
  _ = require 'underscore'
  $ = require 'jquery'
  ich = require 'ich'

  utils = require 'cs!utils'
  BaseView = utils.BaseView

  class TeamView extends BaseView
    tagName: 'li'

    initialize: ->
      _.bindAll @

      @template = ich.team

      @bind_to @model, 'change', @render
      @bind_to @model, 'remove', @unrender

    render: ->
      $(@el).html @template(@model.toJSON())

      @

    unrender: ->
      $(@el).remove()

    remove: -> @model.destroy()

    open: ->
      app.navigate('team/' + @model.id, true)

    events:
      'click .delete': 'remove'
      'click .view': 'open'
