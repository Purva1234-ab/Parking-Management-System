<?php
session_start();
include 'dbconnect.php'; // Ensure dbconnect.php is configured properly

// Fetch available parking slots
$slots_sql = "SELECT booking_id FROM parking_slots WHERE is_available = 1"; 
$result = $conn->query($slots_sql);

if (!$result) {
    die("Query failed: " . $conn->error); // Debugging connection issues
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book Parking Slot</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: 'Arial', sans-serif;
            background-color: #f5f7fa;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }

        .container {
            background-color: #fff;
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            max-width: 500px;
            width: 100%;
        }

        h2 {
            color: #333;
            text-align: center;
            margin-bottom: 20px;
        }

        label {
            margin-bottom: 5px;
            display: block;
            font-weight: bold;
        }

        select, input[type="date"], input[type="time"], input[type="text"], button {
            width: 100%;
            padding: 10px;
            margin-bottom: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 1rem;
        }

        button {
            background-color: #4CAF50;
            color: white;
            border: none;
            cursor: pointer;
        }

        button:hover {
            background-color: #45a049;
        }

        p {
            text-align: center;
            color: #999;
        }

        .slot {
            margin: 5px;
            padding: 15px;
            background-color: #e74c3c; /* Red for available slots */
            color: white;
            font-weight: bold;
            border-radius: 5px;
            text-align: center;
            cursor: pointer;
        }

        .slot:hover {
            background-color: #c0392b;
        }

    </style>
</head>
<body>
    <div class="container">
        <h2>Book a Parking Slot</h2>
        <form method="POST" action="process_booking.php">
            <label for="slot_id">Select Slot:</label>
            <select name="slot_id" id="slot_id" required>
                <option value="">Select a slot</option>
                <?php if ($result->num_rows > 0): ?>
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <option value="<?= $row['booking_id']; ?>">Slot ID: <?= $row['booking_id']; ?></option>
                    <?php endwhile; ?>
                <?php else: ?>
                    <option value="">No available slots</option>
                <?php endif; ?>
            </select>

            <label for="date">Date:</label>
            <input type="date" name="date" id="date" required>

            <label for="time">Time:</label>
            <input type="time" name="time" id="time" required>

            <label for="vehicle_type">Vehicle Type:</label>
            <input type="text" name="vehicle_type" id="vehicle_type" required>

            <label for="payment_method">Payment Method:</label>
            <select name="payment_method" id="payment_method" required>
                <option value="">Select a payment method</option>
                <option value="Online">Online</option>
                <option value="Cash">Cash</option>
            </select>

            <button type="submit">Book Slot</button>
        </form>

        <div class="slot-status">
            <?php 
            // Display available slots
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<div class='slot'>Slot ID: {$row['booking_id']}</div>";
                }
            } else {
                echo "<p>No available slots!</p>";
            }
            ?>
        </div>

        <?php if ($result->num_rows == 0): ?>
            <p>No available slots!</p>
        <?php endif; ?>
    </div>
</body>
</html>

<?php
$conn->close();
?>
