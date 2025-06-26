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
                    // Sanitize and validate email input
                    $email = trim($_POST['email'] ?? '');

                    if (empty($email)) {
                        echo '<div class="alert alert-danger" role="alert">Please enter your email.</div>';
                    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                        echo '<div class="alert alert-danger" role="alert">Invalid email format.</div>';
                    } else {
                        // Check if email exists in Lecturer table
                        $sql = "SELECT LecturerID FROM Lecturer WHERE Email = ?";
                        $stmt = $conn->prepare($sql);
                        if ($stmt) {
                            $stmt->bind_param("s", $email);
                            $stmt->execute();
                            $stmt->store_result();

                            if ($stmt->num_rows > 0) {
                                // Email found, redirect to dashboard
                                session_start(); // Start the session
                                // Serialize the email and store it in session 
                                $_SESSION['email'] = $email; // Store email in session
                                $_SESSION['user_id'] = $stmt->fetch()[0]; // Assuming LecturerID
                                header("Location: dashboard.php");
                                exit();
                            } else {
                                echo '<div class="alert alert-danger" role="alert">Email not found. Please check your email or sign up.</div>';
                            }
                            $stmt->close();
                        } else {
                            echo '<div class="alert alert-danger" role="alert">Database error: ' . $conn->error . '</div>';
                        }
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
                    <label for="email" class="form-label">Email:</label>
                    <input type="email" id="email" name="email" required class="form-control rounded">
                </div>

                <button type="submit" class="btn btn-custom w-100 rounded">Sign Up</button>
            </form>
        </div>
    </div>

    <!-- Bootstrap JS (optional, for components that need JS) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" xintegrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
</body>
</html>
