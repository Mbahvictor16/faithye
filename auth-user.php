<?php
if (isset($_COOKIE["cookie"])) {
    $user = $_COOKIE["cookie"];

    $validUser = "SELECT * FROM users WHERE user_id = '$user'";

    $checkUser = $conn_db->query($validUser);

    if ($checkUser) {
        if ($checkUser->num_rows == 0) {
            setcookie("cookie", $user, time() - 86400, "/");
        }
    }
}
