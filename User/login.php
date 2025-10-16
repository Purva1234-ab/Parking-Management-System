<?php
session_start();  // Start the session at the top

// Include your database connection
include 'dbconnect.php'; 

// Enable error reporting for debugging (you can remove this once the issue is fixed)
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$error_message = "";  // Initialize the error message variable

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get username and password from the form
    $username = $conn->real_escape_string($_POST['username']);
    $password = $_POST['password'];

    // Query to check if user exists with the provided username
    $stmt = $conn->prepare("SELECT id, username, password FROM users WHERE username = ?");
    $stmt->bind_param('s', $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Fetch the user data
        $user = $result->fetch_assoc();
        $hashed_password = $user['password'];  // Assume this is the hashed password stored in the database

        // Verify the password
        if (password_verify($password, $hashed_password)) {
            // Set user data in session
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];

            // Redirect to dashboard after login (ensure no output before this line)
            header('Location: dashboard.php');
            exit();  // Ensure no further execution after redirect
        } else {
            $error_message = "Invalid username or password.";
        }
    } else {
        $error_message = "Invalid username or password.";
    }

    // Close the prepared statement
    $stmt->close();
}

// Close the database connection
$conn->close();
?>

<!-- Display error message if set -->
<?php if (!empty($error_message)) : ?>
    <div class="error-message"><?= $error_message; ?></div>
<?php endif; ?>
