<?php
$username = "root";
$host = "localhost";
$password = "";
$db_name = "fathiye";

$conn = new mysqli($host, $username, $password);

if ($conn->connect_error) {
    die($conn->connect_error);
} else {
    echo "<pre style='display:none;'>connection established</pre>";
}

$sql_db = "CREATE DATABASE IF NOT EXISTS $db_name";

if ($conn->query($sql_db) === TRUE) {
    $conn_db = new mysqli($host, $username, $password, $db_name);

    if ($conn_db->connect_error) {
        die($conn_db->connect_error);
    } else {
        echo "<pre style='display:none;'>connection established</pre>";
    }
} else {
    echo "<pre style='display:none;'>Couldn't query</pre>";
}

$sql_newsletter = "CREATE TABLE IF NOT EXISTS newsletter (email VARCHAR(255) UNIQUE NOT NULL)";

if ($conn_db->query($sql_newsletter)) {
    echo "<pre style='display:none;'>Table created</pre>";
} else {
    echo "<pre style='display:none;'>could not create table</pre>";
}

$err = null;
