define (require, exports, module) ->
  Backbone = require 'backbone'
  _ = require 'underscore'
  $ = require 'jquery'
  ich = require 'ich'

  Team = require 'cs!models/team'
  TeamView = require 'cs!controllers/team'

  class TeamListView extends Backbone.View
    initialize: ->
      _.bindAll @

      @template = ich.team_list
      
      @collection.bind 'add', @appendItem
      @collection.bind 'change', @render
      @collection.bind 'reset', @render

    render: ->
      $(@el).html @template
      
      _.each @collection.models, (team) =>
        @appendItem(team)
      , @

      @

    unrender: ->
      console.log('undelegateEvents')

    changeCollection: ->
      @render()

    appendItem: (team) ->
      team_view = new TeamView model: team

      $(@el).find(' ul').append team_view.render().el
