<?php
include "config.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $category = $_POST['category'];
    $priority = $_POST['priority'];
    $task_name = $_POST['task_name'];
    $description = $_POST['description'];
    $due_date = $_POST['due_date'];
    $status = isset($_POST['status']) ? $_POST['status'] : null; // Check if status is set
    $assigned_user = isset($_POST['assigned_user']) ? $_POST['assigned_user'] : null; // Check if assigned_user is set
    $estimated_time = isset($_POST['estimated_time']) ? $_POST['estimated_time'] : null; // Check if estimated_time is set

    $errors = [];
    if (empty($category) || empty($priority) || empty($task_name)) {
        $errors[] = "Category, priority, and task name are required fields.";
    }

    if (!empty($errors)) {
        foreach ($errors as $error) {
            echo "<p>Error: $error</p>";
        }
        echo "<a href='create.php'>Go back to create task page</a>";
        exit();
    }

    $sql = "INSERT INTO tasks (category, priority, task_name, description, due_date, status, assigned_user, estimated_time)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $pdo->prepare($sql);
    if ($stmt->execute([$category, $priority, $task_name, $description, $due_date, $status, $assigned_user, $estimated_time])) {
        header("Location: view_tasks.php");
        exit();
    } else {
        echo "Error: Unable to create task.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Create Task</title>
</head>
<body>
<h1>Create Task</h1>
<form action="create.php" method="post">
    <label for="category">Category:</label><br>
    <input type="text" id="category" name="category" required><br>
    <label for="priority">Priority:</label><br>
    <select id="priority" name="priority" required>
        <option value="Low">Low</option>
        <option value="Medium">Medium</option>
        <option value="High">High</option>
    </select><br>
    <label for="task_name">Task Name:</label><br>
    <input type="text" id="task_name" name="task_name" required><br>
    <label for="description">Description:</label><br>
    <textarea id="description" name="description"></textarea><br>
    <label for="due_date">Due Date:</label><br>
    <input type="date" id="due_date" name="due_date"><br>
    <label for="status">Status:</label><br>
    <input type="text" id="status" name="status"><br> <!-- Adjust this input type as needed -->
    <label for="assigned_user">Assigned User:</label><br>
    <input type="text" id="assigned_user" name="assigned_user"><br>
    <label for="estimated_time">Estimated Time:</label><br>
    <input type="text" id="estimated_time" name="estimated_time"><br> <!-- Adjust this input type as needed -->
    <button type="submit">Create Task</button>
</form>
</body>
</html>
