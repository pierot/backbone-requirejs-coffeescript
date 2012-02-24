define (require, exports, module) ->
  Backbone = require 'backbone'

  class Team extends Backbone.Model
    url: () ->
      base = window.base_url + 'api/' + 'teams'
      
      return base if @isNew()
      return base + (base.charAt(base.length - 1) == '/' ? '' : '/') + this.id

    validate: (attrs) ->
      console.log(attrs.name)
      if attrs.name && attrs.name.length == 0
        return 'Name must be set'

      if attrs.members && attrs.members < 1
        return 'A team needs a least 1 member'

    defaults:
      id: 0
      name: 'Ploeg'
      members: 2

    initialize: () ->
      @bind 'error', (model, error) =>
        console.log(model.get('title') + " " + error)
