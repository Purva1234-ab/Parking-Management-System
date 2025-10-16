<?php
// Include the database connection
include('dbconnect.php');

// Define variables and initialize them to empty values
$name = $username = $email = $dob = $mobile = $password = $license = "";
$name_err = $username_err = $email_err = $mobile_err = $password_err = $license_err = "";

// Processing form when submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Validate name
    if (empty(trim($_POST["name"]))) {
        $name_err = "Please enter your name.";
    } else {
        $name = trim($_POST["name"]);
    }

    // Validate username
    if (empty(trim($_POST["username"]))) {
        $username_err = "Please enter a username.";
    } else {
        $username = trim($_POST["username"]);
    }

    // Validate email
    if (empty(trim($_POST["email"]))) {
        $email_err = "Please enter your email.";
    } else {
        $email = trim($_POST["email"]);
    }

    // Validate mobile number
    if (empty(trim($_POST["mobile"]))) {
        $mobile_err = "Please enter your mobile number.";
    } else {
        $mobile = trim($_POST["mobile"]);
    }

    // Validate password
    if (empty(trim($_POST["password"]))) {
        $password_err = "Please enter a password.";
    } else {
        $password = trim($_POST["password"]);
    }

    // Validate license number
    if (empty(trim($_POST["license"]))) {
        $license_err = "Please enter your license number.";
    } else {
        $license = trim($_POST["license"]);
    }

    // Validate date of birth
    if (empty(trim($_POST["dob"]))) {
        $dob_err = "Please enter your date of birth.";
    } else {
        $dob = trim($_POST["dob"]);
    }

    // If no errors, proceed to insert the data into the database
    if (empty($name_err) && empty($username_err) && empty($email_err) && empty($mobile_err) && empty($password_err) && empty($license_err) && empty($dob_err)) {

        // Prepare an insert statement
        $query = "INSERT INTO users (name, username, email, date_of_birth, mobile_number, password, id_proof_number) VALUES (?, ?, ?, ?, ?, ?, ?)";

        if ($stmt = $conn->prepare($query)) {
            // Bind variables to the prepared statement
            $stmt->bind_param("sssssss", $name, $username, $email, $dob, $mobile, $password, $license);

            // Execute the statement
            if ($stmt->execute()) {
                // Redirect to the login page after successful registration
                header("Location: login.html");
                exit; // Make sure to call exit to stop further script execution
            } else {
                echo "Something went wrong. Please try again later.";
            }
            // Close the prepared statement
            $stmt->close();
        }
    }

    // Close the connection
    $conn->close();
}
?>
