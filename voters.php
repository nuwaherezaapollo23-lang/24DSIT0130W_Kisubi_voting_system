<?php
include 'include/header.php';
include 'include/config.php';
?>

<h2>Manage Voters</h2>
<button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#addVoterModal">Add Voter</button>

<table class="table table-bordered">
<thead>
<tr>
    <th>#</th>
    <th>Reg No</th>
    <th>Name</th>
    <th>Gender</th>
    <th>Email</th>
    <th>Voted</th>
    <th>Actions</th>
</tr>
</thead>
<tbody>
<?php
$SNO =1;
$result = mysqli_query($con, "SELECT * FROM voters");
while($row = mysqli_fetch_assoc($result)){
    $voted = $row['voted'] ? "Yes" : "No";
    echo "<tr>
         <td>{$SNO}</td>
        <td>{$row['reg_no']}</td>
        <td>{$row['name']}</td>
        <td>{$row['gender']}</td>
        <td>{$row['email']}</td>
        <td>$voted</td>
        <td>
            <button class='btn btn-sm btn-success' data-bs-toggle='modal' data-bs-target='#editVoterModal{$row['voter_id']}'>Edit</button>
            <a href='voters.php?delete={$row['voter_id']}' class='btn btn-sm btn-danger'>Delete</a>
        </td>
    </tr>";
     $SNO++;
    // Edit Voter Modal
    echo "
    <div class='modal fade' id='editVoterModal{$row['voter_id']}' tabindex='-1'>
    <div class='modal-dialog'><div class='modal-content'>
    <form method='POST'>
        <div class='modal-header'><h5 class='modal-title'>Edit Voter</h5></div>
        <div class='modal-body'>
            <input type='hidden' name='voter_id' value='{$row['voter_id']}'>
            <input type='text' name='reg_no' class='form-control mb-2' value='{$row['reg_no']}' required>
            <input type='text' name='name' class='form-control mb-2' value='{$row['name']}' required>
            <input type='text' name='gender' class='form-control mb-2' value='{$row['gender']}' required>
            <input type='email' name='email' class='form-control mb-2' value='{$row['email']}' required>
        </div>
        <div class='modal-footer'>
            <button type='button' class='btn btn-secondary' data-bs-dismiss='modal'>Close</button>
            <button type='submit' name='update_voter' class='btn btn-success'>Update</button>
        </div>
    </form></div></div></div>";
}
?>
</tbody>
</table>

<!-- Add Voter Modal -->
<div class="modal fade" id="addVoterModal" tabindex="-1">
<div class="modal-dialog"><div class="modal-content">
<form method="POST">
    <div class="modal-header"><h5 class="modal-title">Add Voter</h5></div>
    <div class="modal-body">
        <input type="text" name="reg_no" class="form-control mb-2" placeholder="Reg No" required>
        <input type="text" name="name" class="form-control mb-2" placeholder="Name" required>
        <input type="text" name="gender" class="form-control mb-2" placeholder="Gender" required>
        <input type="email" name="email" class="form-control mb-2" placeholder="Email" required>
        <input type="password" name="password" class="form-control mb-2" placeholder="Password" required>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="submit" name="add_voter" class="btn btn-primary">Add</button>
    </div>
</form></div></div></div>

<?php
// Add Voter
if(isset($_POST['add_voter'])){
    $reg_no = $_POST['reg_no'];
    $name = $_POST['name'];
    $gender = $_POST['gender'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    mysqli_query($con, "INSERT INTO voters(reg_no,name,gender,email,password) VALUES('$reg_no','$name','$gender','$email','$password')");
    header("Location: voters.php");
}

// Update Voter
if(isset($_POST['update_voter'])){
    $id = $_POST['voter_id'];
    $reg_no = $_POST['reg_no'];
    $name = $_POST['name'];
    $gender = $_POST['gender'];
    $email = $_POST['email'];
    mysqli_query($con, "UPDATE voters SET reg_no='$reg_no', name='$name', gender='$gender', email='$email' WHERE voter_id=$id");
    header("Location: voters.php");
}

// Delete Voter
if(isset($_GET['delete'])){
    $id = $_GET['delete'];
    mysqli_query($con, "DELETE FROM voters WHERE voter_id=$id");
    header("Location: voters.php");
}
?>

<?php include 'include/footer.php'; ?>