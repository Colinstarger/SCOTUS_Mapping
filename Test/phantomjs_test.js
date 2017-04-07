var page = require('webpage').create();

page.open('https://www.courtlistener.com/visualizations/scotus-mapper/777/slug', function() {

page.includeJs("http://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js", function() {

    search = page.evaluate(function() { 
        return  $('#dod-info').text();
    });

    console.log(search);

    phantom.exit()
  });
})