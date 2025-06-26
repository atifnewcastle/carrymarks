<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lecturer Sign Up</title>
    <!-- Bootstrap CSS CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" xintegrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <style>
        body {
            font-family: 'Inter', sans-serif; /* Using Inter font as per instructions */
            background-color: #f0f2f5;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            margin: 0;
        }
        .signup-container { /* Renamed to avoid conflict with Bootstrap's .container */
            background-color: #ffffff;
            padding: 2.5rem;
            border-radius: 1rem; /* Rounded corners */
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 28rem; /* Max width for better form presentation */
        }
        /* Custom styles for Bootstrap integration if needed, mostly for fine-tuning */
        .form-label {
            font-weight: 600;
            color: #333;
        }
        .btn-custom {
            background-color: #4c51bf; /* Indigo background */
            border-color: #4c51bf;
            transition: background-color 0.3s ease;
        }
        .btn-custom:hover {
            background-color: #5a62bb; /* Darker indigo on hover */
            border-color: #5a62bb;
        }
    </style>
</head>
<body>

    <div class="container d-flex justify-content-center align-items-center min-vh-100">
        <div class="signup-container">
            <h2 class="text-center mb-4 text-dark">Lecturer Sign Up</h2>

            <?php
            require_once 'connection.php'; // Include the database connection file
            try {
                // Attempt to establish database connection
                //$conn = new mysqli($dbHost, $dbUser, $dbPass, $dbName);

                // Check connection
                // if ($conn->connect_error) {
                //     // Display error message (do not use alert())
                //     echo '<div class="alert alert-danger" role="alert">Database Connection failed: ' . $conn->connect_error . '</div>';
                // }

                // Check if the form has been submitted
                if ($_SERVER["REQUEST_METHOD"] == "POST" && $conn) {
                    // Sanitize and retrieve form data
                    // $lecturerId = $conn->real_escape_string($_POST['lecturer_id']);
                    // $firstName = $conn->real_escape_string($_POST['first_name']);
                    // $lastName = $conn->real_escape_string($_POST['last_name']);
                    $email = $conn->real_escape_string($_POST['email']);
                    // $password = $_POST['password']; // Password will be hashed
                    // $department = $conn->real_escape_string($_POST['department']);

                    // Input validation
                    if (empty($lecturerId) || empty($firstName) || empty($lastName) || empty($email) || empty($password)) {
                        echo '<div class="alert alert-danger" role="alert">Please fill in all required fields.</div>';
                    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                        echo '<div class="alert alert-danger" role="alert">Invalid email format.</div>';
                    } else {
                        // Hash the password for security
                        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

                        // Check if LecturerID or Email already exists
                        $checkSql = "SELECT LecturerID FROM Lecturer WHERE LecturerID = ? OR Email = ?";
                        $stmtCheck = $conn->prepare($checkSql);
                        $stmtCheck->bind_param("ss", $lecturerId, $email);
                        $stmtCheck->execute();
                        $stmtCheck->store_result();

                        if ($stmtCheck->num_rows > 0) {
                            echo '<div class="alert alert-warning" role="alert">LecturerID or Email already exists. Please use a different one.</div>';
                        } else {
                            // Prepare an SQL INSERT statement
                            // Note: The `Lecturer` table from the previous prompt does not have a 'Password' column.
                            // For a sign-up page, you would typically add a 'PasswordHash' column to store hashed passwords.
                            // I am adding it here for demonstration.
                            $sql = "INSERT INTO Lecturer (LecturerID, FirstName, LastName, Email, Department, PasswordHash) VALUES (?, ?, ?, ?, ?, ?)";

                            // Prepare and bind parameters to prevent SQL injection
                            $stmt = $conn->prepare($sql);
                            if ($stmt) {
                                $stmt->bind_param("ssssss", $lecturerId, $firstName, $lastName, $email, $department, $hashedPassword);

                                // Execute the statement
                                if ($stmt->execute()) {
                                    echo '<div class="alert alert-success" role="alert">Lecturer "' . htmlspecialchars($firstName) . ' ' . htmlspecialchars($lastName) . '" signed up successfully!</div>';
                                } else {
                                    echo '<div class="alert alert-danger" role="alert">Error: ' . $stmt->error . '</div>';
                                }
                                // Close the statement
                                $stmt->close();
                            } else {
                                echo '<div class="alert alert-danger" role="alert">Error preparing statement: ' . $conn->error . '</div>';
                            }
                        }
                        $stmtCheck->close();
                    }
                }
            } catch (mysqli_sql_exception $e) {
                echo '<div class="alert alert-danger" role="alert">An error occurred: ' . $e->getMessage() . '</div>';
            } finally {
                // Close the database connection if it was opened
                if ($conn) {
                    $conn->close();
                }
            }
            ?>

            <!-- Lecturer Sign Up Form -->
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
                <div class="mb-3">
                    <label for="lecturer_id" class="form-label">Lecturer ID:</label>
                    <input type="text" id="lecturer_id" name="lecturer_id" required class="form-control rounded">
                </div>

                <div class="mb-3">
                    <label for="first_name" class="form-label">First Name:</label>
                    <input type="text" id="first_name" name="first_name" required class="form-control rounded">
                </div>

                <div class="mb-3">
                    <label for="last_name" class="form-label">Last Name:</label>
                    <input type="text" id="last_name" name="last_name" required class="form-control rounded">
                </div>

                <div class="mb-3">
                    <label for="email" class="form-label">Email:</label>
                    <input type="email" id="email" name="email" required class="form-control rounded">
                </div>

                <div class="mb-3">
                    <label for="password" class="form-label">Password:</label>
                    <input type="password" id="password" name="password" required class="form-control rounded">
                </div>

                <div class="mb-4">
                    <label for="department" class="form-label">Department (Optional):</label>
                    <input type="text" id="department" name="department" class="form-control rounded">
                </div>

                <button type="submit" class="btn btn-custom w-100 rounded">Sign Up</button>
            </form>
        </div>
    </div>

    <!-- Bootstrap JS (optional, for components that need JS) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" xintegrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
</body>
</html>
