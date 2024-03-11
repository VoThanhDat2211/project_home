<?php
session_start();
if (!isset($_SESSION["username"])) {
    header("Location: login_view.php");
}
require_once("../function/change_password_handler.php");

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
        .changepassword {
            height: 60px;
            line-height: 60px;
            text-align: right;
            padding-right: 30px;
            font-style: normal;
            font-size: 20px;
        }

        .changepassword a {
            /* text-decoration: none; */
            color: red;
            margin-left: 8px;
            text-decoration: double;
        }

        .user {
            height: 30px;
            background-color: rgb(230, 231, 251);
        }

        .user p {
            height: 100%;
            font-size: 28px;
            text-align: center;
            font-style: normal;
        }

        .changepassword a:hover {
            color: #CC0000;
            text-decoration: underline;

        }

        .logout:hover {
            cursor: pointer;
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
            font-style: italic;
            color: red;
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
    <div class="changepassword">
        <p><a href="todo_view.php">MyTodos</a>
            <span> |</span>
            <a href="logout.php" class="logout">Logout</a>
        </p>
    </div>

    <div class="user">
        <p>
            <?php echo "Welcome   " . $_SESSION["username"] ?>
        </p>

    </div>

    <div class="content">
        <form action="" method="post" id="form1">
            <fieldset>
                <legend>Change Password</legend>
                <div class="form-list">
                    <div class="form-item">
                        <div class="item-left">
                            <label for="oldpassword">Old Password</label>
                        </div>
                        <div class="item-right"> <input type="password" name="oldpassword" placeholder="******"
                                value="<?php echo $oldpassword ?>"></div>
                    </div>
                    <span class="error">
                        <?php
                        echo !empty($errors['oldpassword']['required']) ? $errors['oldpassword']['required'] : '';
                        echo !empty($errors['oldpassword']['matched']) ? $errors['oldpassword']['matched'] : '';
                        ?>
                    </span>

                    <div class="form-item">
                        <div class="item-left">
                            <label for="newpassword">New Password</label>
                        </div>
                        <div class="item-right"> <input type="password" name="newpassword" placeholder="*******"
                                value="<?php echo $newpassword ?>"></div>
                    </div>
                    <span class="error">
                        <?php
                        echo !empty($errors['newpassword']['required']) ? $errors['newpassword']['required'] : '';
                        echo !empty($errors['newpassword']['duplicate']) ? $errors['newpassword']['duplicate'] : '';
                        echo !empty($errors['newpassword']['min_length']) ? $errors['newpassword']['min_length'] : '';
                        ?>
                    </span>

                    <div class="form-item">
                        <div class="item-left">
                            <label for="cfnewpassword">Confirm Password</label>
                        </div>
                        <div class="item-right"> <input type="password" name="cfnewpassword" placeholder="*******"
                                value="<?php echo $cfnewpassword ?>"></div>
                    </div>
                    <span class="error">
                        <?php
                        echo !empty($errors['cfnewpassword']['required']) ? $errors['cfnewpassword']['required'] : '';
                        echo !empty($errors['cfnewpassword']['matched']) ? $errors['cfnewpassword']['matched'] : '';
                        ?>
                    </span>
                    <div class="form-item">
                        <div class="item-left"><input class="reset" type="reset"></div>
                        <div class="item-right"> <input class="submit" type="submit" onclick="return validate()"></div>
                    </div>
                </div>
            </fieldset>
        </form>
    </div>
    <script>
        function validate() {
            var password = document.getElementById("newpassword").value.trim();
            var confirmPassword = document.getElementById("cfnewpassword").value.trim();
            var error = document.getElementsByClassName("error");
            var errorPassword = error[1]; // Lấy phần tử đầu tiên có class là "error"
            var errorConfirm = error[2]; // Lấy phần tử thứ hai có class là "error"
            if (!validatePassword(password, errorPassword)) {
                return false;
            }

            if (!confirm(confirmPassword, password, errorConfirm)) {
                return false;
            }
            return true;

        }

        function validatePassword(password, errorPassword) {
            errorPassword.innerHTML = "";
            if (password === "") {
                errorPassword.innerHTML = "Password không được để trống!";
                return false;
            } else if (password.length < 6) {
                errorPassword.innerHTML = "Password ít nhất 6 ký tự!";
                return false;
            } else {
                var specialCharRegex = /[!@#$%^&*(),.?":{}|<>]/;
                var uppercaseCharRegex = /[A-Z]/;
                var lowercaseCharRegex = /[a-z]/;
                var numberRegex = /[0-9]/;
                if (!specialCharRegex.test(password) || !uppercaseCharRegex.test(password) || !lowercaseCharRegex.test(
                    password) || !numberRegex.test(password)) {
                    errorPassword.innerHTML = "Password gồm số, chữ hoa,thường, kí tự đặc biệt !";
                    return false;
                }
            }
            return true;
        }

        function confirm(cfPassword, password, errorConfirm) {
            if (cfPassword !== password) {
                errorConfirm.innerHTML = "Mật khẩu không khớp!";
                return false;
            }
            return true;
        }
    </script>
</body>

</html>