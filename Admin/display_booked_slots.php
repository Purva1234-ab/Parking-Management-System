<?php
include 'dbconnect.php';

$sql = "SELECT booking_id, username, vehicle_type, date, status 
        FROM bookings  
        JOIN users  ON bookings.user_id = users.id"; // Adjust table and column names as needed

$result = $conn->query($sql);

echo '<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Booked Slots</title>
    <style>
        /* General Styles */
        body {
            font-family: Arial, sans-serif;
            background: url("Parking.jpg") no-repeat center center fixed; /* Background image */
            background-size: cover;
            padding: 20px;
            color: #333;
        }

        h2 {
            text-align: center;
            color: #007bff; /* Header color */
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0; /* Space around the table */
            background-color: rgba(255, 255, 255, 0.9); /* Slight transparency */
            border-radius: 10px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        th, td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: #007bff; /* Header background color */
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
<body>';

echo "<h2>Booked Slots</h2>";
if ($result->num_rows > 0) {
    echo "<table>
            <tr>
                <th>Booking ID</th>
                <th>Username</th>
                <th>Vehicle Type</th>
                <th>Booking Date</th>
                <th>Status</th>
            </tr>";
    while ($row = $result->fetch_assoc()) {
        echo "<tr>
                <td>" . htmlspecialchars($row['booking_id']) . "</td>
                <td>" . htmlspecialchars($row['username']) . "</td>
                <td>" . htmlspecialchars($row['vehicle_type']) . "</td>
                <td>" . htmlspecialchars($row['date']) . "</td>
                <td>" . htmlspecialchars($row['status']) . "</td>
              </tr>";
    }
    echo "</table>";
} else {
    echo "<div class='no-bookings'>No bookings available.</div>";
}

// Close the database connection
$conn->close();

echo '</body>
</html>';
?>
