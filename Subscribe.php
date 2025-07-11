<?php
// 1. Get form data
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];

    // 2. Validate email
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        die("Invalid email format.");
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
    $check = $conn->prepare("SELECT id FROM subscribers WHERE email = ?");
    $check->bind_param("s", $email);
    $check->execute();
    $check->store_result();

    if ($check->num_rows > 0) {
        echo "This email $email has already subscribed!";
        $check->close();
        $conn->close();
        exit();
    }
    $check->close();

    // 7. Prepare & insert email into database
    $stmt = $conn->prepare("INSERT INTO subscribers (email) VALUES (?)");
    $stmt->bind_param("s", $email);

    if ($stmt->execute()) {
        echo "Thanks for subscribing!";
    } else {
        echo "Something went wrong. Please try again later.";
    }

    // 8. Close connections
    $stmt->close();
    $conn->close();
} else {
    echo "Invalid request.";
}
?>