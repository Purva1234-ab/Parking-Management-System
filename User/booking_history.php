<?php
include 'dbconnect.php';
session_start();

$user_id = $_SESSION['user_id'];

// Check if user is logged in
if (!isset($user_id)) {
    echo "Please log in to view your booking history.";
    exit();
}

$sql = "SELECT b.date, b.time, b.vehicle_type, b.payment_method, ps.booking_id 
        FROM bookings b 
        JOIN parking_slots ps ON b.booking_id = ps.booking_id 
        WHERE b.user_id = '$user_id'";

$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Booking History</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f6f9;
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
            margin: 0;
            padding: 20px;
        }

        .container {
            max-width: 900px;
            width: 100%;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            padding: 40px;
        }

        .booking-box {
            border: 1px solid #ddd;
            border-radius: 8px;
            padding: 20px;
            margin-bottom: 15px;
            background-color: #f9f9f9;
        }

        .booking-box h4 {
            margin: 0 0 10px;
            font-size: 1.2rem;
            color: #333;
        }

        .booking-details {
            font-size: 0.9rem;
            color: #555;
        }

        .no-bookings {
            text-align: center;
            font-size: 1.2rem;
            color: #999;
        }
    </style>
</head>
<body>

<div class="container">
    <h2>Booking History</h2>
    <?php
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo "<div class='booking-box'>
                    <h4>Booking ID: {$row['booking_id']}</h4>
                    <div class='booking-details'>
                        <p><strong>Date:</strong> {$row['date']}</p>
                        <p><strong>Time:</strong> {$row['time']}</p>
                        <p><strong>Vehicle Type:</strong> {$row['vehicle_type']}</p>
                        <p><strong>Payment Method:</strong> {$row['payment_method']}</p>
                    </div>
                  </div>";
        }
    } else {
        echo "<div class='no-bookings'>No booking history found</div>";
    }

    $conn->close();
    ?>
</div>

</body>
</html>
