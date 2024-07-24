<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
?>


<?php
$servername = "localhost"; // Replace with your database server name
$username = "root"; // Replace with your database username
$password = "Drishti@123"; // Replace with your database password
$dbname = "portfolio_data"; // Replace with your database name

// Create a connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Collect and sanitize form data
    $name = filter_input(INPUT_POST, 'contactName', FILTER_SANITIZE_STRING);
    $email = filter_input(INPUT_POST, 'contactEmail', FILTER_SANITIZE_EMAIL);
    $subject = filter_input(INPUT_POST, 'contactSubject', FILTER_SANITIZE_STRING);
    $message = filter_input(INPUT_POST, 'contactMessage', FILTER_SANITIZE_STRING);

    // Validate email
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "Invalid email format";
        exit;
    }

    // Prepare and bind
    $stmt = $conn->prepare("INSERT INTO contacts (name, email, subject, message) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $name, $email, $subject, $message);

    // Execute the statement
    if ($stmt->execute()) {
        echo "OK";
    } else {
        echo "Error: " . $stmt->error;
    }

    // Close the statement and connection
    $stmt->close();
}

$conn->close();
?>
