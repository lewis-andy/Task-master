<?php
// Include database connection
include "config.php";

// Retrieve tasks from the database
$sql = "SELECT * FROM tasks";
$stmt = $pdo->query($sql);
$tasks = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>View Tasks</title>
    <style>
        .task-container {
            border: 1px solid #ccc;
            border-radius: 5px;
            margin-bottom: 10px;
            padding: 10px;
        }
        .task-info {
            font-weight: bold;
            margin-bottom: 5px;
        }
        .task-actions {
            margin-top: 10px;
        }
        .task-actions a {
            margin-right: 10px;
            text-decoration: none;
            color: blue;
        }
        .task-actions a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
<h1>View Tasks</h1>
<a href="create.php">Create New Task</a>
<div class="task-list">
    <?php if (!empty($tasks)): ?>
        <?php foreach ($tasks as $task): ?>
            <div class="task-container">
                <div class="task-info">Task ID: <?php echo $task['id']; ?></div>
                <div class="task-info">Category: <?php echo $task['category']; ?></div>
                <div class="task-info">Priority: <?php echo $task['priority']; ?></div>
                <div class="task-info">Task Name: <?php echo $task['task_name']; ?></div>
                <div class="task-info">Description: <?php echo $task['description']; ?></div>
                <div class="task-info">Due Date: <?php echo $task['due_date']; ?></div>
                <div class="task-info">Status: <?php echo $task['status']; ?></div>
                <div class="task-info">Assigned User: <?php echo $task['assigned_user']; ?></div>
                <div class="task-info">Estimated Time: <?php echo $task['estimated_time']; ?></div>
                <div class="task-actions">
                    <a href="edit_task.php?id=<?php echo $task['id']; ?>">Edit</a>
                    <a href="view_tasks.php?delete=<?php echo $task['id']; ?>" onclick="return confirm('Are you sure you want to delete this task?')">Delete</a>
                </div>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <p>No tasks found.</p>
    <?php endif; ?>
</div>
</body>
</html>
