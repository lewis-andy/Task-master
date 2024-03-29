<?php
include "config.php";

// Check if task ID is provided in the URL
if (!isset($_GET['id']) || empty($_GET['id'])) {
    echo "Task ID not provided.";
    exit();
}

$task_id = $_GET['id'];

// Retrieve task details from the database
$sql = "SELECT * FROM tasks WHERE id = ?";
$stmt = $pdo->prepare($sql);
$stmt->execute([$task_id]);
$task = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$task) {
    echo "Task not found.";
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve updated task details from the form
    $category = $_POST['category'];
    $priority = $_POST['priority'];
    $task_name = $_POST['task_name'];
    $description = $_POST['description'];
    $due_date = $_POST['due_date'];
    $status = $_POST['status'];
    $assigned_user = $_POST['assigned_user'];
    $estimated_time = $_POST['estimated_time'];

    // Update task details in the database
    $sql = "UPDATE tasks SET category = ?, priority = ?, task_name = ?, description = ?, due_date = ?, status = ?, assigned_user = ?, estimated_time = ? WHERE id = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$category, $priority, $task_name, $description, $due_date, $status, $assigned_user, $estimated_time, $task_id]);

    // Redirect to view tasks page after updating
    header("Location: view_tasks.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Task</title>
</head>
<body>
<h1>Edit Task</h1>
<form action="edit_task.php?id=<?php echo $task_id; ?>" method="post">
    <!-- Display existing task details in the form -->
    <label for="category">Category:</label><br>
    <input type="text" id="category" name="category" value="<?php echo $task['category']; ?>" required><br>
    <label for="priority">Priority:</label><br>
    <select id="priority" name="priority" required>
        <option value="Low" <?php if ($task['priority'] == 'Low') echo 'selected'; ?>>Low</option>
        <option value="Medium" <?php if ($task['priority'] == 'Medium') echo 'selected'; ?>>Medium</option>
        <option value="High" <?php if ($task['priority'] == 'High') echo 'selected'; ?>>High</option>
    </select><br>
    <label for="task_name">Task Name:</label><br>
    <input type="text" id="task_name" name="task_name" value="<?php echo $task['task_name']; ?>" required><br>
    <label for="description">Description:</label><br>
    <textarea id="description" name="description"><?php echo $task['description']; ?></textarea><br>
    <label for="due_date">Due Date:</label><br>
    <input type="date" id="due_date" name="due_date" value="<?php echo $task['due_date']; ?>"><br>
    <label for="status">Status:</label><br>
    <input type="text" id="status" name="status" value="<?php echo $task['status']; ?>"><br>
    <label for="assigned_user">Assigned User:</label><br>
    <input type="text" id="assigned_user" name="assigned_user" value="<?php echo $task['assigned_user']; ?>"><br>
    <label for="estimated_time">Estimated Time:</label><br>
    <input type="text" id="estimated_time" name="estimated_time" value="<?php echo $task['estimated_time']; ?>"><br>
    <button type="submit">Update Task</button>
</form>
</body>
</html>
