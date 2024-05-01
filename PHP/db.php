<?php
// db.php
$servername = "localhost";
$username = "Username"; // اسم المستخدم لقاعدة البيانات
$password = "Password"; // كلمة المرور لقاعدة البيانات
$dbname = "ss_database"; // اسم قاعدة البيانات

// إنشاء اتصال
$conn = new mysqli($servername, $username, $password, $dbname);

// تحقق من الاتصال
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>

