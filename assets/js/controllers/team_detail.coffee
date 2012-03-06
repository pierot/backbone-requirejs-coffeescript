define (require, exports, module) ->
  Backbone = require 'backbone'
  _ = require 'underscore'
  $ = require 'jquery'
  ich = require 'ich'

  utils = require 'cs!utils'
  BaseView = utils.BaseView

  class TeamDetailView extends BaseView
    initialize: ->
      _.bindAll @

      @template = ich.team_detail

      @bind_to @model, 'change', @render

    render: ->
      $(@el).html @template(@model.toJSON())

      @

