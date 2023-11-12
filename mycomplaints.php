<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Complaints</title>
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
            max-width: 800px;
            margin: 20px auto;
            background-color: #333;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
            padding: 20px;
            box-sizing: border-box;
        }

        h2 {
            text-align: center;
            color: #fff;
        }

        .complaint {
            border: 1px solid #ccc;
            padding: 10px;
            margin-bottom: 20px;
            transition: transform 0.3s ease-in-out;
        }

        .complaint:hover {
            transform: scale(1.03);
        }

        .complaint img {
            max-width: 200px;
            height: auto;
            border-radius: 8px;
            margin-right: 20px;
        }

        .complaint-details {
            flex: 1;
        }

        .complaint-details p {
            margin: 5px 0;
        }

        .status-button {
            border: none;
            padding: 5px;
            margin-bottom: 10px;
            border-radius: 5px;
            cursor: pointer;
            font-weight: bold;
        }

        .status-red {
            background-color: red;
            color: white;
        }

        .status-yellow {
            background-color: yellow;
            color: black;
        }

        .status-green {
            background-color: green;
            color: white;
        }

        @media only screen and (max-width: 600px) {
            .container {
                width: 100%;
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

        // Check if the user is logged in
        if (!isset($_SESSION['user_id'])) {
            header("Location: login.php"); // Redirect to the login page if not logged in
            exit();
        }

        // Retrieve user ID from the session
        $userId = $_SESSION['user_id'];

        // Fetch all complaints for the user from the Complaints table
        $query = "SELECT * FROM Complaints WHERE user_id = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("i", $userId);
        $stmt->execute();
        $result = $stmt->get_result();

        // Check if there are any complaints
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $complaintId = $row['complaint_id'];
                $complaintText = $row['complaint_text'];
                $photoPath = $row['photo_path'];
                $complaintDate = $row['complaint_date'];
                $complaintStatus = $row['complaint_status'];
                $response = $row['response'];

                // Output HTML for each complaint
                echo '<div class="complaint">';
                echo "<img src='$photoPath' alt='Complaint Photo'>";
                echo '<div class="complaint-details">';
                echo "<h3>Complaint ID: $complaintId</h3>";
                echo "<p>Date: $complaintDate</p>";
                echo "<p>Complaint: $complaintText</p>";
                echo "<p>Status: <button class='status-button status-$complaintStatus'>$complaintStatus</button></p>";
                echo "<p>Response: $response</p>";
                echo '</div>';
                echo '</div>';
            }
        } else {
            echo '<p>No complaints found.</p>';
        }

        // Close the database connection
        $conn->close();
        ?>
    </div>
</body>

</html>
