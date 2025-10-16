<?php
session_start();
include 'dbconnect.php';

// Ensure user is logged in
if (!isset($_SESSION['user_id'])) {
    echo "Please log in to view your profile.";
    exit();
}

// Get the logged-in user's ID
$user_id = $_SESSION['user_id'];

// Fetch user details from the database
$sql = "SELECT name, username, email, date_of_birth, mobile_number FROM users WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id); // Bind user ID parameter
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

// Handle form submission for updating user details
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Update user details
    $name = $_POST['name'];
    $username = $_POST['username'];
    $email = $_POST['email'];
    $date_of_birth = $_POST['date_of_birth'];
    $mobile_number = $_POST['mobile_number'];

    $update_sql = "UPDATE users SET name=?, username=?, email=?, date_of_birth=?, mobile_number=? WHERE id=?";
    $update_stmt = $conn->prepare($update_sql);
    $update_stmt->bind_param("sssssi", $name, $username, $email, $date_of_birth, $mobile_number, $user_id);
    
    if ($update_stmt->execute()) {
        $success_message = "Profile updated successfully.";
    } else {
        $error_message = "Error updating profile.";
    }
    $update_stmt->close();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Profile</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f6f9;
            margin: 0;
            padding: 20px;
        }

        .container {
            max-width: 800px;
            margin: auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        h2 {
            text-align: center;
            color: #333;
        }

        .profile-details {
            margin-bottom: 20px;
        }

        .profile-details label {
            font-weight: bold;
        }

        .profile-details p {
            margin: 5px 0;
            color: #555;
        }

        .update-button {
            display: block;
            width: 100%;
            padding: 10px;
            background-color: #007bff;
            color: #fff;
            text-align: center;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            text-decoration: none;
        }

        .update-button:hover {
            background-color: #0056b3;
        }

        form {
            margin-top: 20px;
        }

        input[type="text"],
        input[type="email"],
        input[type="date"] {
            width: 100%;
            padding: 10px;
            margin: 5px 0;
            border-radius: 5px;
            border: 1px solid #ddd;
        }

        button[type="submit"] {
            background-color: #28a745;
            color: white;
            border: none;
            border-radius: 5px;
            padding: 10px;
            cursor: pointer;
            width: 100%;
        }

        button[type="submit"]:hover {
            background-color: #218838;
        }

        .success-message,
        .error-message {
            color: #28a745;
            text-align: center;
            margin: 10px 0;
        }

        .error-message {
            color: #dc3545;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>User Profile</h2>
        <div class="profile-details">
            <label>Name:</label>
            <p><?php echo $user['name']; ?></p>

            <label>Username:</label>
            <p><?php echo $user['username']; ?></p>

            <label>Email:</label>
            <p><?php echo $user['email']; ?></p>

            <label>Date of Birth:</label>
            <p><?php echo $user['date_of_birth']; ?></p>

            <label>Mobile Number:</label>
            <p><?php echo $user['mobile_number']; ?></p>
        </div>

        <?php if (isset($success_message)): ?>
            <div class="success-message"><?php echo $success_message; ?></div>
        <?php elseif (isset($error_message)): ?>
            <div class="error-message"><?php echo $error_message; ?></div>
        <?php endif; ?>

        <h2>Update Profile</h2>
        <form method="post" action="">
            <label>Name:</label>
            <input type="text" name="name" value="<?php echo $user['name']; ?>" required>

            <label>Username:</label>
            <input type="text" name="username" value="<?php echo $user['username']; ?>" required>

            <label>Email:</label>
            <input type="email" name="email" value="<?php echo $user['email']; ?>" required>

            <label>Date of Birth:</label>
            <input type="date" name="date_of_birth" value="<?php echo $user['date_of_birth']; ?>" required>

            <label>Mobile Number:</label>
            <input type="text" name="mobile_number" value="<?php echo $user['mobile_number']; ?>" required>

            <button type="submit">Update</button>
        </form>
    </div>
</body>
</html>
