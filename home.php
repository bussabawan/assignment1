<!--show member on home page-->
<?php
require_once('conn.php');

// Handle Add Customer
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['action']) && $_POST['action'] == 'add') {
    $name = $_POST['name'];
    $lastname = $_POST['lastname'];
    $telephone = $_POST['telephone'];
    $address = $_POST['address'];
    $user_name = $_POST['user_name'];
    $pass_word = $_POST['pass_word'];
    
    $sql = "INSERT INTO member_s (name, lastname, telephone, address, user_name, pass_word) 
            VALUES ('$name', '$lastname', '$telephone', '$address', '$user_name', '$pass_word')";
    
    if ($conn->query($sql) === TRUE) {
        echo "<p style='color: green;'>เพิ่มข้อมูลลูกค้าสำเร็จ</p>";
    } else {
        echo "<p style='color: red;'>ข้อผิดพลาด: " . $conn->error . "</p>";
    }
}

// Handle Edit Customer
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['action']) && $_POST['action'] == 'edit') {
    $id_member = $_POST['id_member'];
    $name = $_POST['name'];
    $lastname = $_POST['lastname'];
    $telephone = $_POST['telephone'];
    $address = $_POST['address'];
    $user_name = $_POST['user_name'];
    $pass_word = $_POST['pass_word'];
    
    $sql = "UPDATE member_s SET name='$name', lastname='$lastname', telephone='$telephone', 
            address='$address', user_name='$user_name', pass_word='$pass_word' WHERE id_member=$id_member";
    
    if ($conn->query($sql) === TRUE) {
        echo "<p style='color: green;'>แก้ไขข้อมูลลูกค้าสำเร็จ</p>";
    } else {
        echo "<p style='color: red;'>ข้อผิดพลาด: " . $conn->error . "</p>";
    }
}

// Handle Delete Customer
if (isset($_GET['delete'])) {
    $id_member = $_GET['delete'];
    $sql = "DELETE FROM member_s WHERE id_member=$id_member";
    
    if ($conn->query($sql) === TRUE) {
        echo "<p style='color: green;'>ลบข้อมูลลูกค้าสำเร็จ</p>";
    } else {
        echo "<p style='color: red;'>ข้อผิดพลาด: " . $conn->error . "</p>";
    }
}

// Get Customer for Edit
$edit_customer = null;
if (isset($_GET['edit'])) {
    $id_member = $_GET['edit'];
    $sql = "SELECT * FROM member_s WHERE id_member=$id_member";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        $edit_customer = $result->fetch_assoc();
    }
}

echo '<h2>ข้อมูลลูกค้า</h2>';

// Form to Add/Edit Customer
echo "<h3>" . ($edit_customer ? "แก้ไขข้อมูลลูกค้า" : "เพิ่มข้อมูลลูกค้า") . "</h3>";
echo "<form method='POST'>";
echo "<input type='hidden' name='action' value='" . ($edit_customer ? "edit" : "add") . "'>";
if ($edit_customer) {
    echo "<input type='hidden' name='id_member' value='" . $edit_customer['id_member'] . "'>";
}
echo "<label>ชื่อ:</label> <input type='text' name='name' value='" . ($edit_customer ? $edit_customer['name'] : '') . "' required><br>";
echo "<label>นามสกุล:</label> <input type='text' name='lastname' value='" . ($edit_customer ? $edit_customer['lastname'] : '') . "' required><br>";
echo "<label>เบอร์โทร:</label> <input type='text' name='telephone' value='" . ($edit_customer ? $edit_customer['telephone'] : '') . "' required><br>";
echo "<label>ที่อยู่:</label> <input type='text' name='address' value='" . ($edit_customer ? $edit_customer['address'] : '') . "' required><br>";
echo "<label>ชื่อผู้ใช้:</label> <input type='text' name='user_name' value='" . ($edit_customer ? $edit_customer['user_name'] : '') . "' required><br>";
echo "<label>รหัสผ่าน:</label> <input type='password' name='pass_word' value='" . ($edit_customer ? $edit_customer['pass_word'] : '') . "' required><br>";
echo "<button type='submit'>" . ($edit_customer ? "บันทึกการแก้ไข" : "เพิ่มลูกค้า") . "</button>";
if ($edit_customer) {
    echo " <a href='home.php'><button type='button'>ยกเลิก</button></a>";
}
echo "</form>";
echo "<hr>";

// Display Customer List
echo "<h3>รายการลูกค้า</h3>";
$sql = "SELECT * FROM member_s";
if ($result = $conn->query($sql)) {
    if ($result->num_rows > 0) {
        echo "<table border='1' style='border-collapse: collapse; width: 100%;'>";
        echo "<tr style='background-color: #f2f2f2;'><th>รหัสลูกค้า</th><th>ชื่อ</th><th>นามสกุล</th><th>เบอร์โทร</th><th>ที่อยู่</th><th>ชื่อผู้ใช้</th><th>การจัดการ</th></tr>";
        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . $row['id_member'] . "</td>";
            echo "<td>" . $row['name'] . "</td>";
            echo "<td>" . $row['lastname'] . "</td>";
            echo "<td>" . $row['telephone'] . "</td>";
            echo "<td>" . $row['address'] . "</td>";
            echo "<td>" . $row['user_name'] . "</td>";
            echo "<td>";
            echo "<a href='home.php?edit=" . $row['id_member'] . "'><button>แก้ไข</button></a> ";
            echo "<a href='home.php?delete=" . $row['id_member'] . "' onclick='return confirm(\"ยืนยันการลบข้อมูลลูกค้า?\")'><button style='background-color: red; color: white;'>ลบ</button></a>";
            echo "</td>";
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
