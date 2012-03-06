define (require, exports, module) ->
  Backbone = require 'backbone'
  _ = require 'underscore'

  class Team extends Backbone.Model
    url: () ->
      base = window.base_url + 'api/' + 'teams'
      
      return base if @isNew()
      return base + '/' + this.id

    validate: (attrs) ->
      if _.isEmpty(attrs.name)
        return 'Name must be set'

      if attrs.members < 1
        return 'A team needs a least 1 member'

    defaults:
      id: null
      name: ''
      members: null

    initialize: () ->
      @bind 'error', (model, error) =>
        console.log(model)
        console.log('error: ' + error)
        console.log('error: ' + model.get('name') + " " + error)
