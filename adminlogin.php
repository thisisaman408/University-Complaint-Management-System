<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login - Movie Ticket Booking</title>
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

        .login-container {
            background-color: #1b1a1a;
            max-width: 5in;
            width: 90%;
            padding: 20px;
            border-radius: 15px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
            text-align: left;
        }

        .login-container h2 {
            font-size: 24px;
            margin: 0 auto;
            margin-bottom: 20px;
            text-align: center;
        }

        .login-container label {
            display: block;
            margin: 10px 0;
            align-items: left;
        }

        .login-container input {
            display: block;
            margin: 10px 0;
        }

        .login-container input {
            width: 95%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 10px;
            margin: 10px 0;
        }

        .login-container button {
            width: 100%;
            background-color: #4CAF50;
            padding: 10px;
            border: none;
            border-radius: 10px;
            cursor: pointer;
            margin: 10px 0;
        }

        .login-container button:hover {
            background-color: #233c24;
        }
    </style>
</head>
<body>
<div class="start">
    <div class="login-container">
        <h2>Admin Login</h2>
        <?php
            if (isset($_GET['error']) && $_GET['error'] === '1') {
                echo '<p style="color: red;">Incorrect username or password</p>';
            }
        ?>
        <form action="admin_login_process.php" method="post">
            <label for="username">Username</label>
            <input
                type="text"
                id="username"
                name="username"
                placeholder="Enter your username"
                required
            />

            <label for="password">Password</label>
            <input type="password" id="password" name="password" placeholder="Enter your password" required>

            <button type="submit">Login</button>
        </form>
    </div>
</div>

</body>
</html>
