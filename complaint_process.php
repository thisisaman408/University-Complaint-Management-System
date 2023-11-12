<?php
session_start();

// Include the database connection file
include 'connection.php';

// Check if the form was submitted using the POST method
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Retrieve form data
    $complaintText = $_POST["complaint"];

    // Process file upload
    $targetDirectory = "uploads/";
    $targetFile = $targetDirectory . basename($_FILES["photo"]["name"]);

    // Validate file type and size
    $allowedFileTypes = ["jpg", "jpeg", "png", "gif"];
    $maxFileSize = 5 * 1024 * 1024; // 5MB

    $fileExtension = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

    if (!in_array($fileExtension, $allowedFileTypes)) {
        die("Error: Invalid file type. Only JPG, JPEG, PNG, and GIF files are allowed.");
    }

    if ($_FILES["photo"]["size"] > $maxFileSize) {
        die("Error: File size exceeds 5MB.");
    }

    move_uploaded_file($_FILES["photo"]["tmp_name"], $targetFile);

    // Assuming you have a user ID stored in a session variable
    $userId = $_SESSION["user_id"];

    // Insert into Complaints table
    $query = "INSERT INTO Complaints (user_id, complaint_text, photo_path) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($query);

    // Check if the prepare statement was successful
    if ($stmt) {
        $stmt->bind_param("iss", $userId, $complaintText, $targetFile);
        $stmt->execute();
        $stmt->close();

        // Display success message and redirect
        echo '<p style="color: green;">Complaint registered successfully!</p>';
        header("refresh:2;url=complaint.php"); // Redirect to the homepage after 2 seconds
        exit();
    } else {
        // Handle the case when prepare fails
        echo "Error in prepare statement: " . $conn->error;
    }
}
?>
