<?php

if (!function_exists('dd')) {
    function dd (mixed $vars) {
        echo '<pre>';
        var_dump($vars);
        echo '</pre>';
        exit;
    }
}