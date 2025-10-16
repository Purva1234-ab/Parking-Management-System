<?php
include 'dbconnect.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Generate Report</title>
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

        form {
            display: flex;
            flex-direction: column;
            align-items: center;
            margin-bottom: 30px;
        }

        label {
            margin: 10px 0 5px;
            font-weight: bold;
        }

        input[type="date"] {
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 5px;
            width: 200px; /* Set a fixed width for date inputs */
        }

        button {
            margin-top: 15px;
            padding: 10px 20px;
            background-color: #007bff; /* Button background color */
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        button:hover {
            background-color: #0056b3; /* Button hover effect */
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

<h2>Generate Report</h2>
<form action="generate_report.php" method="POST">
    <label for="start_date">Start Date:</label>
    <input type="date" id="start_date" name="start_date" required>
    
    <label for="end_date">End Date:</label>
    <input type="date" id="end_date" name="end_date" required>

    <button type="submit">Generate Report</button>
</form>

<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $start_date = $_POST['start_date'];
    $end_date = $_POST['end_date'];

    // SQL query to fetch bookings within the selected date range
    $sql = "SELECT b.booking_id, u.username, b.vehicle_type, b.booking_date, b.status 
            FROM bookings b 
            JOIN users u ON b.user_id = u.user_id 
            WHERE b.booking_date BETWEEN '$start_date' AND '$end_date'";

    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        echo "<h3 style='text-align:center;'>Report from $start_date to $end_date</h3>";
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
                    <td>" . $row['booking_id'] . "</td>
                    <td>" . $row['username'] . "</td>
                    <td>" . $row['vehicle_type'] . "</td>
                    <td>" . $row['booking_date'] . "</td>
                    <td>" . ($row['status'] == 'approved' ? 'Approved' : 'Pending') . "</td>
                  </tr>";
        }
        echo "</table>";
    } else {
        echo "<div class='no-bookings'>No bookings found for the selected date range.</div>";
    }
}

// Close the database connection
$conn->close();
?>

</body>
</html>
