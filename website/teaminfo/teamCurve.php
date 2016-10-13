<?php
error_reporting(0);
$q=$_GET["q"];
$db=new mysqli("127.0.0.1","root","sjtuigem2016","IGEM");
if ($db->connect_errno>0)
{
    die("Unable to connect to database [".$db->connect_error."]");
}

$sql="select * from Teams where Team_Name = '$q'";

if (!$result=$db->query($sql))
{
    die("There was an error running the query [".$db->error."]");
}


while ($row=$result->fetch_assoc()) 
    $team_id=$row['Team_ID'];


$sql="select * from Teamfile_Manager where Team_ID = '$q'";

if (!$result=$db->query($sql))
{
    die("There was an error running the query [".$db->error."]");
}


while ($row=$result->fetch_assoc()) 
$curve=$row['background'];
if($curve!=NULL)
	echo $curve;
else
	echo "teaminfo\\img\\moren.jpg";//默认背景


?>