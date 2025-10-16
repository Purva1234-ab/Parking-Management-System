<?php
session_start();
include 'dbconnect.php';

// Check if the user is logged in and if the booking ID is provided
if (!isset($_SESSION['user_id']) || !isset($_GET['id'])) {
    echo "Unauthorized access!";
    exit();
}

// Get booking ID from the URL
$booking_id = intval($_GET['id']);

// Update the booking status to 'Rejected'
$sql = "UPDATE bookings SET status = 'Rejected' WHERE booking_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $booking_id);

if ($stmt->execute()) {
    header("Location: booking_requests.php?message=Booking rejected successfully.");
    exit(); // Always exit after a redirect
} else {
    echo "Error rejecting booking: " . $conn->error;
}

$stmt->close();
$conn->close();
?>
