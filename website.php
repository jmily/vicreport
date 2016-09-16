<?php
require_once 'model/JsonGenerator.php';
require_once 'Config.php';
require_once 'entity/TableReport.php';
require_once 'model/Database.php';
require_once 'model/ReportRepository.php';
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Victoria Connect</title>

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css">
    <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="css/custom.css">
    <link rel="stylesheet" href="css/leaflet.css" />
    <link rel="stylesheet" href="css/Control.Loading.css" />
    <link rel="stylesheet" href="css/dataTable.css" />


    <style>
        @import url('http://fonts.googleapis.com/css?family=Open+Sans');
        body
        {
            font-family: 'Open Sans';
        }
        /*h1*/
        /*{*/
            /*font-size: 60px;*/
        /*}*/

        @media (max-width: 900px) {
            #header {
                width:100%;
                height: 600px;
                background: linear-gradient( rgba(0, 0, 0, 0.1), rgba(0, 0, 0, 0.2) ), url('./images/background.jpg');
                background-repeat: no-repeat;
                background-size: 1024px 100%;
                background-position: 50% 0;
                background-attachment: scroll;
                z-index:2;
            }
        }

        @media (min-width: 901px) {
            #header {
                width:100%;
                height: 100vh;
                background: linear-gradient( rgba(0, 0, 0, 0.1), rgba(0, 0, 0, 0.2) ), url('./images/background.jpg');
                background-repeat: no-repeat;
                background-size: 1600px 100%;
                background-position: 50% 0;
                background-attachment: scroll;
                z-index:2;

            }
        }

        a {
            z-index: 12;
        }

        .margins {
            margin-top:51px;
        }

        #maps {
            height:auto;
            z-index:999;
        }


        #report {
            height:auto;
            background-color: #ECEDF2;
            min-height: 800px;
            padding-bottom:25px;
        }

        .navbar-default {
            height: 100px;
            background-color: #2D4D8D;
            height: 40px;
        }

        .down-button {

            margin-top: 20px;
        }

        .first {
            margin-bottom: 8px;
        }
        .centered{ float:none; margin:0 auto;}


         hr {
             margin:auto;
             background-color: #2D4D8D;
        }

        section hr {
            width: 90px;
            border-top: 2px solid transparent;
        }
        hr {
            margin-top: 20px;
            margin-bottom: 20px;
            border: 0;
            border-top: 1px solid #eee;
        }
        .title {
            color:#777;
            margin-top:5%;
            margin-bottom: 2%;
        }
        .title .first-letter {
            color:#2D4D8D;

        }

        h1 {
            font-weight: 900;
        }


    </style>

</head>
   <body>
   <nav class="navbar navbar-default navbar-fixed-top" id="nav-menu">
       <div class="container">
           <div class="navbar-header">
               <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                   <span class="sr-only">Toggle navigation</span>
                   <span class="icon-bar"></span>
                   <span class="icon-bar"></span>
                   <span class="icon-bar"></span>
               </button>
               <a class="navbar-brand" href=<?php echo htmlspecialchars($_SERVER['PHP_SELF']) ?>>Victoria Connect</a>
           </div>
           <div id="navbar" class="navbar-collapse collapse">
               <ul class="nav navbar-nav navbar-right">
                   <li><a class="btn nav-link" href="#about">About</a></li>
                   <li><a class="btn nav-link" href="#maps">Map</a></li>
                   <li><a class="btn nav-link" href="#report">Reports</a></li>
               </ul>
           </div><!--/.nav-collapse -->
       </div>
   </nav>
      <header id="header">
          <div class="container">
              <div class="jumbotron text-center col-xs-12">
                  <h1 class="down-text">
                      <div class = "first"><strong>Strengthening Citizen</strong></div>
                      <div class = "sub">Engagement with Government</div>
                  </h1>

                  <h4 class="space">
                      <div class="first"> Beta version. Developed by <a style="color:white; text-decoration: underline" href="http://www.cityxlab.com/">CityX</a>.</div>
                  </h4>

                  <div class="col-xs-1 centered"><a class="btn-cus down-button" href="#" rel="next"><i class="fa fa-chevron-circle-down fa-3x"></i></a></div>
              </div>
          </div>
      </header>

   <section id="about">
       <div class="container">
               <p style="margin-top:140px; margin-bottom: 100px; font-size: 28px; line-height: 1.6em;">
                   Victoria Connect helps Victorian residents make their neighbourhood works better by reporting issues such as potholes, damaged signs, signal malfunction, unsafe locations, crashes, near-crashes, debris on the road, dead animal, etc. Reports are collected and archived at a database hosted at the National eResearch Collaboration Tools and Resources project (Nectar) cloud for research purposes. This is a beta version. We are currently working with city councils in Victoria to improve this service and hopefully roll out the final version of the app. Hang in there for a bit longer.
               </p>
       </div>
   </section>

   <section id="maps">
           <div class="col-xs-12 margins">
