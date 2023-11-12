<?php
session_start();

// Include the database connection file
include 'connection.php';

// Check if the user is logged in as an admin
if (!isset($_SESSION['admin_id'])) {
    header("Location: adminlogin.php"); // Redirect to the admin login page if not logged in
    exit();
}

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $status = $_POST["status"];
    $complaint_id = $_POST["complaint_id"];

    // Update status in the Complaints table
    $updateQuery = "UPDATE Complaints SET complaint_status = ? WHERE complaint_id = ?";
    $updateStmt = $conn->prepare($updateQuery);

    // Check if the prepared statement is created successfully
    if (!$updateStmt) {
        die("Error preparing update query: " . $conn->error);
    }

    // Bind parameters and execute the update statement
    $updateStmt->bind_param("si", $status, $complaint_id);

    if ($updateStmt->execute()) {
        // Redirect to the user details page
        header("Location: viewuserdetails.php?complaint_id=$complaint_id");
        exit();
    } else {
        // Display an error message if the update fails
        die("Error updating status: " . $updateStmt->error);
    }

    // Close the update statement
    $updateStmt->close();
} else {
    // If the form is not submitted, redirect to the homepage
    header("Location: index.php");
    exit();
}
?>
