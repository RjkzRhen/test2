<?php
include_once '../db/db.php';
include_once '../table2/getTable2Rows.php';

$rows = getTable2Rows();
function getTableRows($minAge = 0) {
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "users1";

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Ошибка подключения: " . $conn->connect_error);
    }

    $sql = "SELECT * FROM `name` WHERE age >= ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $minAge);
    $rows = array(); // Инициализация переменной $rows как пустого массива
    if ($stmt->execute()) {
        $result = $stmt->get_result();
        if ($result) {
            while ($row = $result->fetch_assoc()) {
                $ageClass = $row['age'] > 50 ? 'age-over-50' : '';
                $rows[] = array(
                    'id' => $row['id'],
                    'last_name' => $row['last_name'],
                    'first_name' => $row['first_name'],
                    'middle_name' => $row['middle_name'],
                    'age' => $row['age'],
                    'ageClass' => $ageClass
                );
            }
        }
    }

    $conn->close();
    return $rows;
}

// Пример использования функции
$minAge = isset($_GET['minAge']) ? (int)$_GET['minAge'] : 0;
$tableRows = getTableRows($minAge);

function displayTable($tableRows) {
    echo "<table>";
    echo "<tr><th>ID</th><th>Фамилия</th><th>Имя</th><th>Отчество</th><th>Возраст</th><th>Действия</th></tr>";
    foreach ($tableRows as $row) {
        echo "<tr>";
        echo "<td>".$row['id']."</td>";
        echo "<td>".$row['last_name']."</td>";
        echo "<td>".$row['first_name']."</td>";
        echo "<td>".$row['middle_name']."</td>";
        echo "<td class=\"".$row['ageClass']."\">".$row['age']."</td>";
        echo "<td><a href='delete.php?id=".$row['id']."'>Удалить</a></td>";
        echo "</tr>";
    }
    echo "</table>";
}

// Использование новой функции
displayTable($tableRows);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Таблица пользователей</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            padding: 10px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        th {
            background-color: #ffffff;
        }
        tr:nth-child(even) {
            background-color: #ffffff;
        }
        tr:hover {
            background-color: #f1f1f1;
        }
        .age-over-50 {
            color: red;
        }
    </style>
</head>
<body>
<form action="" method="get">
    <label for="minAge">Минимальный возраст:</label>
    <input type="number" id="minAge" name="minAge" value="<?= $minAge ?>">
    <input type="submit" value="Фильтровать">
</form>
<!--
<table>
    <tr>
        <th>ID</th>
        <th>Фамилия</th>
        <th>Имя</th>
        <th>Отчество</th>
        <th>Возраст</th>
        <th>Действия</th>
    </tr>
    <?php
while ($row = $tableRows->fetch_assoc()) {
    $ageClass = $row['age'] > 50 ? 'age-over-50' : '';
    echo "<tr>";
    echo "<td>".$row['id']."</td>";
    echo "<td>".$row['last_name']."</td>";
    echo "<td>".$row['first_name']."</td>";
    echo "<td>".$row['middle_name']."</td>";
    echo "<td class=\"".$ageClass."\">".$row['age']."</td>";
    echo "<td><a href='delete.php?id=".$row['id']."'>Удалить</a></td>";
    echo "</tr>";
}
?>
</table>
-->
</body>
</html>