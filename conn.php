<?php
// --- การเชื่อมต่อ MySQL ---
$servername = "localhost";   // ชื่อเซิร์ฟเวอร์
$username   = "root";        // ชื่อผู้ใช้ MySQL
$password   = "";            // รหัสผ่าน MySQL
$dbname     = "scm67_minimart"; // ชื่อฐานข้อมูล

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("เชื่อมต่อฐานข้อมูลล้มเหลว: " . $conn->connect_error);
} else {
    // echo("connect success");
}
?>
