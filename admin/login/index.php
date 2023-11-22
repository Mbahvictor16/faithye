<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../css/admin/admin.css">
    <title>Admin Login</title>
</head>

<body>
    <?php
    session_start();
    if (!empty($_SESSION["session_admin"])) {
        header("Location: ../../admin");
    }
    ?>
    <?php
    include "../admin.php";
    include "./functions.php";

    $result = $conn_db->query($sql_find);

    if ($result->num_rows > 0) {
        echo "";
    } else {
        if ($conn_db->query($sql_insert) === TRUE) {
            echo "";
        } else {
            die("Couldn't insert data into database");
        }
    }
    ?>
    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $user = trim($_POST["username"]);
        $password = $_POST["password"];
        $sql_find = "SELECT * FROM admin_users WHERE username = '$user'";

        $result = $conn_db->query($sql_find);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $verify = password_verify($password, $row['pscd']);

                if ($verify) {
                    session_start();
                    $_SESSION["session_admin"] = $row['SS_ID'];
                    header("Location: ../../admin");
                } else {
                    $err = "Password is incorrect";
                }
            }
        } else {
            $err = "No user found";
        }
    }
    ?>
    <main class="form-bg">
        <section class="form-section">
            <div class="form-div">
                <?php if ($err !== null) { ?>
                    <div style="text-align: center; font-size: 0.75rem" class="error">
                        <?php echo $err; ?>
                    </div>
                <?php } ?>
                <form action="" method="post" data-login>
                    <div class="form-box">
                        <label for="username">Username</label>
                        <input type="text" name="username" id="username" />
                    </div>

                    <div class="form-box">
                        <label for="password">Password</label>
                        <input type="password" name="password" id="password" />
                    </div>

                    <div class="form-box">
                        <input type="submit" value="Login">
                    </div>
                </form>
            </div>
        </section>
    </main>
    <script src="../../js/admin/index.js"></script>
    <?php $conn_db->close(); ?>
</body>

</html>