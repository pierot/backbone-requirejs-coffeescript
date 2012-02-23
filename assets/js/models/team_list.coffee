define (require, exports, module) ->
  Backbone = require 'backbone'

  Team = require 'cs!models/team'

  class TeamList extends Backbone.Collection
    model: Team
    url: window.base_url + 'api/' + 'teams'
