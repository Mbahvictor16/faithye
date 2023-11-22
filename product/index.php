<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/main.css">
    <title>View Product</title>
    <style>
        .decrement,
        .increment {
            background: var(--primary-color);
            border: 1px solid #000;
            cursor: pointer;
        }

        body {
            position: relative;
        }

        .popup-section {
            height: 100dvh;
            width: 100dvw;
            position: absolute;
            inset: 0;
        }

        .popup-bg {
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.25);
            display: flex;
            align-items: center;
            justify-content: center;
            backdrop-filter: 8px;
        }

        .popup-div {
            padding: 12px 24px;
            background: #ffffff;
            border-radius: 3px;
            width: min(90%, 500px);
        }

        .popup-btn {
            width: max(20%, 100px);
            background: var(--primary-color);
            border: 1px solid var(--primary-color);
            cursor: pointer;
        }

        .popup-btn-div {
            display: flex;
            align-items: center;
            justify-content: flex-end;
            margin-block: 12px;
        }

        #none.popup-section {
            display: none;
        }
    </style>
</head>

<body>
    <?php
    include "../config.php";
    include "../cart/cart.php";

    if (isset($_POST["buy-now"]) && $_SERVER["REQUEST_METHOD"] == "POST") {
        $dialog = false;

        if ($dialog == false) {
            $quantity = $_POST["quantity"];
            $post_name = $_POST["product"];
            header("Location: ../buy?p_id=$post_name&qty=$quantity");
        }
    }
    ?>

    <header class="product-details-header product-header">
        <span onclick="history.back()">
            &larr;
        </span>
    </header>

    <main class="product-details-main product-main">

        <section class="product-details-section">
            <?php
            $p_id = $_GET["p_id"];
            $sql_find = "SELECT * FROM products WHERE p_ID = '$p_id'";
            $result = $conn_db->query($sql_find);

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) { ?>


                    <div class="product-details-div">
                        <div class="product-details-img">
                            <img src="../<?php echo $row["img_path"]; ?>" alt="">
                        </div>

                        <div class="product-details-details">
                            <h2><?php echo $row["p_name"] ?></h2>

                            <div class="product-details-price">
                                <small>
                                    <b><?php echo $row["p_price"]; ?> NGN</b>
                                </small>
                            </div>

                            <div class="product-details-description">
                                <?php echo $row["p_description"] ?>
                            </div>

                            <div class="quantity">
                                <?php if ($row["p_quan"] > 0) { ?>
                                    <small>
                                        Quantity:
                                        <span>
                                            <?php echo $row["p_quan"]; ?>
                                        </span>
                                        remaining
                                    </small>
                                <?php } else { ?>
                                    <s style="color: #aaaaaa;">
                                        <small>
                                            Out of stock
                                        </small>
                                    </s>
                                <?php } ?>
                            </div>

                            <div class="action-cart-buy">

                                <div>
                                    <form action="" method="post">
                                        <div class="form-box" style="width: fit-content; gap: 3px;">
                                            <button type="button" class="decrement btn"> &minus; </button>
                                            <input type="number" name="quantity" value=1 style="width: 8ch; text-align:center;" min="1" pattern="[0-9]{3}" />
                                            <button type="button" class="increment btn"> &plus; </button>
                                        </div>
                                        <input type="submit" value="Add to cart" class="btn" style="background: var(--primary-color); display:block; width: 100%; border: 1px solid var(--primary-color); margin-bottom: 2px" name="add-to-cart" />
                                        <input type="hidden" name="product" value="<?php echo $row["p_ID"] ?>">

                                        <button type="submit" class="btn form-btn" name="buy-now" style="width: 100%">Buy Now</button>
                                    </form>


                                </div>

                            </div>


                        </div>
                    </div>
            <?php }
            } ?>

            <?php
            if (isset($_POST["add-to-cart"]) && $_SERVER["REQUEST_METHOD"] == "POST"  && $dialog == true) {
                $post_name = $_POST["product"];
                $u_id = $_COOKIE["cookie"];
                $quantity = $_POST["quantity"];

                if (empty($_COOKIE["cookie"])) {
                    header("Location: ../login");
                    exit;
                }

                $sql_verify_quan = "SELECT * FROM products WHERE p_ID = '$post_name'";

                $check_quan = $conn_db->query($sql_verify_quan);

                if ($check_quan->num_rows > 0) {
                    while ($row = $check_quan->fetch_assoc()) {
                        if ($row["p_quan"] == 0) { ?>

                            <section class="popup-section">
                                <div class="popup-bg">
                                    <div class="popup-div">
                                        <div class="popup-message">
                                            You cannot add products that are out of stock to your cart!
                                        </div>
                                        <div class="popup-btn-div">
                                            <button class="btn popup-btn">
                                                Ok
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </section>

                            <script>
                                const popupBtn = document.querySelector(".popup-btn");
                                const popupSection = document.querySelector(".popup-section");

                                document.body.style.overflowY = "hidden";

                                popupBtn.addEventListener("click", () => {
                                    popupSection.id = "none";
                                    document.body.style.overflowY = "auto";
                                    history.back();
                                })
                            </script>
            <?php
                            exit;
                        }
                    }
                }


                $sql_check_product = "SELECT * FROM cart WHERE p_ID = '$post_name' AND user_id = '$u_id'";

                $result = $conn_db->query($sql_check_product);

                if ($result->num_rows == 0) {

                    $sql_add = "INSERT INTO cart VALUES ('$u_id','$post_name', '$quantity')";

                    if ($conn_db->query($sql_add)) {
                        echo "<script>history.back()</script>";
                    } else {
                        echo "<script>console.error('couldn't add product')</script>";
                    }
                } else {
                    while ($row = $result->fetch_assoc()) {
                        $row_quan = $row['quantity'] + $quantity;
                        $sql_update = "UPDATE cart SET quantity = '$row_quan' WHERE p_ID = '$post_name' AND user_id = '$u_id'";

                        if ($conn_db->query($sql_update)) {
                            echo "<script>history.back()</script>";
                        } else {
                            echo "<script>console.error('couldn't update')</script>";
                        }
                    }
                }
            }
            ?>
        </section>
    </main>

    <script src="../js/history.js"></script>
    <script>
        const incrementBtn = document.querySelector(".increment");
        const decrementBtn = document.querySelector(".decrement");
        const quantity = document.querySelector("[name='quantity']");

        incrementBtn.addEventListener("click", () => {
            quantity.value = Number(quantity.value) + 1;
        })

        decrementBtn.addEventListener("click", () => {
            if (Number(quantity.value) === 1) return;
            quantity.value = Number(quantity.value) - 1;
        })
    </script>
    </script>


    <?php
    $conn_db->close();
    ?>
</body>

</html>