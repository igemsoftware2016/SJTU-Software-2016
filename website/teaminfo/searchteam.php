<?php
error_reporting(0);
$t=$_GET["t"];
error_reporting(0);
$db=new mysqli("127.0.0.1","root","sjtuigem2016","IGEM");
if ($db->connect_errno>0)
{
    die("Unable to connect to database [".$db->connect_error."]");
}
$sql="select Team_Name from Teams where Team_Name like '$t"."%'";
if (!$result=$db->query($sql))
{
    die("There was an error running the query [".$db->error."]");
}
$teamIndex=0;
while ($row=$result->fetch_assoc()) {
    $teamIndex=$teamIndex+1;
    echo "<li onclick=showTeamInfo(this.innerHTML) onmouseover=turnblue(this) onmouseout=turnwhite(this) value="."$teamIndex".">".$row['Team_Name']."</li>";
}
?>