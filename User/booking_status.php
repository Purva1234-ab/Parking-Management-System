<?php
session_start(); // Start the session
include 'dbconnect.php'; // Include your database connection file

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    echo "You must be logged in to view your booking status.";
    exit();
}

// Get the user ID from the session
$user_id = $_SESSION['user_id'];

// Fetch the booking statuses for the logged-in user
$sql = "SELECT booking_id, vehicle_type, date, time, payment_method, status 
        FROM bookings 
        WHERE user_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

// HTML and CSS for displaying booking status
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Booking Status</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f5f7fa;
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
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        th {
            background-color: #007bff; /* Header color */
            color: white;
        }
        tr:hover {
            background-color: #f1f1f1; /* Highlight on hover */
        }
        .no-bookings {
            text-align: center;
            font-size: 18px;
            margin-top: 20px;
        }
    </style>
</head>
<body>

<div class="container">
    <h2>Your Booking Status</h2>
    <table>
        <thead>
            <tr>
                <th>Booking ID</th>
                <th>Vehicle Type</th>
                <th>Date</th>
                <th>Time</th>
                <th>Payment Method</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($result->num_rows > 0): ?>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?= htmlspecialchars($row['booking_id']); ?></td>
                        <td><?= htmlspecialchars($row['vehicle_type']); ?></td>
                        <td><?= htmlspecialchars($row['date']); ?></td>
                        <td><?= htmlspecialchars($row['time']); ?></td>
                        <td><?= htmlspecialchars($row['payment_method']); ?></td>
                        <td><?= htmlspecialchars($row['status']); ?></td> <!-- Displaying status -->
                    </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr>
                    <td colspan="6" class="no-bookings">No bookings found.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

</body>
</html>

<?php
$stmt->close(); // Close the statement
$conn->close(); // Close the database connection
?>
