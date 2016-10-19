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


$sql="select * from Teamfile_Manager where Team_ID = '$team_id'";

if (!$result1=$db->query($sql))
{
    die("There was an error running the query [".$db->error."]");
}


while ($row1=$result1->fetch_assoc()) 
$curve=$row1['background'];
if($curve!=NULL)
	$curve="    <div id=\"sec1\" style=\"background-size:100% 50%; background-image:url(http://www.sjtuimap.com/static/".$curve.");\">
	<font size=\"+7\" color=\"#FFFFFF\" face=\"Microsoft YaHei UI\">$q</font>
	<div id=\"track\" style=\"float:left;font-family:toboto;
    padding-top:30%;position:relative;\"><font size=\"+5\" color=\"#FFFFFF\" face=\"Microsoft YaHei UI\">Track</font>
      </div>
    </div>";
else
	$curve="    <div id=\"sec1\" style=\"background-size:100% 50%; background-image:url(http://www.sjtuimap.com/static/img/mrbackground.jpg);\">
	<font size=\"+7\" color=\"#FFFFFF\" face=\"Microsoft YaHei UI\">$q</font>
	<div id=\"track\" style=\"float:left;font-family:toboto;
    padding-top:30%;position:relative;\"><font size=\"+5\" color=\"#FFFFFF\" face=\"Microsoft YaHei UI\">Track</font>
      </div>
    </div>";//默认背景


?>