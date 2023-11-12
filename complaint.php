<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Complaint Page</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #1b1a1a;
            color: #fff;
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        .container {
            max-width: 600px;
            margin: 20px auto;
            background-color: #333;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
            padding: 20px;
            box-sizing: border-box;
            position: relative;
        }

        h2 {
            text-align: center;
            color: #fff;
        }

        form {
            display: flex;
            flex-direction: column;
        }

        label {
            margin-bottom: 8px;
            color: #fff;
        }

        textarea,
        input {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
            background-color: #1b1a1a; /* Match the background color */
            color: #fff;
        }

        button {
            background-color: #4caf50;
            color: white;
            border: none;
            padding: 12px;
            border-radius: 5px;
            cursor: pointer;
        }

        button:hover {
            background-color: #45a049;
        }

        .profile-btn,
        .complaints-btn,
        .signout-btn {
            background-color: #3498db;
            color: white;
            border: none;
            padding: 8px 12px;
            border-radius: 5px;
            cursor: pointer;
            margin-top: 10px;
        }

        .success-message {
            background-color: #4caf50;
            color: white;
            padding: 10px;
            border-radius: 5px;
            margin-bottom: 20px;
            text-align: center;
        }

        @media only screen and (max-width: 600px) {
            .container {
                margin: 10px;
            }
        }
    </style>
</head>

<body>
    <div class="container">
        <?php
        // Start the session
        session_start();

        // Include the database connection file
        include 'connection.php';

        // Check if the form is submitted
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            // Retrieve form data
            $complaintText = $_POST["complaint"];
            $responseText = isset($_POST["response"]) ? $_POST["response"] : '';

            // Process file upload
            $targetDirectory = "uploads/";
            $targetFile = $targetDirectory . basename($_FILES["photo"]["name"]);

            // Validate file type and size
            $allowedFileTypes = ["jpg", "jpeg", "png", "gif"];
            $maxFileSize = 10 * 1024 * 1024; // 10MB

            $fileExtension = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

            if (!in_array($fileExtension, $allowedFileTypes)) {
                die("Error: Invalid file type. Only JPG, JPEG, PNG, and GIF files are allowed.");
            }

            if ($_FILES["photo"]["size"] > $maxFileSize) {
                die("Error: File size exceeds 10MB.");
            }

            move_uploaded_file($_FILES["photo"]["tmp_name"], $targetFile);

            // Assuming you have a user ID stored in a session variable
            $userId = isset($_SESSION["user_id"]) ? $_SESSION["user_id"] : null;

            // Check if user is logged in
            if (!$userId) {
                echo '<p style="color: red;">Error: User not logged in.</p>';
                exit();
            }

            // Insert into Complaints table
            $query = "INSERT INTO Complaints (user_id, complaint_text, photo_path, response) VALUES (?, ?, ?, ?)";
            $stmt = $conn->prepare($query);

            // Check if the prepare statement was successful
            if ($stmt) {
                // Use an empty string as the default value for the "response" column
                $defaultResponse = '';

                $stmt->bind_param("isss", $userId, $complaintText, $targetFile, $responseText);
                $stmt->execute();
                $stmt->close();

                // Display success message and redirect
                echo '<div class="success-message">Complaint registered successfully!</div>';
                header("refresh:2;url=complaint.php"); // Redirect to the homepage after 2 seconds
                exit();
            } else {
                // Handle the case when prepare fails
                echo "Error in prepare statement: " . $conn->error;
            }
        }
        ?>

        <h2>File a Complaint</h2>

        <form action="complaint.php" method="post" enctype="multipart/form-data">
            <label for="complaint">Complaint:</label>
            <textarea id="complaint" name="complaint" placeholder="Enter your complaint" required></textarea>

            <label for="photo">Upload Photo (max 10MB):</label>
            <input type="file" id="photo" name="photo" accept="image/*" required>
            <button type="submit">Submit Complaint</button>
        </form>

        <button class="profile-btn" onclick="redirectToProfile()">Profile</button>
        <button class="complaints-btn" onclick="redirectToMyComplaints()">My Complaints</button>

        <!-- Sign Out Button -->
        <form action="login.php" method="post">
            <button class="signout-btn" type="submit">Sign Out</button>
        </form>
    </div>

    <script>
        function redirectToProfile() {
            // Redirect to profile.php after clicking the Profile button
            window.location.href = 'profile.php';
        }

        function redirectToMyComplaints() {
            // Redirect to mycomplaints.php after clicking the My Complaints button
            window.location.href = 'mycomplaints.php';
        }
    </script>
</body>

</html>
