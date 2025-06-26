<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

require 'connection.php';
//echo "<p>Lecturer ID: " . htmlspecialchars($_SESSION['user_id']) . "</p>";

// Fetch classes from the database
$sql = "SELECT * FROM class WHERE LecturerID = ? ORDER BY Semester DESC";
$stmt = $conn->prepare($sql);
if ($stmt) {
    $stmt->bind_param("s", $_SESSION['user_id']); // Assuming user_id is the LecturerID
    $stmt->execute();
    $result = $stmt->get_result();
} else {
    // Handle error if the statement could not be prepared
    echo "Error preparing statement: {$conn->error}";
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Lecturer Dashboard</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- DataTables CSS -->
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css"/>
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    <!-- DataTables JS -->
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
</head>
<body>
    <?php
     include "includes/header_lecturer.php";
     ?>
<div class="container">
    <?php
    if (isset($_GET['msg']) && !empty($_GET['msg'])): ?>
        <div class="alert alert-info alert-dismissible fade show mt-3" role="alert">
            <?php echo htmlspecialchars($_GET['msg']); ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>
    <h2>All Classes</h2>
    <div class="mb-3 float-end">
        <a href="new_class.php" class="btn btn-primary">Add New Class</a>
    </div>
    <table id="classesTable" class="display">
        <thead>
            <tr>
                <th>Class ID</th>
                <th>Class Name</th>
                <th>Course Code</th>
                <th>Lecturer ID</th>
                <th>Credits</th>
                <th>Semester</th>
                <th>Year</th>
                <th>Menu</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($result && $result->num_rows > 0): ?>
                <?php while($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row['ClassID']); ?></td>
                        <td><?php echo htmlspecialchars($row['ClassName']); ?></td>
                        <td><?php echo htmlspecialchars($row['CourseCode']); ?></td>
                        <td><?php echo htmlspecialchars($row['LecturerID']); ?></td>
                        <td><?php echo htmlspecialchars($row['Credits']); ?></td>
                        <td><?php echo htmlspecialchars($row['Semester']); ?></td>
                        <td><?php echo htmlspecialchars($row['Year']); ?></td>
                        <td>
                            <a href="update_class.php?id=<?php echo urlencode($row['ClassID']); ?>" class="btn btn-sm btn-warning">Update</a>
                            <a href="delete_class.php?id=<?php echo urlencode($row['ClassID']); ?>" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this class?');">Delete</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            <?php endif; ?>
        </tbody>
    </table>
</div>
<script>
    $(document).ready(function() {
        $('#classesTable').DataTable();
    });
</script>
<!-- Bootstrap JS Bundle -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>