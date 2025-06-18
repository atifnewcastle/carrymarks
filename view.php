<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Students</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <?php
     include "includes/header.php";
     ?>
    <div class="container mt-4">
        <h2>Students List</h2>
        <table class="table table-bordered" id="studentsTable">
            <thead class="table-dark">
                <tr>
                    <th>#</th>
                    <th>Image</th>
                    <th>Name</th>
                    <th>Student ID</th>
                    <th>Program</th>
                </tr>
            </thead>
            <tbody>
                <!-- Data will be inserted here by JavaScript -->
            </tbody>
        </table>
    </div>
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const students = JSON.parse(localStorage.getItem('students') || '[]');
        const tbody = document.querySelector('#studentsTable tbody');
        students.forEach((student, idx) => {
            const imgSrc = student.image ? `./${student.image}` : 'https://via.placeholder.com/50x50?text=No+Image';
            const tr = document.createElement('tr');
            tr.innerHTML = `
                <td>${idx + 1}</td>
                <td><img src="${imgSrc}" alt="Student Image" style="width:50px;height:50px;object-fit:cover;border-radius:5px;"></td>
                <td>${student.name || ''}</td>
                <td>${student.student_id || ''}</td>
                <td>${student.program || ''}</td>
            `;
            tbody.appendChild(tr);
        });
    });
    </script>

    <!-- Bootstrap JS (optional, for navbar toggling) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>