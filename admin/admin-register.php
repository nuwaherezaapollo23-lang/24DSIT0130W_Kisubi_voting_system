<?php
session_start();
include '../include/config.php';

if(isset($_POST['register'])){

$username = trim($_POST['username']);
$password = password_hash($_POST['password'], PASSWORD_DEFAULT);

/* Check if username exists */
$check = mysqli_query($con,"SELECT username FROM admin WHERE username='$username'");

if(mysqli_num_rows($check) > 0){

$error = "⚠️ Username already exists";

}else{

$stmt = mysqli_prepare($con,"INSERT INTO admin (username,password) VALUES (?,?)");

mysqli_stmt_bind_param($stmt,"ss",$username,$password);

if(mysqli_stmt_execute($stmt)){

$success = "✅ Admin registered successfully";

}else{

$error = "Registration failed";

}

}

}
?>

<!DOCTYPE html>
<html lang="en">

<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">

<title>Admin Register</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

<style>

body{
background:#f4f6f9;
}

.card-box{
max-width:420px;
margin:80px auto;
padding:30px;
border-radius:10px;
box-shadow:0 4px 15px rgba(0,0,0,0.2);
background:white;
}

</style>

</head>

<body>

<div class="card-box">

<h4 class="text-center mb-4">Admin Registration</h4>

<?php if(isset($error)){ ?>
<div class="alert alert-danger"><?php echo $error; ?></div>
<?php } ?>

<?php if(isset($success)){ ?>
<div class="alert alert-success"><?php echo $success; ?></div>
<?php } ?>

<form method="POST">

<div class="mb-3">
<label>Username</label>
<input type="text" name="username" class="form-control" required>
</div>

<div class="mb-3">
<label>Password</label>
<input type="password" name="password" class="form-control" required>
</div>

<button name="register" class="btn btn-success w-100">
Register Admin
</button>

<div class="text-center mt-3">
<a href="index.php">Already have account? Login</a>
</div>

</form>

</div>

</body>
</html>