<?php
$host = "localhost";
$username = "root";
$password = ""; // default for XAMPP
$database = "checkout_db";

// Create connection
$conn = new mysqli($host, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $country = $_POST['country'];
    $first = $_POST['first_name'];
    $last = $_POST['last_name'];
    $address = $_POST['address'];
    $city = $_POST['city'];
    $phone = $_POST['phone'];

    // 6. Check if previous order request has completed or not
    $check = $conn->prepare("SELECT first_name FROM orders WHERE email = ? AND phone = ?");
    $check->bind_param("ss", $email, $phone);
    $check->execute();
    $check->store_result();

    if ($check->num_rows > 0) {
        echo "Dear '$first $last' Your previous order is already under process, kindly wait for this order to be delivered before applying for another order!";
        $check->close();
        $conn->close();
        exit();
    }
    $check->close();

    $stmt = $conn->prepare("INSERT INTO orders (email, country, first_name, last_name, address, city, phone) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssssss", $email, $country, $first, $last, $address, $city, $phone);

    if ($stmt->execute()) {
        echo "Congratulations, $first $last Your order has been successfully received by our sales team";
    } else {
        echo "error";
    }

    $stmt->close();
    $conn->close();
} else {
    echo "invalid";
}
?>