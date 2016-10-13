<?php
error_reporting(0);
$db=new mysqli("127.0.0.1","root","sjtuigem2016","IGEM");
if ($db->connect_errno>0)
{
    die("Unable to connect to database [".$db->connect_error."]");
}
$sql="select Team_Name from Teams";
if (!$result=$db->query($sql))
{
    die("There was an error running the query [".$db->error."]");
}
$teamIndex=0;
while ($row=$result->fetch_assoc()) {
    $teamIndex=$teamIndex+1;
    echo "<button name="."$teamIndex"." onClick=showTeamInfo(this.innerHTML)>".$row['Team_Name']."</button>";
}
?>