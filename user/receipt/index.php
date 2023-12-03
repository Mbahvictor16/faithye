<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../css/main.css">
    <title>Receipt</title>
</head>

<body>
    <?php
    include "../../config.php";
    include "../../auth-user.php";
    ?>
    <main>
        <?php
        $ref_id = isset($_GET["ref_id"]) ? $_GET["ref_id"] : null;

        if ($ref_id == null) {
            header("../../user");
        }

        $getReceipt = "SELECT *, sales.p_quan as sales_quan FROM sales RIGHT JOIN products ON sales.P_ID = products.P_ID WHERE ref_id = '$ref_id'";

        $receiptDetails = $conn_db->query($getReceipt);

        if ($receiptDetails) {
            if ($receiptDetails->num_rows > 0) { ?>

                <section class="receipt-details-section">
                    <div class="receipt-details-div">
                        <div class="receipt">
                            <h1>Faithye</h1>

                            <div>
                                <small>
                                    Receipt No: <?php echo substr($ref_id, 32, 22) ?>
                                </small>
                            </div>

                            <table>
                                <thead>
                                    <td>Item</td>
                                    <td>Unit Price</td>
                                    <td>Quantity</td>
                                    <td>Total</td>
                                </thead>

                                <tbody>

                                    <?php
                                    while ($row = $receiptDetails->fetch_assoc()) {
                                    ?>
                                        <tr>
                                            <td><?php echo $row["p_name"] ?></td>
                                            <td><?php echo $row["p_price"] ?></td>
                                            <td class="quan"><?php echo $row["sales_quan"] ?></td>
                                            <td><?php echo $row["TotalAmount"] ?></td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>

                            <?php
                            $getGrandTotal = "SELECT SUM(TotalAmount) as grand_total FROM sales WHERE ref_id = '$ref_id'";

                            $grandTotal = $conn_db->query($getGrandTotal);

                            if ($grandTotal) {
                                if ($grandTotal->num_rows > 0) {
                                    $TOTAL = $grandTotal->fetch_assoc(); ?>

                                    <div class="grand-total">
                                        <h4 style="text-align: right;">Grand Total: <?php echo $TOTAL["grand_total"] ?> NGN</h4>
                                    </div>

                            <?php
                                }
                            }
                            ?>
                        </div>
                    </div>
                </section>


            <?php
            } else { ?>
                <div>
                    This receipt is invalid.
                </div>
            <?php
            }
        } else { ?>
            <div>
                There was a connection issue.
            </div>
        <?php
        }
        ?>
    </main>
</body>

</html>