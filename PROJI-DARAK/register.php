<?php
session_start();

$servername = "mysql-3e6b8f9a-darak.f.aivencloud.com";
$username   = "avnadmin";
$password   = "AVNS_pz25C9MQxsOQp_dMHeU";
$dbname     = "defaultdb";
$port       = 21817;

// إنشاء الاتصال بقاعدة البيانات السحابية
$conn = new mysqli($servername, $username, $password, $dbname, $port);

if ($conn->connect_error) {
    die("فشل الاتصال: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST['email']);
    $user_password = password_hash(trim($_POST['password']), PASSWORD_DEFAULT);

    // إدخال الحساب في قاعدة البيانات
    $stmt = $conn->prepare("INSERT INTO users (email, password) VALUES (?, ?)");
    $stmt->bind_param("ss", $email, $user_password);

    if ($stmt->execute()) {
        // إرسال رسالة بريد إلكتروني للتأكيد
        $to = $email;
        $subject = "تأكيد التسجيل في منصة DARAK";
        $message = "مرحباً بك،\n\nتم إنشاء حسابك بنجاح في منصة DARAK.";
        $headers = "From: no-reply@darak.com" . "\r\n" .
                   "Content-Type: text/plain; charset=UTF-8";

        @mail($to, $subject, $message, $headers);

        echo "<h3 style='color:green; text-align:center;'>تم التسجيل بنجاح! تم إرسال رسالة تأكيد إلى بريدك.</h3>";
        echo "<script>setTimeout(function(){ window.location.href='index.html'; }, 3000);</script>";
    } else {
        echo "<h3 style='color:red; text-align:center;'>حدث خطأ أثناء التسجيل أو البريد مُسجل مسبقاً!</h3>";
    }

    $stmt->close();
}
$conn->close();
?>
