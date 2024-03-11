<?php

include '../db/db.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    deleteRecord($id);
    header("Location: index.php"); // Перенаправление обратно на страницу с таблицей пользователей
    exit;
}
