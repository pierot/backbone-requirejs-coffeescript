define (require, exports, module) ->
  Backbone = require 'backbone'
  $ = require 'jquery'
  utils = require 'cs!utils'

  AppRouter = require 'cs!router'

  $ ->
    utils.tpl.loadTemplates ['team', 'team_detail', 'team_list', 'not_found', 'menu', 'info', 'register'], ->
      window.app = new AppRouter()
      window.app.navigate()

      Backbone.history.start {pushState: true}

      $('body a').bind 'click', (e) ->
        e.preventDefault()
        
        window.app.navigate $(this).attr('href'), true

        return false

  module.exports = {}