<!--               <h1 class="text-left"><span class="first-letter">T</span>he Map</h1>-->
<!--               <hr class="text-left">-->
           </div>


           <div class="map-container" id="map" style="width:100%; height: 600px;">
           </div>

   </section>
   <section id="report">
       <div class="container">
           <div class="col-xs-12 title ">
               <h1 class="text-center"><span class="first-letter">R</span>eports</h1>
               <hr class="text-center">
           </div>

           <div class="report container">
               <div class="report col-xs-12">
                   <?php
                   $tableReport = ReportRepository::getAllTableReport();
                   $html = '<table id="example" class="display" cellspacing="0" width="100%">
                 <thead>
                    <tr>
                       <th>Report Type</th>
                       <th>Report Status</th>
                       <th>Description</th>
                       <th>Address</th>
                       <th>Create At</th>
                    </tr>
                  </thead>';

                   foreach($tableReport as $report)
                   {
                       if($report->getReportStatus() == 'Solved')
                       {
                           $html .= '<tr class="solved-row">';
                       }
                       else if($report->getReportStatus()=='Created')
                       {
                           $html .= '<tr class="pending-row">';
                       }
                       else
                       {
                           $html .= '<tr>';
                       }

                       $html .= '
                        <td>'.$report->getReportType().'</td>
                        <td>'.$report->getReportStatus().'</td>
                        <td>'.$report->getDescription().'</td>
                        <td>'.$report->getAddress().'</td>
                        <td>'.$report->getCreateAt().'</td>
                       </tr>';
                   }
                   $html .= '</table>';

                   echo $html;
                   ?>
               </div>

       </div>
       </section>
   </body>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
<script src="js/classie.js"></script>
<script src="js//leaflet.js"></script>
<script src="js/Control.Loading.js"></script>
<script src="js/jquery.easing.min.js"></script>
<script src="js/jquery.malihu.PageScroll2id.min.js"></script>
<script src="js/modernizr.custom.js"></script>
<script src="js/jquery.dataTables.min.js"></script>
<script>


    var cbpAnimatedHeader = (function() {

        var docElem = document.documentElement,
            header = document.querySelector('.navbar-fixed-top'),
            downButton = document.querySelector('.down-button'),
            downText = document.querySelector('.down-text'),
            didScroll = false,
            changeHeaderOn = 200;

       // console.log(header);

        function init() {
            window.addEventListener( 'scroll', function( event ) {
                if( !didScroll ) {
                    didScroll = true;
                    setTimeout( scrollPage, 100 );
                }
            }, false );
        }

        function scrollPage() {
            var sy = scrollY();
            //console.log(header);
            if ( sy <= changeHeaderOn ) {
             //   classie.remove( header, 'navbar-expanded' );
                classie.remove(downButton,'hide');
                classie.remove(downText,'hide');
                classie.add( downButton, 'btn-cus' );
            }
            else {
                classie.remove( downButton, 'btn-cus' );
                classie.add(downButton,'hide');
                classie.add(downText,'hide');
            //    classie.add( header, 'navbar-expanded' );
            }
            didScroll = false;
        }

        function scrollY() {
            return window.pageYOffset || docElem.scrollTop;
        }

        init();

    })();

    (function($){

        $(window).load(function(){

            $("#nav-menu a,a[href='#top'],a[rel='m_PageScroll2id']").mPageScroll2id({
                highlightSelector:"#nav-menu a"
            });

            $("a[rel='next']").click(function(e){
                e.preventDefault();
               // var to=$(this).parent().parent("section").next().attr("id");
                console.log(to)
                var to = $('#about').attr("id");
                $.mPageScroll2id("scrollTo",to);
            });

        });
    })(jQuery);
