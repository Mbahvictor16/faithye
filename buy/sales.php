<?php
$sql_sales = "CREATE TABLE IF NOT EXISTS sales (user_id VARCHAR(255) NOT NULL, p_ID VARCHAR(255) NOT NULL, p_quan INT(6) NOT NULL, TotalAmount INT NOT NULL, ref_id VARCHAR(500) NOT NULL PRIMARY KEY, date_purchased TIMESTAMP DEFAULT CURRENT_TIMESTAMP NOT NULL, FOREIGN KEY (user_id) REFERENCES users(user_id), FOREIGN KEY (p_ID) REFERENCES products(p_ID))";

if ($conn_db->query($sql_sales)) {
    echo "<script>console.log('created successfully');</script>";
} else {
    echo "<script>console.error('couldn't create table');</script>";
}
