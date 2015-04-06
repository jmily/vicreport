<?php
/**
 * Created by PhpStorm.
 * User: Julian
 * Date: 5/12/14
 * Time: 10:14 AM
 */
require_once 'model/ReportRepository.php';
require_once 'model/Database.php';
require_once 'Config.php';

//sleep(1000);

$id = $_GET['id'];

$report = new ReportRepository();

$image = $report->getImageById($id);

header('Content-type: image/jpg');

echo $image;