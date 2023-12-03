<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/main.css">
    <title>Search Results</title>
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
                        <h1 class="product-heading">Search Products</h1>

                        <div class="product-filter">
                            <form action="" class="search" method="get">
                                <div class="form-input">
                                    <input type="text" name="q" id="search" placeholder="Search e.g Blue Water Lilies" />
                                    <button type="submit" class="form-btn">&rarr;</button>
                                </div>
                            </form>
                        </div>
                    </div>

                    <hr>

                    <div class="all-product-container product-container">
                        <?php
                        $page = isset($_GET["page"]) ? $_GET["page"] : 1;
                        $limit = 10;
                        $start = ($page - 1) * $limit;
                        $q = isset($_GET["q"]) ? urldecode($_GET["q"]) : null;
                        $arr_q = explode(" ", $q);
                        $conditions = [];
                        foreach ($arr_q as $key) {
                            $conditions[] = "p_name LIKE '%$key%' OR p_name REGEXP '%$key%'";
                        }

                        $implode_q = implode(" OR ", $conditions);
                        if ($q == null) {
                        ?>
                            <div style="text-align: center; color: #cccccc">
                                Couldn't find any product
                            </div>
                            <?php } else {
                            $sql_search = "SELECT * FROM products WHERE $implode_q ORDER BY date_created DESC LIMIT $limit OFFSET $start";
                            $result = $conn_db->query($sql_search);

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
                                                    <a href="../product?p_id=<?php echo $row["p_ID"]; ?>" class="btn view-link">
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
                                    Couldn't find any products.
                                </div>
                            <?php } ?>

                        <?php } ?>
                    </div>
                </div>
            </div>
        </section>

        <?php
        $countItems = "SELECT COUNT(*) as totalItems FROM products WHERE $implode_q";

        $result = $conn_db->query($countItems);

        if ($result) {
            if ($result->num_rows > 0) {
                $getTotal = $result->fetch_assoc();

                $totalItems = $getTotal["totalItems"];

                $totalPages = ceil($totalItems / $limit);

                if ($totalPages > 1) {

        ?>

                    <section class="pagination-section">
                        <div class="pagination-div">
                            <div class="pagination-box">
                                <div class="pagination-previous">
                                    <a href="?page=<?php echo $page <= 0 ? 1 : $page - 1 ?>" class="btn">
                                        &laquo;
                                    </a>
                                </div>

                                <div class="pagination-links">
                                    <?php
                                    for ($i = 1; $i <= $totalPages; $i++) {
                                    ?>
                                        <a href="?page=<?php echo $i; ?>" class="btn">
                                            <?php echo $i; ?>
                                        </a>
                                    <?php
                                    }
                                    ?>
                                </div>

                                <div class="pagination-next">
                                    <a href="?page=<?php echo $page >= $totalPages ? $totalPages : $page + 1 ?>" class="btn">
                                        &raquo;
                                    </a>
                                </div>
                            </div>
                        </div>
                    </section>


        <?php
                }
            }
        }
        ?>
    </main>

    <?php $conn_db->close() ?>

    <script src="../js/hamburger.js"></script>
    <script src="../js/mdq.js"></script>
    <script src="../js/history.js"></script>
</body>

</html>