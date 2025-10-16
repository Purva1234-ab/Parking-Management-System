<?php
session_start();

// Redirect to login page if not authenticated
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <style>
        /* Sidebar Styles */
        .sidebar {
            height: 100vh;
            width: 250px;
            background-color: #343a40;
            color: #ffffff;
            position: fixed;
            overflow-y: auto;
        }
        .sidebar h4 {
            font-size: 1.5rem;
            margin-bottom: 20px;
            text-align: center;
        }
        .sidebar a {
            color: #ffffff;
            padding: 10px 15px;
            display: flex;
            align-items: center;
            text-decoration: none;
            transition: background-color 0.3s ease;
        }
        .sidebar a i {
            margin-right: 10px;
        }
        .sidebar a:hover {
            background-color: #495057;
        }
        /* Main Content */
        .w-100 {
            margin-left: 250px;
            padding-top: 15px;
        }
        .top-bar {
            background-color: #f8f9fa;
            padding: 10px 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }
        .top-bar .dropdown-toggle {
            background: none;
            border: none;
            color: #343a40;
            font-size: 1rem;
            font-weight: bold;
        }
        .content {
            padding: 20px;
        }
    </style>
</head>
<body>
    <div class="d-flex">
        <!-- Sidebar -->
        <div class="sidebar p-3">
            <h4>Dashboard</h4>
            <hr>
            <ul class="nav flex-column">
                <li class="nav-item">
                    <a class="nav-link" href="book_slot.php"><i class="fas fa-car"></i> Book Parking Slot</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="booking_history.php"><i class="fas fa-history"></i> Booking History</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="booking_status.php"><i class="fas fa-info-circle"></i> Booking Status</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="available_slots.php"><i class="fas fa-parking"></i> Available Parking Slots</a>
                </li>
            </ul>
        </div>

        <!-- Main Content -->
        <div class="w-100">
            <div class="top-bar">
                <h5>Welcome, <?php echo htmlspecialchars($_SESSION['username']); ?>!</h5>
                <div class="dropdown">
                    <button class="btn dropdown-toggle" type="button" id="profileDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="fas fa-user-circle"></i> Profile
                    </button>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="profileDropdown">
                        <a class="dropdown-item" href="profile.php">View Profile</a>
                        <a class="dropdown-item text-danger" href="logout.php">Logout</a>
                    </div>
                </div>
            </div>

            <div class="content">
                <h4>Dashboard Content</h4>
                <p>Welcome! Use the sidebar to manage your parking slots.</p>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS and dependencies -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
