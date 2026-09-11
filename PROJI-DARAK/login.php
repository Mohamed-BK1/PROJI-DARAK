<?php
session_start();

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "darak_db";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST['email']);
    $user_password = trim($_POST['password']);

    $stmt = $conn->prepare("SELECT password FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        if (password_verify($user_password, $row['password'])) {
            $_SESSION['email'] = $email;
            header("Location: about.html");
            exit();
        } else {
            echo "<h3 style='color:red; text-align:center;'>كلمة السر غير صحيحة!</h3>";
        }
    } else {
        echo "<h3 style='color:red; text-align:center;'>البريد الإلكتروني غير مسجل!</h3>";
    }
    $stmt->close();
}
$conn->close();
?>