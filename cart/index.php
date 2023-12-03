<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/main.css">
    <title>Cart</title>
</head>

<body>
    <?php
    if (empty($_COOKIE["cookie"])) {
        header("Location: ../login");
        exit;
    }
    include "../config.php";
    include "./cart.php";
    include "../auth-user.php";
    ?>
    <header>
        <div class="header-block">
            <div class="logo-menu">
                <div class="hamburger-menu">
                    <div></div>
                    <div></div>
                    <div></div>
                </div>

                <div class="logo">
                    Faithye
                </div>
            </div>

            <div class="nav">
                <nav>
                    <div style="font-size: 3rem; font-weight: bold">
                        <span>
                            &times;
                        </span>
                    </div>
                    <ul>
                        <li><a href="../">Home</a></li>
                        <li><a href="../shop/">Shop</a></li>
                        <li><a href="../blog/">Blog</a></li>
                        <li><a href="../about/">About</a></li>
                    </ul>
                </nav>
            </div>

            <?php if (isset($_COOKIE["cookie"])) { ?>
                <div class="user">
                    <ul style="column-gap: 2em;">
                        <li title="profile">
                            <a href="../user/">
                                <img src="../assets/svg/user.svg" alt="" style="object-fit: contain; height: 1.5em; width: 1.5em;" />
                            </a>
                        </li>
                        <li title="logout">
                            <form action="" method="post">
                                <input type="submit" name="logout" value="" class="form-btn" style="background: url(../assets/svg/logout.svg); background-repeat: no-repeat; background-size: 1.5em; background-position: center; height: 1.5em; border:none; cursor: pointer;" />
                            </form>

                            <?php
                            if (isset($_POST['logout']) && $_SERVER['REQUEST_METHOD'] == 'POST') {
                                setcookie("cookie", $_COOKIE["cookie"], time() - (86400 * 30), "/");
                                header("Location: ../login");
                            }
                            ?>
                        </li>
                    </ul>
                </div>
            <?php } else { ?>
                <div class="user">
                    <ul>
                        <li>
                            <a href="../login/" class="btn login">Login</a>
                        </li>
                        <li>
                            <a href="../register/" class="btn register">Register</a>
                        </li>
                    </ul>
                </div>
            <?php } ?>
        </div>
    </header>

    <main>
        <div class="total-price">
            <?php
            $user_id = $_COOKIE["cookie"];

            $sql_total_price = "SELECT SUM(p_price * quantity) AS total_price  FROM cart INNER JOIN products ON cart.p_ID = products.p_ID WHERE user_id = '$user_id'";

            $result = $conn_db->query($sql_total_price);

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {

                    $sql_cart_num = "SELECT COUNT('$user_id') AS cart_count FROM cart WHERE user_id = '$user_id'";
                    $result = $conn_db->query($sql_cart_num);

                    if ($result->num_rows > 0) {
                        while ($col = $result->fetch_assoc()) {
                            $cart_count = $col['cart_count'];

                            if ($cart_count > 0) { ?>

                                <div>
                                    <h3>Total: <?php echo $row["total_price"]; ?> NGN</h3>

                                    <div>
                                        <a href="../buy" class="btn buy-all">Buy All</a>
                                    </div>
                                </div>

                    <?php }
                        }
                    } ?>
            <?php }
            }
            ?>

        </div>


        <?php
        $u_id = $_COOKIE["cookie"];
        $sql_cart_num = "SELECT COUNT('$u_id') AS cart_count FROM cart WHERE user_id = '$u_id'";
        $result = $conn_db->query($sql_cart_num);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $cart_count = $row['cart_count'];

                if ($cart_count > 0) { ?>

                    <div class="clear-cart" style="display: flex; justify-content: right; padding: 0 2em;">

                        <form action="" method="post">

                            <input type="submit" value="Clear All" name="clearCart" style="background: #000; color:#fff; border: 1px solid #000" />
                        </form>
                    </div>

        <?php
                }
            }
        }
        ?>


        <?php
        if (isset($_POST["clearCart"]) && $_SERVER["REQUEST_METHOD"] == "POST") {
            $user_id = $_COOKIE["cookie"];

            $sql_delete = "DELETE FROM cart WHERE user_id = '$user_id'";

            if ($conn_db->query($sql_delete)) {
                echo "<script>history.back()</script>";
            } else {
                echo "<script>console.error('couldn't deleted');</script>";
            }
        }
        ?>

        <?php
        $user_id = $_COOKIE["cookie"];

        $sql_find_cart = "SELECT * FROM cart RIGHT JOIN products ON cart.p_ID = products.p_ID WHERE user_id = '$user_id'";

        $result = $conn_db->query($sql_find_cart);

        if ($result->num_rows > 0) { ?>
            <div class="cart-page">
                <?php while ($row = $result->fetch_assoc()) { ?>
                    <div class="cart-items">
                        <div class="cart-img">
                            <img src="../<?php echo $row["img_path"]; ?>" alt="">
                        </div>
                        <div class="cart-details">
                            <h3>
                                <?php echo $row["p_name"]; ?>
                            </h3>

                            <div class="cart-price">
                                Unit Price:
                                <span>
                                    <?php echo $row["p_price"]; ?> NGN
                                </span>
                            </div>

                            <div class="cart-quantity">
                                Quantity:
                                <span>
                                    <?php echo $row["quantity"]; ?>
                                </span>
                            </div>

                            <div class="cart-unit-totalAmount">
                                Total:
                                <span>
                                    <?php echo $row["p_price"] * $row["quantity"]; ?> NGN
                                </span>
                            </div>

                            <div class="action">
                                <div class="buy-action">
                                    <a href="../buy?p_id=<?php echo $row["p_ID"] . "&qty=" . $row["quantity"]; ?>" class="btn">Buy Now</a>
                                </div>

                                <form action="" method="post">
                                    <input type="hidden" name="delete_id" value="<?php echo $row["p_ID"]; ?>">
                                    <input type="submit" value="Remove" style="background: #000; display:block; width: 100%; border: 1px solid #000000; color: #ffffff">
                                </form>
                                <?php
                                if (isset($_POST['delete_id']) && $_SERVER['REQUEST_METHOD'] == 'POST') {
                                    $user_id = $_COOKIE['cookie'];
                                    $delete_p_id = $_POST['delete_id'];

                                    $sql_delete = "DELETE FROM cart WHERE p_ID = '$delete_p_id' AND user_id = '$user_id'";

                                    if ($conn_db->query($sql_delete)) {
                                        echo "<script>history.back()</script>";
                                    } else {
                                        echo "<script>console.error('couldn't deleted');</script>";
                                    }
                                }
                                ?>
                            </div>
                        </div>
                    </div>
                <?php } ?>

            </div>


        <?php } else { ?>
            <div class="empty-cart">
                Your cart is empty!
            </div>
        <?php } ?>

    </main>
    <?php $conn_db->close() ?>

    <script src="../js/hamburger.js"></script>
    <script src="../js/mdq.js"></script>
    <script src="../js/history.js"></script>
</body>

</html>