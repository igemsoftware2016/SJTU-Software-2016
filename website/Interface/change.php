<?php

    header('content-type:application:json;charset=utf8');
    header('Access-Control-Allow-Origin:*');
    header('Access-Control-Allow-Methods:GET');
    header('Access-Control-Allow-Headers:x-requested-with,content-type');
    error_reporting(0);
    $db=new mysqli("127.0.0.1","root","sjtuigem2016","IGEM");
    
    if($db->connect_error){
	echo "Failed connection".$db->connect_error;
    } else{
	
    } 
    $answer = array();

    $username = $_GET["username"] ? $_GET["username"] : "";
    $password = $_GET["pwd"] ? $_GET["pwd"] : "";
    $newpassword = $_GET["newpwd"] ? $_GET["newpwd"] : "";
    $renewpassword = $_GET["renewpwd"] ? $_GET["renewpwd"] : "";
    
    $sql = "select ID,Account_Number,IGEM_Password from Person where Account_Number=\"{$username}\"";
    //echo $sql;
    if (!$result=$db->query($sql))
    {
	$answer["info"]="There was an error running the query [".$db->error."]";
	echo json_encode($answer);
	exit;
    }
    if ($result->num_rows < 1) {
        $answer["result"]= 1; 
        $answer["info"] = "No this user, Please register!";
    	echo json_encode($answer);
        exit;
    } 
    $row = $result->fetch_assoc();
    if ($row["IGEM_Password"] != $password){
       $answer["result"] = 2;
       $answer["info"] = "Old Password Wrong!";
       echo json_encode($answer);
       exit;
    }
  
    $sql = "update Person set IGEM_Password=\"{$newpassword}\" where Account_Number=\"{$username}\"";
    if (!$result=$db->query($sql))
    {
	$answer["result"]=3;
	$answer["info"]="Change Error";
	echo json_encode($answer);
	exit;
    } else{
	$answer["result"]=0;
	$answer["info"]="Change Successful!";
	echo json_encode($answer);
        exit;	  
    }    
  
?>