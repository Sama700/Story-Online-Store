<?php

include 'db.php'; // تضمين ملف الاتصال بقاعدة البيانات

// Fetch products
$sql = "SELECT * FROM products";
$result = $conn->query($sql);

$products = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $products[] = $row;
    }
}

$conn->close();

?>