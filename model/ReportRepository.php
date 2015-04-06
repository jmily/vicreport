<?php
/**
 * Created by PhpStorm.
 * User: Julian
 * Date: 5/12/14
 * Time: 9:39 AM
 */

class ReportRepository
{
   public function getAllReports()
   {
       $link = Database::DbConnection();
       $query = "SELECT * FROM reports ";
       $result = $link->query($query) or die($link->error.__LINE__);

       while($row = $result->fetch_assoc())
       {
           $report = new Report($row['report_id'],$row['description'], $row['latitude'], $row['longitude'], $row['address']);
           $reports[] = $report;

       }
       Database::ConnectionClose($link);
       return $reports;
   }

   public function getImageById($id)
   {
       $link = Database::DbConnection();
       $query = "SELECT image FROM reports WHERE report_id = $id ";
       $result = $link->query($query) or die($link->error.__LINE__);

       while($row = $result->fetch_assoc())
       {
           $image = $row['image'];
       }
       Database::ConnectionClose($link);
       return $image;
   }

    public static function getAllTableReport()
    {
        $link = Database::DbConnection();
        $query = "SELECT * FROM `reports`
                  INNER JOIN `report_status` ON `reports`.`report_status_id` = `report_status`.`report_status_id`
                  INNER JOIN `report_types` ON `reports`.`report_type_id` = `report_types`.`report_type_id`";
        $result = $link->query($query) or die($link->error.__LINE__);

        while($row = $result->fetch_assoc())
        {
            $tableReport = new TableReport($row['report_id'],$row['latitude'],$row['longitude'],$row['report_description'], $row['report_status_description'], $row['description'], $row['address'],$row['created_at']);
            $tableReports[] = $tableReport;

        }
        Database::ConnectionClose($link);
        return $tableReports;
    }
}




