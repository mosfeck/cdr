<?php include('header.php'); ?>
<style type="text/css">
    body {
        font: 14px sans-serif;
        color: #fff;
        /* text-align: center;  */
        /*margin: 0 auto;*/
    }

    table {
        color: #fff;
    }

    .page-header {
        text-align: center;
    }

    /* h1 {
        border-bottom: 1px solid;
    } */

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
    .top-space{
        margin-top: 30px;
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
$id = $name = $email = $phone = $designation = $department =  $password = $confirm_password = "";
//prepare a select statement
$sql = "SELECT * from user_manage";
$result = $pdo->query($sql); { ?>
    <div class="container ">
        <div class="row ">
            <div class="col-lg-12 col-md-12 col-sm-12">
                <a href="create_user.php" class="btn btn-primary">Create User</a> 
            </div>
        </div>
        <div class="row mt-3 mb-5 pb-3">
            <div class="col-lg-12 col-md-12 col-sm-12 ">
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
                                    <td style="max-width: 60px;"><a href="update_user.php?id=<?php echo $row['id']; ?>" title="Edit"><img src="img/edit.png" alt="edit image" style="width:15%;margin-right: 5px;"></a>
                                        <a href="delete_user.php?id=<?php echo $row['id']; ?>" onclick="return confirm('Are you sure you want to Delete?')" title="Delete"><img src="img/clear.png" alt="edit image" style="width:15%"></a>
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
<?php


}
// close connection
unset($pdo);
?>

<link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.css" />

<script>
    $(document).ready(function() {
        $('#user-table').DataTable();
    });
</script>
<script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.js"></script>
<?php include('footer.php'); ?>