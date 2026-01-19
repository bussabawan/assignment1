<!--show member on home page-->
<?php
require_once('conn.php');
echo '<h2>ข้อมูลลูกค้า</h2>';
$sql = "SELECT * FROM member_s";
if ($result = $conn->query($sql)) {
    if ($result->num_rows > 0) {
        echo "<table border='1'>";
        echo "<tr><th>รหัสลูกค้า</th><th>ชื่อ</th><th>นามสกุล</th><th>เบอร์โทร</th><th>ที่อยู่</th><th>ชื่อผู้ใช้</th><th>รหัสผ่าน</th></tr>";
        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . $row['id_member'] . "</td>";
            echo "<td>" . $row['name'] . "</td>";
            echo "<td>" . $row['lastname'] . "</td>";
            echo "<td>" . $row['telephone'] . "</td>";
            echo "<td>" . $row['address'] . "</td>";
            echo "<td>" . $row['user_name'] . "</td>";
            echo "<td>" . $row['pass_word'] . "</td>";
            echo "</tr>";
        }
        echo "</table>";
        $result->free();
    } else {
        echo "ไม่มีข้อมูลลูกค้า";
    }
} else {
    echo "ข้อผิดพลาดในการดึงข้อมูล: " . $conn->error;
}
?>
