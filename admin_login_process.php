<?php
session_start();
$error = false;

// Establish a database connection (you need to replace these with your actual database credentials)
include 'connection.php';

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Fetch admin details from the database
    $sql = "SELECT admin_id FROM Admins WHERE username = '$username' AND password = '$password'";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) == 1) {
        // Admin credentials are correct
        $_SESSION['logged_in'] = true;

        // Retrieve the user's ID from the query result
        $row = mysqli_fetch_assoc($result);
        $admin_id_from_database = $row['admin_id'];

        // Debugging output
        echo "Admin ID (Before Setting): " . $_SESSION['admin_id'] . "<br>";
        echo "Admin ID (From Database): " . $admin_id_from_database . "<br>";

        $_SESSION['admin_id'] = $admin_id_from_database; // Set the admin's session ID

        // Debugging output
        echo "Admin ID (After Setting): " . $_SESSION['admin_id'] . "<br>";

        // Redirect to movielist.php
        header("Location: admincomplaint.php");
        exit;
    } else {
        // Admin credentials are incorrect
        $error = true;
        header("Location: adminlogin.php?error=1");
        exit;
    }
}

mysqli_close($conn);
?>
