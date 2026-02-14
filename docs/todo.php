<?php 
include "server.php";
session_start();

mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

if (!isset($_SESSION["username"])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION["id"];

# ADD TASK
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add_task'])) {
    try {
        $task = $_POST['task_content'];

        $stmt = $conn->prepare("INSERT INTO tasks (uid, task) VALUES (?, ?)");
        $stmt->bind_param("is", $user_id, $task);
        $stmt->execute();

        header("Location: todo.php");
        exit();

    } catch (Exception $e) {
        echo "<script>alert('Failed to add task');</script>";
    }
}

# delete button
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['delete'])) {
    try {
        $id = $_POST['id'];

        $stmt = $conn->prepare("DELETE FROM tasks WHERE id=? AND uid=?");
        $stmt->bind_param("ii", $id, $user_id);
        $stmt->execute();

        header("Location: todo.php");
        exit();

    } catch (Exception $e) {
        echo "<script>alert('Deletion Failed');</script>";
    }
}


    $stmt = $conn->prepare("SELECT * FROM tasks WHERE uid=? ORDER BY id DESC");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();

?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" href="todo.css">
<title>Todo List</title>
</head>
<body>

<nav>
<h1>Welcome <?php echo htmlspecialchars($_SESSION["username"]); ?> </h1>

<form action="Login.php" method="post" >
        <button type="submit" class="logout">Logout</button>
</form>

</nav>
<form method="post" class="task-form">
    <input type="text" name="task_content" placeholder="Enter a new task" required> 
    <input type="submit" name="add_task" value="Add Task" >
</form>


<div class="task-container">
<h2>Your Tasks</h2>

<?php while($row = $result->fetch_assoc()) { ?>
    <div class="task">
        <p class="trow"><?php echo htmlspecialchars($row['task']);?></p>
        <form method="post" >
        <form method="post">
            <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
            <button type="submit" name="delete" class="delete">Delete</button>
        </form>
</form>
    </div>
<?php } ?>
</div>


</body>
</html>
