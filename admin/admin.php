<?php
$username = "root";
$host = "localhost";
$password = "";
$db_name = "fathiye";

$conn = new mysqli($host, $username, $password);

if ($conn->connect_error) {
    die($conn->connect_error);
} else {
    echo "";
}

$sql_db = "CREATE DATABASE IF NOT EXISTS $db_name";

if ($conn->query($sql_db) === TRUE) {
    $conn_db = new mysqli($host, $username, $password, $db_name);

    if ($conn_db->connect_error) {
        die($conn_db->connect_error);
    } else {
        echo "";
    }
} else {
    echo "";
}

$sql_table = "CREATE TABLE IF NOT EXISTS admin_users (id INT(6) AUTO_INCREMENT PRIMARY KEY, username VARCHAR(25) COLLATE utf8_bin, pscd VARCHAR(255), SS_ID VARCHAR(255))";

if ($conn_db->query($sql_table) === TRUE) {
    echo "";
} else {
    echo "";
}

$sql_blog = "CREATE TABLE IF NOT EXISTS blogs (b_id VARCHAR(255) PRIMARY KEY NOT NULL, title VARCHAR(255) NOT NULL, b_img BLOB, img_type CHAR(6), article TEXT NOT NULL)";

if ($conn_db->query($sql_blog)) {
    echo "<pre style='display:none;'>Table created</pre>";
} else {
    echo "<pre style='display:none;'>Couldn't create table</pre>";
}
$err = null;
$updated = null;
