<?php
include 'dbconnect.php';

// Fetch all booking details along with the approval status
$sql = "SELECT booking_id, username, vehicle_type, date, status 
        FROM bookings 
        JOIN users  ON user_id = user_id"; // Ensure the correct table and column names

$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>All Booking Details</title>
    <style>
        /* General Styles */
        body {
            font-family: Arial, sans-serif;
            background: url('Parking.jpg') no-repeat center center fixed; /* Use your background image */
            background-size: cover;
            padding: 20px;
            color: #333;
        }

        h2 {
            text-align: center;
            margin-bottom: 20px;
            color: #007bff; /* Header color */
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin: 0 auto; /* Center the table */
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
<body>

<h2>All Booking Details</h2>

<?php
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
        // Display each booking's details
        echo "<tr>
                <td>" . $row['booking_id'] . "</td>
                <td>" . $row['username'] . "</td>
                <td>" . $row['vehicle_type'] . "</td>
                <td>" . $row['date'] . "</td>
                <td>" . ($row['status'] == 'approved' ? 'Approved' : 'Pending') . "</td>
              </tr>";
    }
    echo "</table>";
} else {
    echo "<div class='no-bookings'>No bookings found.</div>";
}

// Close the database connection
$conn->close();
?>

</body>
</html>
