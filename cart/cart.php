<?php

$sql_cart = "CREATE TABLE IF NOT EXISTS cart (user_id VARCHAR(255) NOT NULL, p_ID VARCHAR(255) NOT NULL, quantity INT(6) NOT NULL, FOREIGN KEY (user_id) REFERENCES users(user_id), FOREIGN KEY (p_ID) REFERENCES products(p_ID))";

if ($conn_db->query($sql_cart)) {
    echo "<pre style='display:none;'>Table created</pre>";
} else {
    echo "<pre style='display:none;'>could not create table</pre>";
}

$dialog = true;
