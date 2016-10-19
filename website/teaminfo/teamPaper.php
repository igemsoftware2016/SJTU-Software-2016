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

Teams 表里加PAPER路径

*/
if (!$result=$db->query($sql))
{
    die("There was an error running the query [".$db->error."]");
}

$paper="";
while ($row=$result->fetch_assoc()) 
    $teamid= $row['Team_ID'];
$sql="select * from Papers where team_id='$team_id'";
if (!$result=$db->query($sql))
{
    die("There was an error running the query [".$db->error."]");
}
while ($row=$result->fetch_assoc()) 
    $paper=$paper.$row['file_name']." <br />";

echo $paper;

?>