<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
header("Content-Type: application/json");

include 'config.php';

// ✅ POST: Add new student from HTML form
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['name']) && isset($_POST['email'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];

    $stmt = $conn->prepare("INSERT INTO students (name, email) VALUES (:name, :email)");
    $stmt->bindParam(':name', $name);
    $stmt->bindParam(':email', $email);

    if ($stmt->execute()) {
        $lastId = $conn->lastInsertId();
        // Redirect for form submission
        header("Location: student-profile.php?id=$lastId");
        exit();
    } else {
        echo json_encode(['message' => '❌ Failed to add student']);
    }
}

// ✅ GET: Fetch all students (for table view)
elseif ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $stmt = $conn->prepare("SELECT * FROM students");
    $stmt->execute();
    $students = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode($students);
}

// ✅ PUT: Update student (via API/AJAX)
elseif ($_SERVER['REQUEST_METHOD'] === 'PUT') {
    $data = json_decode(file_get_contents("php://input"), true);

    if (isset($data['id'], $data['name'], $data['email'])) {
        $stmt = $conn->prepare("UPDATE students SET name = :name, email = :email WHERE id = :id");
        $stmt->bindParam(':name', $data['name']);
        $stmt->bindParam(':email', $data['email']);
        $stmt->bindParam(':id', $data['id']);

        if ($stmt->execute()) {
            echo json_encode(['message' => '✅ Student updated successfully']);
        } else {
            echo json_encode(['message' => '❌ Failed to update student']);
        }
    } else {
        echo json_encode(['message' => '❗ Invalid update data']);
    }
}

// ✅ DELETE: Delete student (via API/AJAX)
elseif ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
    $data = json_decode(file_get_contents("php://input"), true);

    if (isset($data['id'])) {
        $stmt = $conn->prepare("DELETE FROM students WHERE id = :id");
        $stmt->bindParam(':id', $data['id']);

        if ($stmt->execute()) {
            echo json_encode(['message' => '✅ Student deleted successfully']);
        } else {
            echo json_encode(['message' => '❌ Failed to delete student']);
        }
    } else {
        echo json_encode(['message' => '❗ Invalid delete request']);
    }
}
?>


