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
    $repassword = $_GET["repwd"] ? $_GET["repwd"] : "";

    if (!$username){
       die("No username!\n");
    }
    if (!$password){
       die("No /password!\n");
    }

    
    if (strlen($password)<6){
       die("Password must long than 6!\n");
    }
    if ($password!=$repassword){
       die("Different Password and Repeat-Password!\n");
    }
    
    $sql = "select ID from Person where Account_Number=\"{$username}\"";
    //echo $sql;
    if (!$result=$db->query($sql))
    {
	$answer["info"]="There was an error running the query [".$db->error."]";
	echo json_encode($answer);
	exit;
    } 
    while ($row = $result->fetch_assoc()) {
    	if ($row["ID"]){
	   $answer["info"]="The username you input is exist!";
	   echo json_encode($answer);
	   exit;
	}
    }

    $sql = "insert into Person(Name, Account_Number, IGEM_Password) values(\"{$username}\", \"{$username}\", \"{$password}\")";
    if (!$result=$db->query($sql))
    {
	$answer["info"]="There was an error running the query [".$db->error."]";
	echo json_encode($answer);
	exit;
    } else{	   
	$answer["info"]="Register Successful!";	
	echo json_encode($answer);
        exit;	  
    }    

?>