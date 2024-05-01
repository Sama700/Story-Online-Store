<?php

include 'db.php'; // تضمين ملف الاتصال بقاعدة البيانات

$conn = new mysqli($servername, $username, $password, $dbname);

// التحقق من الاتصال
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// استقبال البيانات من نموذج التسجيل
$username = $_POST['username'];
$password = $_POST['password'];

// تشفير كلمة المرور
$hashed_password = password_hash($password, PASSWORD_DEFAULT);

// إدراج البيانات في قاعدة البيانات
$stmt = $conn->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
$stmt->bind_param("ss", $username, $hashed_password);

if ($stmt->execute()) {
    echo "User registered successfully.";
} else {
    echo "Error registering user: " . $conn->error;
}

$stmt->close();
$conn->close();

// بعد تسجيل الدخول بنجاح يتمم توجيه المستخدم إلى صفحة المنتجات
header('Location: products.php');
exit();

?>
