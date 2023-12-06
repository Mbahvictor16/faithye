<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/main.css">
    <title>Blogs</title>
</head>

<body>
    <?php
    include "../config.php";
    include "../cart/cart.php";
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
                        <li><a href="">Blog</a></li>
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
    </main>

    <?php $conn_db->close(); ?>
    <script src="../js/hamburger.js"></script>
    <script src="../js/mdq.js"></script>
    <script src="../js/history.js"></script>
</body>

</html>