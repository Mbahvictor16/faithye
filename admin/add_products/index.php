<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../css/admin/admin.css">
    <title>Add Product</title>

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
    <?php
    include "../admin.php";
    if (!isset($_COOKIE["cookie"])) {
        header("Location: ../../login");
        exit;
    }
    session_start();
    if (empty($_SESSION["session_admin"])) {
        header("Location: ../login");
    }
    ?>

    <?php
    $sql_table = "CREATE TABLE IF NOT EXISTS products (p_ID VARCHAR(255) PRIMARY KEY NOT NULL UNIQUE, p_name VARCHAR(255) NOT NULL, p_price DECIMAL(10,2) NOT NULL, p_quan INT(6) NOT NULL, p_description VARCHAR(500) NOT NULL, img_path VARCHAR(255) NOT NULL, date_created TIMESTAMP DEFAULT CURRENT_TIMESTAMP NOT NULL, date_updated TIMESTAMP DEFAULT CURRENT_TIMESTAMP NOT NULL)";

    if ($conn_db->query($sql_table)) {
        echo "<pre style='display:none;'>Table created</pre>";
    } else {
        echo "<pre style='display:none;'>Couldn't create table</pre>";
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
                        <li>
                            <a href="../">Home</a>
                        </li>
                        <li>
                            <a href="../all_products/">All Products</a>
                        </li>
                    </ul>
                </nav>
            </div>

            <div>
                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                    <input type="submit" name="LOGOUT" value="Log Out" id="logout">
                </form>

                <?php
                if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["LOGOUT"])) {
                    session_unset();
                    session_destroy();
                    header("Location: ../login");
                }
                ?>
            </div>
        </aside>
        <?php
        if (is_dir("../../uploads")) {
            echo "<pre style='display:none;'>Folder exists</pre>";
        } else {
            mkdir("../../uploads");
        }

        $_id = $p_id = $p_name = $p_price = $p_desc = $p_quan = "";
        if ($_SERVER['REQUEST_METHOD'] == 'POST' && $_FILES["img"]) {
            $_id =  uniqid(uniqid(), true);
            $p_id = "p_id_$_id";
            $p_name = $_POST['product-name'];
            $p_price = $_POST['price'];
            $p_desc = $_POST['p_desc'];
            $p_quan = $_POST['quantity'];
            $name = $_FILES["img"]["name"];
            $path_ext = strtolower(pathinfo(basename($name), PATHINFO_EXTENSION));
            $new_img_name = "IMG_" . uniqid(uniqid(), true) . "." . $path_ext;
            $target_dir = "../../uploads/$new_img_name";

            $uploadOK = true;

            if ($_id === "" || $p_id === "" || $p_name  === "" || $p_price === "" || $p_quan === "" || $p_desc ===  "") {
                $err = "Fill in the required information";
                $uploadOK = false;
            }


            if ($_FILES["img"]["error"] == 0) {

                if ($_FILES["img"]["size"] > 10000000) {
                    $err = "Image size should not be more than 10MB";
                    $uploadOK = false;
                }

                if ($path_ext !== "jpg" && $path_ext !== "png" && $path_ext !== "jpeg" && $path_ext !== "gif") {
                    $err = "Only *.jpg, *.jpeg, *.png and *.gif images are allowed";
                    $uploadOK = false;
                }

                if ($uploadOK === true) {
                    move_uploaded_file($_FILES["img"]["tmp_name"], $target_dir);

                    $sql_insert = "INSERT INTO products (p_ID, p_name, p_price, p_quan, p_description, img_path) VALUES ('$p_id', '$p_name', '$p_price', '$p_quan', '$p_desc', 'uploads/$new_img_name')";

                    if ($conn_db->query($sql_insert)) {
                        $updated = "Created new product successfully";
                        $_POST['product-name'] = $_POST['price'] = $_POST['p_desc'] = $_POST['quantity'] = "";
                    } else {
                        $err = "An error occurred while creating product";
                    }
                }
            } else {
                $err = "Error in image upload";
            }
        }
        ?>
        <main>
            <div>
                <form action method="post" style="width: 40%; margin-block: 8px" enctype="multipart/form-data" data-edit>

                    <?php if ($updated !== null) { ?>
                        <div class="success" style="text-align: center; font-size: 0.75rem">
                            <?php echo $updated; ?>
                        </div>
                    <?php } ?>

                    <?php if ($err !== null) { ?>
                        <div class="error" style="text-align: center; font-size: 0.75rem">
                            <?php echo $err; ?>
                        </div>
                    <?php } ?>

                    <div class="form-box">
                        <label for="product-name">Name of Product</label>
                        <input type="text" name="product-name" id="product-name" required />
                    </div>

                    <div class="form-box">
                        <label for="price">Price</label>
                        <div style="display: flex; gap: 6px;">
                            <input type="number" name="price" id="price" min="0" pattern="[0-9]+" required />
                            <input type="text" maxlength="3" value="NGN" readonly />
                        </div>
                    </div>

                    <div class="form-box">
                        <label for="qunatity">Quantity</label>
                        <div style="display: flex; gap: 6px;">
                            <input type="number" name="quantity" id="quantity" min="0" pattern="[0-9]+" required />
                        </div>
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
                        <label for="price">Description</label>
                        <div>
                            <label for="p_desc"></label>
                            <textarea name="p_desc" id="p_desc" cols="30" rows="10" required></textarea>
                        </div>
                    </div>

                    <div class="form-box">
                        <input type="submit" name="update" value="Create Product">
                    </div>

                </form>

            </div>
        </main>
    </section>

    <?php
    $conn_db->close();
    ?>
    <script src="../../js/admin/index.js"></script>
    <script src="../../js/admin/photo.js"></script>
</body>

</html>