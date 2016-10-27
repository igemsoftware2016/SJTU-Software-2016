<?php
error_reporting(E_ALL);
$q=$_GET["q"];
$output="";
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


while ($row=$result->fetch_assoc()) {
    
    $teamname=$row['Team_Name'];
    
			$track=$row['Track'];

$output="<font size='56px'><b>".$teamname."</b></font><br /><br /><br /><font size='20px'>ADDRESS:</font><br />";

"<font size='18px'>".$schoolid=$row['School_ID']."</font>";
$areaid=$row['Area_ID'];
}


$sql_school="select * from Schools where School_ID = '".$schoolid."'";
if (!$result=$db->query($sql_school))
{
    die("There was an error running the query [".$db->error."]".$sql_school);
}
else
	while ($row=$result->fetch_assoc()) {
	$schoolname=$row['School_Name'];}

$sql_area="select * from Areas where Area_ID = '$areaid'";
if (!$result=$db->query($sql_area))
{
    die("There was an error running the query [".$db->error."]".$sql_area);
}
else
	while ($row=$result->fetch_assoc()) 
{
	if($row['Region']!=NULL)
 $region=$row['Region'];
 if($row['Country']!=NULL)
 $country=$row['Country'];
 }
 $output=$output.$schoolname.'<br/>'.$country.','.$region."<br/><font size='20px'>KIND & TRACK:</font><br/>".$track;
echo $output;

?>
