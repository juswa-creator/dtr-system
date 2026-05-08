<?php 
include 'config.php';
session_start();
?>

<link rel="stylesheet" href="style.css">

<div class="login-wrapper">
    <div class="login-box">
        <h2>Login</h2>

        <form method="POST">
            <input type="text" name="username" placeholder="Username" required>
            <input type="password" name="password" placeholder="Password" required>

            <select name="role">
                <option value="admin">Admin</option>
                <option value="employee">Employee</option>
                <option value="ojt">OJT</option>
            </select>

            <button name="login">Log in</button>
        </form>

        <?php
        if(isset($_POST['login'])){
            $username = $conn->real_escape_string($_POST['username']);
            $password = $_POST['password'];
            $role = $conn->real_escape_string($_POST['role']);

            $query = $conn->query("SELECT * FROM users WHERE username='$username' AND role='$role'");
            $user = $query->fetch_assoc();

            if($user && $password == $user['password']){
                $_SESSION['user'] = $user;

                if($role == 'admin'){
                    header("Location: admin.php");
                } else {
                    header("Location: user.php");
                }
                exit();
            } else {
                echo "<p class='error'>Invalid login</p>";
            }
        }
        ?>
    </div>
</div>