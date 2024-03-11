<?php
session_start();
if (!isset($_SESSION["username"])) {
    header("Location: login_view.php");
}
require_once "../function/add_todo_handler.php";
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

    .task-content {
        margin-top: 38px;
        font-size: 28px;
        font-style: normal;
        display: flex;
        width: 100%;
        justify-content: center;
        font-size: 18px;

    }

    .title {
        margin-right: 50px;

    }

    .title input {
        padding: 10px;
        outline: none;
        border: none;
        border-left: 1px solid black;
        font-size: 20px;
        margin-bottom: 12px;
    }

    .error {
        font-size: 16px;
        color: red;
        margin-top: 5px;
    }

    .add {
        margin-left: 50px;
    }

    input[type="submit"] {
        font-size: 18px;
        border-radius: 20px;
        background-color: rgb(204, 230, 255);
        border: 0;
        padding: 4px 26px;
        font-weight: 600
    }

    input[type="submit"]:hover {
        background-color: rgb(220, 220, 220);
        cursor: pointer;
    }
    </style>
</head>

<body>
    <?php include "../include/header.php" ?>
    <form method="POST" class="task-content">
        <div class="title">
            <input type="text" placeholder="Title" name="title"> <br>
            <span class="error">
                <?php
                echo !empty($errors["title"]["required"]) ? $errors["title"]["required"] : "";
                ?>
            </span>
        </div>
        <div class="add">
            <input type="submit" class="addBtn" value="Add">
        </div>
    </form>



</body>

</html>