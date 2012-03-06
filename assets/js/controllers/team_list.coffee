define (require, exports, module) ->
  Backbone = require 'backbone'
  _ = require 'underscore'
  $ = require 'jquery'
  ich = require 'ich'

  utils = require 'cs!utils'
  BaseView = utils.BaseView

  Team = require 'cs!models/team'
  TeamView = require 'cs!controllers/team'

  class TeamListView extends BaseView
    initialize: ->
      _.bindAll @

      @template = ich.team_list
     
      @bind_to @collection, 'add', @appendItem
      @bind_to @collection, 'change', @render
      @bind_to @collection, 'reset', @render

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
