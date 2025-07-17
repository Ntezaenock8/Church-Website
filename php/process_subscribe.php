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

// Collect data
$email = mysqli_real_escape_string($conn, $_POST['email']);

// Validate input
if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
    // Check if email already exists
    $sql_check = "SELECT email FROM subscribers WHERE email = ?";
    $stmt_check = $conn->prepare($sql_check);
    $stmt_check->bind_param("s", $email);
    $stmt_check->execute();
    $stmt_check->store_result();

    if ($stmt_check->num_rows > 0) {
        echo "<h2>Already Subscribed</h2><p>This email is already subscribed.</p>";
        echo "<p><a href='contact-us.html'>Back to Contact Us</a></p>";
    } else {
        // Insert data into database
        $sql = "INSERT INTO subscribers (email) VALUES (?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $email);

        if ($stmt->execute()) {
            echo "<h2>Thank You!</h2><p>You have successfully subscribed to our newsletter.</p>";
            echo "<p><a href='contact-us.html'>Back to Contact Us</a></p>";
        } else {
            echo "Error: " . $stmt->error;
        }
        $stmt->close();
    }
    $stmt_check->close();
} else {
    echo "Invalid email address. Please enter a valid email.";
}

// Close the connection
$conn->close();
?>