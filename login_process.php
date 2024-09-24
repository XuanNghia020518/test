<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "web_car";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Kết nối thất bại: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user = $conn->real_escape_string($_POST['username']);
    $pass = $_POST['password'];

    $sql = "SELECT * FROM users WHERE username='$user'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        
        if ($row['password'] === $pass) {
            if ($row['role'] == 1) {
                header("Location: admin.php");
            } else if ($row['role'] == 2) {
                header("Location: user.php");
            }
            exit();
        } else {
            echo "Mật khẩu không đúng.";
        }
    } else {
        echo "Tên đăng nhập không đúng.";
    }
}

$conn->close();
?>
