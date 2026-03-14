<?php 
include 'include/header.php'; 
include 'include/config.php'; ?>

<?php
$voters = mysqli_fetch_row(mysqli_query($con, "SELECT COUNT(*) FROM voters"))[0];
$candidates = mysqli_fetch_row(mysqli_query($con, "SELECT COUNT(*) FROM candidates"))[0];
$positions = mysqli_fetch_row(mysqli_query($con, "SELECT COUNT(*) FROM positions"))[0];
$votes = mysqli_fetch_row(mysqli_query($con, "SELECT COUNT(*) FROM votes"))[0];
?>

<div class="row text-center">
  <div class="col-md-3 mb-3"><div class="card p-3 bg-primary text-white">Voters<br><?php echo $voters; ?></div></div>
  <div class="col-md-3 mb-3"><div class="card p-3 bg-success text-white">Candidates<br><?php echo $candidates; ?></div></div>
  <div class="col-md-3 mb-3"><div class="card p-3 bg-warning text-dark">Positions<br><?php echo $positions; ?></div></div>
  <div class="col-md-3 mb-3"><div class="card p-3 bg-info text-white">Votes<br><?php echo $votes; ?></div></div>
</div>

<?php include 'include/footer.php'; ?>