<?php

/**
 * Created by PhpStorm.
 * User: reunan
 * Date: 01/04/2017
 * Time: 01:19
 */
class Helpers
{
    public static function exec($command){
        return shell_exec($command . " 2>&1");
    }

    public static function contains($text, $match){
        return strpos($text, $match) !== false;
    }
}