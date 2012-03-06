define (require, exports, module) ->
  Backbone = require 'backbone'
  $ = require 'jquery'
  utils = require 'cs!utils'

  router = require 'cs!router'

  AppRouter = router.AppRouter
  AppView = router.AppView

  $ ->
    utils.tpl.loadTemplates ['team', 'team_detail', 'team_list', 'not_found', 'menu', 'info', 'register'], ->
      window.app = new AppRouter(new AppView)
      window.app.navigate()

      Backbone.history.start {pushState: true}

      $('body a').bind 'click', (e) ->
        e.preventDefault()
        
        window.app.navigate $(this).attr('href'), true

        return false

  module.exports = {}
