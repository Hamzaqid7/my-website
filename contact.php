<?php
// 1. Get form data
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $subject = $_POST['subjects'];
    $message = $_POST['messages'];

    // 2. Validate email
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        die("Invalid email format.");
    }

    if (empty($username) || empty($email) || empty($subject) || empty($message)) {
    die("All fields are required.");
    }

    // 3. DB connection parameters
    $host = "localhost";
    $db = "newsletter_db";
    $user = "root";       // use your DB username
    $pass = "";           // use your DB password

    // 4. Create MySQLi connection
    $conn = new mysqli($host, $user, $pass, $db);

    // 5. Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // 6. Check if email already exists
    $check = $conn->prepare("SELECT username FROM clients WHERE email = ?");
    $check->bind_param("s", $email);
    $check->execute();
    $check->store_result();

    if ($check->num_rows > 0) {
        echo "Your previous request is already under process, kindly wait for our reply!";
        $check->close();
        $conn->close();
        exit();
    }
    $check->close();

    // 7. Insert data into 'clients' table
    $stmt = $conn->prepare("INSERT INTO clients (username, email, subjects, messages) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $username, $email, $subject, $message);

    if ($stmt->execute()) {
        echo "Thanks for reaching out! We'll get back to you shortly.";
    } else {
        echo "Something went wrong. Please try again later.";
    }

    $stmt->close();
    $conn->close();
} else {
    echo "Invalid request.";
}
?>