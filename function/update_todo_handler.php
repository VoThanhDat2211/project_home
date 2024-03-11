<?php
session_start();
require_once "../database/connectDB.php";
$taskStatus = $_SESSION["taskStatus"];
if (!empty($taskStatus)) {
    $is_execute = false;
    foreach ($_SESSION["taskStatus"] as $task) {
        $sql_updateTask = "UPDATE tasks SET completed = 1 WHERE title='$task'";
        $result = mysqli_query($conn, $sql_updateTask);
        if ($result) {
            $is_execute = true;
        }
    }
    if ($is_execute) {
        echo "<script>alert('Cập nhật thành công thành công')</script>";
        echo "<script>window.location.href = '../view/todo_view.php';</script>";
        exit;
    }
} else {
    header("Location: ../view/todo_view.php");
}

?>