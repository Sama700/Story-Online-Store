<?php

include 'db.php'; // تضمين ملف الاتصال بقاعدة البيانات

session_start();
// Assuming you have a database connection set up as $db

// Function to generate a CSRF token
function generateCsrfToken() {
    return bin2hex(random_bytes(32));
}

// Function to validate the CSRF token
function validateCsrfToken($token) {
    return isset($_SESSION['csrf_token']) && hash_equals($_SESSION['csrf_token'], $token);
}

// Generate a new CSRF token if one does not exist
if (!isset($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = generateCsrfToken();
}

// Check if the form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate the CSRF token
    if (!validateCsrfToken($_POST['csrf_token'])) {
        die('CSRF token validation failed.');
    }

    // Retrieve all the form data and sanitize it
    $first_name = filter_input(INPUT_POST, 'first_name', FILTER_SANITIZE_STRING);
    $last_name = filter_input(INPUT_POST, 'last_name', FILTER_SANITIZE_STRING);
    $address = filter_input(INPUT_POST, 'address', FILTER_SANITIZE_STRING);
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    $phone = filter_input(INPUT_POST, 'phone', FILTER_SANITIZE_STRING);
    $birthdate = filter_input(INPUT_POST, 'birthdate', FILTER_SANITIZE_STRING);
    $gender = filter_input(INPUT_POST, 'gender', FILTER_SANITIZE_STRING);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    // Validate the passwords
    if ($password !== $confirm_password) {
        die('Passwords do not match.');
    }

    // Hash the password
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Prepare the SQL statement to prevent SQL injection
    $stmt = $db->prepare("INSERT INTO users (first_name, last_name, address, email, phone, birthdate, gender, password) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");

    // Bind the parameters and execute the statement
    $stmt->bind_param("ssssssss", $first_name, $last_name, $address, $email, $phone, $birthdate, $gender, $hashed_password);
    
    // Execute and check if the user was added successfully
    if ($stmt->execute()) {
        echo "User registration successful.";
    } else {
        echo "User registration failed: " . $stmt->error;
    }

    $stmt->close();
}

// Close the database connection
$db->close();

// بعد إضافة المستخدم إلى قاعدة البيانات بنجاح، يتم توجيهه إلى صفحة المنتجات
header('Location: products.php');
exit();

?>
