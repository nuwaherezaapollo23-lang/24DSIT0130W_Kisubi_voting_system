<?php
session_start();
include '../include/config.php';

if(isset($_POST['add'])){

$name=$_POST['name'];
$reg=$_POST['reg'];
$faculty=$_POST['faculty'];
$position=$_POST['position'];

mysqli_query($con,"INSERT INTO candidates(name,reg_no,faculty,position_id) 
VALUES('$name','$reg','$faculty','$position')");

$success="Candidate added";

}
?>

<!DOCTYPE html>
<html>
<head>

<title>Add Candidate</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

</head>

<body>

<div class="container mt-5">

<h4>Add Candidate</h4>

<?php if(isset($success)){ ?>
<div class="alert alert-success"><?php echo $success; ?></div>
<?php } ?>

<form method="POST">

<input type="text" name="name" class="form-control mb-3" placeholder="Candidate name" required>

<input type="text" name="reg" class="form-control mb-3" placeholder="Registration number" required>

<input type="text" name="faculty" class="form-control mb-3" placeholder="Faculty" required>

<select name="position" class="form-control mb-3">

<?php
$pos=mysqli_query($con,"SELECT * FROM positions");
while($p=mysqli_fetch_assoc($pos)){
?>

<option value="<?php echo $p['position_id']; ?>">
<?php echo $p['position_name']; ?>
</option>

<?php } ?>

</select>

<button name="add" class="btn btn-success">Add Candidate</button>

</form>

</div>

</body>
</html>