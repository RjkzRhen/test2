<?php

include_once '../db/db.php';

function getTable2Rows() {
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "users1";

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Ошибка подключения: " . $conn->connect_error);
    }

    $sql = "SELECT * FROM name";
    $stmt = $conn->prepare($sql);
    $stmt->execute();

    $result = $stmt->get_result();
    $rows = array();
    while ($row = $result->fetch_assoc()) {
        $rows[] = $row;
    }

    $conn->close();
    return $rows;
}
?>