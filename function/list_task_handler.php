<?php
require_once "../database/connectDB.php";
$username = $_SESSION["username"];
$sql_title = "SELECT title,completed FROM tasks t Inner Join user u ON t.user_id=u.id WHERE u.username = ? AND t.is_delete = 0";
$stmt_title = mysqli_prepare($conn, $sql_title);
mysqli_stmt_bind_param($stmt_title, "s", $username);
mysqli_stmt_execute($stmt_title);
$resultTitle = mysqli_stmt_get_result($stmt_title);
$titles = [];
if (mysqli_num_rows($resultTitle) > 0) {
    while ($row = mysqli_fetch_assoc($resultTitle)) {
        $titles[] = $row;
    }
}
?>