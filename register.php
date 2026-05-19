<?php
include('config.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $student_id = trim($_POST['student_id']);
    $full_name = trim($_POST['full_name']);
    $course = trim($_POST['course']);
    $year_level = intval($_POST['year_level']);
    $password = trim($_POST['password']);

    // 1. Validation: Check if any fields are empty
    if (empty($student_id) || empty($full_name) || empty($course) || empty($year_level) || empty($password)) {
        echo json_encode(["status" => "error", "message" => "All fields are required."]);
        exit;
    }

    // 2. Check if the Student ID already exists in the system
    $check_stmt = $conn->prepare("SELECT id FROM students WHERE student_id = ?");
    $check_stmt->bind_param("s", $student_id);
    $check_stmt->execute();
    $check_result = $check_stmt->get_result();

    if ($check_result->num_rows > 0) {
        echo json_encode(["status" => "error", "message" => "This Student ID is already registered."]);
        exit;
    }
    $check_stmt->close();

    // 3. Insert the new student record
    // Note: For actual production deployment, use password_hash($password, PASSWORD_DEFAULT)
    $insert_stmt = $conn->prepare("INSERT INTO students (student_id, password, full_name, course, year_level, gpa) VALUES (?, ?, ?, ?, ?, 0.00)");
    $insert_stmt->bind_param("ssssi", $student_id, $password, $full_name, $course, $year_level);

    if ($insert_stmt->execute()) {
        echo json_encode(["status" => "success", "message" => "Account created successfully!"]);
    } else {
        echo json_encode(["status" => "error", "message" => "Something went wrong. Please try again."]);
    }
    
    $insert_stmt->close();
}
?>
