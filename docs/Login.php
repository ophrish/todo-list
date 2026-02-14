<?php 
include "server.php";   
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Todo Login In Page</title>
</head>
<body>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <h1>Login In</h1>
<label for="username">Username:</label> <input type="text" id="username" name="username" required> 
<label for="password">Password:</label> <input type="password" id="password" name="password" required>
<input type="submit" value="Login" class="btn">
<input type="button" value="Don't have an account? Sign Up" class="login" onclick="window.location.href='index.php'">
    </form>
</body>
</html>

<?php
 
 if($_SERVER["REQUEST_METHOD"]=="POST"){
    $username = filter_input(INPUT_POST, "username", FILTER_SANITIZE_SPECIAL_CHARS);
    $password = filter_input(INPUT_POST,"password", FILTER_SANITIZE_SPECIAL_CHARS);


    $sql = "SELECT * FROM `users` WHERE name='$username'";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);

    if(password_verify($password, $row["passwords"])){
        echo "<script>alert('Login successful');</script>";
        session_start();
        $_SESSION["username"] = $username;
        $_SESSION["id"] = $row["id"];
        header("Location: todo.php");
    }
    else{
        echo "<script>alert('Login failed');</script>";
    }
 }

?>