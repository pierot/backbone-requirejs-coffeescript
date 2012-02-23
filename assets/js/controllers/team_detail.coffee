define (require, exports, module) ->
  Backbone = require 'backbone'
  _ = require 'underscore'
  $ = require 'jquery'
  ich = require 'ich'

  class TeamDetailView extends Backbone.View
    initialize: ->
      _.bindAll @

      @template = ich.team_detail

      @model.bind 'change', @render

    render: ->
      $(@el).html @template(@model.toJSON())

      @

