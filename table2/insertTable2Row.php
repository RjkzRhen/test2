<?php

include_once '../db/db.php';

function insertTable2Row($data) {

    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "users1";

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Ошибка подключения: " . $conn->connect_error);
    }

    $sql = "INSERT INTO `name` (last_name, first_name, middle_name, age) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sss", $data['column1'], $data['column2'], $data['column3']);

    if ($stmt->execute()) {
        return true;
    } else {
        return false;
    }
}
?>