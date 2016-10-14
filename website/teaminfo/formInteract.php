<?php
error_reporting(E_ALL);
$db=new mysqli("127.0.0.1","root","sjtuigem2016","IGEM");
if ($db->connect_errno>0)
{
	echo "no1";
    die("Unable to connect to database [".$db->connect_error."]");
}
$sql="select * from Teams order by Team_Name";
if (!$result=$db->query($sql))
{
	echo "no2";
    die("There was an error running the query [".$db->error."]");
}
$teamIndex=0;
while ($row=$result->fetch_assoc()) 
{
    $teamIndex=$teamIndex+1;
	$sql="select avatar from Teamfile_Manager where Team_ID='".$row['Team_ID']."'";
	if (!$teamtouxiang=$db->query($sql))
	{
		echo $no3;
		die("There was an error running the query [".$db->error."]");
	}
	else
	{
		$row2=$teamtouxiang->fetch_assoc();
		$touxiang=$row2['avatar'];
	}
		//img:头像
		if($touxiang==NULL)
		$touxiang="teaminfo\\img\\3.png";
		$teamname=$row['Team_Name'];
		echo "<li name='$teamname' onclick=showTeamInfo('".$row['Team_Name']."') onmouseover=turnblue(this) onmouseout=turnwhite(this) value='$teamname'><img height=\"40px\" width=\"40px\"src=\"".$touxiang."\" />".$row['Team_Name']."</li>";
		
}
	
?>