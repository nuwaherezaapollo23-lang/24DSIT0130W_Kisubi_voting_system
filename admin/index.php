<?php
session_start();
include '../include/config.php';

if(isset($_POST['login'])){

$username = trim($_POST['username']);
$password = $_POST['password'];

$stmt = mysqli_prepare($con,"SELECT * FROM admin WHERE username=?");

mysqli_stmt_bind_param($stmt,"s",$username);
mysqli_stmt_execute($stmt);

$result = mysqli_stmt_get_result($stmt);

if(mysqli_num_rows($result) > 0){

$row = mysqli_fetch_assoc($result);

if(password_verify($password,$row['password'])){

$_SESSION['admin_id'] = $row['admin_id'];
$_SESSION['admin_name'] = $row['username'];

header("Location: results.php");
exit();

}else{

$error = "⚠️ Incorrect password";

}

}else{

$error = "⚠️ Admin not found";

}

}
?>

<!DOCTYPE html>
<html lang="en">

<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">

<title>Admin Login</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

<style>

body{
background:linear-gradient(135deg,#343a40,#0d6efd);
height:100vh;
display:flex;
align-items:center;
justify-content:center;
}

.login-box{
width:420px;
background:white;
padding:30px;
border-radius:10px;
box-shadow:0 6px 20px rgba(0,0,0,0.25);
}

</style>

</head>

<body>

<div class="login-box">

<h4 class="text-center mb-4">Admin Login</h4>

<?php if(isset($error)){ ?>
<div class="alert alert-danger"><?php echo $error; ?></div>
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

<button name="login" class="btn btn-primary w-100">
Login
</button>

<div class="text-center mt-3">
<a href="admin-register.php">Create Admin Account</a>
</div>

</form>

</div>

</body>
</html>