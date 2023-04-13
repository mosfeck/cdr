<?php
    // Include config file
    require_once "config.php";

    try {
        $MemberID = "";

        // Attempt select query execution
        if (!empty($_GET["term"])) {
            $MemberID = trim($_GET["term"]);
            $sql = "select * from  Memberdetails where 
            MemberID LIKE '%" . $MemberID . "%' or 
            MemberName LIKE '%" . $MemberID . "%' or
            CompanyName LIKE '%" . $MemberID . "%' or 
            Phone LIKE '%" . $MemberID . "%' or 
            Email LIKE '%" . $MemberID . "%' or
            Address LIKE '%" . $MemberID . "%' or
            Business LIKE '%" . $MemberID . "%' order by MemberiD desc";
        } else {
            $sql = "select * from  Memberdetails order by MemberiD desc limit 10";
        }

        if ($result = $pdo->query($sql)) {
            if ($result->rowCount() > 0) {
                echo "<div class='table-responsive'>";
                echo "<table class='table table-bordered table-striped'  id='myTable'>";
                echo "<thead>";
                echo "<tr>";
                echo "<th>Sl.</th>";
                echo "<th>Member</th>";
                echo "<th>Company</th>";
                echo "<th>Phone</th>";
                echo "<th>Email</th>";
                echo "<th>Address</th>";
                echo "<th>Business</th>";
                echo "<th>Message</th>";
                echo "<th>MemberPhoto</th>";
                echo "<th>Action</th>";
                echo "</tr>";
                echo "</thead>";
                echo '<tbody>';
                while ($row = $result->fetch()) {
                    echo "<tr>";
                    echo "<td>" . $row['MemberID'] . "</td>";
                    echo "<td>" . $row['MemberName'] . "</td>";
                    echo "<td>" . $row['CompanyName'] . "</td>";
                    echo "<td>" . $row['Phone'] . "</td>";
                    echo "<td>" . $row['Email'] . "</td>";
                    echo "<td>" . $row['Address'] . "</td>";
                    echo "<td>" . $row['Business'] . "</td>";
                    echo "<td>" . $row['Message'] . "</td>";
                    echo '<td>
                            <img src="data:image/jpeg;base64,' . base64_encode($row['imageData']) . '" class="imagesize" alt="No image"/>
                         </td>';
                    echo "<td>";
                    /* echo "<a href='read.php?id=". $row['MemberID'] ."' title='View Record' data-toggle='tooltip'><span class='glyphicon glyphicon-eye-open'></span></a>";
                      echo "<a href='update.php?id=". $row['MemberID'] ."' title='Update Record' data-toggle='tooltip'><span class='glyphicon glyphicon-pencil'></span></a>";
                      echo "<a href='delete.php?id=". $row['MemberID'] ."' title='Delete Record' data-toggle='tooltip'><span class='glyphicon glyphicon-trash'></span></a>"; */

                    //echo "<a href='membership_show.php?MemberID=". $row['MemberID'] ."' title='View Record' data-toggle='tooltip'><span class='fa fa-eye'></span></a>";
                    echo "<a href='membership_update.php?MemberID=" . $row['MemberID'] . "' title='Update Record' data-toggle='tooltip'><span class='fa fa-pencil'></span></a>";
                    echo "<a href='membership_delete.php?MemberID=" . $row['MemberID'] . "' title='Delete Record' data-toggle='tooltip'><span class='fa fa-trash'></span></a>";
                    echo "</td>";
                    echo "</tr>";
                }
                echo "</tbody>";
                echo "</table>";
                echo "</div>";
                // Free result set
                unset($result);
            } else {
                echo "<p class='lead'><em>No records were found.</em></p>";
            }
        }
    } catch (PDOException $e) {
        die("ERROR: Could not able to execute $sql. " . $e->getMessage());
    }


    // Close connection
    unset($pdo);
?>

