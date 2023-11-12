<?php
session_start();

// Include the database connection file
include 'connection.php';

// Check if the user is logged in as an admin
if (!isset($_SESSION['admin_id'])) {
    header("Location: adminlogin.php"); // Redirect to the admin login page if not logged in
    exit();
}

// Check if the complaint_id parameter is set in the URL
if (!isset($_GET['complaint_id'])) {
    header("Location: admincomplaint.php"); // Redirect to the admin complaints page if complaint_id is not provided
    exit();
}

$complaint_id = $_GET['complaint_id'];

// Fetch user details and complaint info from the database
$query = "SELECT u.user_id, u.username, n.first_name, n.middle_name, n.last_name, e.email_address, m.mobile_number, ud.date_of_birth, c.response, c.complaint_status
FROM Users u
JOIN Name n ON u.name_id = n.name_id
JOIN Email e ON u.email_id = e.email_id
JOIN Mobile m ON u.mobile_id = m.mobile_id
LEFT JOIN UserDetails ud ON u.user_id = ud.user_id
JOIN Complaints c ON u.user_id = c.user_id
WHERE c.complaint_id = ?";

$stmt = $conn->prepare($query);

if (!$stmt) {
    die("Error preparing user details query: " . $conn->error);
}

$stmt->bind_param("i", $complaint_id);

if (!$stmt->execute()) {
    die("Error executing user details query: " . $stmt->error);
}

$userResult = $stmt->get_result();

if (!$userResult) {
    die("Error fetching user details result: " . $stmt->error);
}

$user = $userResult->fetch_assoc();

// Fetch complaint info from the Complaints table based on complaint_id
$complaintInfoQuery = "SELECT complaint_status, response FROM Complaints WHERE complaint_id = ?";
$complaintInfoStmt = $conn->prepare($complaintInfoQuery);

if (!$complaintInfoStmt) {
    die("Error preparing complaint info query: " . $conn->error);
}

$complaintInfoStmt->bind_param("i", $complaint_id);

if (!$complaintInfoStmt->execute()) {
    die("Error executing complaint info query: " . $complaintInfoStmt->error);
}

$complaintInfoResult = $complaintInfoStmt->get_result();

if (!$complaintInfoResult) {
    die("Error fetching complaint info result: " . $complaintInfoStmt->error);
}

$complaintInfo = $complaintInfoResult->fetch_assoc();
$complaintStatus = $complaintInfo['complaint_status'];
$response = $complaintInfo['response'];

// Handle form submission to update status and response
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $newStatus = $_POST["status"];
    $newResponse = $_POST["response"];

    // Update status and response in the database
    $updateQuery = "UPDATE Complaints SET complaint_status = ?, response = ? WHERE complaint_id = ?";
    $updateStmt = $conn->prepare($updateQuery);

    if ($updateStmt) {
        $updateStmt->bind_param("ssi", $newStatus, $newResponse, $complaint_id);
        $updateStmt->execute();
        $updateStmt->close();

        // Redirect to the admin complaints page after updating
        header("Location: admincomplaint.php?success=1");
        exit();
    } else {
        die("Error in prepare statement: " . $conn->error);
    }
}

// Display user details and update status form
echo '
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Details - Complaint Page</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: black;
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            color: white;
        }

        .container {
            max-width: 600px;
            margin: 20px auto;
            background-color: #1b1a1a;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
            padding: 20px;
            box-sizing: border-box;
        }

        h2 {
            text-align: center;
        }

        p {
            margin-bottom: 10px;
        }

        form {
            display: flex;
            flex-direction: column;
        }

        label {
            margin-bottom: 8px;
        }

        select,
        button,
        textarea {
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
            background-color: #1b1a1a; /* Match the background color */
            color: white;
        }

        select {
            width: 100%;
        }

        button {
            background-color: #4caf50;
            color: white;
            border: none;
            cursor: pointer;
        }

        button:hover {
            background-color: #45a049;
        }

        .success-message {
            background-color: #4caf50;
            color: white;
            padding: 10px;
            border-radius: 5px;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>User Details</h2>
        <p>User ID: ' . $user['user_id'] . '</p>
        <p>Username: ' . $user['username'] . '</p>
        <p>First Name: ' . $user['first_name'] . '</p>
        <p>Email: ' . $user['email_address'] . '</p>
        <p>Mobile: ' . $user['mobile_number'] . '</p>
        <p>Date of Birth: ' . $user['date_of_birth'] . '</p>

        <p>Complaint ID: ' . $complaint_id . '</p>
        <p>Complaint Status: ' . $complaintStatus . '</p>';

// Display success message if set in the URL parameters
if (isset($_GET['success']) && $_GET['success'] == 1) {
    echo '<div class="success-message">Update successful!</div>';
}

echo '
        <form action="" method="post">
            <label for="status">Update Status:</label>
            <select name="status" id="status">
                <option value="red" ' . ($complaintStatus == "red" ? 'selected' : '') . '>Not Checked</option>
                <option value="yellow" ' . ($complaintStatus == "yellow" ? 'selected' : '') . '>Checked, Not Solved</option>
                <option value="green" ' . ($complaintStatus == "green" ? 'selected' : '') . '>Solved</option>
            </select>

            <label for="response">Admin Response:</label>
            <textarea id="response" name="response" placeholder="Enter admin response">' . $response . '</textarea>

            <button type="submit">Update</button>
        </form>
    </div>
</body>
</html>';
?>
