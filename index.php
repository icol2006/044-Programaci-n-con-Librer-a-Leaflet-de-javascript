<html>

<head>
  <title>Mapa</title>
  <meta charset="utf-8">
  <link rel="stylesheet" href="https://unpkg.com/leaflet@1.3.1/dist/leaflet.css" />
  <script src="https://unpkg.com/leaflet@1.3.1/dist/leaflet.js"></script>


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
    <table>
      <tr>
        <td>
          <b style="margin-right: 20px;">Buscar direccion</b>
        </td>
        <td>
          <input style="height:30px;margin-right: 20px;" type="text" name="addr" value="<?php echo (isset($_GET['direccion'])) ? $_GET['direccion'] : "" ?>" id="addr" size="58" onchange="refrescarValorDireccion()" />
        </td>
        <td>
          <button type="button" style="float: right;" onclick="addr_search(true);">Buscar</button>
        </td>
      </tr>
    </table>

    <br>
    <div id="results" style="overflow: auto;height: 100px;background-color:#fff2f2;padding-left:10px"></div>

    <br>
    <form method="post" action="save.php">
      <input type="hidden" name="id" value="<?php echo (isset($_GET['id'])) ? $_GET['id'] : "0" ?>">
      <input type="hidden" id="direccion" name="direccion" value="<?php echo (isset($_GET['direccion'])) ? $_GET['direccion'] : "" ?>"></input>
      <table>
        <tr>
          <td>
            Latitud
            <input type="text" style="height:30px;display: inline;" name="lat" id="lat" value="">
          </td>
          <td>
            Longitud
            <input type="text" style="height:30px;display: inline;" name="lon" id="lon" value="">
            <input name="save" style="margin-left: 30px;" type="submit" value="Guardar">
          </td>
        </tr>
      </table>
    </form>

    <div id="map"></div>

  </div>

  <script type="text/javascript">
    // Barcelona
    var startlat = '<?php echo (isset($_GET['lat'])) ? $_GET['lat'] : 41.38289390 ?>';
    var startlon = '<?php echo (isset($_GET['lon'])) ? $_GET['lon'] : 2.17743220 ?>';



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
      lat = "0";
      lon = "0";
      map.setView([lat1, lng1], 18);
      myMarker.setLatLng([lat1, lng1]);
      if (typeof lat1 == "number") {
        lat = lat1.toFixed(8);
      } else {
        lat = lat1;
      }
      if (typeof lng1 == "number") {
        lon = lng1.toFixed(8);
      } else {
        lon = lng1;
      }

      document.getElementById('lat').value = lat;
      document.getElementById('lon').value = lon;
      myMarker.bindPopup("Lat " + lat + "<br />Lon " + lon).openPopup();
    }

    function myFunction(arr,configurarPunto) {
      var out = "";
      var i;

      if (arr.length > 0) {
        out += "Resultados de busqueda"
        for (i = 0; i < arr.length; i++) {
          out += "<div class='address' title='Mostrar coordenadas' onclick='chooseAddr(" + arr[i].lat + ", " + arr[i].lon + ");return false;'>" + arr[i].display_name + "</div>";
        }

        document.getElementById('results').innerHTML = out;

        var puntoGpsInicial = '<?php echo (isset($_GET['lat'])) ? $_GET['lat']  : "" ?>'

        if (arr.length > 0 && configurarPunto==true) {
          chooseAddr(parseFloat(arr[0].lat), parseFloat(arr[0].lon));
        }
      } else {
        document.getElementById('results').innerHTML = "No hay resultados...";
      }

    }

    function addr_search(configurarPunto) {
      var inp = document.getElementById("addr");
      var xmlhttp = new XMLHttpRequest();
      var url = "https://nominatim.openstreetmap.org/search?format=json&limit=15&q=" + inp.value;
      xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
          var myArr = JSON.parse(this.responseText);
          myFunction(myArr,configurarPunto);
        }
      };
      xmlhttp.open("GET", url, true);
      xmlhttp.send();
    }

    addr_search(false);


    chooseAddr(startlat, startlon);

    function refrescarValorDireccion() {
      document.getElementById("direccion").value = document.getElementById("addr").value;
    }

    var res = '<?php echo (isset($_GET['res'])) ? $_GET['res']  : "" ?>'

    if (res.length > 0) {
      res == "done" ? alert("Registro Guardado") : alert("Registro no fue guardado");
    }
  </script>

</body>

</html>