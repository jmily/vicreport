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
    <title>Victoria Reports</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/leaflet.css" />
    <link rel="stylesheet" href="css/Control.Loading.css" />
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/dataTable.css" />
    <link rel="stylesheet" href="css/style.css" />
    <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" />


    <script src="js/jquery-1.11.1.min.js"></script>
    <script src="js/jquery.dataTables.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/js/bootstrap.min.js"></script>

    <script src="js//leaflet.js"></script>
    <script src="js/Control.Loading.js"></script>
    <script src="js/jquery.malihu.PageScroll2id.min.js"></script>

    <script src="js/main.js"></script>
    <!-- Latest compiled and minified CSS -->

    <script>
        $(document).ready(function() {
            $('#example').DataTable();
        } );
    </script>



</head>
<body>

<div id="loader">
    <div class="l">L</div>
    <div class="o">O</div>
    <div class="a">A</div>
    <div class="d">D</div>
    <div class="i">I</div>
    <div class="n">N</div>
    <div class="g">G</div>
</div>


<div id="map" style="width: 100vw; height: 100vh">
    <div class="footer">
        <div class="show-report container" id="nav-menu"><a href="#report"><i class="report-icon fa fa-file-text-o"></i>SHOW REPORTS</div></a>
    </div>
</div>

<div id="control">
   <div id="check-status">
       <input type = "radio" name = "status" class = "report-status" value = "allStatus" checked = "checked" />
       <label for = "sizeSmall">show all status</label>
       <br>
       <input type = "radio" name = "status" class="report-status" value = "created" />
       <label for = "sizeMed">Created</label>
       <br>

       <input type = "radio" name = "status" class="report-status" value = "solved" />
       <label for = "sizeLarge">Solved</label>
       <br>
       </div>
</div>

<div class="content" id="report" style="position: absolute; top:100vh; width:100%; background-color: white; height:1000px; z-index: 1208;">
    <div class="show-map container"><a href="#top"><i class="show-map-icon fa fa-map-marker"></i>Show whole map</div></a>
    <div class="report container">
        <div class="report-heading">
            <h4 class="report-heading-text">Report</h4>
        </div>
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
</div>



<script>

    var map = L.map('map').setView([-37.831180, 145.009731], 10);
    startLoading();

    var bicycleRental = <?php $i = new JsonGenerator();
     echo $i->jsonGenerate(); ?>

    L.tileLayer('https://{s}.tiles.mapbox.com/v3/{id}/{z}/{x}/{y}.png', {
        maxZoom: 18,
        id: 'examples.map-20v6611k'
    }).addTo(map);




    function onEachFeature(feature, layer) {
        var popupContent = "<img class=\"lazy-image\" src =\"getImage.php?id="+feature.id+"\" width=\"300px;\"><br>";
        if (feature.properties && feature.properties.popupContent) {
            popupContent += "<div class=\"description\" ><br>Created at "+feature.properties.popupCreateAt+"<span class=\"status\">Status: "+feature.properties.popupStatus+"</span><h5>Description</h5>"+feature.properties.popupContent+"</div>";
        }
        layer.bindPopup(popupContent);
    }

    L.geoJson([bicycleRental], {

        style: function (feature) {
            return feature.properties && feature.properties.style;
        },

        onEachFeature: onEachFeature,

        pointToLayer: function (feature, latlng) {

            var fillColor = "#ff7800";
            var className = "created";
            if(feature.properties.popupStatus == 'Solved')
            {
                fillColor = "#5cb85c";
                className = "solved";
            }
            return L.circleMarker(latlng, {
                radius: 6,
                fillColor: fillColor,
                color: "#fff",
                border:"none",
                weight: 1,
                opacity: 1,
                fillOpacity: 0.8,
                className: className
            });
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


    $('body').on('change','.report-status',function()
    {
       var selectedValue = this.value;
        if(selectedValue == 'created')
        {
            $('.solved').hide();
            $('.created').show();
        }
        else if(selectedValue == 'solved')
        {
            $('.solved').show();
            $('.created').hide();
        }
        else
        {
            $('.solved').show();
            $('.created').show();
        }
    });

</script>
</body>
</html>
