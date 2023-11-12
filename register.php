<?php
// Start a session
session_start();

// Include the database connection file
include 'connection.php';

// Function to sanitize user input
function sanitizeInput($input) {
    // You can implement your input sanitization logic here
    return $input;
}

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get user input from the form and sanitize it
    $first_name = sanitizeInput($_POST['first_name']);
    $last_name = '';
    $username = sanitizeInput($_POST['username']);
    $password = sanitizeInput($_POST['password']);
    $confirm_password = sanitizeInput($_POST['confirm_password']);
    $mobile = sanitizeInput($_POST['mobile']);
    $email = sanitizeInput($_POST['email']);
    $date_of_birth = sanitizeInput($_POST['date_of_birth']);

    // Check if password and confirm password match
    if ($password !== $confirm_password) {
        $error_message = 'Password and confirm password do not match.';
        // Redirect back to the registration page with an error message
        header("Location: register.php?error=1&message=" . urlencode($error_message));
        exit;
    }

    // Check if the username is unique and doesn't contain spaces
    $checkUserQuery = "SELECT * FROM Users WHERE username = '$username' OR username LIKE '% %'";
    $checkUserResult = mysqli_query($conn, $checkUserQuery);

    if (mysqli_num_rows($checkUserResult) > 0) {
        $error_message = 'Username is not available, kindly login or choose a different username';
        // Redirect back to the registration page with an error message
        header("Location: register.php?error=1&message=" . urlencode($error_message));
        exit;
    }
    // Check if the email is unique
    $checkEmailQuery = "SELECT * FROM Email WHERE email_address = '$email'";
    $checkEmailResult = mysqli_query($conn, $checkEmailQuery);

    if (mysqli_num_rows($checkEmailResult) > 0) {
        $error_message = 'Email is already registered.';
        // Redirect back to the registration page with an error message
        header("Location: register.php?error=1&message=" . urlencode($error_message));
        exit;
    }

    // Check if the mobile number is unique
    $checkMobileQuery = "SELECT * FROM Mobile WHERE mobile_number = '$mobile'";
    $checkMobileResult = mysqli_query($conn, $checkMobileQuery);

    if (mysqli_num_rows($checkMobileResult) > 0) {
        $error_message = 'Mobile number is already registered.';
        // Redirect back to the registration page with an error message
        header("Location: register.php?error=1&message=" . urlencode($error_message));
        exit;
    }
    // Insert the new user's data into the database
    $insertUserQuery = "INSERT INTO Users (username, password) VALUES ('$username', '$password')";

    if (mysqli_query($conn, $insertUserQuery)) {
        // Get the user_id of the newly inserted user
        $user_id = mysqli_insert_id($conn);

        // Insert user details into the Name Table
        $insertNameQuery = "INSERT INTO Name (first_name, last_name) VALUES ('$first_name', NULL)";
        if (mysqli_query($conn, $insertNameQuery)) {
            $name_id = mysqli_insert_id($conn);
            // Update the existing user with the name_id
            $updateUserQuery = "UPDATE Users SET name_id = $name_id WHERE user_id = $user_id";
            mysqli_query($conn, $updateUserQuery);
        }

        // Insert user details into the Email Table
        $insertEmailQuery = "INSERT INTO Email (email_address) VALUES ('$email')";
        if (mysqli_query($conn, $insertEmailQuery)) {
            $email_id = mysqli_insert_id($conn);
            // Update the existing user with the email_id
            $updateUserQuery = "UPDATE Users SET email_id = $email_id WHERE user_id = $user_id";
            mysqli_query($conn, $updateUserQuery);
        }

        // Insert user details into the Mobile Table
        $insertMobileQuery = "INSERT INTO Mobile (mobile_number) VALUES ('$mobile')";
        if (mysqli_query($conn, $insertMobileQuery)) {
            $mobile_id = mysqli_insert_id($conn);
            // Update the existing user with the mobile_id
            $updateUserQuery = "UPDATE Users SET mobile_id = $mobile_id WHERE user_id = $user_id";
            mysqli_query($conn, $updateUserQuery);
        }

        // Insert user details into the UserDetails Table, including date of birth
        $insertUserDetailsQuery = "INSERT INTO UserDetails (user_id, date_of_birth) VALUES ($user_id, '$date_of_birth')";
        mysqli_query($conn, $insertUserDetailsQuery);

        // Registration successful, redirect to login page with a success message
        header('Location: login.php?message=registration_successful');
        exit;
    } else {
        // Error occurred during registration, redirect to login page with an error message
        header('Location: login.php?message=registration_error');
        exit;
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Registration Page</title>
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <style>
        body {
            font-family: Arial, sans-serif;
            background-size: cover;
            background-color: black;
            background-position: center;
            height: 100vh;
            margin: auto 0;
            display: flex;
            justify-content: center;
            align-items: center;
            color: white;
        }

        .container {
            width: 100%;
            max-width: 400px;
            padding: 20px;
            background-color: #1b1a1a;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        h2 {
            text-align: left;
            font-size: 24px;
            margin-bottom: 20px;
        }

        .form-group {
            margin-bottom: 15px;
            width: 100%;
        }

        label {
            font-weight: bold;
            font-size: 14px;
        }

        input[type="text"],
        input[type="password"],
        input[type="email"],
        input[type="tel"],
        input[type="date"],
        input[type="file"] {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 10px;
        }

        .register-button {
            width: 100%;
            padding: 12px;
            background-color: #4caf50;
            color: #fff;
            border: none;
            border-radius: 10px;
            cursor: pointer;
            margin-top: 10px;
        }

        .register-button:hover {
            background-color: #233c24;
        }

        .login-link {
            text-align: center;
        }

        .login-link a {
            text-decoration: none;
            color: #3693f6;
        }

        .login-link a:hover {
            color: #0056b3;
        }

        /* Error Message Styling */
        .error-message {
            color: red;
            font-size: 14px;
            margin-top: 5px;
        }

        /* Success Message Styling */
        .success-message {
            color: green;
            font-size: 14px;
            margin-top: 5px;
        }
        @media (max-width: 600px) {
            .container {
                width: 100%;
                padding: 10px;
            }

            .form-group {
                width: 100%;
            }

            input[type="file"] {
                width: 100%;
            }
        }

    </style>
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        function checkPasswordMatch() {
            var password = document.getElementById("password").value;
            var confirm_password = document.getElementById("confirm_password").value;
            var passwordError = document.getElementById("passwordError");

            if (password !== confirm_password) {
                passwordError.style.color = "red";
                passwordError.innerText = "Password and confirm password do not match.";
            } else {
                passwordError.style.color = "green";
                passwordError.innerText = "Passwords match!";
            }
        }

        function togglePasswordVisibility() {
            var passwordInput = document.getElementById("password");
            var passwordToggle = document.getElementById("passwordToggle");

            if (passwordInput.type === "password") {
                passwordInput.type = "text";
                passwordToggle.innerText = "👁️";
            } else {
                passwordInput.type = "password";
                passwordToggle.innerText = "🔒";
            }
        }
        function checkUsername() {
            var username = document.getElementById("username").value;
            var usernameError = document.getElementById("usernameError");
            var regex = /^[a-zA-Z0-9]+$/; // Regular expression to allow only letters and numbers

            if (!regex.test(username)) {
                usernameError.style.color = "red";
                usernameError.innerText = "Username can only contain letters and numbers.";
            } else {
                usernameError.style.color = "green";
                usernameError.innerText = "Username is valid!";
            }
        }
        function checkEmail() {
            var email = document.getElementById("email").value;
            var emailError = document.getElementById("emailError");

            // Send an AJAX request to check if the email already exists
            var xhr = new XMLHttpRequest();
            xhr.open("POST", "check_email.php", true);
            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
            xhr.onreadystatechange = function () {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    var response = xhr.responseText;
                    if (response === "exists") {
                        emailError.style.color = "red";
                        emailError.innerText = "This email is already in use. Please login.";
                    } else {
                        emailError.style.color = "green";
                        emailError.innerText = "Email is available.";
                    }
                }
            };
            xhr.send("email=" + email);
        }
        function checkEmailUniqueness() {
            var email = document.getElementById("email").value;
            var emailError = document.getElementById("emailError");

            $.ajax({
                url: 'check_email.php',
                method: 'POST',
                data: { email: email },
                success: function (response) {
                    if (response === 'exists') {
                        emailError.style.color = 'red';
                        emailError.innerText = 'Email is already in use. Please log in.';
                    } else {
                        emailError.style.color = 'green';
                        emailError.innerText = 'Email is available for registration.';
                    }
                }
            });
        }        function checkMobileUniqueness() {
            var mobile = document.getElementById("mobile").value;
            var mobileError = document.getElementById("mobileError");

            $.ajax({
                url: 'check_mobile.php',
                method: 'POST',
                data: { mobile: mobile },
                success: function (response) {
                    if (response === 'exists') {
                        mobileError.style.color = 'red';
                        mobileError.innerText = 'Mobile number is already in use. Please log in.';
                    } else {
                        mobileError.style.color = 'green';
                        mobileError.innerText = 'Mobile number is available for registration.';
                    }
                }
            });
        }

        function checkUsernameFormat() {
        var username = document.getElementById("username").value;
        var usernameError = document.getElementById("usernameError");
        var regex = /^[a-zA-Z0-9]+$/; // Regular expression to allow only letters and numbers

        if (!regex.test(username)) {
            usernameError.style.color = "red";
            usernameError.innerText = "Username can only contain letters and numbers.";
        } else {
            usernameError.style.color = "green";
            usernameError.innerText = "Username format is valid!";
        }
    }
        function checkMobile() {
            var mobile = document.getElementById("mobile").value;
            var mobileError = document.getElementById("mobileError");

            // Send an AJAX request to check if the mobile number already exists
            var xhr = new XMLHttpRequest();
            xhr.open("POST", "check_mobile.php", true);
            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
            xhr.onreadystatechange = function () {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    var response = xhr.responseText;
                    if (response === "exists") {
                        mobileError.style.color = "red";
                        mobileError.innerText = "This mobile number is already in use. Please login.";
                    } else {
                        mobileError.style.color = "green";
                        mobileError.innerText = "Mobile number is available.";
                    }
                }
            };
            xhr.send("mobile=" + mobile);
        }
    </script>
