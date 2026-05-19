<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: index.html");
    exit;
}

include('config.php');

// Fetch complete logged-in student details
$stmt = $conn->prepare("SELECT * FROM students WHERE id = ?");
$stmt->bind_param("i", $_SESSION['user_id']);
$stmt->execute();
$student = $stmt->get_result()->fetch_assoc();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Dashboard</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <nav class="navbar">
        <div class="nav-brand">Campus Portal</div>
        <div class="user-info">
            <span>Welcome, <strong><?php echo htmlspecialchars($student['full_name']); ?></strong></span>
            <a href="logout.php" class="logout-link">Logout</a>
        </div>
    </nav>

    <div class="dashboard-container">
        <aside class="sidebar">
            <ul>
                <li><a href="#" class="active">Overview</a></li>
                <li><a href="#" onclick="alert('Grades module coming soon!')">Academic Records</a></li>
                <li><a href="#" onclick="alert('Enrollment module coming soon!')">Enrolled Classes</a></li>
                <li><a href="#" onclick="alert('Settings module coming soon!')">Account Settings</a></li>
            </ul>
        </aside>

        <main class="main-content">
            <h2>Dashboard Overview</h2>
            
            <div class="card-grid">
                <div class="card">
                    <h3>Student Info</h3>
                    <p><strong>ID:</strong> <?php echo htmlspecialchars($student['student_id']); ?></p>
                    <p><strong>Course:</strong> <?php echo htmlspecialchars($student['course']); ?></p>
                    <p><strong>Year Level:</strong> <?php echo htmlspecialchars($student['year_level']); ?>rd Year</p>
                </div>

                <div class="card Highlight-card">
                    <h3>Academic Standing</h3>
                    <div class="gpa-display">
                        <span class="gpa-num"><?php echo htmlspecialchars($student['gpa']); ?></span>
                        <span class="gpa-label">Current GPA</span>
                    </div>
                </div>

                <div class="card">
                    <h3>System Messages</h3>
                    <p class="notice">✓ Midterm examinations schedule has been posted.</p>
                    <p class="notice">✓ Please clear any outstanding balances before enrollment ends.</p>
                </div>
            </div>
        </main>
    </div>
</body>
</html>