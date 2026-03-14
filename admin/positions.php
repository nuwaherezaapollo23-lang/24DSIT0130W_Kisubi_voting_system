<?php 
include '../include/header.php'; 
include '../include/config.php'; ?>

<h2>Manage Positions</h2>
<button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#addPositionModal">Add Position</button>

<table class="table table-bordered">
  <thead><tr><th>#</th><th>Position Name</th><th>Actions</th></tr></thead>
  <tbody>
  <?php
  $sno=1;
  $result = mysqli_query($con, "SELECT * FROM positions");
  while($row = mysqli_fetch_assoc($result)){
      echo "<tr>
      <td>{$sno}</td>
      <td>{$row['position_name']}</td>
      <td>
        <button class='btn btn-sm btn-success' data-bs-toggle='modal' data-bs-target='#editPositionModal{$row['position_id']}'>Edit</button>
        <a href='positions.php?delete={$row['position_id']}' class='btn btn-sm btn-danger'>Delete</a>
      </td>
      </tr>";
      $sno++;
      // Edit Modal
      echo "
      <div class='modal fade' id='editPositionModal{$row['position_id']}' tabindex='-1'>
      <div class='modal-dialog'><div class='modal-content'>
      <form method='POST'>
        <div class='modal-header'><h5 class='modal-title'>Edit Position</h5></div>
        <div class='modal-body'>
          <input type='hidden' name='position_id' value='{$row['position_id']}'>
          <input type='text' name='position_name' class='form-control' value='{$row['position_name']}' required>
        </div>
        <div class='modal-footer'>
          <button type='button' class='btn btn-secondary' data-bs-dismiss='modal'>Close</button>
          <button type='submit' name='update_position' class='btn btn-success'>Update</button>
        </div>
      </form></div></div></div>";
  }
  ?>
  </tbody>
</table>

<!-- Add Modal -->
<div class="modal fade" id="addPositionModal" tabindex="-1">
<div class="modal-dialog"><div class="modal-content">
<form method="POST">
  <div class="modal-header"><h5 class="modal-title">Add Position</h5></div>
  <div class="modal-body"><input type="text" name="position_name" class="form-control" placeholder="Position Name" required></div>
  <div class="modal-footer">
    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
    <button type="submit" name="add_position" class="btn btn-primary">Add</button>
  </div>
</form></div></div></div>

<?php
// Add Position
if(isset($_POST['add_position'])){
  $name = $_POST['position_name'];
  mysqli_query($con, "INSERT INTO positions(position_name) VALUES('$name')");
  header("Location: positions.php");
}

// Update Position
if(isset($_POST['update_position'])){
  $id = $_POST['position_id'];
  $name = $_POST['position_name'];
  mysqli_query($con, "UPDATE positions SET position_name='$name' WHERE position_id=$id");
  header("Location: positions.php");
}

// Delete Position
if(isset($_GET['delete'])){
  $id = $_GET['delete'];
  mysqli_query($con, "DELETE FROM positions WHERE position_id=$id");
  header("Location: positions.php");
}
?>

<?php include '../include/footer.php'; ?>