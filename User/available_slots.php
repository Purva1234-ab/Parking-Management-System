<?php
include 'dbconnect.php';

// Fetch all parking slots with their availability status
$slots_sql = "SELECT booking_id, is_available FROM parking_slots";
$result = $conn->query($slots_sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Available Parking Slots</title>
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
            padding: 20px;
        }

        h2 {
            text-align: center;
            color: #333;
            margin-bottom: 20px;
        }

        .slots {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
        }

        .slot-box {
            border: 1px solid #ddd;
            border-radius: 8px;
            padding: 20px;
            margin: 10px;
            flex: 1 1 calc(25% - 20px); /* Four boxes per row with margin */
            box-sizing: border-box;
            display: flex;
            justify-content: center;
            align-items: center;
            cursor: pointer;
        }

        .available {
            background-color: #28a745; /* Green */
            color: white;
        }

        .booked {
            background-color: #dc3545; /* Red */
            color: white;
        }

        .pending {
            background-color: #ffc107; /* Yellow */
            color: black;
        }

        .no-slots {
            text-align: center;
            font-size: 1.2rem;
            color: #999;
        }

        @media (max-width: 768px) {
            .slot-box {
                flex: 1 1 calc(50% - 20px); /* Two boxes per row on smaller screens */
            }
        }

        @media (max-width: 480px) {
            .slot-box {
                flex: 1 1 calc(100% - 20px); /* One box per row on extra small screens */
            }
        }
    </style>
</head>
<body>

<div class="container">
    <h2>Parking Slots</h2>
    <div class="slots">
        <?php
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                // Determine the slot status based only on availability
                $statusClass = $row['is_available'] == 1 ? 'available' : 'booked';

                // Display each slot with the appropriate class
                echo "<div class='slot-box $statusClass'>
                        <p>Slot Number (Booking ID): {$row['booking_id']}</p>
                      </div>";
            }
        } else {
            echo "<div class='no-slots'>No slots found!</div>";
        }

        $conn->close();
        ?>
    </div>
</div>

</body>
</html>
