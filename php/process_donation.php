<?php
// Database connection parameters
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "rhema_donations";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$giving_type = mysqli_real_escape_string($conn, $_POST['giving_type']);
$payment_method = mysqli_real_escape_string($conn, $_POST['payment_method']);
$amount = filter_var($_POST['amount'], FILTER_VALIDATE_FLOAT);

// Validate inputs
if ($giving_type && $payment_method && $amount !== false && $amount > 0) {
    $sql = "INSERT INTO donations (giving_type, payment_method, amount) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssd", $giving_type, $payment_method, $amount);

    if ($stmt->execute()) {
        // Redirect to a success page
        echo "<h2>Thank You!</h2><p>Your donation of $$amount has been recorded successfully.</p>";
        echo "<p><a href='give.html'>Back to Donation Form</a></p>";
    } else {
        echo "Error: " . $stmt->error;
    }
    $stmt->close();
} else {
    echo "Invalid input. Please ensure all fields are filled correctly.";
}

$conn->close();
?>