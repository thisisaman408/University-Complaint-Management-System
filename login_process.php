<?php
// Start a session
session_start();
$error = false;

// Include the database connection file
include 'connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // SQL query to check if the username and password match in your Users table
    $sql = "SELECT user_id FROM Users WHERE username = '$username' AND password = '$password'";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) == 1) {
        // Username and password are correct, set a session variable to indicate the user is logged in
        $_SESSION['logged_in'] = true;

        // Retrieve the user's ID from the query result
        $row = mysqli_fetch_assoc($result);
        $user_id = $row['user_id'];

        // Set the user_id in the session
        $_SESSION['user_id'] = $user_id;

        // Redirect to movielist.php
        header('Location: complaint.php');
        exit;
    } else {
        // Username or password is incorrect, set an error parameter in the URL
        $error = true;
        header('Location: login.php?error=1');
        exit;
    }
}

// Close the database connection
mysqli_close($conn);
?>
