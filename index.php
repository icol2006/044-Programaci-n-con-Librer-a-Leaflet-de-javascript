<html>

<head>
  <title>Mapa</title>
  <meta charset="utf-8">
  <link rel="stylesheet" href="https://unpkg.com/leaflet@1.3.1/dist/leaflet.css" />
  <script src="https://unpkg.com/leaflet@1.3.1/dist/leaflet.js"></script>

  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous">
  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-Piv4xVNRyMGpqkS2by6br4gNJ7DXjqk09RmUpJ8jgGtD7zP9yug3goQfGII0yAns" crossorigin="anonymous"></script>


  <style type="text/css">
    html,
    body {
      width: 100%;
      padding: 0;
      margin: 0;
    }

    .container {
      width: 95%;
      max-width: 980px;
      padding: 1% 2%;
      margin: 0 auto
    }

    /* #lat,
    #lon {
      text-align: right
    } */

    #map {
      width: 100%;
      height: 60%;
      padding: 0;
      margin: 0;
    }

    .address {
      cursor: pointer;
      color: rgb(16, 130, 201);
      font-size: small;
    }

    .address:hover {
      color: #AA0000;
      text-decoration: underline;
      font-size: small;
    }
  </style>
</head>

<body>


  <div class="container body-content">
    <div class="form-group">
      <b>Buscar direccion</b>
      <input style="height:30px" type="text" class="form-control input-sm" name="addr" value="<?php echo (isset($_GET['direccion'])) ? $_GET['direccion'] : "0" ?>" id="addr" size="58" />
      <button type="button" class="btn btn-primary float-right mt-2  btn-sm" onclick="addr_search();">Buscar</button>
      <div id="results"></div>
    </div>
    <form method="post" action="save.php">
      <div class="form-row">
        <div class="form-group col-md-6">
          <input type="hidden" name="id" value="<?php echo (isset($_GET['id'])) ? $_GET['id'] : "0" ?>">
          <label>Latitud</label>
          <input type="text" style="height:30px" class="form-control input-sm" name="lat" id="lat" value="">
        </div>
        <div class="form-group col-md-6">
          <label>Longitud</label>
          <input type="text" style="height:30px" class="form-control input-sm" name="lon" id="lon" value="">
        </div>
      </div>
      <input name="save" type="submit" class="btn btn-success  btn-sm float-right" value="Guardar">
    </form>

    <br />

    <div id="map"></div>

  </div>



  <script type="text/javascript">
    // New York
    var startlat = 40.75637123;
    var startlon = -73.98545321;

    var options = {
      center: [startlat, startlon],
      zoom: 9
    }

    document.getElementById('lat').value = startlat;
    document.getElementById('lon').value = startlon;

    var map = L.map('map', options);
    var nzoom = 12;

    L.tileLayer('http://{s}.tile.osm.org/{z}/{x}/{y}.png', {
      attribution: 'OSM'
    }).addTo(map);

    var myMarker = L.marker([startlat, startlon], {
      title: "Coordinates",
      alt: "Coordinates",
      draggable: true
    }).addTo(map).on('dragend', function() {
      var lat = myMarker.getLatLng().lat.toFixed(8);
      var lon = myMarker.getLatLng().lng.toFixed(8);
      var czoom = map.getZoom();
      //  if(czoom < 18) { nzoom = czoom + 2; }
      //  if(nzoom > 18) { nzoom = 18; }
      if (czoom != 18) {
        map.setView([lat, lon]);
      }
      //if(czoom != 18) { map.setView([lat,lon], nzoom); } else { map.setView([lat,lon]); }
      document.getElementById('lat').value = lat;
      document.getElementById('lon').value = lon;
      myMarker.bindPopup("Lat " + lat + "<br />Lon " + lon).openPopup();
    });

    function chooseAddr(lat1, lng1) {
      myMarker.closePopup();
      map.setView([lat1, lng1], 18);
      myMarker.setLatLng([lat1, lng1]);
      lat = lat1.toFixed(8);
      lon = lng1.toFixed(8);
      document.getElementById('lat').value = lat;
      document.getElementById('lon').value = lon;
      myMarker.bindPopup("Lat " + lat + "<br />Lon " + lon).openPopup();
    }

    function myFunction(arr) {
      var out = "<br />";
      var i;

      if (arr.length > 0) {
        for (i = 0; i < arr.length; i++) {
          out += "<div class='address' title='Mostrar coordenadas' onclick='chooseAddr(" + arr[i].lat + ", " + arr[i].lon + ");return false;'>" + arr[i].display_name + "</div>";
        }

        document.getElementById('results').innerHTML = out;

        if(arr.length>0)
        {
        chooseAddr(parseFloat(arr[0].lat),parseFloat(arr[0].lon));
        }
      } else {
        document.getElementById('results').innerHTML = "No hay resultados...";
      }

    }

    function addr_search() {
      var inp = document.getElementById("addr");
      var xmlhttp = new XMLHttpRequest();
      var url = "https://nominatim.openstreetmap.org/search?format=json&limit=6&q=" + inp.value;
      xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
          var myArr = JSON.parse(this.responseText);
          myFunction(myArr);
        }
      };
      xmlhttp.open("GET", url, true);
      xmlhttp.send();
    }

    addr_search();

  </script>

</body>

</html>