<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "accounting_system";

// إنشاء الاتصال
$conn = new mysqli($servername, $username, $password, $dbname);

// التحقق من الاتصال
if ($conn->connect_error) {
    die("فشل الاتصال: " . $conn->connect_error);
}

// تعيين الترميز إلى UTF-8 لدعم اللغة العربية
$conn->set_charset("utf8");
?>
