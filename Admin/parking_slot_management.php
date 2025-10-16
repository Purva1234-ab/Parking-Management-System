<?php
include 'dbconnect.php';

// Fetch all parking slots and user details
$sql = "SELECT booking_id, is_available, vehicle_type, date, time, id, name, email, created_at
        FROM parking_slots ps 
        LEFT JOIN users  ON id = id"; 

$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Parking Slot Management</title>
    <style>
        /* General Styles */
        body {
            font-family: Arial, sans-serif;
            background: url('Parking.jpg') no-repeat center center fixed; /* Background image */
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

        .no-slots {
            text-align: center;
            font-size: 18px;
            margin-top: 20px;
        }
    </style>
</head>
<body>

<h2>Parking Slot Management</h2>

<?php
if ($result->num_rows > 0) {
    echo "<table>
            <tr>
                <th>Booking ID</th>
                <th>Availability</th>
                <th>Vehicle Type</th>
                <th>Date</th>
                <th>Time</th>
                <th>User ID</th>
                <th>User Name</th>
                <th>User Email</th>
            </tr>";
    while ($row = $result->fetch_assoc()) {
        // Use null coalescing operator for cleaner code
        $booking_id = htmlspecialchars($row['booking_id'] ?? 'N/A');
        $is_available = htmlspecialchars($row['is_available'] ? 'Available' : 'Not Available');
        $vehicle_type = htmlspecialchars($row['vehicle_type'] ?? 'N/A');
        $date = htmlspecialchars($row['date'] ?? 'N/A');
        $time = htmlspecialchars($row['time'] ?? 'N/A');
        $user_id = htmlspecialchars($row['user_id'] ?? 'N/A');
        $user_name = htmlspecialchars($row['name'] ?? 'N/A');
        $user_email = htmlspecialchars($row['email'] ?? 'N/A');

        echo "<tr>
                <td>{$booking_id}</td>
                <td>{$is_available}</td>
                <td>{$vehicle_type}</td>
                <td>{$date}</td>
                <td>{$time}</td>
                <td>{$user_id}</td>
                <td>{$user_name}</td>
                <td>{$user_email}</td>
              </tr>";
    }
    echo "</table>";
} else {
    echo "<div class='no-slots'>No slots available.</div>";
}

$conn->close();
?>

</body>
</html>
