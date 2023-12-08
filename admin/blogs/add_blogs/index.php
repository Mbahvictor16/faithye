<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../../css/admin/admin.css">
    <title>Add Blog</title>

    <style>
        input[type="text"]:read-only {
            width: 10ch;
        }

        textarea {
            resize: none;
            width: 100%;
            font-family: Verdana, Geneva, Tahoma, sans-serif;
            font-size: 1em;
        }

        [for="img"]>div {
            width: 200px;
            height: 200px;
            border: 1px solid #ccc;
        }

        [for="img"]>div img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            -o-object-fit: cover;
            object-position: top;
            -o-object-position: top;
        }

        [type="file"] {
            display: none;
        }
    </style>
</head>

<body>
    <section id="body">
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

        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["create"])) {
            if ($_FILES["img"]["error"] == 0) {
                $tmpName = $_FILES["img"]["tmp_name"];
                $title = $_POST["title"];
                $article = $_POST["article"];
                $imgType = $_FILES["img"]["type"] . strtolower(pathinfo(basename($_FILES["img"]["name"]), PATHINFO_EXTENSION));

                $imgContent = file_get_contents($tmpName);

                $base64Encode = base64_encode($imgContent);

                $b_ig = "b_ig" . uniqid(uniqid(), true);

                $insertArticle = "INSERT INTO blogs VALUES ('$b_ig', '$title', '$base64Encode', '$imgType', '$article')";

                if ($conn_db->query($insertArticle)) {
                    header("Location: ../all_blogs");
                }
            } else {
                $err = "Error uploading image";
            }
        }
        ?>
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

                        <li><a href="../all_blogs/">All Blogs</a></li>
                        <li><a href="">Add Blogs</a></li>
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
            <div>
                <form action method="post" style="width: 40%; margin-block: 8px" enctype="multipart/form-data" data-edit>

                    <?php if ($err !== null) { ?>
                        <div class="error" style="text-align: center; font-size: 0.75rem">
                            <?php echo $err; ?>
                        </div>
                    <?php } ?>

                    <div class="form-box">
                        <label for="product-name">Title</label>
                        <input type="text" name="title" id="title" required />
                    </div>


                    <div class="form-box">
                        <label for="img">
                            <div>
                                <img src="" data-img>
                            </div>
                        </label>
                        <div style="display: flex; gap: 6px;">
                            <input type="file" name="img" id="img" accept="jpg, jpeg, png" data-file required>
                        </div>
                    </div>

                    <div class="form-box">
                        <label for="article">Article</label>
                        <div>
                            <textarea name="article" id="article" cols="30" rows="10" required></textarea>
                        </div>
                    </div>

                    <div class="form-box">
                        <input type="submit" name="create" value="Create Blog Post">
                    </div>

                </form>

            </div>
        </main>
    </section>
    <?php
    $conn_db->close();
    ?>
    <script src="../../../js/admin/index.js"></script>
    <script src="../../../js/admin/photo.js"></script>
</body>

</html>