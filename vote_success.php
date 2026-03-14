<?php
session_start();
include 'include/config.php';

if(!isset($_SESSION['voter_id'])){
    header("Location: index.php");
    exit();
}

$voter_id = intval($_SESSION['voter_id']);

/* CHECK IF USER ALREADY VOTED */
$check = mysqli_query($con,"SELECT name,voted FROM voters WHERE voter_id='$voter_id'");
$row = mysqli_fetch_assoc($check);

if($row['voted'] == 0){
    // Voter hasn't voted yet → redirect to vote page
    header("Location: vote.php");
    exit();
}

$voter_name = htmlspecialchars($row['name']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Vote Completed</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<style>
body {
    background: linear-gradient(135deg, #6f42c1, #0d6efd);
    height: 100vh;
    display: flex;
    align-items: center;
    justify-content: center;
    font-family: 'Segoe UI', sans-serif;
}
.success-card {
    background: #fff;
    border-radius: 15px;
    padding: 40px 30px;
    max-width: 600px;
    text-align: center;
    box-shadow: 0 8px 30px rgba(0,0,0,0.3);
}
.success-card h1 {
    font-size: 48px;
    color: #28a745;
}
.success-card h3 {
    margin-top: 15px;
    font-weight: 500;
    color: #333;
}
.success-card p {
    font-size: 18px;
    color: #555;
    margin-top: 20px;
}
.success-card .btn-home {
    margin-top: 30px;
    font-size: 18px;
    padding: 12px 35px;
    border-radius: 50px;
}
</style>
</head>
<body>

<div class="success-card">
    <h1>🎉 Congratulations!</h1>
    <h3>Hello <?php echo $voter_name; ?>,</h3>
    <p>You have successfully completed your vote.<br>
    Please wait patiently for the election results, which will be announced soon.</p>
    <a href="logout.php" class="btn btn-primary btn-home">Logout</a>
</div>

</body>
</html>