</head>
<body>
    <div class="container">
        <h2>Register</h2>
        <!-- Display Success or Error Messages -->
        <?php
        if (isset($_GET['error']) && $_GET['error'] == 1) {
            echo '<p class="error-message">' . $_GET['message'] . '</p>';
        } elseif (isset($_GET['message']) && $_GET['message'] == 'registration_successful') {
            echo '<p class="success-message">Registration successful. You can now <a href="login.php">login</a>.</p>';
        }
        ?>
        <form action="register.php" method="post">
            <div class="form-group">
                <label for="first_name">Name</label>
                <input type="text" id="first_name" name="first_name" required />
            </div>
            <div class="form-group">
                <label for="username">Username</label>
                <input type="text" id="username" name="username" required onkeyup="checkUsernameFormat();" />
                <span id="usernameError" class="error-message"></span>
            </div>

            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" required onkeyup="checkPasswordMatch();" />
                <span id="passwordToggle" style="cursor: pointer;" onclick="togglePasswordVisibility();">🔒</span>
            </div>

            <div class="form-group">
                <label for="confirm_password">Confirm Password</label>
                <input type="password" id="confirm_password" name="confirm_password" required onkeyup="checkPasswordMatch();" />
                <span id="passwordError" class="error-message"></span>
            </div>
            <div class="form-group">
                <label for="mobile">Mobile Number</label>
                <input type="tel" id="mobile" name="mobile" required onkeyup="checkMobileUniqueness();" />
                <span id="mobileError" class="error-message"></span>
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" required onkeyup="checkEmailUniqueness();" />
                <span id="emailError" class="error-message"></span>
            </div>

            <div class="form-group">
                <label for="date_of_birth">Date of Birth</label>
                <input type="date" id="date_of_birth" name="date_of_birth" required />
            </div>

            <button type="submit" class="register-button">Register</button>
        </form>

    </div>
</body>
</html>
