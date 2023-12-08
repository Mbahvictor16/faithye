<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin</title>
    <link rel="stylesheet" href="../css/admin/admin.css">
</head>

<body>
    <?php
    include "./admin.php";
    if (!isset($_COOKIE["cookie"])) {
        header("Location: ../login");
        exit;
    }
    session_start();
    if (empty($_SESSION["session_admin"])) {
        header("Location: ./login");
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
                        <li><a href="">Home</a></li>
                    </ul>
                    <ul class="product-nav">
                        <h3>Products</h3>
                        <li>
                            <a href="./products/all_products/">All Products</a>
                        </li>
                        <li>
                            <a href="./products/add_products/">Add Products</a>
                        </li>

                    </ul>

                    <ul class="blog-nav">
                        <h3>Blogs</h3>

                        <li><a href="./blogs/all_blogs/">All Blogs</a></li>
                        <li><a href="./blogs/add_blogs/">Add Blogs</a></li>

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
            $ss_id = $_SESSION["session_admin"];
            $sql_find_user = "SELECT * FROM admin_users WHERE SS_ID = '$ss_id'";

            $result = $conn_db->query($sql_find_user);
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) { ?>
                    <div>
                        <h1>User</h1>
                        <p>Name: <?php echo $row['username']; ?></p>
                    </div>
            <?php }
            } ?>

            <div style="margin-block: 64px;">
                <h1>Edit Details</h1>

                <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']) ?>" method="post" style="width: 40%; margin-block: 8px" data-edit>

                    <?php if ($updated !== null) { ?>
                        <div class="success">
                            <?php echo $updated; ?>
                        </div>
                    <?php } ?>

                    <?php if ($err !== null) { ?>
                        <div class="error">
                            <?php echo $err; ?>
                        </div>
                    <?php } ?>

                    <div class="form-box">
                        <label for="username">Username</label>
                        <input type="text" name="username" id="username" />
                    </div>

                    <div class="form-box">
                        <label for="password">Password</label>
                        <input type="password" name="password" id="password" />
                    </div>

                    <div class="form-box">
                        <input type="submit" name="update" value="Update Changes">
                    </div>

                </form>
            </div>

            <?php
            $ss_id = $_SESSION["session_admin"];
            if (isset($_POST['update']) && $_SERVER['REQUEST_METHOD'] == 'POST') {

                $username = trim($_POST['username']);
                $password = trim($_POST['password']);
                $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

                if ($password === '' && $username !== '') {
                    $sql_update = "UPDATE admin_users SET username = '$username' WHERE SS_ID = '$ss_id'";
                    if ($conn_db->query($sql_update)) {
                        $updated = "Updated successfully";
                        session_unset();
                        session_destroy();
                        header("Location: ./login");
                    } else {
                        $err = "There was an error updating";
                    }
                } else if ($username === '' && $password !== '') {
                    $sql_update = "UPDATE admin_users SET pscd = '$hashedPassword' WHERE SS_ID = '$ss_id'";
                    if ($conn_db->query($sql_update)) {
                        $updated = "Updated successfully";
                        session_unset();
                        session_destroy();
                        header("Location: ./login");
                    } else {
                        $err = "There was an error updating";
                    }
                } else {
                    $sql_update = "UPDATE admin_users SET username = '$username', pscd = '$hashedPassword' WHERE SS_ID = '$ss_id'";
                    if ($conn_db->query($sql_update)) {
                        $updated = "Updated successfully";
                        session_unset();
                        session_destroy();
                        header("Location: ./login");
                    } else {
                        $err = "There was an error updating";
                    }
                }
            }
            ?>
        </main>
    </section>
    <?php
    $conn_db->close();
    ?>
    <script src="../js/admin/index.js"></script>
</body>

</html>