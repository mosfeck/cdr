<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Dashboard</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.js"></script>
    <style type="text/css">
        .wrapper{
            width: 1200px;
            margin: 0 auto;
        }
        .page-header h2{
            margin-top: 0;
        }
        table tr td:last-child a{
            margin-right: 15px;
        }
        .imagesize{
            width: 70px;
            height: 70px;
            /*padding: 3px;*/
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.5);
            border: 1px solid #FFFFFF;
            border-radius: 4px; 
            margin: 5px;
        }
    </style>
    <script type="text/javascript">
        $(document).ready(function(){
            $('[data-toggle="tooltip"]').tooltip();   
        });
    </script>
</head>
<body>
    <div class="wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="page-header clearfix">
                        <h2 class="pull-left">Employees Details</h2>
                        <a href="create.php" class="btn btn-success pull-right">Add New Employee</a>
                    </div>                  
<?php
                    // Include config file
                    require_once "config.php";
                    
                    // Attempt select query execution
                    $sql = "SELECT * FROM memberdetails";
                    if($result = $pdo->query($sql)){
                        if($result->rowCount() > 0){
                            echo "<table class='table table-bordered table-striped'>";
                                echo "<thead>";
                                    echo "<tr>";
										echo "<th>Slno</th>";
                                        echo "<th>MemberName</th>";
                                        echo "<th>CompanyName</th>";
                                        echo "<th>Phone</th>";
                                        echo "<th>Email</th>";
                                        echo "<th>Address</th>";
										echo "<th>Business</th>";
										echo "<th>Message</th>";
                                        echo "<th>Photo</th>";
										echo "<th>Action</th>";
                                    echo "</tr>";
                                echo "</thead>";
                                echo "<tbody>";
                                while($row = $result->fetch()){
                                    echo "<tr>";
                                        echo "<td>" . $row['MemberID'] . "</td>";
                                        echo "<td>" . $row['MemberName'] . "</td>";
                                        echo "<td>" . $row['CompanyName'] . "</td>";
                                        echo "<td>" . $row['Phone'] . "</td>";
										echo "<td>" . $row['Email'] . "</td>";
										echo "<td>" . $row['Address'] . "</td>";
										echo "<td>" . $row['Business'] . "</td>";
										echo "<td>" . $row['Message'] . "</td>";
                                        echo '
                                    
                                        <td>
                                            <img src="data:image/jpeg;base64,'.base64_encode($row['imageData']).'" class="imagesize"/>
                                        </td>
                                   

                                ';
                                        echo "<td>";
                                            echo "<a href='read.php?id=". $row['MemberID'] ."' title='View Record' data-toggle='tooltip'><span class='glyphicon glyphicon-eye-open'></span></a>";
                                            echo "<a href='update.php?id=". $row['MemberID'] ."' title='Update Record' data-toggle='tooltip'><span class='glyphicon glyphicon-pencil'></span></a>";
                                            echo "<a href='delete.php?id=". $row['MemberID'] ."' title='Delete Record' data-toggle='tooltip'><span class='glyphicon glyphicon-trash'></span></a>";
                                        echo "</td>";
                                    echo "</tr>";
                                }
                                echo "</tbody>";                            
                            echo "</table>";
                            // Free result set
                            unset($result);
                        } else{
                            echo "<p class='lead'><em>No records were found.</em></p>";
                        }
                    } else{
                        echo "ERROR: Could not able to execute $sql. " . $mysqli->error;
                    }
                    
                    // Close connection
                    unset($pdo);
                    ?>
                 </div>
            </div>        
        </div>
    </div>
</body>
</html>