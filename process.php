<?php
//accepts POST requests to process student registration
// and file upload for profile pictures
 if ($_SERVER['REQUEST_METHOD'] === 'POST') {
 	session_start();

 	$name   	= htmlspecialchars(trim($_POST['name']));
 	$student_id = htmlspecialchars(trim($_POST['student_id']));
 	$program	= htmlspecialchars(trim($_POST['program']));

 	$allowedTypes = ['image/jpeg', 'image/png'];
 	$maxSize  	= 2 * 1024 * 1024; // 2MB

 	if ($_FILES['profile_pic']['error'] === UPLOAD_ERR_OK) {
     	$tmpPath  = $_FILES['profile_pic']['tmp_name'];
     	$fileSize = $_FILES['profile_pic']['size'];
     	$fileType = mime_content_type($tmpPath);

     	if (in_array($fileType, $allowedTypes) && $fileSize <= $maxSize) {
         	$filename   = time() . '_' . basename($_FILES['profile_pic']['name']);
         	$targetPath = 'uploads/' . $filename;
         	move_uploaded_file($tmpPath, $targetPath); 

         	$_SESSION['students'][] = [
             	'name'   	=> $name,
             	'student_id' => $student_id,
             	'program'	=> $program,
             	'image'  	=> $targetPath
         	];

            echo "<script>
                let students = JSON.parse(localStorage.getItem('students') || '[]');
                students.push({
                    name: " . json_encode($name) . ",
                    student_id: " . json_encode($student_id) . ",
                    program: " . json_encode($program) . ",
                    image: " . json_encode($targetPath) . "
                });
                localStorage.setItem('students', JSON.stringify(students));
            </script>";

         	echo "<p>Registration successful.</p>";
         	echo '<a href="view.php">View all students</a>';
     	} else {
         	echo "Error: invalid file type/size.";
     	}
 	} else {
     	echo "Error uploading file.";
 	}
 }
    else {
    	echo "Invalid request method.";
    }