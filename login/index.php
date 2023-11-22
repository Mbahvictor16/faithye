<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/main.css">
    <title>Login</title>
</head>

<body>

    <?php
    include "../config.php";
    ?>

    <?php if (isset($_COOKIE["cookie"])) {
        header("Location: ../");
    } ?>

    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $email = trim($_POST["email"]);
        $password = $_POST["password"];

        $sql_select = "SELECT * FROM users WHERE email = '$email'";

        $result = $conn_db->query($sql_select);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $verify = password_verify($password, $row['pscd']);

                if ($verify) {
                    setcookie("cookie", $row["user_id"], time() + (86400 * 30), "/");
                    header("Location: ../");
                } else {
                    $err = "Password is Incorrect";
                }
            }
        } else {
            $err = "No user with this email exists";
        }
    }
    ?>

    <main class="form-bg">
        <section class="form-section">
            <div class="svg-bg">
                <div class="form-svg"></div>
            </div>

            <div class="form-div">
                <form action="" method="post" data-login>
                    <?php if ($err !== null) { ?>
                        <div class="error" style="text-align: center;">
                            <?php echo $err; ?>
                        </div>

                    <?php } ?>
                    <div class="form-box">
                        <label for="email">Email</label>
                        <input type="email" name="email" id="email" placeholder="example@gmail.com" />
                    </div>

                    <div class="form-box">
                        <label for="password">Password</label>
                        <input type="password" name="password" id="password" placeholder="********" />
                    </div>

                    <div class="register-link">
                        Don't have acccount yet? <a href="../register/">Register</a>
                    </div>

                    <div class="forgot-password">
                        <a href="../forgot-password">forgot password?</a>
                    </div>

                    <div class="form-box">
                        <input type="submit" value="Login">
                    </div>
                </form>
            </div>
        </section>
    </main>
    <script src="../js/history.js"></script>
    <?php $conn_db->close() ?>
</body>

</html>