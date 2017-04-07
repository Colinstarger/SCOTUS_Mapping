var page = require('webpage').create();
      page.open('https://courtlistener.com/visualizations/scotus-mapper/1124/slug?dos=2', function() {
        page.includeJs('http://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js', function() {
          var search = page.evaluate(function() { 
              return  $('#dod-info').text();
          });
          console.log(search);
          phantom.exit()
        });
      })