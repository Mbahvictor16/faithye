<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <link rel="stylesheet" href="./css/main.css">
    <title>Faithye</title>

    <style>
        .go-to-shop-btn:hover {
            background: #ffffff !important;
            color: #000000 !important;
            border: 1px solid #000000;
        }
    </style>
</head>

<body>
    <?php
    include "./config.php";
    include "./cart/cart.php";
    include "./buy/sales.php";
    include "./auth-user.php";

    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["search"])) {
        $q = $_POST["search"];
        header("Location: ./search?q=$q");
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
                        <li><a href="">Home</a></li>
                        <li><a href="./shop/">Shop</a></li>
                        <li><a href="./blog/">Blog</a></li>
                        <li><a href="./about/">About</a></li>
                    </ul>
                </nav>
            </div>

            <?php if (isset($_COOKIE["cookie"])) { ?>
                <div class="user">
                    <ul style="column-gap: 2em;">
                        <li title="cart">
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
                            <a href="./cart/" id="cart" data-cart="<?php echo $cart_count; ?>">
                                <img src="./assets/svg/cart.svg" alt="" style="object-fit: contain; height: 1.5em; width: 1.5em;" />
                            </a>
                        </li>
                        <li title="profile">
                            <a href="./user/">
                                <img src="./assets/svg/user.svg" alt="" style="object-fit: contain; height: 1.5em; width: 1.5em;" />
                            </a>
                        </li>
                        <li title="logout">
                            <form action="" method="post">
                                <input type="submit" name="logout" value="" class="form-btn" style="background: url(./assets/svg/logout.svg); background-repeat: no-repeat; background-size: 1.5em; background-position: center; height: 1.5em; border:none; cursor: pointer;" />
                            </form>

                            <?php
                            if (isset($_POST['logout']) && $_SERVER['REQUEST_METHOD'] == 'POST') {
                                setcookie("cookie", $_COOKIE["cookie"], time() - (86400 * 30), "/");
                                header("Location: ./login");
                            }
                            ?>
                        </li>
                    </ul>
                </div>
            <?php } else { ?>
                <div class="user">
                    <ul>
                        <li>
                            <a href="./login/" class="btn login">Login</a>
                        </li>
                        <li>
                            <a href="./register/" class="btn register">Register</a>
                        </li>
                    </ul>
                </div>
            <?php } ?>
        </div>

        <div class="search-div">
            <div class="search-box">
                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) ?>" method="post">
                    <input type="search" name="search" id="search" placeholder="Search e.g Blue Water Lilies" />
                    <input type="submit" value="Search" class="form-btn" />
                </form>
            </div>
        </div>
    </header>

    <main>
        <section class="hero">
            <div class="hero-bg">
                <div class="hero-container">
                    <div class="hero-title">
                        <div class="hero-text">
                            <h1>Enjoy your Shopping</h1>
                            <a href="./shop/" class="btn">Shop Now &rarr;</a>
                        </div>
                    </div>

                    <div class="hero-banner">
                        <div class="hero-img">
                            <img src="./assets/Blue Sky noBg.png" alt="">
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="best-seller-product-section product-section">
            <div class="best-seller-product-bg product-bg">
                <div class="best-seller-product-div product-div">
                    <h1>Best Sellers⭐</h1>

                    <div class="best-seller-product-container product-container">
                        <?php
                        $sql_get = "SELECT DISTINCT sales.p_ID, products.img_path, products.p_name FROM sales INNER JOIN products ON products.p_ID = sales.p_ID ORDER BY sales.p_quan DESC LIMIT 5;";

                        $result = $conn_db->query($sql_get);

                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                        ?>
                                <div class="best-seller-product product-card">
                                    <a href="./product?p_id=<?php echo $row["p_ID"] ?>">
                                        <div class="best-seller-product-img-div product-img-div">
                                            <img src="./<?php echo $row["img_path"] ?>" alt="" class="product-img">
                                        </div>
                                        <div class="best-seller-product-title product-title">
                                            <span class="best-seller-product-text product-text">
                                                <?php echo $row["p_name"] ?>
                                            </span>
                                        </div>
                                    </a>
                                </div>
                            <?php }
                        } else { ?>
                            <div class="hide"></div>
                        <?php } ?>


                    </div>
                </div>
            </div>
        </section>

        <section class="hot-product-section product-section">
            <div class="hot-product-bg product-bg">
                <div class="hot-product-div product-div">
                    <h1>Hot Products🔥</h1>

                    <div class="hot-product-container product-container">
                        <?php
                        $sql_get = "SELECT DISTINCT sales.p_ID, products.img_path, products.p_name FROM sales INNER JOIN products ON products.p_ID = sales.p_ID ORDER BY sales.date_purchased DESC LIMIT 5;";

                        $result = $conn_db->query($sql_get);

                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                        ?>
                                <div class="hot-product product-card">
                                    <a href="./product?p_id=<?php echo $row["p_ID"] ?>">
                                        <div class="hot-product-img-div product-img-div">
                                            <img src="./<?php echo $row["img_path"] ?>" alt="" class="product-img">
                                        </div>
                                        <div class="hot-product-title product-title">
                                            <span class="hot-product-text product-text">
                                                <?php echo $row["p_name"] ?>
                                            </span>
                                        </div>
                                    </a>
                                </div>
                            <?php }
                        } else { ?>
                            <div class="hide"></div>
                        <?php } ?>


                    </div>
                </div>
            </div>
        </section>

        <section class="new-product-section product-section">
            <div class="new-product-bg product-bg">
                <div class="new-product-div product-div">
                    <h1>Newest Products</h1>

                    <div class="new-product-container product-container">
                        <?php
                        $sql_get = "SELECT p_name, p_ID, img_path FROM products ORDER BY date_created DESC LIMIT 5";

                        $result = $conn_db->query($sql_get);

                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                        ?>
                                <div class="new-product product-card">
                                    <a href="./product?p_id=<?php echo $row["p_ID"] ?>">
                                        <div class="new-product-img-div product-img-div">
                                            <img src="./<?php echo $row["img_path"] ?>" alt="" class="new-product-img product-img">
                                        </div>
                                        <div class="new-product-title product-title">
                                            <span class="new-product-text product-text">
                                                <?php echo $row["p_name"] ?>
                                            </span>
                                        </div>
                                    </a>
                                </div>
                            <?php }
                        } else { ?>
                            <div class="hide"></div>
                        <?php } ?>

                    </div>
                </div>
            </div>
        </section>

        <section class="goto-shop" style="margin-top: 40px;">
            <div style="text-align: center;">
                <a href="./shop/" class="btn go-to-shop-btn" style="background: #000000; color: #ffffff; padding: 0.75em 1em;">
                    Go to Shop &rarr;
                </a>
            </div>
        </section>

        <section class="new-product-section product-section">
            <div class="new-product-bg product-bg">
                <div class="new-product-div product-div">
                    <h1>RECENT BLOGS</h1>

                    <div class="new-product-container product-container">
                        <?php
                        $sql_get = "SELECT * FROM blogs";

                        $result = $conn_db->query($sql_get);

                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                        ?>
                                <div class="new-product product-card">
                                    <a href="./blog/article?b_id=<?php echo $row["b_id"] ?>">
                                        <div class="new-product-img-div product-img-div">
                                            <img src="data:<?php echo $row["img_type"] ?>;base64,<?php echo $row["b_img"]; ?>" alt="" class="new-product-img product-img">
                                        </div>
                                        <div class="new-product-title product-title">
                                            <span class="new-product-text product-text">
                                                <?php echo $row["title"] ?>
                                            </span>
                                        </div>
                                    </a>
                                </div>
                            <?php }
                        } else { ?>
                            <div class="hide"></div>
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
                        <li><a href="">Home</a></li>
                        <li><a href="./shop/">Shop</a></li>
                        <li><a href="./blog/">Blog</a></li>
                        <li><a href="./about/">About</a></li>
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
    <?php
    $conn_db->close();
    ?>
    <script async src="./js/hamburger.js"></script>
    <script src="./js/mdq.js"></script>
    <script src="./js/history.js"></script>

    <script>
        const hide = document.querySelectorAll('.hide');

        hide.forEach(element => element.parentElement.parentElement.parentElement.parentElement.style.display = 'none');
    </script>
</body>

</html>