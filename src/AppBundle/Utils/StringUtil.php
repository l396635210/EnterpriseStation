<?php

namespace AppBundle\Utils;
/**
 * Created by PhpStorm.
 * User: Lizheng
 * Date: 2017/1/30
 * Time: 21:28
 */

class StringUtil {

    private static $images = ["jpg", "jpeg", "png", "gif"];

    public function isImage($ext){
        return in_array($ext, self::$images);
    }

}