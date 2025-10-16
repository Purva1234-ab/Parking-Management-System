<?php
session_start();
include 'dbconnect.php'; // Ensure the database connection is set up correctly

// Check if the user is logged in and if the booking ID is provided
if (!isset($_SESSION['user_id']) || !isset($_GET['id'])) {
    echo "Unauthorized access!";
    exit();
}

// Get booking ID from the URL
$booking_id = intval($_GET['id']);

// Ensure the booking ID is a valid number
if ($booking_id <= 0) {
    echo "Invalid booking ID!";
    exit();
}

// Update the booking status to 'Approved'
$sql = "UPDATE bookings SET status = 'Approved' WHERE booking_id = ?";
$stmt = $conn->prepare($sql);

if ($stmt === false) {
    echo "Error preparing statement: " . $conn->error;
    exit();
}

$stmt->bind_param("i", $booking_id);

if ($stmt->execute()) {
    // Set a success message to display after redirect
    $_SESSION['message'] = "Booking approved successfully.";
    header("Location: booking_requests.php"); // Redirect back to booking requests
    exit(); // Always exit after a redirect
} else {
    echo "Error approving booking: " . $stmt->error;
}

// Close the statement and the connection
$stmt->close();
$conn->close();
?>
