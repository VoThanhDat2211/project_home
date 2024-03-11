<?php
$username = "";
$password = "";
$captcha = "";
$errors = [];
// validate dữ liệu
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $username = $_POST["username"];
    $password = $_POST["password"];
    $captcha = $_POST["captcha"];
    if (empty($username)) {
        $errors["username"]["required"] = "Username không được để trống !";
    }
    if (empty($password)) {
        $errors["password"]["required"] = "Password không được để trống !";
    }
    if (empty($captcha)) {
        $errors["captcha"]["required"] = "Captcha không được để trống !";
    } else {
        if ($captcha !== $_SESSION["captchaSs"]) {
            $errors["captcha"]["matched"] = "Captcha không đúng !";
        }
    }


    // connection db
    if (empty($errors) && !empty($username)) {
        require_once "../database/connectDB.php";
        // lay du lieu tu db 
        $sql = "SELECT * FROM user WHERE username = ? AND is_delete = 0";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();
        $stmt->close();
        if ($result->num_rows > 0) {
            $rows = $result->fetch_assoc();
            $hashPasswordCheck = password_verify($password, $rows['password']);
            if ($hashPasswordCheck === true) {
                $_SESSION["username"] = $rows["username"];
                header("Location: todo_view.php");
            } else {
                $errors["password"]["matched"] = "Mật khẩu không chính xác !";
            }
        } else {
            $errors["username"]["matched"] = "Username không tồn tại !";
        }
    }
}
?>