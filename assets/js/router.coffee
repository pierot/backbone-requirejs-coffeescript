define (require, exports, module) ->
  Backbone = require 'backbone'
  $ = require 'jquery'

  TeamListView = require 'cs!controllers/team_list'
  TeamDetailView = require 'cs!controllers/team_detail'
  GenericView = require 'cs!controllers/generic'
  RegisterView = require 'cs!controllers/register'

  Generic = require 'cs!models/generic'
  TeamList = require 'cs!models/team_list'
  Team = require 'cs!models/team'

  class AppView
    show_view: (view) ->
      if @current_view
        @current_view.close()

      @current_view = view
      @current_view.render()

      $('#content').html(@current_view.el)

  class AppRouter extends Backbone.Router
    routes:
      '': 'list'
      'info': 'info'
      'register': 'register'

      'teams': 'list'
      'team/:id': 'team_details'

      ':notfound': 'not_found'

    initialize: (@app_view) ->
      @menu_data = new Generic
      @menu_data.set template: 'menu'

      @menu = new GenericView model: @menu_data, el: $('#wrapper nav')[0]
      @menu.render()

    list: ->
      @before () =>
        team_list_view = new TeamListView collection: @team_list

        @app_view.show_view(team_list_view)

    team_details: (id) ->
      @before () =>
        team = @team_list.get(id)

        team_detail_view = new TeamDetailView model: team

        @app_view.show_view(team_detail_view)

    register: () ->
      @before () =>
        team = new Team

        page_view = new RegisterView model: team

        @app_view.show_view(page_view)

    info: () ->
      page_data = new Generic
      page_data.set template: 'info'

      page_view = new GenericView model: page_data

      @app_view.show_view(page_view)

    not_found: () ->
      generic_page = new Generic
      generic_page.set template: 'not_found'

      generic_view = new GenericView model: generic_page

      @app_view.show_view(generic_view)

    before: (callback) ->
      if @team_list
        callback() if callback
      else
        @team_list = new TeamList
        @team_list.fetch { success: () =>
          callback() if callback
        }

  module.exports = {AppRouter: AppRouter, AppView: AppView}
