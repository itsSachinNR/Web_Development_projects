<?php

// --- 1. Database Configuration ---
$servername = "localhost"; // Usually 'localhost'
$username = "your_db_username"; // *** CHANGE THIS ***
$password = "your_db_password"; // *** CHANGE THIS ***
$dbname = "flower_shop"; // The database name you created

// --- 2. Create Connection ---
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    // Stop the script and display a connection error
    die("Connection failed: " . $conn->connect_error);
}

// --- 3. Check if the form was submitted using POST method ---
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // --- 4. Prepare and Sanitize Input Data ---
    // Use mysqli_real_escape_string to prevent basic SQL Injection and trim whitespace
    $name = $conn->real_escape_string(trim($_POST['name']));
    $email = $conn->real_escape_string(trim($_POST['email']));
    $phone = $conn->real_escape_string(trim($_POST['phone'] ?? '')); // Use empty string if phone is not set
    $orderType = $conn->real_escape_string(trim($_POST['orderType'] ?? '')); // Use empty string if orderType is not set
    $message = $conn->real_escape_string(trim($_POST['message']));

    // Simple validation (check required fields based on your HTML)
    if (empty($name) || empty($email) || empty($message)) {
        die("Error: Name, Email, and Message are required fields.");
    }

    // --- 5. Construct the SQL INSERT statement ---
    $sql = "INSERT INTO contacts (name, email, phone, order_type, message)
            VALUES ('$name', '$email', '$phone', '$orderType', '$message')";

    // --- 6. Execute the query and provide feedback ---
    if ($conn->query($sql) === TRUE) {
        // Success message and redirect
        echo "<h2>Thank You!</h2>";
        echo "<p>Your message has been successfully sent to Blooms & Petals. We will be in touch soon.</p>";
        // Optional: Redirect the user back to the contact page or a thank you page after 5 seconds
        echo '<meta http-equiv="refresh" content="5;url=contact.html">';

    } else {
        // Error handling
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
} else {
    // If someone tries to access the PHP file directly
    echo "Access Denied. Please submit the form.";
}

// --- 7. Close Connection ---
$conn->close();

?>