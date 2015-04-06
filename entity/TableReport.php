<?php
/**
 * Created by PhpStorm.
 * User: Julian
 * Date: 6/03/15
 * Time: 12:45 PM
 */

class TableReport
{
    private $id;
    private $latitude;
    private $longitude;
    private $reportType;
    private $reportStatus;
    private $description;
    private $address;
    private $createAt;


    public function __construct($id,$latitude,$longitude,$reportType,$reportStatus,$description, $address, $createAt)
    {
        $this->id = $id;
        $this->latitude = $latitude;
        $this->longitude = $longitude;
        $this->reportType = $reportType;
        $this->reportStatus = $reportStatus;
        $this->description = $description;
        $this->address = $address;
        $this->createAt = $createAt;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getReportType()
    {
        return $this->reportType;
    }

    /**
     * @param mixed $reportType
     */
    public function setReportType($reportType)
    {
        $this->reportType = $reportType;
    }

    /**
     * @return mixed
     */
    public function getReportStatus()
    {
        return $this->reportStatus;
    }

    /**
     * @param mixed $reportStatus
     */
    public function setReportStatus($reportStatus)
    {
        $this->reportStatus = $reportStatus;
    }

    /**
     * @return mixed
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param mixed $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * @return mixed
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * @param mixed $address
     */
    public function setAddress($address)
    {
        $this->address = $address;
    }

    /**
     * @return mixed
     */
    public function getCreateAt()
    {
        return $this->createAt;
    }/**
     * @param mixed $createAt
     */
    public function setCreateAt($createAt)
    {
        $this->createAt = $createAt;
    }

    /**
     * @return mixed
     */
    public function getLatitude()
    {
        return $this->latitude;
    }

    /**
     * @param mixed $latitude
     */
    public function setLatitude($latitude)
    {
        $this->latitude = $latitude;
    }

    /**
     * @return mixed
     */
    public function getLongitude()
    {
        return $this->longitude;
    }

    /**
     * @param mixed $longitude
     */
    public function setLongitude($longitude)
    {
        $this->longitude = $longitude;
    }


}