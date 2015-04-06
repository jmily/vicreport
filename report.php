
<?php
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
    <script src="js/jquery-1.11.1.min.js"></script>
    <script src="js/jquery.dataTables.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/js/bootstrap.min.js"></script>
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/dataTable.css" />
    <link rel="stylesheet" href="css/style.css" />
    <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" />
    <script>
        $(document).ready(function() {
            $('#example').DataTable();
        } );
    </script>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body{margin:0;}
    </style>
</head>
<body>
<nav class="navbar navbar-inverse navbar-fixed-top">
    <div class="navbar-inner">
    <div class="container">
        <div class="navbar-header">

            <a class="navbar-brand" href="#">Monash Road Report</a>
        </div>
        <div id="navbar" class="navbar-collapse collapse">
        </div><!--/.nav-collapse -->
    </div>
        </div>
</nav>
<div class="container">
    <div class="report-heading">
        <h4 class="report-heading-text"><i class="report-icon fa fa-file-text-o"></i>Report</h4>
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


</body>
</html>


