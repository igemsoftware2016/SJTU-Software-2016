<?php
error_reporting(0);
$q=$_GET["q"];
$db=new mysqli("127.0.0.1","root","sjtuigem2016","IGEM");
if ($db->connect_errno>0)
{
    die("Unable to connect to database [".$db->connect_error."]");
}

$sql="select * from Teams where Team_Name = '$q'";
/* 

Teams

*/
if (!$result=$db->query($sql))
{
    die("There was an error running the query [".$db->error."]");
}

$paper="";
while ($row=$result->fetch_assoc()) 
    $teamid= $row['Team_ID'];

$sql="select * from Papers where team_id='$teamid'";

if (!$result1=$db->query($sql))
{
    die("There was an error running the query [".$db->error."]");
}

while ($row1=$result1->fetch_assoc()) {
	//echo  "<br><br><a class=\"button stroke animate-intro\" href=\"".$row1['save_path']."\">".$row1['file_name']."</a>
	//				<h5 class=\"stroke animate-intro\" style=\"display:inline;z-index:1500;\">Size: ".$row1['file_size']."</h5>" ;}
	echo  "<br><br><a class=\"\" href=\"".$row1['save_path']."\">".$row1['file_name']."</a>
	      <h5 class=\"\" style=\"display:inline;z-index:1500;\">Size: ".$row1['file_size']."MB</h5>" ;}


?>