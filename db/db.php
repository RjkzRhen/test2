<?php
function deleteRecord($id) {
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "users1";

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Ошибка подключения: " . $conn->connect_error);
    }

    // Подготовка SQL-запроса для удаления записи
    $sql = "DELETE FROM `name` WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();

    // Проверка успешности удаления
    if ($stmt->affected_rows > 0) {
        echo "Запись успешно удалена!";
    } else {
        echo "Не удалось удалить запись.";
    }

    // Закрытие соединения
    $stmt->close();
    $conn->close();
}
?>

