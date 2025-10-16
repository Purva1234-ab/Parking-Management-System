<?php
include 'dbconnect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Step 1: Check if the user submitted username and email
    if (isset($_POST['username']) && isset($_POST['email'])) {
        $username = $_POST['username'];
        $email = $_POST['email'];

        // Verify user in the database
        $sql = "SELECT * FROM users WHERE username='$username' AND email='$email'";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            // Step 2: Display password reset form
            echo '
                <form method="POST" action="">
                    <input type="hidden" name="username" value="' . htmlspecialchars($username) . '">
                    <input type="hidden" name="email" value="' . htmlspecialchars($email) . '">
                    <label for="new_password">New Password:</label>
                    <input type="password" name="new_password" required>
                    <label for="confirm_password">Confirm Password:</label>
                    <input type="password" name="confirm_password" required>
                    <button type="submit" name="reset_password">Reset Password</button>
                </form>
            ';
        } else {
            echo "No user found with the provided username and email.";
        }
    }

    // Step 3: Update password
    if (isset($_POST['reset_password'])) {
        $username = $_POST['username'];
        $email = $_POST['email'];
        $newPassword = $_POST['new_password'];
        $confirmPassword = $_POST['confirm_password'];

        if ($newPassword === $confirmPassword) {
            // Hash the new password
            $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);

            // Update the password in the database
            $updateSql = "UPDATE users SET password='$hashedPassword' WHERE username='$username' AND email='$email'";
            if ($conn->query($updateSql) === TRUE) {
                echo "Your password has been updated successfully.";
            } else {
                echo "Error updating password. Please try again.";
            }
        } else {
            echo "Passwords do not match. Please try again.";
        }
    }
}
?>
