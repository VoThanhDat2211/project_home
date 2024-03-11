<?php
$oldpassword = "";
$newpassword = "";
$cfnewpassword = "";
// validate dữ liệu
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $oldpassword = $_POST["oldpassword"];
    $newpassword = $_POST["newpassword"];
    $cfnewpassword = $_POST["cfnewpassword"];
    if (empty($oldpassword)) {
        $errors["oldpassword"]["required"] = "Old Password không được để trống !";
    }

    if (empty($newpassword)) {
        $errors["newpassword"]["required"] = "New password không được để trống !";
    } else if (strlen($newpassword) < 6) {
        $errors["newpassword"]["min_length"] = "Password ít nhất 6 ký tự !";
    } else {
        $special_char_regex = '/[@_!#$%^&*()<>?\/|}{~:]/';
        $uppercase_char_regex = '/[A-Z]/';
        $lowercase_char_regex = '/[a-z]/';
        $number_regex = '/[0-9]/';
        if (
            !preg_match($special_char_regex, $newpassword) ||
            !preg_match($uppercase_char_regex, $newpassword) ||
            !preg_match($lowercase_char_regex, $newpassword) ||
            !preg_match($number_regex, $newpassword)
        ) {
            $errors["newpassword"]["invalid"] = "Password gồm số, chữ hoa,thường, kí tự đặc biệt !";
        }
    }


    if (empty($cfnewpassword)) {
        $errors["cfnewpassword"]["required"] = "Bạn phải xác nhận mật khẩu !";
    } else {
        if ($cfnewpassword !== $newpassword) { {
                $errors["cfnewpassword"]["matched"] = "Mật khẩu không trùng khớp !";
            }
        }
    }

    // connection db
    if (empty($errors) && !empty($oldpassword)) {
        require_once "../database/connectDB.php";
        // lay du lieu tu db 
        $sql = "SELECT * FROM user WHERE username = ? ";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $_SESSION["username"]);
        $stmt->execute();
        $result = $stmt->get_result();
        $stmt->close();
        if ($result->num_rows > 0) {
            $rows = $result->fetch_assoc();
            $hashPasswordCheck = password_verify($oldpassword, $rows['password']);
            if ($hashPasswordCheck === true) {
                if ($newpassword == $oldpassword) {
                    $errors['newpassword']['duplicate'] = 'Trùng mật khẩu cũ !';
                } else {
                    // update mat khau 
                    $password = password_hash($newpassword, PASSWORD_DEFAULT);
                    $username = $_SESSION["username"];
                    $sql = "UPDATE user SET password = '$password' WHERE username = '$username' ";
                    if ($conn->query($sql)) {
                        echo "<script>alert('Đổi mật khẩu thành công')</script>";
                        echo "<script>window.location.href = '../todo_view.php';</script>";
                    }
                }
            } else {
                $errors["oldpassword"]["matched"] = "Old password Không chính xác !";
            }
        } else {
            echo "<script>alert('Người dùng không tồn tại')</script>";
        }
    }
}
?>