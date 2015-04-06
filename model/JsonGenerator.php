<?php
/**
 * Created by PhpStorm.
 * User: Julian
 * Date: 5/12/14
 * Time: 10:53 AM
 */
require_once 'model/Database.php';
require_once 'model/ReportRepository.php';
require_once 'Config.php';
require_once 'entity/Report.php';

class JsonGenerator
{
   public function jsonGenerate()
   {
       $reportRepository = new ReportRepository();
       $reports = $reportRepository->getAllTableReport();

       $json = '{
            "type": "FeatureCollection",
            "features": [';

       foreach ($reports as $report)
       {
           $prettyDate = date('D j/M/Y', strtotime($report->getCreateAt()));
         $json .= '{
                     "geometry": {
                          "type": "Point",
                          "coordinates": ['.$report->getLongitude().','
                                           .$report->getLatitude().'
                                          ]
                                 },
                     "type": "Feature",
                     "properties" :
                     {
                         "popupContent": "'.$report->getDescription().'",
                         "popupStatus": "'.$report->getReportStatus().'",
                         "popupCreateAt": "'.$prettyDate.'"
                     },
                     "id": '.$report->getId().'
                     },';
       }
       $json .= '
            ]
        }';
       return $json;
   }
}

