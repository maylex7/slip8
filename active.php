

<?php
// รับค่าจากฟอร์มแบบปลอดภัย
//$username = filter_input(INPUT_POST, 'USERNAME_ID', FILTER_SANITIZE_STRING);
//$password = filter_input(INPUT_POST, 'USER_PASSWORD', FILTER_SANITIZE_STRING);


$username = filter_input(INPUT_POST, 'u_fake', FILTER_SANITIZE_STRING);
$password = filter_input(INPUT_POST, 'realInput', FILTER_SANITIZE_STRING);

// แสดงผลสำหรับ debug (ควรลบเมื่อขึ้น production)
//echo "user = " . htmlspecialchars($username) . "<br>";
///echo "password = " . htmlspecialchars($password) . "<br>";
// เข้ารหัสรหัสผ่านแบบ MD5 (ควรใช้ password_hash() ในระบบใหม่)
$password2 = md5($password);
//echo "password 2= " . htmlspecialchars($password2) . "<br>";
// ส่งต่อไปยัง classuser.php พร้อมพารามิเตอร์
header("Location: action/classuser.php?action=login&username=" . urlencode($username) . "&password=" . urlencode($password2));
exit;
?>