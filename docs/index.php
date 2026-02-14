<?php 
include "server.php";   
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Todo sign in page</title>
</head>
<body>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <h1>Sign In</h1>
<label for="username">Username:</label> <input type="text" id="username" name="username" required> 
<label for="password">Password:</label> <input type="password" id="password" name="password" required>
<input type="submit" value="Sign In" class="btn">
<input type="button" value="Already have an account? Login" class="login" onclick="window.location.href='Login.php'">
    </form>
</body>
</html>

<?php
 
 if($_SERVER["REQUEST_METHOD"]== "POST")
 {
    $username = filter_input(INPUT_POST, "username", FILTER_SANITIZE_SPECIAL_CHARS);
    $password = filter_input(INPUT_POST,"password", FILTER_SANITIZE_SPECIAL_CHARS);
    $hash=password_hash($password, PASSWORD_DEFAULT);

    $sql = "INSERT INTO `users`(`name`, `passwords`) VALUES ('$username','$hash')";

    try{
        mysqli_query($conn, $sql);
        header("Location: Login.php");
    }
    catch(mysqli_sql_exception){
        echo "<script>alert('Registration failed');</script>";
    }
 }

?>