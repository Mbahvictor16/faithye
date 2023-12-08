<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../css/main.css">
    <title>All purchases</title>
</head>

<body>
    <?php
    include "../../config.php";
    include "../../buy/sales.php";
    include "../../auth-user.php";

    if (empty($_COOKIE["cookie"])) {
        header("../../login");
        exit;
    }
    ?>
    <header class="product-details-header product-header">
        <span onclick="history.back()">
            &larr;
        </span>
    </header>

    <main>
        <?php
        $user = $_COOKIE["cookie"];
        $get_purchases = "SELECT DISTINCT ref_id, date_purchased FROM sales WHERE user_id = '$user' ORDER BY date_purchased DESC";

        $all_purchases = $conn_db->query($get_purchases);

        if ($all_purchases) {
            if ($all_purchases->num_rows > 0) {
        ?>
                <section class="user-purchase-section user-details">
                    <div class="user-purchase-div user-details">
                        <div class="recent-purchases">
                            <h3>All Purchases</h3>
                        </div>
                        <?php
                        while ($row = $all_purchases->fetch_assoc()) { ?>
                            <div class="purchases">
                                <a href="../receipt?ref_id=<?php echo $row["ref_id"] ?>">
                                    <div class="ref_id">
                                        <?php echo $row["ref_id"] ?>
                                    </div>
                                    <div class="date_purchased">
                                        <small>
                                            <?php echo $row["date_purchased"] ?>
                                        </small>
                                    </div>
                                </a>
                            </div>
                        <?php
                        }
                        ?>
                    </div>
                </section>
        <?php
            }
        }
        ?>
    </main>

    <?php $conn_db->close(); ?>
    <script src="../../js/history.js"></script>
</body>

</html>