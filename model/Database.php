<?php
/**
 * Created by PhpStorm.
 * User: Julian
 * Date: 5/12/14
 * Time: 9:38 AM
 */

class Database
{
    public static function DbConnection()
    {
        $link = new mysqli(Config::DB_HOST,Config::DB_USER,Config::DB_PASS,Config::DB_NAME);
        if (mysqli_connect_errno())
        {
            printf("Connect failed: %s\n", mysqli_connect_error());
            exit();
        }
        return $link;
    }
    public static function ConnectionClose($link)
    {
        mysqli_close($link);
    }
} 