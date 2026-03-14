<?php
session_start();
include 'include/config.php';

/* FUNCTION TO GENERATE UNIQUE REG NUMBER */
function generateRegNo($con){

    do{

        $digits = rand(1000,9999);

        $characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $letters = '';

        for($i=0; $i<3; $i++){
            $letters .= $characters[rand(0,25)];
        }

        $reg_no = "UNIK".$digits.$letters;

        $check = mysqli_query($con,"SELECT reg_no FROM voters WHERE reg_no='$reg_no'");

    } while(mysqli_num_rows($check) > 0);

    return $reg_no;
}

/* Generate reg number for display */
$generated_reg = generateRegNo($con);


if(isset($_POST['register'])){

$reg_no = $_POST['reg_no'];
$name = $_POST['name'];
$email = $_POST['email'];
$gender = $_POST['gender'];
$password = password_hash($_POST['password'], PASSWORD_DEFAULT);

/* CHECK IF EMAIL EXISTS */
$checkEmail = mysqli_query($con,"SELECT email FROM voters WHERE email='$email'");

if(mysqli_num_rows($checkEmail) > 0){

$error = "⚠️ This email is already registered. Please login instead.";

}else{

$stmt = mysqli_prepare($con,"INSERT INTO voters (reg_no,name,password,gender,email) VALUES (?,?,?,?,?)");

mysqli_stmt_bind_param($stmt,"sssss",$reg_no,$name,$password,$gender,$email);

if(mysqli_stmt_execute($stmt)){

$success = "✅ Registration successful! Your Registration Number is <b>$reg_no</b>. Please save it to login.";

}else{

$error = "Registration failed. Please try again.";

}

mysqli_stmt_close($stmt);

}

}
?>

<!doctype html>
<html lang="en">

<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">

<title>Voter Registration</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

<style>

body{
background:#f8f9fa;
}

.register-card{
max-width:500px;
margin:60px auto;
padding:30px;
background:#fff;
border-radius:10px;
box-shadow:0 4px 15px rgba(0,0,0,0.2);
}

/* Custom alerts */

.error-box{
background:#ffe6e6;
color:#b30000;
padding:12px 15px;
border-left:5px solid #ff4d4d;
border-radius:5px;
font-size:14px;
margin-bottom:15px;
}

.success-box{
background:#e6fff0;
color:#006633;
padding:12px 15px;
border-left:5px solid #00cc66;
border-radius:5px;
font-size:14px;
margin-bottom:15px;
}

</style>

</head>

<body>

<div class="register-card">

<h3 class="text-center mb-4">Voter Registration</h3>

<?php if(isset($error)){ ?>
<div class="error-box">
<?php echo $error; ?>
</div>
<?php } ?>

<?php if(isset($success)){ ?>
<div class="success-box">
<?php echo $success; ?>
</div>
<?php } ?>

<form method="POST">

<div class="mb-3">
<label class="form-label">Registration Number</label>

<input 
type="text"
name="reg_no"
class="form-control"
value="<?php echo $generated_reg; ?>"
placeholder="This is your login ID. Save it carefully."
readonly>

<div class="form-text text-danger">
⚠️ Please save this Registration Number. You will use it to login and vote.
</div>

</div>

<div class="mb-3">
<label class="form-label">Full Name</label>
<input type="text" name="name" class="form-control" placeholder="Enter full name" required>
</div>

<div class="mb-3">
<label class="form-label">Email</label>
<input type="email" name="email" class="form-control" placeholder="Enter email address" required>
</div>

<div class="mb-3">
<label class="form-label">Gender</label>

<select name="gender" class="form-control" required>

<option value="">Select Gender</option>
<option value="Male">Male</option>
<option value="Female">Female</option>

</select>

</div>

<div class="mb-3">
<label class="form-label">Password</label>
<input type="password" name="password" class="form-control" placeholder="Enter password" required>
</div>

<button type="submit" name="register" class="btn btn-success w-100">
Register
</button>

<div class="text-center mt-3">
Already registered?
<a href="index.php">Login here</a>
</div>

</form>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>