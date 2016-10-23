<?php
$username = $_GET["name"];
$password = $_GET["key"];
echo $username;
echo $password;
exec("python account.py $username $password 2>&1",$output,$my_return);
print_r($output);
echo $my_return;
if ($output[2]=="True"){
	exec("python SignNum.py $username",$mykey,$return_val);
	print_r($mykey);
    echo "TRUE";
	
//	$data=array();
//	$data[]=array('username'=>$username,'password'=>$mykey);
//	$json_string=json_encode($data);
//	$suffix=".json";
//	$fp=fopen("result.json",'w');
//	fwrite($fp,$json_string);
//	echo "!!!!!!";
//	fclose($fp);
}
if ($output[2]=="False"){
    echo "FALSE";
}
?>
