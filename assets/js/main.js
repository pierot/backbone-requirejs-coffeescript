require({
    paths: {
      cs: 'libs/cs',
      order: 'libs/order',
      jquery: 'http://ajax.googleapis.com/ajax/libs/jquery/1.7/jquery.min',
      underscore: 'libs/underscore-min',
      backbone: 'libs/backbone-min',
      ich: 'libs/ICanHaz'
    }
  }, [
    'jquery',
    'order!underscore',
    'order!backbone',
    'order!ich',
    'cs!app'
  ]
);
