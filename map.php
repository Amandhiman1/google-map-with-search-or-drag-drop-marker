<style>
  #map_canvas {
    width: 94%;
    height: 300px;
    margin-left: 16px;
  }

  #current {
    padding-top: 25px;
  }

  #geocomplete {
    background-color: #fff;
    font-family: Roboto;
    font-size: 15px;
    font-weight: 300;
    margin-left: 12px;
    padding: 0 11px 0 13px;
    text-overflow: ellipsis;
    width: 300px;
  }
</style>


<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.8.1/jquery.min.js"></script>

<script
  src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDGTVhMzF87TQrVBvh7hSTwbNCENJxP4qo&libraries=places&callback=initialize"
  async defer></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/geocomplete/1.7.0/jquery.geocomplete.min.js"></script>

<input id="geocomplete" type="text" placeholder="Search Location">

<!-- <div id="map"></div> -->

<section>
  <div id='map_canvas'></div>
  <div id="current" style="margin-left: 20px;">
    <p>Marker dropped: Current Lat:18.103 Current Lng:80.274</p>
  </div>
</section>

<script>

  function initialize() {

    $("#geocomplete").geocomplete({
      details: "form"
    }).bind("geocode:result", function (event, result) {

      var myLatlng = new google.maps.LatLng(parseFloat(result.geometry.location.lat()), parseFloat(result.geometry
        .location.lng()));

      var map = new google.maps.Map(document.getElementById('map_canvas'), {
        zoom: 15,
        center: new google.maps.LatLng(result.geometry.location.lat(), result.geometry.location.lng()),
        mapTypeId: google.maps.MapTypeId.ROADMAP
      });
      
      newpossition(result.geometry.location.lat(), result.geometry.location.lng());
    });

  }


  function newpossition(lat, lng){
    console.log(lat);
    var map = new google.maps.Map(document.getElementById('map_canvas'), {
      zoom: 15,
      center: new google.maps.LatLng(lat, lng),
      mapTypeId: google.maps.MapTypeId.ROADMAP
    });
    document.getElementById('current').innerHTML = '<p>Marker dropped: Current Lat: ' + lat +
      ' Current Lng: ' + lat + '</p>';
    // document.getElementById('latitude').value = coords.latitude;
    //   document.getElementById('longitude').value = coords.longitude;
    var myMarker = new google.maps.Marker({
      position: new google.maps.LatLng(lat, lng),
      draggable: true
    });
    google.maps.event.addListener(myMarker, 'dragend', function (evt) {

      document.getElementById('current').innerHTML = '<p>Marker  dropped: Current Lat: ' + evt.latLng.lat().toFixed(
        3) + ' Current Lng: ' + evt.latLng.lng().toFixed(3) + '</p>';
      // document.getElementById('latitude').value = evt.latLng.lat().toFixed(3);
      // document.getElementById('longitude').value = evt.latLng.lng().toFixed(3);
    });
    google.maps.event.addListener(myMarker, 'dragstart', function (evt) {
      document.getElementById('current').innerHTML = '<p>Currently dragging marker...</p>';
    });
    map.setCenter(myMarker.position);
    myMarker.setMap(map);
  }


  setTimeout(() => {
    newpossition(30.67, 70.67);
  }, 1500);
</script>
