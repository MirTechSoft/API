<?php
// DB Connection
include 'config.php';

// Get ID from URL
if (!isset($_GET['id']) || empty($_GET['id'])) {
    echo "<h2>❗ No student ID provided.</h2>";
    exit();
}

$id = $_GET['id'];

// Fetch student details
$stmt = $conn->prepare("SELECT * FROM students WHERE id = :id");
$stmt->bindParam(':id', $id, PDO::PARAM_INT);
$stmt->execute();
$student = $stmt->fetch(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Student Profile</title>
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background-color: #f8f9fa;
            padding: 30px;
        }

        .card {
            max-width: 500px;
            margin: auto;
            background: white;
            border-radius: 12px;
            padding: 30px;
            box-shadow: 0 0 12px rgba(0, 0, 0, 0.1);
        }

        .card h2 {
            margin-top: 0;
            color: #007bff;
        }

        .info {
            margin: 15px 0;
            font-size: 18px;
        }

        .back-link {
            display: inline-block;
            margin-top: 20px;
            text-decoration: none;
            color: #007bff;
            font-weight: bold;
        }

        .back-link:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="card">
        <?php if ($student): ?>
            <h2>Student Profile</h2>
            <div class="info"><strong>ID:</strong> <?= htmlspecialchars($student['id']) ?></div>
            <div class="info"><strong>Name:</strong> <?= htmlspecialchars($student['name']) ?></div>
            <div class="info"><strong>Email:</strong> <?= htmlspecialchars($student['email']) ?></div>
        <?php else: ?>
            <h2>❌ Student not found.</h2>
        <?php endif; ?>
        <a class="back-link" href="index.html">← Back to Form</a>
    </div>
</body>
</html>
