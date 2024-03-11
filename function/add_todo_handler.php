<?php
require_once "../database/connectDB.php";
$errors = [];
$titleAdd = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $titleAdd = $_POST["title"];
    if (empty($titleAdd)) {
        $errors["title"]["required"] = "Title không được để trống !";
    } else {
        $username = $_SESSION["username"];
        // kiem tra xem title da ton tai chua?
        $sql_task = "SELECT *  FROM tasks t Inner Join user u ON t.user_id=u.id WHERE u.username = ? AND t.title =?";
        $stmt_task = mysqli_prepare($conn, $sql_task);
        mysqli_stmt_bind_param($stmt_task, "ss", $username, $titleAdd);
        mysqli_stmt_execute($stmt_task);
        $result_tasks = mysqli_stmt_get_result($stmt_task);
        if (mysqli_num_rows($result_tasks) > 0) {
            echo "<script>alert('Task đã tồn tại, tạo tài khoản không thành công')</script>";
            echo "<script>window.location.href = '../view/todo_view.php';</script>";
            exit;

        }

        //lay id cua nguoi dung
        $sql_user = "SELECT id  FROM user u  WHERE u.username = ?";
        $stmt_user = mysqli_prepare($conn, $sql_user);
        mysqli_stmt_bind_param($stmt_user, "s", $username);
        mysqli_stmt_execute($stmt_user);
        $result_tasks = mysqli_stmt_get_result($stmt_user);
        $user_id = 0;
        if (mysqli_num_rows($result_tasks) > 0) {
            $row = mysqli_fetch_assoc($result_tasks);
            $user_id = $row["id"];
        }

        // viet cau lenh de insert add
        if (!(empty($user_id))) {
            $sql_insert_task = "insert into tasks(title,user_id) values(?,?);";
            $stmt_insert_task = mysqli_prepare($conn, $sql_insert_task);
            mysqli_stmt_bind_param($stmt_insert_task, "si", $titleAdd, $user_id);
            mysqli_stmt_execute($stmt_insert_task);
            $affacted_row = mysqli_stmt_affected_rows($stmt_insert_task);

            if ($affacted_row > 0) {
                echo "<script>alert('Tạo task thành công')</script>";
                echo "<script>window.location.href = '../view/todo_view.php';</script>";
                exit;
            } else {
                echo "<script>alert('Tạo task thất bại')</script>";
                echo "<script>window.location.href = '../view/todo_view.php';</script>";
                exit;
            }

        }
    }


}

?>