<?php
$username = "mbahvictor16";
$secret = "mbah2001";
$pass = password_hash($secret, PASSWORD_DEFAULT);
$id = uniqid(uniqid(), true);
$session = "session-$id";
$sql_find = "SELECT * FROM admin_users WHERE username = '$username'";
$sql_insert = "INSERT INTO admin_users(username, pscd, SS_ID) VALUES ('$username', '$pass', '$session')";
