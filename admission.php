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
    $last_name = sanitizeInput($_POST['last_name']);
    $email = sanitizeInput($_POST['email']);
    $major = sanitizeInput($_POST['major']);
    $graduation_year = sanitizeInput($_POST['graduation_year']);
    $course_id = sanitizeInput($_POST['course_id']);

    // Insert the new student's data into the Student Table
    $insertStudentQuery = "INSERT INTO Student (FirstName, LastName, Email, Major, GraduationYear) VALUES ('$first_name', '$last_name', '$email', '$major', $graduation_year)";

    if (mysqli_query($conn, $insertStudentQuery)) {
        // Get the student_id of the newly inserted student
        $student_id = mysqli_insert_id($conn);

        // Insert the enrollment record into the Enrollment Table
        $enrollment_date = date('Y-m-d'); // Get the current date
        $insertEnrollmentQuery = "INSERT INTO Enrollment (StudentID, CourseID, EnrollmentDate) VALUES ($student_id, $course_id, '$enrollment_date')";

        if (mysqli_query($conn, $insertEnrollmentQuery)) {
            // Registration successful, redirect to a success page
            header('Location: registration_success.php');
            exit;
        } else {
            // Error occurred during registration, redirect to an error page
            header('Location: registration_error.php');
            exit;
        }
    } else {
        // Error occurred during registration, redirect to an error page
        header('Location: registration_error.php');
        exit;
    }
}
?>

<!-- HTML Form for Student Registration -->
<!DOCTYPE html>
<html>
<head>
    <title>Student Registration</title>
    <!-- Add your CSS styling here -->
</head>
<body>
    <div class="container">
        <h2>Student Registration</h2>
        <!-- Display Success or Error Messages -->
        <?php
        if (isset($_GET['error']) && $_GET['error'] == 1) {
            echo '<p class="error-message">' . $_GET['message'] . '</p>';
        } elseif (isset($_GET['message']) && $_GET['message'] == 'registration_successful') {
            echo '<p class="success-message">Registration successful. You can now <a href="loginpage.php">login</a>.</p>';
        }
        ?>
        <form action="register.php" method="post">
            <div class="form-group">
                <label for="first_name">First Name</label>
                <input type="text" id="first_name" name="first_name" required />
            </div>
            <div class="form-group">
                <label for="last_name">Last Name</label>
                <input type="text" id="last_name" name="last_name" required />
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" required />
            </div>
            <div class="form-group">
                <label for="major">Major</label>
                <input type="text" id="major" name="major" required />
            </div>
            <div class="form-group">
                <label for="graduation_year">Graduation Year</label>
                <input type="number" id="graduation_year" name="graduation_year" required />
            </div>
            <div class="form-group">
                <label for="course_id">Select Course</label>
                <!-- Add a select dropdown for course selection -->
            </div>
            <button type="submit" class="register-button">Register</button>
        </form>
        <p class="login-link">
            Already have an account? <a href="loginpage.php">Login</a>
        </p>
    </div>
</body>
</html>
