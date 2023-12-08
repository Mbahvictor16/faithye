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

$sql_user = "CREATE TABLE IF NOT EXISTS users (user_id VARCHAR(255) NOT NULL PRIMARY KEY UNIQUE, email VARCHAR(255) UNIQUE NOT NULL, pscd VARCHAR(255) NOT NULL)";

if ($conn_db->query($sql_user)) {
    echo "<pre style='display:none;'>Table created</pre>";
} else {
    echo "<pre style='display:none;'>could not create table</pre>";
}

$sql_newsletter = "CREATE TABLE IF NOT EXISTS newsletter (email VARCHAR(255) UNIQUE NOT NULL)";

if ($conn_db->query($sql_newsletter)) {
    echo "<pre style='display:none;'>Table created</pre>";
} else {
    echo "<pre style='display:none;'>could not create table</pre>";
}

$sql_table = "CREATE TABLE IF NOT EXISTS products (p_ID VARCHAR(255) PRIMARY KEY NOT NULL UNIQUE, p_name VARCHAR(255) NOT NULL, p_price DECIMAL(10,2) NOT NULL, p_quan INT(6) NOT NULL, p_description VARCHAR(500) NOT NULL, img_path VARCHAR(255) NOT NULL, date_created TIMESTAMP DEFAULT CURRENT_TIMESTAMP NOT NULL, date_updated TIMESTAMP DEFAULT CURRENT_TIMESTAMP NOT NULL)";

if ($conn_db->query($sql_table)) {
    echo "<pre style='display:none;'>Table created</pre>";
} else {
    echo "<pre style='display:none;'>Couldn't create table</pre>";
}

$sql_blog = "CREATE TABLE IF NOT EXISTS blogs (b_id VARCHAR(255) PRIMARY KEY NOT NULL, title VARCHAR(255) NOT NULL, b_img BLOB,img_type CHAR(6), article TEXT NOT NULL)";

if ($conn_db->query($sql_blog)) {
    echo "<pre style='display:none;'>Table created</pre>";
} else {
    echo "<pre style='display:none;'>Couldn't create table</pre>";
}

$err = null;