</script>
<script>
    $(document).ready(function()
    {


   // var map = L.map('map').setView([-37.831180, 145.009731], 10);
   var map = L.map('map',{
       center: [-37.831180, 145.009731],
       zoom: 10,
       scrollWheelZoom: false
   });
   // startLoading();

    var bicycleRental = <?php $i = new JsonGenerator();
     echo $i->jsonGenerate(); ?>

        L.tileLayer('https://api.tiles.mapbox.com/v4/{id}/{z}/{x}/{y}.png?access_token={accessToken}', {
            maxZoom: 18,
            id: 'mapbox.mapbox-streets-v7',
            accessToken: 'pk.eyJ1IjoiaHlsYXNjYSIsImEiOiJjaXQ1bGlkcmowMGJmMnNsamQ1dmFsNHhqIn0.03A6_DNp4_9hQligu9xaYA'
        }).addTo(map);







    function onEachFeature(feature, layer) {
        var popupContent = "<img class=\"lazy-image\" src =\"getImage.php?id="+feature.id+"\" width=\"300px;\"><br>";
        if (feature.properties && feature.properties.popupContent) {
            popupContent += "<div class=\"description\" ><br>Created at "+feature.properties.popupCreateAt+"&nbsp;&nbsp;<span class=\"status\">Status: "+feature.properties.popupStatus+"</span><h5>Description</h5>"+feature.properties.popupContent+"</div>";
        }
        layer.bindPopup(popupContent).openPopup();
    }

    L.geoJson([bicycleRental], {

        style: function (feature) {
            return feature.properties && feature.properties.style;
        },

        onEachFeature: onEachFeature,

        pointToLayer: function (feature, latlng) {

            var redIcon = L.icon({
                iconUrl: 'images/pin_red.png',
                popupAnchor: [-3, -76],
                iconSize: [25,25]
            });

            var blackIcon = L.icon({
                iconUrl: 'images/pin_black.png',
                popupAnchor: [-3, -76]
            });

            var icon = redIcon;

            if(feature.properties.popupStatus == 'Solved')
            {
                icon = blackIcon;
            }

            return L.marker(latlng, {icon: icon});

//            return L.circleMarker(latlng, {
//                radius: 6,
//                fillColor: fillColor,
//                color: "#fff",
//                border:"none",
//                weight: 1,
//                opacity: 1,
//                fillOpacity: 0.8,
//                className: className
//            });
        }
    }).addTo(map)
        .on('ready',finishedLoading);

    var loadingControl = L.Control.loading({
        separate: true
    });
    map.addControl(loadingControl);

    function startLoading() {
        loader.className = '';
    }

    function finishedLoading() {
        // first, toggle the class 'done', which makes the loading screen
        // fade out
        loader.className = 'done';
        setTimeout(function() {
            // then, after a half-second, add the class 'hide', which hides
            // it completely and ensures that the user can interact with the
            // map again.
            loader.className = 'hide';
        }, 500);
    }

    });
</script>

<script>
    $(document).ready(function() {
        $('#example').DataTable();
    } );
</script>


</html>