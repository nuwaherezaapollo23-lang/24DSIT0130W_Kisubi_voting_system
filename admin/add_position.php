<?php
session_start();
include '../include/config.php';

if(isset($_POST['add'])){

$position=$_POST['position'];

mysqli_query($con,"INSERT INTO positions(position_name) VALUES('$position')");

$success="Position added successfully";

}
?>

<!DOCTYPE html>
<html>
<head>

<title>Add Position</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

</head>

<body>

<div class="container mt-5">

<h4>Add Position</h4>

<?php if(isset($success)){ ?>
<div class="alert alert-success"><?php echo $success; ?></div>
<?php } ?>

<form method="POST">

<input type="text" name="position" class="form-control mb-3" placeholder="Position name" required>

<button name="add" class="btn btn-primary">Add Position</button>

</form>

</div>

</body>
</html>