<?php
session_start();

$servername = "mysql-3e6b8f9a-darak.f.aivencloud.com";
$username   = "avnadmin";
$password   = "AVNS_pz25C9MQxsOQp_dMHeU";
$dbname     = "defaultdb";
$port       = 21817;

$conn = mysqli_connect($servername, $username, $password, $dbname, $port);

if (!$conn) {
    die("فشل الاتصال: " . mysqli_connect_error());
}

// معالجة الدخول عند إرسال النموذج
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST['email']);
    $user_password = trim($_POST['password']);

    $stmt = $conn->prepare("SELECT id, password FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($row = $result->fetch_assoc()) {
        if (password_verify($user_password, $row['password'])) {
            $_SESSION['user_id'] = $row['id'];
            echo "<h3 style='color:green;text-align:center;'>تم تسجيل الدخول بنجاح!</h3>";
        } else {
            $error = "كلمة المرور غير صحيحة";
        }
    } else {
        $error = "الحساب غير موجود";
    }
}
?>

<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>تسجيل الدخول</title>
    <style>
        body { font-family: sans-serif; display: flex; justify-content: center; align-items: center; height: 100vh; background: #f4f4f9; }
        .card { background: white; padding: 20px; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); width: 300px; }
        input { width: 100%; padding: 10px; margin: 8px 0; border: 1px solid #ccc; border-radius: 4px; box-sizing: border-box; }
        button { width: 100%; padding: 10px; background: #28a745; color: white; border: none; border-radius: 4px; cursor: pointer; }
    </style>
</head>
<body>
    <div class="card">
        <h2>تسجيل الدخول</h2>
        <?php if (!empty($error)) echo "<p style='color:red;'>$error</p>"; ?>
        <form method="POST">
            <input type="email" name="email" placeholder="البريد الإلكتروني" required>
            <input type="password" name="password" placeholder="كلمة المرور" required>
            <button type="submit">دخول</button>
        </form>
    </div>
</body>
</html>
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
