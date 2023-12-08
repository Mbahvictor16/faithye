<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../../css/admin/admin.css">
    <title>All Products</title>
</head>

<body>
    <?php
    include "../../admin.php";
    if (!isset($_COOKIE["cookie"])) {
        header("Location: ../../../login");
        exit;
    }
    session_start();
    if (empty($_SESSION["session_admin"])) {
        header("Location: ../../login");
    }
    ?>

    <section id="body">
        <aside>
            <div>
                <div class="logo">
                    Faithye
                </div>
                <nav>
                    <ul>
                        <li><a href="../../">Home</a></li>
                    </ul>
                    <ul class="product-nav">
                        <h3>Products</h3>
                        <li>
                            <a href="">All Products</a>
                        </li>
                        <li>
                            <a href="../add_products/">Add Products</a>
                        </li>
                    </ul>

                    <ul class="blog-nav">
                        <h3>Blogs</h3>

                        <li><a href="../../blogs/all_blogs/">All Blogs</a></li>
                        <li><a href="../../blogs/add_blogs/">Add Blogs</a></li>
                    </ul>
                </nav>
            </div>

            <div>
                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                    <input type="submit" name="LOGOUT" value="Log Out" id="logout">
                </form>

                <?php
                if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["LOGOUT"])) {
                    session_start();
                    session_unset();
                    session_destroy();
                    header("Location: ../../login");
                }
                ?>
            </div>
        </aside>

        <main>
            <?php
            $sql_get_all = "SELECT * FROM products ORDER BY date_created DESC";
            $result = $conn_db->query($sql_get_all);

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
            ?>
                    <div class="product">
                        <div class="product-img">
                            <img src="../../../<?php echo $row["img_path"]; ?>" alt="">
                        </div>
                        <div class="product-details">
                            <h3>
                                <?php echo $row["p_name"]; ?>
                            </h3>

                            <div class="product-price">
                                Unit Price:
                                <span>
                                    <?php echo $row["p_price"]; ?> NGN
                                </span>
                            </div>

                            <div class="product-quantity">
                                Quantity:
                                <span>
                                    <?php echo $row["p_quan"]; ?>
                                </span>
                            </div>

                            <div class="unit_price">
                                Amount Expected:
                                <span>
                                    <?php echo $row["p_price"] * $row["p_quan"]; ?> NGN
                                </span>
                            </div>

                            <div class="action">
                                <div class="buy-action">
                                    <a href="../edit_product?p_id=<?php echo $row["p_ID"]; ?>" class="btn">Edit</a>
                                </div>

                                <form action="" method="post">
                                    <input type="hidden" name="delete_id" value="<?php echo $row["p_ID"]; ?>">
                                    <input type="submit" value="Delete" style="background: #000; display:block; width: 100%; border: 1px solid #000000; color: #ffffff">
                                </form>
                                <?php
                                if (isset($_POST['delete_id']) && $_SERVER['REQUEST_METHOD'] == 'POST') {
                                    $user_id = $_COOKIE['cookie'];
                                    $delete_p_id = $_POST['delete_id'];




                                    $select_file = "SELECT * FROM products  WHERE p_ID = '$delete_p_id'";

                                    $result = $conn_db->query($select_file);

                                    function DeleteID($delete_p_id, $conn_db)
                                    {
                                        $sql_delete_product = "DELETE FROM products WHERE p_ID = '$delete_p_id'";

                                        $sql_delete_cart = "DELETE FROM cart WHERE p_ID = '$delete_p_id'";

                                        $sql_delete_sales = "DELETE FROM sales WHERE p_ID = '$delete_p_id'";
                                        if ($conn_db->query($sql_delete_sales) && $conn_db->query($sql_delete_cart) && $conn_db->query($sql_delete_product)) {
                                            echo "<script>history.back()</script>";
                                        } else {
                                            echo "<script>console.error('couldn't deleted');</script>";
                                        }
                                    }

                                    if ($result->num_rows > 0) {
                                        while ($row = $result->fetch_assoc()) {
                                            $imgPath = $row["img_path"];
                                            if (file_exists("../../../$imgPath")) {
                                                if (unlink("../../../$imgPath")) {
                                                    DeleteID($delete_p_id, $conn_db);
                                                }
                                            } else {
                                                DeleteID($delete_p_id, $conn_db);
                                            }
                                        }
                                    }
                                }
                                ?>
                            </div>
                        </div>
                    </div>
                <?php }
            } else { ?>
                <div style="text-align: center; color: #cccccc">You don't have any product.</div>
            <?php } ?>
        </main>
    </section>

    <script src="../../../js/admin/index.js"></script>
</body>

</html>