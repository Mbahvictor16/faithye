<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/main.css">
    <title>Buy</title>

    <style>
        .card {
            width: min(90%, 340px);
            height: fit-content;
            box-shadow: 2px 2px 8px #cccccc, -2px -2px 8px #cccccc, -2px 2px 8px #cccccc,
                2px -2px 8px #cccccc;
            padding: 12px 16px;
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            border-radius: 3px;
        }

        input[type="text"] {
            width: 8ch;
            border: 1px solid #000 !important;
            outline: 1px solid #000 !important;
        }

        input[type="text"]:focus {
            border: 1px solid var(--primary-color) !important;
            outline: 1px solid var(--primary-color) !important;
        }

        input[type="text"]::placeholder {
            text-align: center;
        }

        .card-number {
            margin-top: 24px;
        }

        .card-number-details {
            display: flex;
            justify-content: space-evenly;
        }

        .cvv-exp-date {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin: 32px 12px;
        }

        .card-number-details-label,
        .cvv-label,
        .exp-date-label {
            margin-bottom: 12px;
        }

        input[type="text"].input-error {
            border: 1px solid var(--error) !important;
            outline: 1px solid var(--error) !important;
        }
    </style>
</head>

<body>
    <?php
    include "../config.php";
    include "./sales.php";
    include "../auth-user.php";
    if (empty($_COOKIE["cookie"])) {
        header("Location: ../login");
        exit;
    }
    ?>
    <header class="product-details-header product-header">
        <span onclick="history.back()">
            &larr;
        </span>
    </header>

    <main>
        <?php
        if ($_SERVER["REQUEST_METHOD"] == "POST") {

            $ref_id = "ref:" . uniqid(uniqid(uniqid(), true), true);

            $user_id = $_COOKIE["cookie"];

            $totalAmount = $_POST["TotalAmount"];

            if (empty($_GET["p_id"])) {
                $sql_get_sales = "SELECT * FROM cart RIGHT JOIN products ON cart.p_ID = products.p_ID WHERE user_id = '$user_id'";

                $sales = $conn_db->query($sql_get_sales);

                if ($sales->num_rows > 0) {
                    while ($product = $sales->fetch_assoc()) {
                        $price = $product["p_price"];
                        $p_id = $product["p_ID"];
                        $quantity = $product["quantity"];
                        $p_quan = $product["p_quan"];

                        $Amount = $price * $quantity;

                        $new_quan = $p_quan - $quantity;

                        $sql_insert_sales = "INSERT INTO sales (user_id, p_id, p_quan, TotalAmount, ref_id) VALUES ('$user_id', '$p_id', '$quantity', '$Amount', '$ref_id')";

                        $sql_update_product_quantity = "UPDATE products SET p_quan = '$new_quan' WHERE p_ID = '$p_id'";

                        $sql_del_cart = "DELETE FROM cart WHERE p_ID = '$p_id' AND user_id = '$user_id'";

                        if ($conn_db->query($sql_insert_sales) && $conn_db->query($sql_update_product_quantity) && $conn_db->query($sql_del_cart)) {
                            header("Location: ../");
                        }
                    }
                }
            }

            if (isset($_GET["p_id"])) {
                $p_id = $_GET["p_id"];
                $qty = $_GET["qty"];
                $sql_del_cart = "DELETE FROM cart WHERE user_id = '$user_id' AND p_ID = '$p_id'";

                $sql_select_product_quantity = "SELECT * FROM products WHERE p_ID = '$p_id'";

                $sql_insert_sales = "INSERT INTO sales (user_id, p_id, p_quan, TotalAmount, ref_id) VALUES ('$user_id', '$p_id', '$qty', '$totalAmount', '$ref_id')";

                if ($conn_db->query($sql_insert_sales)) {

                    $result = $conn_db->query($sql_select_product_quantity);

                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            $new_quan = $row['p_quan'] - $_GET['qty'];
                            $sql_update_product_quantity = "UPDATE products SET p_quan = '$new_quan' WHERE p_ID = '$p_id'";


                            if ($conn_db->query($sql_del_cart) && $conn_db->query($sql_update_product_quantity)) {
                                header("Location: ../");
                            }
                        }
                    }
                }
            }
        }
        ?>
        <div>
            <?php
            $user_id = $_COOKIE["cookie"];
            if (empty($_GET["p_id"])) {

                $sql_total_price = "SELECT SUM(p_price * quantity) AS total_price FROM cart RIGHT JOIN products ON cart.p_ID = products.p_ID WHERE user_id = '$user_id'";

                $result = $conn_db->query($sql_total_price);

                if ($result->num_rows > 0) {

                    while ($row = $result->fetch_assoc()) {
            ?>
                        <div class="card">
                            <form action="" method="post">
                                <div class="card-number">

                                    <div class="card-number-details-label">
                                        Card Number
                                    </div>

                                    <div class="card-number-details">
                                        <input type="text" pattern="[0-9]{4}" name="" id="" maxlength="4" class="first-number" placeholder="xxxx" />


                                        <input type="text" pattern="[0-9]{4}" name="" id="" maxlength="4" class="second-number" placeholder="xxxx" />

                                        <input type="text" pattern="[0-9]{4}" name="" id="" maxlength="4" class="third-number" placeholder="xxxx" />


                                        <input type="text" pattern="[0-9]{4}" name="" id="" maxlength="4" class="fourth-number" placeholder="xxxx" />
                                    </div>

                                </div>

                                <div class="cvv-exp-date">
                                    <div class="cvv">
                                        <div class="cvv-label">
                                            CVV
                                        </div>
                                        <input type="text" pattern="[0-9]{3}" name="" id="" maxlength="3" class="cvv-number" placeholder="xxx" />
                                    </div>

                                    <div class="exp-date">
                                        <div class="exp-date-label">
                                            Exp Date
                                        </div>
                                        <input type="text" pattern="[0-9]{2}" name="" id="" maxlength="2" class="exp-month" placeholder="xx" />
                                        <input type="text" pattern="[0-9]{2}" name="" id="" maxlength="2" class="exp-year" placeholder="xx" />
                                    </div>
                                </div>

                                <input type="hidden" name="TotalAmount" value=" <?php echo $row["total_price"]; ?>" />

                                <div class="pay-submit">
                                    <input type="submit" value="Pay <?php echo $row["total_price"]; ?> NGN" style="display: block !important; width: 100%; background:#000; border: 1px solid #000; color: #fff" />
                                </div>

                            </form>
                        </div>

                    <?php }
                }
            } else if (isset($_GET["p_id"]) && isset($_GET["qty"])) {
                $p_id = $_GET["p_id"];
                $sql_find_cart = "SELECT * FROM products WHERE p_ID = '$p_id' AND p_quan <> 0";

                $result = $conn_db->query($sql_find_cart);

                if ($result->num_rows > 0) {

                    while ($row = $result->fetch_assoc()) {

                    ?>

                        <div class="card">
                            <form action="" method="post">
                                <div class="card-number">

                                    <div class="card-number-details-label">
                                        Card Number
                                    </div>

                                    <div class="card-number-details">
                                        <input type="text" pattern="[0-9]{4}" name="" id="" maxlength="4" class="first-number" placeholder="xxxx" />


                                        <input type="text" pattern="[0-9]{4}" name="" id="" maxlength="4" class="second-number" placeholder="xxxx" />

                                        <input type="text" pattern="[0-9]{4}" name="" id="" maxlength="4" class="third-number" placeholder="xxxx" />


                                        <input type="text" pattern="[0-9]{4}" name="" id="" maxlength="4" class="fourth-number" placeholder="xxxx" />
                                    </div>

                                </div>

                                <div class="cvv-exp-date">
                                    <div class="cvv">
                                        <div class="cvv-label">
                                            CVV
                                        </div>
                                        <input type="text" pattern="[0-9]{3}" name="" id="" maxlength="3" class="cvv-number" placeholder="xxx" />
                                    </div>

                                    <div class="exp-date">
                                        <div class="exp-date-label">
                                            Exp Date
                                        </div>
                                        <input type="text" pattern="[0-9]{2}" name="" id="" maxlength="2" class="exp-month" placeholder="xx" />
                                        <input type="text" pattern="[0-9]{2}" name="" id="" maxlength="2" class="exp-year" placeholder="xx" />
                                    </div>
                                </div>

                                <input type="hidden" name="TotalAmount" value=" <?php echo $row["p_price"]; ?>" />

                                <div class="pay-submit">
                                    <input type="submit" value="Pay <?php echo $row["p_price"] * $_GET["qty"]; ?> NGN" style="display: block !important; width: 100%; background:#000; border: 1px solid #000; color: #fff" />
                                </div>

                            </form>
                        </div>


                    <?php }
                } else { ?>
                    <div style="text-align: center; color: #cccccc;">
                        <span>
                            You cannot pay for items that are out of stock.
                        </span>
                    </div>
            <?php
                }
            } ?>

        </div>
    </main>
    <?php $conn_db->close() ?>
    <script src="../js/pay.js"></script>
    <script src="../js/history.js"></script>
</body>

</html>