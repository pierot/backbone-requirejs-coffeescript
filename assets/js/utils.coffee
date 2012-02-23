define (require, exports, module) ->
  $ = require 'jquery'
  ich = require 'ich'

  tpl =
    # Recursively pre-load all the templates for the app.
    # This implementation should be changed in a production environment. 
    # All the template files should be concatenated in a single file.
    loadTemplates: (names, callback) ->
      if names.length > 0 && callback
        @loadTemplate(0, names, callback)

    loadTemplate: (index, names, callback) ->
      name = names[index]

      $.get window.base_url + 'assets/templates/' + name + '.html', (data) =>
        # Convert to icanhaz template
        ich.addTemplate(name, data)

        index++

        if (index < names.length)
          @loadTemplate(index, names, callback)
        else
          callback()
      , 'html'

  module.exports = {tpl: tpl}
