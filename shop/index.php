<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/main.css">
    <title>Shop</title>
</head>

<body>
    <?php
    include "../config.php";
    include "../cart/cart.php";
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
                        <li><a href="">Shop</a></li>
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
        <section class="hot-product-section product-section">
            <div class="hot-product-bg product-bg">
                <div class="hot-product-div product-div">
                    <div class="title-heading-search">
                        <h1 class="product-heading">All Products</h1>

                        <div class="product-filter">
                            <form action="" class="search" method="get">
                                <div class="form-input">
                                    <input type="text" name="search" id="search" placeholder="Search e.g Blue Water Lilies" />
                                    <button type="submit" class="form-btn">&rarr;</button>
                                </div>
                            </form>
                        </div>
                    </div>

                    <hr>

                    <div class="all-product-container product-container">
                        <?php
                        $sql_get_all = "SELECT * FROM products ORDER BY date_created DESC";

                        $result = $conn_db->query($sql_get_all);

                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) { ?>
                                <div class="all-product product-card">
                                    <div class="all-product-img-div product-img-div">
                                        <img src="../<?php echo $row["img_path"]; ?>" alt="" class="all-product-img product-img">
                                    </div>
                                    <div class="all-product-title product-title">
                                        <span class="all-product-text product-text">
                                            <?php echo $row["p_name"]; ?>
                                        </span>

                                        <div class="all-product-price product-price">
                                            <div class="price-div">
                                                <span class="price">
                                                    <?php echo $row["p_price"]; ?> NGN
                                                </span>
                                            </div>
                                        </div>

                                        <div class="view-product">
                                            <div class="action view btn">
                                                <a href="../product?product_id=<?php echo $row["p_ID"]; ?>" class="btn view-link">
                                                    View Product
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            <?php
                            }
                        } else { ?>
                            <div style="text-align: center; color: #cccccc;">
                                You don't have any products.
                            </div>
                        <?php } ?>

                    </div>
                </div>
            </div>
        </section>
    </main>

    <footer>
        <h3>Fathiye</h3>

        <div>
            <div class="nav--footer">
                <div role="navigation">
                    <ul>
                        <li><a href="../">Home</a></li>
                        <li><a href="">Shop</a></li>
                        <li><a href="../blog/">Blog</a></li>
                        <li><a href="../about/">About</a></li>
                    </ul>
                </div>
            </div>

            <div class="news-letter">
                <div class="search-div">
                    <div class="search-box">
                        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) ?>" method="post">
                            <div style="margin-bottom: 6px;">
                                Sign up for our weekly newsletter?
                            </div>
                            <input type="email" name="news-letter" id="news-letter" placeholder="Type your email address" />
                            <button type="submit" class="form-btn" style="background: #ccc; border: 1px solid #ccc; border-radius: 3px;">&rarr;</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </footer>
    <?php $conn_db->close() ?>

    <script src="../js/hamburger.js"></script>
    <script src="../js/mdq.js"></script>
    <script src="../js/history.js"></script>

</body>

</html>