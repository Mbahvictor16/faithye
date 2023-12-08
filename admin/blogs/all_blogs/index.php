<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../../css/admin/admin.css">
    <title>Document</title>
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
                            <a href="../../products/all_products/">All Products</a>
                        </li>
                        <li>
                            <a href="../../products/add_products/">Add Products</a>
                        </li>
                    </ul>

                    <ul class="blog-nav">
                        <h3>Blogs</h3>

                        <li><a href="">All Blogs</a></li>
                        <li><a href="../add_blogs/">Add Blogs</a></li>
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
                    header("Location: ./login");
                }
                ?>
            </div>
        </aside>

        <main>
            <?php
            $sql_get_all = "SELECT * FROM blogs";
            $result = $conn_db->query($sql_get_all);

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
            ?>
                    <div class="product">
                        <div class="product-img">
                            <img src="data:<?php echo $row["img_type"] ?>;base64,<?php echo base64_decode($row["b_img"]); ?>" alt="">
                        </div>
                        <div class="product-details">
                            <h3>
                                <?php echo $row["title"]; ?>
                            </h3>


                        </div>
                    </div>
                <?php }
            } else { ?>
                <div style="text-align: center; color: #cccccc">You don't have any product.</div>
            <?php } ?>
        </main>105
    </section>
</body>

</html>