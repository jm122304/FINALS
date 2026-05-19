<?php
session_start();
include('config.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $student_id = trim($_POST['student_id']);
    $password = trim($_POST['password']);

    // Using prepared statements for security
    $stmt = $conn->prepare("SELECT id, password, full_name FROM students WHERE student_id = ?");
    $stmt->bind_param("s", $student_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $row = $result->fetch_assoc();
        
        // Simple string comparison for standard setup. 
        // Use password_verify() later if you choose to hash passwords.
        if ($password === $row['password']) {
            $_SESSION['user_id'] = $row['id'];
            $_SESSION['student_id'] = $student_id;
            $_SESSION['name'] = $row['full_name'];
            
            echo json_encode(["status" => "success"]);
            exit;
        }
    }
    
    echo json_encode(["status" => "error", "message" => "Invalid Student ID or Password."]);
}
?>
