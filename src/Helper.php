<?php


namespace App;


class Helper
{
    function dd($arg)
    {
        echo '<pre>';
        print_r($arg);
        echo '</pre>';
    }

    function goUrl(string $url)
    {
        echo '<script type="text/javascript">location="';
        echo $url;
        echo '";</script>';
    }
}