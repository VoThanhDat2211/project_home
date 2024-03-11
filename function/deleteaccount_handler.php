<?php
$session_lifetime = 60;
session_set_cookie_params($session_lifetime);
session_start();
if (!isset($_SESSION["username"])) {
    header("Location: login_view.php");
}

if (isset($_POST["accept"])) {
    require_once "../database/connectDB.php";
    $username = $_SESSION["username"];
    $sql_user = "SELECT id FROM user WHERE username = ?";
    $stmt_user = mysqli_prepare($conn, $sql_user);
    mysqli_stmt_bind_param($stmt_user, "s", $username);
    mysqli_stmt_execute($stmt_user);
    $resultUser = mysqli_stmt_get_result($stmt_user);

    if ($resultUser->num_rows > 0) {
        $row = mysqli_fetch_assoc($resultUser);
        $userId = $row["id"];

        $sql_deleteTasks = "UPDATE tasks SET is_delete=1 WHERE user_id=?";
        $stmt_deleteTasks = mysqli_prepare($conn, $sql_deleteTasks);
        mysqli_stmt_bind_param($stmt_deleteTasks, "i", $userId);
        $resultTasks = mysqli_stmt_execute($stmt_deleteTasks);

        if ($resultTasks) {
            $sql_deleteUser = "UPDATE user SET is_delete=1 WHERE id=?";
            $stmt_deleteUser = mysqli_prepare($conn, $sql_deleteUser);
            mysqli_stmt_bind_param($stmt_deleteUser, "i", $userId);
            $result_deleteUser = mysqli_stmt_execute($stmt_deleteUser);

            if ($result_deleteUser) {
                session_destroy();
                echo "<script>alert('Xóa tài khoản thành công')</script>";
                echo "<script>window.location.href = '../view/login_view.php';</script>"; // Chuyển hướng trang bằng JavaScript
                exit;
            } else {
                echo "<script>alert('Xóa tài khoản không thành công')</script>";
                echo "<script>window.location.href = '../view/login_view.php';</script>"; // Chuyển hướng trang bằng JavaScript
                exit;
            }
        }
    }
} else if (isset($_POST["cancel"])) {
    header("Location: ../view/todo_view.php");
}
?>
<!DOCTYPE html>
<html>

<head>
    <title>Xác nhận xóa tài khoản</title>
</head>

<body>

    <form method="post">
        <label>Bạn có chắc chắn muốn xóa tài khoản?</label>
        <button type="submit" name="accept">Xác nhận</button>
        <button type="submit" name="cancel">Quay lại</button>
    </form>

</body>

</html>