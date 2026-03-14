<?php
session_start();
include 'include/config.php';

if(!isset($_SESSION['voter_id'])){
    header("Location: index.php");
    exit();
}

$voter_id = intval($_SESSION['voter_id']);

/* CHECK IF USER ALREADY VOTED */
$check = mysqli_query($con,"SELECT voted FROM voters WHERE voter_id='$voter_id'");
$row = mysqli_fetch_assoc($check);

if($row['voted'] == 1){
    header("Location: results.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">

<title>Vote for Candidates</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

<style>

body{
background:#f4f6f9;
}

.card-header{
font-size:18px;
font-weight:bold;
background:#0d6efd;
color:white;
}

.vote-btn{
font-size:18px;
padding:10px 30px;
}

</style>

</head>

<body>

<div class="container mt-5">

<div class="d-flex justify-content-between mb-3">
<h2>Student Voting System</h2>
<a href="logout.php" class="btn btn-danger btn-sm">Logout</a>
</div>

<p class="text-muted">Select one candidate for each position</p>

<form action="process_vote.php" method="POST">

<?php

$positions = mysqli_query($con,"SELECT * FROM positions");

while($pos = mysqli_fetch_assoc($positions)){

$position_id = $pos['position_id'];

?>

<div class="card mb-4 shadow-sm">

<div class="card-header">
<?php echo $pos['position_name']; ?>
</div>

<div class="card-body">

<div class="table-responsive">

<table class="table table-bordered table-striped table-hover">

<thead class="table-dark">

<tr>
<th width="80">Vote</th>
<th>Candidate Name</th>
<th>Registration No</th>
<th>Faculty</th>
</tr>

</thead>

<tbody>

<?php

$candidates = mysqli_query($con,"SELECT * FROM candidates WHERE position_id='$position_id'");

if(mysqli_num_rows($candidates) == 0){

echo "<tr><td colspan='4' class='text-center text-danger'>No candidates available for this position</td></tr>";

}else{

while($cand = mysqli_fetch_assoc($candidates)){
?>

<tr>

<td class="text-center">
<input 
type="radio"
name="position_<?php echo $position_id; ?>"
value="<?php echo $cand['candidate_id']; ?>"
required>
</td>

<td><?php echo htmlspecialchars($cand['name']); ?></td>

<td><?php echo htmlspecialchars($cand['reg_no']); ?></td>

<td><?php echo htmlspecialchars($cand['faculty']); ?></td>

</tr>

<?php 
}

}
?>

</tbody>

</table>

</div>

</div>

</div>

<?php } ?>

<div class="text-center mt-4 mb-5">

<button type="submit" class="btn btn-success vote-btn">
Submit Vote
</button>

</div>

</form>

</div>

</body>
</html>