<?php
session_start();

include 'connection.php';

// Check if the user is logged in
if (isset($_SESSION['logged_in'])) {
    $user_id = $_SESSION['user_id'];

    // Fetch user data from the database
    $sql = "SELECT Users.username, Name.first_name, Name.middle_name, Name.last_name, Email.email_address, Mobile.mobile_number, UserDetails.date_of_birth
            FROM Users
            JOIN Name ON Users.name_id = Name.name_id
            JOIN Email ON Users.email_id = Email.email_id
            JOIN Mobile ON Users.mobile_id = Mobile.mobile_id
            JOIN UserDetails ON Users.user_id = UserDetails.user_id
            WHERE Users.user_id = $user_id";

    $result = mysqli_query($conn, $sql);

    if ($result && mysqli_num_rows($result) == 1) {
        $userData = mysqli_fetch_assoc($result);
    }
}

mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <!-- your head content here -->
  </head>
  <body>
    <div class="start">
      <div class="profile-container">
        <!-- your form content here -->
      </div>
    </div>
  </body>
</html>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Edit Profile - Movie Ticket Booking</title>
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

      .edit-profile-container {
        background-color: #1b1a1a;
        max-width: 5in;
        width: 90%;
        padding: 20px;
        border-radius: 15px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
        text-align: left;
        font-size: 18px;
      }

      .edit-profile-container h2 {
        font-size: 24px;
        margin: 0 auto;
        margin-bottom: 20px;
        text-align: center;
      }

      .edit-profile-container p {
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
      <div class="edit-profile-container">
        <h2>Edit Profile</h2>
        <form action="update_profile.php" method="post">
          <input type="hidden" name="user_id" value="<?php echo $user_id; ?>" />
          <p>
            <strong>Username:</strong>
            <?php echo $userData['username']; ?>
          </p>
          <p>
            <strong>Name:</strong>
            <input type="text" name="first_name" value="<?php echo $userData['first_name']; ?>" />
          </p>
          <p>
            <strong>Email:</strong>
            <input type="email" name="email_address" value="<?php echo $userData['email_address']; ?>" />
          </p>
          <p>
            <strong>Mobile:</strong>
            <input type="tel" name="mobile_number" value="<?php echo $userData['mobile_number']; ?>" />
          </p>
          <p>
            <strong>Date of Birth:</strong>
            <input type="date" name="date_of_birth" value="<?php echo $userData['date_of_birth']; ?>" />
          </p>
          <button type="submit" class="edit-button">Save Changes</button>
        </form>
      </div>
    </div>
  </body>
</html>
