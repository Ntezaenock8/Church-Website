<?php
// Database connection parameters
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "rhema_donations";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$name = mysqli_real_escape_string($conn, $_POST['name']);
$email = mysqli_real_escape_string($conn, $_POST['email']);
$message = mysqli_real_escape_string($conn, $_POST['message']);

// Validate inputs
if ($name && filter_var($email, FILTER_VALIDATE_EMAIL) && $message) {
    // Insert data into database
    $sql = "INSERT INTO contact_messages (name, email, message) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sss", $name, $email, $message);

    if ($stmt->execute()) {
        // Redirect to a success page
        echo "<h2>Thank You!</h2><p>Your message has been sent successfully.</p>";
        echo "<p><a href='contact-us.html'>Back to Contact Us</a></p>";
    } else {
        echo "Error: " . $stmt->error;
    }
    $stmt->close();
} else {
    echo "Invalid input. Please ensure all fields are filled correctly.";
}

$conn->close();
?>