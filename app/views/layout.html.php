<!doctype html>  
<!--[if IE 7 ]><html class="no-js ie7"><![endif]-->
<!--[if IE 8 ]><html class="no-js ie8"><![endif]-->
<!--[if (gte IE 9)|!(IE)]><!--><html class="no-js"><!--<![endif]-->
<html class="no-js">
<head>
  <meta charset="utf-8" />
	
  <title>Backbone Team App</title>

  <link rel="stylesheet/less" href="<?php echo($base_path); ?>assets/css/style.less" />
  <script src="//lesscss.googlecode.com/files/less-1.2.1.min.js"></script>

  <script>
    window.base_url = '<?php echo($base_path); ?>';
  </script>
  <script data-main="<?php echo($base_path); ?>assets/js/main" src="//requirejs.org/docs/release/1.0.6/minified/require.js"></script>
</head>
<body>

  <div id="wrapper">
    <h1>Backbone Team App</h1>
    <nav></nav>

    <div id="content">

      <?php echo($content); ?>

    </div>
  </div>

</body>
</html>
