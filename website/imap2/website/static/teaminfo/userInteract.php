<?php
error_reporting(0);
$q=$_GET["q"];
$db=new mysqli("127.0.0.1","root","sjtuigem2016","IGEM");
if ($db->connect_errno>0)
{
    die("Unable to connect to database [".$db->connect_error."]");
}
$sql="select * from Teams";
if (!$result=$db->query($sql))
{
    die("There was an error running the query [".$db->error."]");
}
while ($row=$result->fetch_assoc()) {
    echo 'Team_ID: '.$row['Team_ID']. '<br />';
    echo 'Team_Name: '.$row['Team_Name']. '<br />';
    echo 'Member_Num: '.$row['Member_Num']. '<br />';
    echo 'Status: '.$row['Status']. '<br />';
}
?>