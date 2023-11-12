<?php
  // Start a session
  session_start();

  // Include the database connection file
  include 'connection.php';

  // Check if the user is logged in
  if (isset($_SESSION['logged_in'])) {
      $user_id = $_SESSION['user_id'];

      // Fetch user data from the database
      $sql = "SELECT Users.username, Name.first_name, Name.middle_name, Name.last_name, Email.email_address, Mobile.mobile_number, UserDetails.date_of_birth, UserDetails.last_login
          FROM Users
          JOIN Name ON Users.name_id = Name.name_id
          JOIN Email ON Users.email_id = Email.email_id
          JOIN Mobile ON Users.mobile_id = Mobile.mobile_id
          JOIN UserDetails ON Users.user_id = UserDetails.user_id
          WHERE Users.user_id = $user_id";

      $result = mysqli_query($conn, $sql);

      if ($result) {
          if (mysqli_num_rows($result) == 1) {
              $userData = mysqli_fetch_assoc($result);

              // Calculate age based on date of birth
              $dateOfBirth = $userData['date_of_birth'];
              $age = date_diff(date_create($dateOfBirth), date_create('today'))->y;
          } else {
              echo "No user data found for this user_id.";
          }
      } else {
          echo "Query error: " . mysqli_error($conn);
      }
  } else {
      // Redirect to the login page if the user is not logged in
      header('Location: loginpage.php');
      exit;
  }

  // Close the database connection
  mysqli_close($conn);
?>     
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>User Profile - Movie Ticket Booking</title>
    <style>
      body {
        font-family: Arial, sans-serif;
        background-color: black;
        text-align: center;
        display: flex;
        align-items: center;
        justify-content: center;
        height: 70vh;
        margin: 0;
        color: white;
      }

      .profile-container {
        background-color: #1b1a1a;
        max-width: 5in;
        width: 90%;
        padding: 20px;
        border-radius: 15px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
        text-align: left;
        font-size: 18px;
      }

      .profile-container h2 {
        font-size: 24px;
        margin: 0 auto;
        margin-bottom: 20px;
        text-align: center;
      }

      .profile-container p {
        color: white;
      }

      .admin p {
        color: white;
      }

      .edit-button {
        background-color: #4caf50;
        color: white;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        padding: 5px 10px;
      }

      .edit-button:hover {
        background-color: #233c24;
      }
    </style>
  </head>
  <body>
    <div class="start">
      <div class="profile-container">
        <h2>User Profile</h2>
        <p>
          <strong>Username:</strong>
          <?php echo $userData['username']; ?>
        </p>
        <p>
          <strong>Name:</strong>
          <?php echo $userData['first_name'] . ' ' . $userData['middle_name'] . ' ' . $userData['last_name']; ?>
        </p>
        <p>
          <strong>Email:</strong>
          <?php echo $userData['email_address']; ?>
        </p>
        <p>
          <strong>Mobile:</strong>
          <?php echo $userData['mobile_number']; ?>
        </p>
        <p>
          <strong>Date of Birth:</strong>
          <?php echo $userData['date_of_birth']; ?>
        </p>
        <p>
          <strong>Age:</strong>
          <?php echo $age; ?>
        </p>
        <p>
          <strong>Last Login:</strong>
          <?php echo $userData['last_login']; ?>
        </p>
        <a href="edit_profile.php" class="edit-button">Edit Profile</a>
      </div>
    </div>
  </body>
</html>

