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


while ($row=$result->fetch_assoc()) {
    echo 'Team_ID: '.$row['Team_ID']. '<br />';
    echo 'Team_Name: '.$row['Team_Name']. '<br />';
    echo 'Member_Num: '.$row['Member_Num']. '<br />';
    echo 'Status: '.$row['Status']. '<br />';

    echo 'Year: '.$row['Year']. '<br />';
	echo 'Track: '.$row['Track']. '<br />';
}

$schoolid=$row['School_ID'];
$areaid=$row['Area_ID'];
$projectid=$row['Project_ID'];


$sql_school="select * from Schools where ID = '".$schoolid."'";
if (!$result=$db->query($sql_school))
{
    die("There was an error running the query [".$db->error."]".$sql_school);
}
else
 echo 'School: '.$row['Name'].'<br />';
 
 
$sql_area="select * from Areas where ID = '$areaid'";
if (!$result=$db->query($sql_area))
{
    die("There was an error running the query [".$db->error."]".$sql_area);
}
else
{
	if($row['Region']!=NULL)
 echo 'Region: '.$row['Region'].'<br />';
 if($row['Country']!=NULL)
 echo 'Country: '.$row['Country'].'<br />';
 }
$sql_project="select * from Projects where Project_ID = '$projectid'";
if (!$result=$db->query($sql_area))
{
    die("There was an error running the query [".$db->error."]".$sql_project);
}
else
{
	if($row['Title']!=NULL)
 echo 'Title: '.$row['Title'].'<br />';
 if($row['Abstract']!=NULL)
 echo 'Abstract: '.$row['Abstract'].'<br />';
 }
?>