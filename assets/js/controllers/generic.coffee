define (require, exports, module) ->
  Backbone = require 'backbone'
  _ = require 'underscore'
  $ = require 'jquery'
  ich = require 'ich'

  utils = require 'cs!utils'
  BaseView = utils.BaseView

  class GenericView extends BaseView
    initialize: ->
      _.bindAll @

      @template = ich[@model.get 'template']
      
    render: ->
      $(@el).html @template()

      @

