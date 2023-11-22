<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/main.css">
    <title>Register</title>
</head>

<body>
    <?php
    include "../config.php";
    if (isset($_COOKIE["cookie"])) {
        header("Location: ../");
    } ?>

    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $email = trim($_POST["email"]);
        $password = $_POST["password"];
        $newsletter = $_POST["consent"];
        $user_id = "u_id_c_id:" . uniqid(uniqid(uniqid(uniqid()), true), true);
        $pscd_hash = password_hash($password, PASSWORD_DEFAULT);

        $sql_insert = "INSERT INTO users VALUES ('$user_id', '$email','$pscd_hash')";

        $sql_check = "SELECT * FROM users WHERE email = '$email'";

        $result = $conn_db->query($sql_check);

        if ($result->num_rows > 0) {
            $err = "A user with email already exists";
        } else {
            if ($conn_db->query($sql_insert)) {
                header("Location: ../login");
            } else {
                $err = "There was a problem registering this user";
            }
        }
    }
    ?>

    <main class="form-bg">
        <section class="form-section">
            <div class="svg-bg">
                <div class="form-svg register"></div>
            </div>

            <div class="form-div">
                <form action="" method="post" data-register>
                    <?php
                    if ($err !== null) { ?>
                        <div class="error" style="text-align: center;">
                            <?php echo $err; ?>
                        </div>
                    <?php
                    }
                    ?>
                    <div class="form-box">
                        <label for="email">Email</label>
                        <input type="email" name="email" id="email" placeholder="example@gmail.com" data-email />
                        <div id="validate-email">
                            <small data-validate-email></small>
                        </div>
                    </div>

                    <div class="form-box">
                        <label for="password">Password</label>
                        <input type="password" name="password" id="password" placeholder="********" data-password />
                        <div class="password-valid-details" data-password-details>
                            <ul>
                                <li password-data-small-caps>Password must contain at least one lower case letters</li>
                                <li password-data-big-caps>Password must contain at least one upper case letter</li>
                                <li password-data-nums>Password must contain at least one digit</li>
                                <li data-password-length>Password must be between 8 and 16 characters</li>
                            </ul>
                        </div>
                    </div>

                    <div class="form-box">
                        <label for="confirm-password">Confirm Password</label>
                        <input type="password" name="confirm-password" id="confirm-password" placeholder="********" data-confirm-password />
                        <div>
                            <small data-password-match></small>
                        </div>
                    </div>

                    <div class="consent-box">
                        <input type="checkbox" name="consent" id="consent">
                        <label for="consent">Do you want to sign up for our weekly newsletter</label>
                    </div>

                    <div class="form-box">
                        <input type="submit" value="Register">
                    </div>
                </form>
            </div>
        </section>
    </main>
    <?php $conn_db->close() ?>
    <script src="../js/formValidate.js"></script>
    <script src="../js/history.js"></script>
</body>

</html>