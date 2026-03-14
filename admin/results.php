<?php
session_start();
if(!isset($_SESSION['admin_id'])) header("Location: index.php");
include '../include/header.php'; 
include '../include/config.php';

// Fetch positions
$positions_result = mysqli_query($con, "SELECT * FROM positions");
?>
<center><h2>Voting Results</h2></center>
<?php while($pos = mysqli_fetch_assoc($positions_result)): ?>
    <h3><?php echo $pos['position_name']; ?></h3>

    <?php
    $stmt = mysqli_prepare($con, "SELECT name, votes FROM candidates WHERE position_id=?");
    mysqli_stmt_bind_param($stmt, "i", $pos['position_id']);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $names = $votes_data = [];
    while($row = mysqli_fetch_assoc($result)){
        $names[] = $row['name'];
        $votes_data[] = $row['votes'];
    }
    mysqli_stmt_close($stmt);
    ?>

    <canvas id="chart<?php echo $pos['position_id']; ?>"></canvas>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const ctx = document.getElementById('chart<?php echo $pos['position_id']; ?>').getContext('2d');
        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: <?php echo json_encode($names); ?>,
                datasets: [{
                    label: 'Votes',
                    data: <?php echo json_encode($votes_data); ?>,
                    backgroundColor: 'rgba(54, 162, 235, 0.6)'
                }]
            }
        });
    </script>
<?php endwhile; ?>