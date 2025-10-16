<?php
session_start();
include 'dbconnect.php'; // Ensure the database connection is set up correctly

// Fetch booking requests
$sql = "SELECT * FROM bookings"; // Adjust your query as necessary
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Booking Requests</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f5f7fa;
            margin: 0;
            padding: 20px;
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
        .alert {
            background-color: #d4edda; /* Success alert color */
            color: #155724;
            padding: 10px;
            margin-bottom: 20px;
            border: 1px solid #c3e6cb;
            border-radius: 5px;
        }
    </style>
</head>
<body>

<h2>Booking Requests</h2>

<?php
// Check and display the message
if (isset($_SESSION['message'])) {
    echo "<div class='alert'>" . htmlspecialchars($_SESSION['message']) . "</div>";
    unset($_SESSION['message']); // Clear the message after displaying it
}

// Check if there are any booking requests
if ($result->num_rows > 0) {
    echo "<table>
            <tr>
                <th>Booking ID</th>
                <th>Vehicle Type</th>
                <th>Status</th>
                <th>Action</th>
            </tr>";
    while ($row = $result->fetch_assoc()) {
        echo "<tr>
                <td>" . htmlspecialchars($row['booking_id']) . "</td>
                <td>" . htmlspecialchars($row['vehicle_type']) . "</td>
                <td>" . htmlspecialchars($row['status']) . "</td>
                <td><a href='approve_booking.php?id=" . $row['booking_id'] . "'>Approve</a></td>
              </tr>";
    }
    echo "</table>";
} else {
    echo "<p>No booking requests found.</p>";
}

$conn->close();
?>

</body>
</html>
