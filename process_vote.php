<?php
session_start();
include("include/config.php");

if(!isset($_SESSION['voter_id'])){
    die("You must be logged in to vote.");
}

$voter_id = intval($_SESSION['voter_id']);

/* check if already voted */
$check = mysqli_query($con,"SELECT voted FROM voters WHERE voter_id='$voter_id'");
$row = mysqli_fetch_assoc($check);

if($row['voted'] == 1){
    die("You have already voted.");
}

/* get all positions */
$positions = mysqli_query($con,"SELECT * FROM positions");

while($pos = mysqli_fetch_assoc($positions)){

    $position_id = $pos['position_id'];

    if(isset($_POST["position_$position_id"])){

        $candidate_id = intval($_POST["position_$position_id"]);

        /* verify candidate exists */
        $checkCandidate = mysqli_query($con,
        "SELECT * FROM candidates 
        WHERE candidate_id='$candidate_id' 
        AND position_id='$position_id'");

        if(mysqli_num_rows($checkCandidate) > 0){

            /* insert vote */
            mysqli_query($con,
            "INSERT INTO votes (voter_id,candidate_id,position_id)
            VALUES ('$voter_id','$candidate_id','$position_id')");

            /* update candidate votes */
            mysqli_query($con,
            "UPDATE candidates 
            SET votes = votes + 1 
            WHERE candidate_id='$candidate_id'");
        }
    }
}

/* mark voter as voted */
mysqli_query($con,"UPDATE voters SET voted=1 WHERE voter_id='$voter_id'");

/* redirect to results */
header("Location: vote_success.php");
exit();
?>