<?php
session_start();
require_once("../function/login_handler.php");
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    /* Header */



    /* Nav */
    .signup {
        height: 60px;
        line-height: 60px;
        text-align: right;
        padding-right: 30px;
        font-style: normal;
        font-size: 20px;
    }

    .signup a {
        text-decoration: none;
        color: red;
        margin-left: 8px;
    }

    .signup a:hover {
        color: #CC0000;
    }

    .content {

        display: flex;
        justify-content: center;
        align-items: center;
    }

    .content fieldset {
        border: 3px solid rgb(222, 229, 250);
        text-align: center;
        font-family: monospace;
        font-style: normal;
        line-height: 150%;
        font-size: 20px;
        font-weight: 600;
        margin-top: 28px;
        width: 480px;
    }

    .form-list {
        font-size: 16px;
        margin: 16px;
        margin-right: 0;

    }

    .form-item {
        display: flex;
        width: 100%;
        text-align: left;

    }

    .form-item .item-left {
        width: 200px;
        padding-left: 12px;
    }

    .form-list .error {
        padding-left: 105px;
        font-size: 10px;
        color: red;
        opacity: 0.8;
    }

    .content input {
        width: 100%;
        height: 100%;
        border: none;
        outline: none;
    }

    .content input:focus {
        border-bottom: 1px solid rgb(222, 229, 250);
    }

    .content .btn input {
        border-radius: 15px;
        height: 30px;
        width: 100px;
        background-color: rgb(204, 230, 255);
    }

    .content .reset,
    .content .submit {
        height: 30px;
        width: 100px;
        border-radius: 25px;
        font-family: monospace;
        font-weight: 600;
        font-size: 16px;
        background-color: rgb(204, 230, 255);
    }
    </style>
</head>

<body>
    <?php include "../include/header.php" ?>
    <div class="signup">
        <p>Don't have an account <a href="signup_view.php"> Create New Account</a></p>
    </div>
    <div class="content">
        <form action="" method="post" id="form1">
            <fieldset>
                <legend>Login</legend>
                <div class="form-list">
                    <div class="form-item">
                        <div class="item-left">
                            <label for="username">User Name</label>
                        </div>
                        <div class="item-right"><input type="text" name="username" placeholder="Input User Name"
                                id="username" value="<?php echo $username ?>"></div>
                    </div>
                    <span class="error">
                        <?php
                        echo !empty($errors['username']['required']) ? $errors['username']['required'] : '';
                        echo !empty($errors['username']['matched']) ? $errors['username']['matched'] : '';
                        ?>
                    </span>

                    <div class="form-item">
                        <div class="item-left">
                            <label for="password">Password</label>
                        </div>
                        <div class="item-right"><input type="password" name="password" placeholder="*******"
                                id="password" value="<?php echo $password ?>"></div>
                    </div>
                    <span class="error">
                        <?php
                        echo !empty($errors['password']['required']) ? $errors['password']['required'] : '';
                        echo !empty($errors['password']['matched']) ? $errors['password']['matched'] : '';
                        ?>
                    </span>

                    <div class="form-item">
                        <div class="item-left">
                            <label for="captcha" style="color:rgb(217,67,66)">
                                <?php
                                require_once "../function/genCaptcha.php";
                                echo $_SESSION['captchaSs'] ?>
                            </label>
                        </div>
                        <div class="item-right"> <input type="text" name="captcha" placeholder="Enter captcha"
                                id="captcha"></div>
                    </div>
                    <span class="error">
                        <?php
                        echo !empty($errors['captcha']['required']) ? $errors['captcha']['required'] : '';
                        echo !empty($errors['captcha']['matched']) ? $errors['captcha']['matched'] : '';
                        ?>
                    </span>

                    <div class="form-item">
                        <div class="item-left"><input class="reset" type="reset"></div>
                        <div class="item-right"> <input class="submit" type="submit" onclick="return validateForm()">
                        </div>
                    </div>
                </div>
            </fieldset>
        </form>
    </div>
    <script>
    function validateForm() {
        var password = document.getElementById("password").value.trim();
        var username = document.getElementById("username").value.trim();
        var error = document.getElementsByClassName("error");
        var errorUsername = error[0]; // Lấy phần tử đầu tiên có class là "error"
        var errorPassword = error[1]; // Lấy phần tử thứ hai có class là "error"
        if (!validateUsername(username, errorUsername)) {
            return false;
        }

        if (!validatePassword(password, errorPassword)) {
            return false;
        }
        return true;

    }

    function validateUsername(username, errorUsername) {
        errorUsername.innerHTML = "";
        if (username === "") {
            errorUsername.innerHTML = "Username không được để trống!";
            return false;
        } else {
            return true;
        }

    }

    function validatePassword(password, errorPassword) {
        errorPassword.innerHTML = "";
        if (password === "") {
            errorPassword.innerHTML = "Password không được để trống!";
            return false;
        }
        return true;
    }
    </script>
</body>

</html>