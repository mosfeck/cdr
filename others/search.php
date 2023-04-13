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
 
 $title=$_POST["title"];
 
 
 $result=mysqli_query($connect, "select * from  Memberdetails where MemberName LIKE '%$title%' order by MemberiD desc");
 
 $found=mysqli_num_rows($result);
 
 if($found>0){
 	while($row=mysqli_fetch_array($result)){
 	echo "<li>$row[MemberID]</br>
 	        <a href=$row[MemberName]>$row[MemberName]</a></li>";
    }   
 }else{
 	echo "<li>No Tutorial Found<li>";
 }
 // ajax search


?>

