<?php include('header.php'); ?>
<style type="text/css">
    
    .page-header {
        text-align: center;
    }

    .row {
        margin: 5px;
    }

    .action_button {
        margin-top: 15px;
    }

    .h-center {
        text-align: center;
    }

    .h-center .btn {
        display: initial;
        margin: 0 auto;
    }

    .top-space {
        margin-top: 30px;
    }
    .align-right{
        float: right;
    }
</style>
<?php
// Initialize the session
session_start();
//include config file
require_once "config.php";
// Check if the user is logged in, if not then redirect him to login page
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: login.php");
    exit;
}
$success = $error = '';

// echo $_SESSION['success'];exit;
if(isset($_SESSION['success'])){
    $success = $_SESSION['success'];
}
if(isset($_SESSION['error'])){
    $error = $_SESSION['error'];
}

$id = $name = $email = $phone = $designation = $department =  $password = $confirm_password = "";
//prepare a select statement
$sql = "SELECT * from user_manage where `name` != 'Administrator'";
$_SESSION['user'] = $sql;
$result = $pdo->query($sql); {
?>
    <div class="container ">
        <div class="row mt-3 mb-5 pb-3">
            <div class="col-lg-12 col-md-12 col-sm-12 ">
                <div class="card">
                    <div class="card-header">
                        <div class="card-title text-center">User Management</div>
                        <?php if($success) {?>
                            <p id="message" class="alert-success p-2"><?php echo $success; ?></p>
                        <?php } if($error) { ?>
                            <p id="message" class="alert-danger p-2"><?php echo $error; ?></p>
                        <?php } ?>
                    </div>
                    <div class="card-body">
                        <a href="create_user.php" class="btn btn-primary btn-sm mb-3">Create User</a>
                        <a href="user_export.php" class="btn btn-info btn-sm text-white align-right">Export</a>
                    
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped table-hover " id="user-table">
                            <thead>
                                <tr class="table-success">
                                    <th> Action </th>
                                    <th> SL</th>
                                    <th> Name</th>
                                    <th> Phone </th>
                                    <th> Email </th>
                                    <th> Designation </th>
                                    <th> Department </th>
                                    <th> Status </th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $sl = 1;
                                foreach ($result as $row) { ?>
                                    <tr <?php echo $sl % 2 == 0 ? ' class="table-info"' : 'class="table-success"'; ?>>
                                        <td style="max-width: 60px;"><a href="update_user.php?id=<?php echo $row['id']; ?>" title="Edit"><img src="img/edit.png" alt="edit image" style="width:20%;margin-right: 5px;"></a>
                                             <a href="delete_user.php?id=<?php echo $row['id']; ?>" onclick="return confirm('Are you sure you want to Delete?')" title="Delete"><img src="img/clear.png" alt="edit image" style="width:20%"></a>
                                        </td>
                                        <td><?php echo $sl++; ?></td>
                                        <td><?php echo $row['name']; ?></td>
                                        <td><?php echo $row['phone']; ?></td>
                                        <td><?php echo $row['email']; ?></td>
                                        <td><?php echo isset($row['designation']) ? $row['designation'] : ''; ?></td>
                                        <td><?php echo isset($row['department']) ? $row['department'] : ''; ?></td>
                                        <td><?php echo $row['status'] == 1 ? 'Active' : 'Inactive'; ?></td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php
}
// close connection
unset($pdo);
?>
<script>
    $(document).ready(function() {
    // $('#message').delay(3200).fadeOut(300); 
});
</script>
<?php include('footer.php'); ?>