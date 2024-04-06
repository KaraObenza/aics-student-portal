<?php

$connection = mysqli_connect('localhost','root','','aics');

if (! $connection) {
    die("Error: Could not connect to the database. " . mysqli_connect_error());
}