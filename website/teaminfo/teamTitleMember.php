<?php
error_reporting(0);
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


while ($row=$result->fetch_assoc()) 
{
	$projectid= $row['Project_ID'];
	$teamid=$row['Team_ID'];
}
$sql2="select * from Projects where Project_ID = '".$projectid."'";

if (!$result=$db->query($sql2))
{
    die("There was an error running the query [".$db->error."]");
}


while ($row=$result->fetch_assoc())
{
	$title=$row['Title'];
	$abstract=$row['Abstract'];
}
$output=" <font size='18px'>TITLE AND ABSTRACT</font><br />".$title."<br />".$abstract."<hr /><font size='3'>MEMBERS</font><br />";


$sql3="select Person_ID from Join_Team where Team_ID='$teamid'";

$personid="";

$name="";
$now = 0;
if (!$result1=$db->query($sql3))
{
    die("There was an error running the query [".$db->error."]");
}else
while ($row1=$result1->fetch_assoc()) 
{
	$personid=$row1['Person_ID'];
if (!$result2=$db->query("select * from Person where ID='$personid'"))
{
    die("There was an error running the query [".$db->error."]");
}
else
{
    $now++;
	$row2=$result2->fetch_assoc();
    $name=$name.sprintf("%30s",$row2['Name']);
	//$name=$name.$row2['Name']."&nbsp&nbsp&nbsp" ;
    if ($now%3==0)
    {
        $name=$name."<br />";
    }
	}
}
echo $output.$name."<hr />";

?>
