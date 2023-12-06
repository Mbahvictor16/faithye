<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/main.css">
    <title>User</title>

    <style>
        div.form-box {
            margin-inline: auto;
        }
    </style>
</head>

<body>
    <?php
    include "../config.php";
    include "../buy/sales.php";
    include "../auth-user.php";

    if (empty($_COOKIE["cookie"])) {
        header("../login");
        exit;
    }
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
                        <?php
                        $u_id = $_COOKIE['cookie'];
                        $sql_cart_num = "SELECT COUNT('$u_id') AS cart_count FROM cart WHERE user_id = '$u_id'";
                        $result = $conn_db->query($sql_cart_num);

                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                $cart_count = $row['cart_count'];
                            }
                        }

                        ?>
                        <li title="cart">
                            <a href="../cart/" id="cart" data-cart="<?php echo $cart_count ?>">
                                <img src="../assets/svg/cart.svg" alt="" style="object-fit: contain; height: 1.5em; width: 1.5em;" />
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
        <?php
        $user = $_COOKIE["cookie"];

        $sql_find_user = "SELECT * FROM users WHERE user_id = '$user'";

        $VALIDUSER = $conn_db->query($sql_find_user);

        if ($VALIDUSER) {
            if ($VALIDUSER->num_rows > 0) {
                $fetchUser = $VALIDUSER->fetch_assoc();

        ?>
                <section class="user-info-section user-details">
                    <div class="user-info-div user-details">
                        <div class="user-email-fl">
                            <b>
                                <?php echo substr(ucfirst($fetchUser["email"]), 0, 1); ?>
                            </b>
                        </div>
                        <div class="user-email-fw">
                            <?php echo $fetchUser["email"]; ?>
                        </div>
                    </div>
                </section>
        <?php
            } else {
                setcookie("cookie", $_COOKIE["cookie"], time() - (86400 * 30), "/");
                header("Location: ../login");
            }
        } else {
            echo "There was a problem in connection. Please try again";
        }
        ?>


        <section class="form-section">
            <div class="form-div">
                <form action="" method="post" data-edit id="data-edit">
                    <?php
                    if ($err !== null) { ?>
                        <div class="error" style="text-align: center;">
                            <?php echo $err; ?>
                        </div>
                    <?php
                    }
                    ?>
                    <div class="form-box">
                        <label for="email">Email</label>
                        <input type="email" name="email" id="email" placeholder="example@gmail.com" data-email />
                        <div id="validate-email">
                            <small data-validate-email></small>
                        </div>
                    </div>

                    <div class="form-box">
                        <label for="password">Password</label>
                        <input type="password" name="password" id="password" placeholder="********" data-password />
                        <div class="password-valid-details" data-password-details>
                            <ul>
                                <li password-data-small-caps>Password must contain at least one lower case letters</li>
                                <li password-data-big-caps>Password must contain at least one upper case letter</li>
                                <li password-data-nums>Password must contain at least one digit</li>
                                <li data-password-length>Password must be between 8 and 16 characters</li>
                            </ul>
                        </div>
                    </div>

                    <div class="form-box">
                        <label for="confirm-password">Confirm Password</label>
                        <input type="password" name="confirm-password" id="confirm-password" placeholder="********" data-confirm-password />
                        <div>
                            <small data-password-match></small>
                        </div>
                    </div>

                    <div class="form-box">
                        <input type="submit" value="Update Details">
                    </div>
                </form>
            </div>
        </section>
        <?php
        $get_purchases = "SELECT DISTINCT ref_id, date_purchased FROM sales WHERE user_id = '$user' LIMIT 5";

        $all_purchases = $conn_db->query($get_purchases);

        if ($all_purchases) {
            if ($all_purchases->num_rows > 0) {
        ?>
                <section class="user-purchase-section user-details">
                    <div class="user-purchase-div user-details">
                        <div class="recent-purchases">
                            <h5>Recent Purchases</h5>

                            <div class="see-all">
                                <a href="./purchases">
                                    <small>
                                        see all &rarr;
                                    </small>
                                </a>
                            </div>
                        </div>
                        <?php
                        while ($row = $all_purchases->fetch_assoc()) { ?>
                            <div class="purchases">
                                <a href="./receipt?ref_id=<?php echo $row["ref_id"] ?>">
                                    <div class="ref_id">
                                        <?php echo $row["ref_id"] ?>
                                    </div>
                                    <div class="date_purchased">
                                        <small>
                                            <?php echo $row["date_purchased"] ?>
                                        </small>
                                    </div>
                                </a>
                            </div>
                        <?php
                        }
                        ?>
                    </div>
                </section>
        <?php
            }
        }
        ?>

    </main>

    <?php $conn_db->close(); ?>
    <script src="../js/hamburger.js"></script>
    <script src="../js/mdq.js"></script>
    <script src="../js/history.js"></script>
    <script src="../js/formValidate.js"></script>

</body>

</html>