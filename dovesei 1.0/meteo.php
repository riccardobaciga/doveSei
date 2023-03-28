<!DOCTYPE html>
<html lang="it">
  <head>
    <meta name="description" content="Webpage description goes here" />
    <meta charset="utf-8" />
    <title>Che tempo fa</title>
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="icon" type="image/png" href="img/ico.png">
    <meta name="author" content="" />
    <script src="https://code.jquery.com/jquery-latest.min.js">
    </script>
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    
    
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.3/dist/leaflet.css"
          integrity="sha256-kLaT2GOSpHechhsozzB+flnD+zUyjE2LlfWPgU04xyI="
          crossorigin=""/>
    <script src="https://unpkg.com/leaflet@1.9.3/dist/leaflet.js"
            integrity="sha256-WBkoXOwTeyKclOHuWtc+i2uENFpDZ9YPdf5Hf+D7ewM="
            crossorigin="">
    </script>
    <link rel="stylesheet" href="/include/weather-icon/css/weather-icons.min.css">
<body class="lookingForSignal" onresize="resizeMap ()">
    <div class="w3-bottom w3-block w3-xlarge w3-padding w3-blue-grey" id="statusBar"> </div>
    <div class="w3-white w3-block" id="map"></div>
    <script>
        
        function getLocation() {
          if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(meteoPosition);
          } else {
            $("#statusBar").html("Geolocatione non funziona sul tuo browser.");
          }
        }
      
        function meteoPosition(position) {
            map.setView(L.latLng(position.coords.latitude, position.coords.longitude));
            url = "get.php?w=getMeteo&x="+position.coords.latitude+"&y="+position.coords.longitude
            console.log(url);
            doAjax(url, [], "visualizzaMeteo");
        }
              
        function resizeMap (){
            $("#map").height($(document).height() - $("#statusBar").height() - 5);
        }
        
        resizeMap ()
        var map = L.map('map').setView([45.466954, 9.185021], 14);
        var myMarher = null;

        L.tileLayer('https://{s}.tile-cyclosm.openstreetmap.fr/cyclosm/{z}/{x}/{y}.png', {
          maxZoom: 20,
          attribution: '<a href="https://github.com/cyclosm/cyclosm-cartocss-style/releases" title="CyclOSM - Open Bicycle render">CyclOSM</a> | Map data: &copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
        }).addTo(map);  
        
        function visualizzaMeteo(data){
            console.log(data);
            
            newPos = L.latLng(+data["x"], +data["y"]);
            
            if (myMarher == null){
                myMarher = new L.marker(newPos).addTo(map);
            }else{
                myMarher.setLatLng(newPos);
            }
            
            stringa = data["nome"] + ": <i class=\""+data["ico"]+"\"></i> " + data["description"] + ", " + data["temperature"]+", " + data["wind"] + " <i class=\""+data["windIco"]+"\"></i> " ;
            
            $("#statusBar").html(stringa)
            resizeMap ();
        }
        
        map.on('click', function(e) {
            url = "get.php?w=getMeteo&x="+e.latlng.lat+"&y="+e.latlng.lng+"&p=3"
            console.log(url);
            doAjax(url, [], "visualizzaMeteo");
        });
        
        getLocation();
      function doAjax(nomeServizio, param, nomeFunzione){
        $.ajax({
          url: nomeServizio,
          type: 'POST', 
          dataType: 'html', 
          data: param
        })
        .done(function(data) {
              try{
                var risposta = JSON.parse(data);
                console.log(risposta);
              }
              catch(e){
                console.log (e+data);
                alert("Errore nella conversione dei dati");
              }
              if (risposta.result === "KO"){
                console.log (risposta.description);
                alert("Errore nell'esecuzione del servizio");
              }
              else{
                window[nomeFunzione](risposta.data);
              }
            }
         )
         .fail(function() {
                console.log ("ERRORE ajax nella chiamata" + this.url + "</p><b>" + this.statusText + "</b>");
                alert("ERRORE ajax nella chiamata");
            }
        );
      }
      
    </script>
  </body>
</html>