<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
$connect= mysqli_connect("localhost", "bappy", "bappy123", "dcci");
if (mysqli_connect_errno()) {
   echo "Failed to connect to MySQL: " . MySQLi_connect_error();
}
$output='';
$sql="";
if (isset($_POST["txt"])) {
    $searchtxt = $_POST["txt"];
    $sql="select * from  Memberdetails where MemberName LIKE '%$searchtxt%' order by MemberiD desc";
    $result= mysqli_query($connect, $sql);

    if(mysqli_num_rows($result)>0)
    {
        $output .='<h4 align="center">Search Result<h4>';
        $output .='<table class="table table-bordered table-responsive">
                    <tr>
                        <th>Slno</th>
                        <th>Member</th>
                        <th>Company</th>
                        <th>Phone</th>
                        <th>Email</th>
                        <th>Address</th>
                        <th>Bussiness</th>
                        <th>Message</th>
                    </tr>';
        while ($row = mysqli_fetch_array($result)) {
            $output .='
                <tr>
                    <td>'.$row["MemberID"].'</td>
                    <td>'.$row["MemberName"].'</td>
                    <td>'.$row["CompanyName"].'</td>
                    <td>'.$row["Phone"].'</td>
                    <td>'.$row["Email"].'</td>
                    <td>'.$row["Address"].'</td>
                    <td>'.$row["Business"].'</td>
                    <td>'.$row["Message"].'</td>    
                </tr>
                </table>
                ';
        }
        echo $output;
//        while($row=mysqli_fetch_array($result)){
// 	echo "<li>$row[MemberID]</br>
// 	        <a href=$row[MemberName]>$row[MemberName]</a></li>";
//        }
        
    }   
    else 
    {
        echo 'Data not found';
    }
}

?>

