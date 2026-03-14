<?php
session_start();
include '../include/config.php';
include '../include/header.php';

/* --- Handle Add/Update/Delete before any HTML --- */
if(isset($_POST['add_candidate'])){
    $name = mysqli_real_escape_string($con, $_POST['name']);
    $reg_no = mysqli_real_escape_string($con, $_POST['reg_no']);
    $faculty = mysqli_real_escape_string($con, $_POST['faculty']);
    $position_id = intval($_POST['position_id']);
    mysqli_query($con, "INSERT INTO candidates(name, reg_no, faculty, position_id) VALUES('$name','$reg_no','$faculty',$position_id)");
    header("Location: candidates.php");
    exit();
}

if(isset($_POST['update_candidate'])){
    $id = intval($_POST['candidate_id']);
    $name = mysqli_real_escape_string($con, $_POST['name']);
    $reg_no = mysqli_real_escape_string($con, $_POST['reg_no']);
    $faculty = mysqli_real_escape_string($con, $_POST['faculty']);
    $position_id = intval($_POST['position_id']);
    mysqli_query($con, "UPDATE candidates SET name='$name', reg_no='$reg_no', faculty='$faculty', position_id=$position_id WHERE candidate_id=$id");
    header("Location: candidates.php");
    exit();
}

if(isset($_GET['delete'])){
    $id = intval($_GET['delete']);
    mysqli_query($con, "DELETE FROM candidates WHERE candidate_id=$id");
    header("Location: candidates.php");
    exit();
}

/* --- Fetch positions and candidates for display --- */
$positions_result = mysqli_query($con, "SELECT * FROM positions");
$positions = [];
while($pos = mysqli_fetch_assoc($positions_result)){
    $positions[$pos['position_id']] = $pos['position_name'];
}

$candidates_result = mysqli_query($con, "SELECT * FROM candidates");
?>

<h2>Manage Candidates</h2>
<button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#addCandidateModal">Add Candidate</button>

<table class="table table-bordered">
    <thead>
        <tr>
            <th>#</th>
            <th>Name</th>
            <th>Reg No</th>
            <th>Faculty</th>
            <th>Position</th>
            <th>Votes</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
    <?php
    $sno=1;
    while($row = mysqli_fetch_assoc($candidates_result)){
        echo "<tr>
            <td>{$sno}</td>
            <td>{$row['name']}</td>
            <td>{$row['reg_no']}</td>
            <td>{$row['faculty']}</td>
            <td>{$positions[$row['position_id']]}</td>
            <td>{$row['votes']}</td>
            <td>
                <button class='btn btn-sm btn-success' data-bs-toggle='modal' data-bs-target='#editCandidateModal{$row['candidate_id']}'>Edit</button>
                <a href='candidates.php?delete={$row['candidate_id']}' class='btn btn-sm btn-danger'>Delete</a>
            </td>
        </tr>";
        $sno++;
        // Edit Modal
        echo "
        <div class='modal fade' id='editCandidateModal{$row['candidate_id']}' tabindex='-1'>
        <div class='modal-dialog'><div class='modal-content'>
        <form method='POST'>
            <div class='modal-header'><h5 class='modal-title'>Edit Candidate</h5></div>
            <div class='modal-body'>
                <input type='hidden' name='candidate_id' value='{$row['candidate_id']}'>
                <input type='text' name='name' class='form-control mb-2' value='{$row['name']}' required>
                <input type='text' name='reg_no' class='form-control mb-2' value='{$row['reg_no']}' required>
                <input type='text' name='faculty' class='form-control mb-2' value='{$row['faculty']}' required>
                <select name='position_id' class='form-control' required>";
                foreach($positions as $id => $pname){
                    $selected = ($id == $row['position_id']) ? "selected" : "";
                    echo "<option value='$id' $selected>$pname</option>";
                }
                echo "</select>
            </div>
            <div class='modal-footer'>
                <button type='button' class='btn btn-secondary' data-bs-dismiss='modal'>Close</button>
                <button type='submit' name='update_candidate' class='btn btn-success'>Update</button>
            </div>
        </form></div></div></div>";
    }
    ?>
    </tbody>
</table>

<!-- Add Candidate Modal -->
<div class="modal fade" id="addCandidateModal" tabindex="-1">
<div class="modal-dialog"><div class="modal-content">
<form method="POST">
    <div class="modal-header"><h5 class="modal-title">Add Candidate</h5></div>
    <div class="modal-body">
        <input type="text" name="name" class="form-control mb-2" placeholder="Name" required>
        <input type="text" name="reg_no" class="form-control mb-2" placeholder="Reg No" required>
        <input type="text" name="faculty" class="form-control mb-2" placeholder="Faculty" required>
        <select name="position_id" class="form-control" required>
            <option value="">Select Position</option>
            <?php foreach($positions as $id => $pname) echo "<option value='$id'>$pname</option>"; ?>
        </select>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="submit" name="add_candidate" class="btn btn-primary">Add</button>
    </div>
</form></div></div></div>

<?php include '../include/footer.php'; ?>