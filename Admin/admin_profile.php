<?php
session_start();
include 'dbconnect.php';

if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: admin_login.php");
    exit();
}

// Fetch admin details
$sql = "SELECT * FROM admins WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $_SESSION['admin_id']);
$stmt->execute();
$result = $stmt->get_result();
$admin = $result->fetch_assoc();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $new_username = $_POST['username'];
    $new_password = $_POST['password']; // Hash password before saving

    $update_sql = "UPDATE admins SET username = ?, password = ? WHERE id = ?";
    $update_stmt = $conn->prepare($update_sql);
    $hashed_password = password_hash($new_password, PASSWORD_DEFAULT); // Hashing for security
    $update_stmt->bind_param("ssi", $new_username, $hashed_password, $admin['id']);
    $update_stmt->execute();
    header("Location: admin_profile.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Profile</title>
    <style>
        /* General Styles */
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: Arial, sans-serif;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            background: url('Parking.jpg') no-repeat center center fixed; /* Use your background image */
            background-size: cover;
        }

        .profile-container {
            background-color: rgba(255, 255, 255, 0.9);
            border-radius: 10px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.2);
            padding: 40px;
            width: 100%;
            max-width: 400px; /* Fixed width for better alignment */
        }

        h2 {
            text-align: center;
            margin-bottom: 20px;
            color: #007bff; /* Title color */
        }

        label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
            color: #333; /* Label color */
        }

        input[type="text"],
        input[type="password"] {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ddd;
            border-radius: 5px;
        }

        button[type="submit"] {
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 5px;
            padding: 10px;
            cursor: pointer;
            width: 100%;
            font-size: 16px;
        }

        button[type="submit"]:hover {
            background-color: #0056b3; /* Darker shade on hover */
        }
    </style>
</head>
<body>
    <div class="profile-container">
        <h2>Admin Profile</h2>
        <form action="" method="POST">
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" value="<?php echo $admin['username']; ?>" required>
            <label for="password">New Password:</label>
            <input type="password" id="password" name="password" required>
            <button type="submit">Update Profile</button>
        </form>
    </div>
</body>
</html>
