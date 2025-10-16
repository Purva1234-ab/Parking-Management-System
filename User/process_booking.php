<?php
session_start();
include 'dbconnect.php';

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    echo "You must be logged in to book a parking slot.";
    exit();
}

// Get the user ID from the session
$user_id = $_SESSION['user_id'];

// Check if the required POST parameters are set
if (isset($_POST['slot_id'], $_POST['date'], $_POST['time'], $_POST['vehicle_type'], $_POST['payment_method'])) {
    $slot_id = $_POST['slot_id'];
    $date = $_POST['date'];
    $time = $_POST['time'];
    $vehicle_type = $_POST['vehicle_type'];
    $payment_method = $_POST['payment_method'];

    // Check if the slot exists and is available
    $check_slot_sql = "SELECT booking_id FROM parking_slots WHERE booking_id = ? AND is_available = 1";
    $check_stmt = $conn->prepare($check_slot_sql);
    
    if ($check_stmt) {
        $check_stmt->bind_param("i", $slot_id);
        $check_stmt->execute();
        $check_result = $check_stmt->get_result();

        if ($check_result->num_rows > 0) {
            // Slot exists and is available, proceed with booking
            $booking_sql = "INSERT INTO bookings (booking_id, user_id, vehicle_type, date, time, payment_method, status) 
                            VALUES (?, ?, ?, ?, ?, ?, 'Pending')";
            $stmt = $conn->prepare($booking_sql);

            if ($stmt) {
                // Bind parameters (booking_id, user_id, vehicle_type, date, time, payment_method)
                $stmt->bind_param("iissss", $slot_id, $user_id, $vehicle_type, $date, $time, $payment_method);

                // Execute the statement
                if ($stmt->execute()) {
                    // After a successful booking, mark the slot as no longer available
                    $update_slot_sql = "UPDATE parking_slots SET is_available = 0 WHERE booking_id = ?";
                    $update_stmt = $conn->prepare($update_slot_sql);
                    $update_stmt->bind_param("i", $slot_id);
                    $update_stmt->execute();
                    $update_stmt->close();

                    echo "Booking successful!";
                    // Optionally, you can redirect to another page after successful booking
                    // header("Location: booking_status.php");
                } else {
                    echo "Error: " . $stmt->error;
                }

                $stmt->close();
            } else {
                echo "Error preparing statement: " . $conn->error;
            }
        } else {
            echo "The selected parking slot is not available or does not exist.";
        }

        $check_stmt->close();
    } else {
        echo "Error preparing check slot statement: " . $conn->error;
    }
} else {
    echo "Invalid booking details.";
}

$conn->close();
?>
