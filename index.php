<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: view/login_view.php");
}
header("Location: view/todo_view.php");