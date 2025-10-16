<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <style>
        /* General Styles */
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: Arial, sans-serif;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            background: url('Parking.jpg') no-repeat center center fixed; /* Use your background image */
            background-size: cover;
        }

        .dashboard-background {
            background-color: rgba(255, 255, 255, 0.9); /* Slightly transparent for overlay effect */
            border-radius: 10px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.2);
            width: 100%;
            max-width: 1200px; /* Max width for larger screens */
            padding: 20px;
        }

        header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        h1 {
            font-size: 2rem;
            color: #007bff; /* Color for the title */
        }

        .profile a {
            color: #007bff;
            text-decoration: none;
            font-weight: bold;
        }

        .profile a:hover {
            color: #0056b3;
        }

        .dashboard-content {
            display: flex;
            width: 100%;
        }

        .sidebar {
            background-color: #f8f9fa;
            padding: 20px;
            border-radius: 10px;
            width: 250px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .sidebar ul {
            list-style: none;
            padding: 0;
        }

        .sidebar ul li {
            margin-bottom: 15px;
        }

        .sidebar ul li a {
            color: #333;
            text-decoration: none;
            font-weight: bold;
            padding: 10px;
            display: block;
            border-radius: 5px;
            transition: background-color 0.3s ease, color 0.3s ease;
        }

        .sidebar ul li a:hover {
            background-color: #007bff;
            color: #fff;
        }

        main {
            flex-grow: 1;
            background-color: #ffffff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
            margin-left: 20px; /* Add margin to separate from sidebar */
        }

        h2 {
            color: #333;
            margin-bottom: 10px;
        }

        p {
            color: #555;
        }
    </style>
</head>
<body>
    <div class="dashboard-background">
        <div class="container">
            <header>
                <h1>Admin Dashboard</h1>
                <div class="profile">
                    <a href="admin_profile.php">Admin Profile</a>
                </div>
            </header>
            <div class="dashboard-content">
                <nav class="sidebar">
                    <ul>
                        <li><a href="display_booked_slots.php">Display Booked Slots</a></li>
                        <li><a href="booking_requests.php">Booking Requests</a></li>
                        <li><a href="parking_slot_management.php">Parking Slot Management</a></li>
                        <li><a href="booking_details.php">Booking Details</a></li>
                        <li><a href="report.php">Reports</a></li>
                        <li><a href="payment_status.php">Payment Status</a></li>
                    </ul>
                </nav>
                <main>
                    <h2>Welcome, Admin!</h2>
                    <p>Select an option from the sidebar to proceed.</p>
                </main>
            </div>
        </div>
    </div>
</body>
</html>
