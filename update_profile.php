<?php
session_start();

include 'connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = $_POST['user_id'];
    $first_name = $_POST['first_name'];
    $middle_name = $_POST['middle_name'];
    $last_name = $_POST['last_name'];
    $email_address = $_POST['email_address'];
    $mobile_number = $_POST['mobile_number'];
    $date_of_birth = $_POST['date_of_birth'];

    // Validate and sanitize user input as needed

    // Update user details in the database
    $updateUserQuery = "UPDATE Users
        JOIN Name ON Users.name_id = Name.name_id
        JOIN Email ON Users.email_id = Email.email_id
        JOIN Mobile ON Users.mobile_id = Mobile.mobile_id
        JOIN UserDetails ON Users.user_id = UserDetails.user_id
        SET Name.first_name = '$first_name',
            Name.middle_name = '$middle_name',
            Name.last_name = '$last_name',
            Email.email_address = '$email_address',
            Mobile.mobile_number = '$mobile_number',
            UserDetails.date_of_birth = '$date_of_birth'
        WHERE Users.user_id = $user_id";

    if (mysqli_query($conn, $updateUserQuery)) {
        // Update successful, redirect to the user profile page with a success message
        $_SESSION['profile_update_success'] = true;
        header('Location: profile.php');
        exit;
    } else {
        // Error occurred during the update, redirect to the user profile page with an error message
        $_SESSION['profile_update_error'] = true;
        header('Location: profile.php');
        exit;
    }
}
?>
