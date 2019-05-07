
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Restaurant Review</title>
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
<script type="text/javascript" src="https://code.jquery.com/jquery-3.4.0.min.js"></script>
<script type="text/javascript" src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" >
    <style>

footer {
  padding-top: 3rem;
  padding-bottom: 3rem;
}

footer p {
  margin-bottom: .25rem;
}
.white{
    color:#ffffff;
}
    </style>
  </head>
  <body>
    <header>
  <div class="navbar navbar-dark bg-dark shadow-sm">
    <div class="container d-flex justify-content-between">
      <a href="#" class="navbar-brand d-flex align-items-center">
        <strong>Restaurant Review</strong>
      </a>
      <div class="white fontendinfo justify-content-end">[Front End v{{ config('myenv.APP_VERSION') }} - @php echo $_SERVER['SERVER_ADDR']; @endphp]</div>
      <div class="white apiinfo justify-content-end">X</div>
    </div>
  </div>
</header>
<body role="main">
<script>
$( document ).ready(function() {
var apiversion = 'n/a';
var apiip = 'n/a';

var jqxhr = $.ajax({
    dataType: "json",
  url: 'http://api.restaurantreview.test/v1/restaurants',
  })
  .done(function(data) {
      console.log(data);
      var html_restaurants = '';

      if(data.app){
        $('.apiinfo').html('[API v' + data.app.version + ' - ' + data.app.ip + ']');

        $.each( data.restaurants, function( i, restaurant ) {
        html_restaurants = html_restaurants + '<div class="col-md-4"><div class="card mb-4 shadow-sm">';
        html_restaurants = html_restaurants + '<img width="100%" height="225" src="'+ restaurant.logo +'">';
        html_restaurants = html_restaurants + '<div class="card-body"><p class="card-text"><b>'+ restaurant.name +'</b></p><div class="d-flex justify-content-between align-items-center">';
        html_restaurants = html_restaurants + '<div class="btn-group">';
        html_restaurants = html_restaurants + '<button type="button" class="votedown btn btn-sm btn-outline-secondary" data-id="'+restaurant.id+'" data-votes="'+restaurant.votes+'"><i class="fas fa-thumbs-down"></i></button>';
        html_restaurants = html_restaurants + '<button type="button" class="voteup btn btn-sm btn-outline-secondary" data-id="'+restaurant.id+'" data-votes="'+restaurant.votes+'"><i class="fas fa-thumbs-up"></i></button>';
        html_restaurants = html_restaurants + '</div>';
        html_restaurants = html_restaurants + '<small class="text-muted"><span id="htmlvotes'+restaurant.id+'">'+ restaurant.votes +'</span> votes</small>';
        html_restaurants = html_restaurants + '</div></div></div></div>';
        });
      }
      $('#content').html(html_restaurants);
})

  .fail(function() {
    alert( "error" );
  })
  .always(function() {

  });

$(document).on("click", "button.voteup" , function() {
    var me = $(this);
    var id = me.data('id');
    var votes = me.data('votes');
    votes = votes + 1;

var jqxhr = $.ajax({
    dataType: "json",
    type: 'POST',
    url: 'http://api.restaurantreview.test/v1/restaurant/upvote',
    data: {restaurant_id: id},
  })
  .done(function(data) {
      console.log(data);
    me.data('votes',votes);
    $('#htmlvotes'+id).html(votes);
  })
  .fail(function() {
    alert( "error" );
  });


});
$(document).on("click", "button.votedown" , function() {
    var me = $(this);
    var id = me.data('id');
    var votes = me.data('votes');
    votes = votes - 1;

    var jqxhr = $.ajax({
    dataType: "json",
    type: 'POST',
    url: 'http://api.restaurantreview.test/v1/restaurant/downvote',
    data: {restaurant_id: id},
  })
  .done(function(data) {
      console.log(data);
    me.data('votes',votes);
    $('#htmlvotes'+id).html(votes);
  })
  .fail(function() {
    alert( "error" );
  });

});

});

</script>
  <div class="album py-5 bg-light">
    <div class="container">
      <div class="row" id="content">
      <div class="text-center"><div class="spinner-grow" style="width: 3rem; height: 3rem;" role="status"><span class="sr-only">Loading...</span></div></div>
      </div>
  </div>
</div>
</body>

<footer class="text-muted">
  <div class="container">
    <p class="float-right">
      <a href="#">Back to top</a>
  </div>
</footer>
</html>

