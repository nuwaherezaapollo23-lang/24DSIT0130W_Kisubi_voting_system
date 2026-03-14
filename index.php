<?php
session_start();
include 'include/config.php';

if(isset($_POST['login'])){

$reg_no = trim($_POST['reg_no']);
$password = trim($_POST['password']);

$stmt = mysqli_prepare($con,"SELECT voter_id,name,password,voted FROM voters WHERE reg_no=?");

mysqli_stmt_bind_param($stmt,"s",$reg_no);
mysqli_stmt_execute($stmt);

$result = mysqli_stmt_get_result($stmt);

if(mysqli_num_rows($result) > 0){

$row = mysqli_fetch_assoc($result);

if(password_verify($password,$row['password'])){

/* CHECK IF ALREADY VOTED */
if($row['voted'] == 1){

$finished = "✅ You have finished voting. No need to login again.";

}else{

$_SESSION['voter_id'] = $row['voter_id'];
$_SESSION['name'] = $row['name'];

header("Location: vote.php");
exit();

}

}else{

$error = "⚠️ Incorrect password";

}

}else{

$error = "⚠️ Registration number not found";

}

mysqli_stmt_close($stmt);

}
?>

<!doctype html>
<html lang="en">

<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">

<title>Voter Login</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

<style>

body{
background:linear-gradient(135deg,#0d6efd,#6f42c1);
height:100vh;
display:flex;
align-items:center;
justify-content:center;
}

.login-card{
width:420px;
background:#fff;
padding:30px;
border-radius:10px;
box-shadow:0 6px 20px rgba(0,0,0,0.25);
}

.error-box{
background:#ffe6e6;
color:#b30000;
padding:12px 15px;
border-left:5px solid #ff4d4d;
border-radius:5px;
font-size:14px;
margin-bottom:15px;
}

</style>

</head>

<body>

<div class="login-card">

<h3 class="text-center mb-4">Voter Login</h3>

<?php if(isset($error)){ ?>
<div class="alert alert-danger">
<?php echo $error; ?>
</div>
<?php } ?>

<?php if(isset($finished)){ ?>
<div class="alert alert-success text-center">
<?php echo $finished; ?>
</div>
<?php } ?>

<?php if(!isset($finished)){ ?>

<form method="POST">

<div class="mb-3">
<label class="form-label">Registration Number</label>
<input type="text" name="reg_no" class="form-control" placeholder="Enter your registration number" required>
</div>

<div class="mb-3">
<label class="form-label">Password</label>
<input type="password" name="password" class="form-control" placeholder="Enter your password" required>
</div>

<button type="submit" name="login" class="btn btn-primary w-100">
Login
</button>

<div class="text-center mt-3">
Not registered?
<a href="register.php">Register here</a>
</div>

</form>

<?php } ?>

</div>

</body>
</html>