<?php
$servername = "mysql-3e6b8f9a-darak.f.aivencloud.com";
$username   = "avnadmin";
$password   = "AVNS_ouuoZ4E1RXO4ueR170o";
$dbname     = "defaultdb";
$port       = 21817;

// إنشاء الاتصال مرة واحدة فقط
$conn = new mysqli($servername, $username, $password, $dbname, $port);

// التحقق من نجاح الاتصال
if ($conn->connect_error) {
    die("فشل الاتصال بقاعدة البيانات: " . $conn->connect_error);
}

// كود معالجة النموذج (POST) يبدأ هنا دون إعادة إنشاء $conn
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
