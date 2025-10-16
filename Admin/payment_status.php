<?php
include 'dbconnect.php';

// Fetch booking details and usernames
$sql = "SELECT date, booking_id, payment_method 
        FROM bookings  
        LEFT JOIN users u ON user_id =booking_id"; // Assuming user_id in bookings matches id in users

$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Status</title>
    <style>
        /* General Styles */
        body {
            font-family: Arial, sans-serif;
            background: url('Parking.jpg'); /* Background image */
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

<h2>Payment Status</h2>

<?php
if ($result->num_rows > 0) {
    echo "<table>
            <tr>
                <th>Username</th>
                <th>Booking Date</th>
                <th>Payment Status</th>
            </tr>";
    while ($row = $result->fetch_assoc()) {
        // Use null coalescing operator for cleaner code
        $username = htmlspecialchars($row['username'] ?? 'N/A');
        $booking_date = htmlspecialchars($row['booking_date'] ?? 'N/A');
        $payment_status = isset($row['payment_method']) ? 
                          ($row['payment_method'] == 'online' ? 'Online Payment' : 'Cash') : 
                          'N/A';

        echo "<tr>
                <td>{$username}</td>
                <td>{$booking_date}</td>
                <td>{$payment_status}</td>
              </tr>";
    }
    echo "</table>";
} else {
    echo "<div class='no-bookings'>No bookings available.</div>";
}

$conn->close();
?>

</body>
</html>
