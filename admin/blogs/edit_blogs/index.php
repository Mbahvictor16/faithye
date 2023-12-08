<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
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
                        <li>
                            <a href="../../products/edit_product/">Edit Products</a>
                        </li>
                    </ul>

                    <ul class="blog-nav">
                        <h3>Blogs</h3>

                        <li><a href="../blogs/all_blogs/">All Blogs</a></li>
                        <li><a href="../blogs/add_blogs/">Add Blogs</a></li>
                        <li><a href="">Edit Blogs</a></li>
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
    </section>
</body>

</html>