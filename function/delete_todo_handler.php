<?php
session_start();
require_once "../database/connectDB.php";
$taskStatus = $_SESSION["taskStatus"];
var_dump($taskStatus);
if (!empty($taskStatus)) {
    $is_execute = false;
    foreach ($taskStatus as $task) {
        var_dump($task);
        $sql_deleteTask = "UPDATE tasks SET is_delete=1 , completed = 1 WHERE title='$task'";
        $result = mysqli_query($conn, $sql_deleteTask);
        if ($result) {
            $is_execute = true;

        }
    }
    if ($is_execute) {
        echo "<script>alert('Xóa thành công')</script>";
        echo "<script>window.location.href = '../view/todo_view.php';</script>";
        exit;
    }
} else {
    header("Location: ../view/todo_view.php");
}
?>