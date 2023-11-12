<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Complaints</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #2b2a2a;
            text-align: center;
            color: white;
            margin: 0;
        }

        .complaint-container {
            background-color: #1b1a1a;
            max-width: 800px;
            width: 90%;
            padding: 20px;
            border-radius: 15px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
            text-align: left;
            margin: 20px auto;
        }

        .complaint-container h2 {
            font-size: 24px;
            margin: 0 auto;
            margin-bottom: 20px;
            text-align: center;
        }

        .complaint {
            border: 1px solid #ccc;
            padding: 10px;
            margin-bottom: 20px;
            transition: transform 0.3s ease-in-out;
            display: flex;
            align-items: flex-start;
        }

        .complaint:hover {
            transform: scale(1.03);
        }

        .complaint img {
            max-width: 150px;
            height: auto;
            border-radius: 8px;
            margin-right: 20px;
        }

        .complaint-details {
            flex: 1; /* Take remaining space */
        }

        .complaint-details p {
            margin: 5px 0;
        }

        .status-circle {
            width: 15px;
            height: 15px;
            border-radius: 50%;
            display: inline-block;
            margin-right: 5px;
        }

        .status-red {
            background-color: red;
        }

        .status-yellow {
            background-color: yellow;
        }

        .status-green {
            background-color: green;
        }

        .status-container {
            display: flex;
            align-items: center;
            margin-top: 10px;
        }

        .view-details-button {
            background-color: #3498db;
            color: white;
            border: none;
            padding: 8px 12px;
            border-radius: 5px;
            text-decoration: none;
            transition: background-color 0.3s ease-in-out;
            margin-top: 10px;
        }

        .view-details-button:hover {
            background-color: #2980b9;
        }

        .action-buttons {
            margin-top: 20px;
            display: flex;
            justify-content: center;
        }

        .action-button {
            background-color: green;
            color: black;
            border: none;
            padding: 8px 12px;
            border-radius: 5px;
            text-decoration: none;
            transition: background-color 0.3s ease-in-out;
            margin: 0 10px;
        }

        .action-button:hover {
            background-color: #2980b9;
        }
    </style>
</head>

<body>
    <div class="complaint-container">
        <h2>Admin - Complaints</h2>

        <?php
        // Include the database connection file
        include 'connection.php';

        // Check if the user is logged in as an admin
        session_start();
        if (!isset($_SESSION['admin_id'])) {
            header("Location: adminlogin.php"); // Redirect to the admin login page if not logged in
            exit();
        }

        // Fetch all complaints from the Complaints table
        $query = "SELECT * FROM Complaints ORDER BY complaint_date DESC";
        $result = $conn->query($query);

        // Check if the query was executed successfully
        if (!$result) {
            echo '<p>Error fetching complaints: ' . $conn->error . '</p>';
        } else {
            // Check if there are any complaints
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $complaintId = $row['complaint_id'];
                    $userId = $row['user_id'];
                    $complaintText = $row['complaint_text'];
                    $photoPath = $row['photo_path'];
                    $complaintDate = $row['complaint_date'];
                    $status = isset($row['complaint_status']) ? $row['complaint_status'] : '';

                    // Fetch user details from the Users table based on user_id
                    $userQuery = "SELECT * FROM Users WHERE user_id = ?";
                    $userStmt = $conn->prepare($userQuery);
                    $userStmt->bind_param("i", $userId);
                    $userStmt->execute();
                    $userResult = $userStmt->get_result();

                    // Check if user details are found
                    if ($userResult->num_rows > 0) {
                        $userRow = $userResult->fetch_assoc();
                        $userName = isset($userRow['username']) ? $userRow['username'] : '';
                        $userEmail = isset($userRow['email_address']) ? $userRow['email_address'] : '';
                        $userMobile = isset($userRow['mobile_number']) ? $userRow['mobile_number'] : '';
                    } else {
                        // Handle the case when no user details are found
                        $userName = 'User not found';
                        $userEmail = 'N/A';
                        $userMobile = 'N/A';
                    }

                    // Determine the status circle class based on the complaint status
                    $statusClass = '';
                    if ($status == 'red') {
                        $statusClass = 'status-red';
                    } elseif ($status == 'yellow') {
                        $statusClass = 'status-yellow';
                    } elseif ($status == 'green') {
                        $statusClass = 'status-green';
                    }

                    // Output HTML for each complaint
                    echo '<div class="complaint">';
                    echo "<img src='$photoPath' alt='Complaint Photo'>";
                    echo '<div class="complaint-details">';
                    echo "<h3>User: $userName</h3>";
                    echo "<p>Date: $complaintDate</p>";
                    echo "<p>Complaint: $complaintText</p>";

                    // Display status and "View User Details" link in a container
                    echo '<div class="status-container">';
                    echo "<span class='status-circle $statusClass'></span>";
                    echo "<a href='viewuserdetails.php?user_id=$userId&complaint_id=$complaintId' class='view-details-button'>View User Details</a>";
                    echo '</div>';

                    echo '</div>';
                    echo '</div>';
                }
            } else {
                echo '<p>No complaints found.</p>';
            }
        }
        ?>

        <!-- Action buttons for Sign Out and New Registration -->
        <div class="action-buttons">
            <a href="adminlogin.php" class="action-button">Sign Out</a>
            <a href="register.php" class="action-button">New Registration</a>
        </div>
    </div>
</body>

</html>
