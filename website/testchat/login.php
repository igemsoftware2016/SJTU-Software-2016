<?php
if(!isset($_POST['submit'])){
    exit('invalid visit!');
}
$username = $_POST['username'];
$password = $_POST['password'];
echo $username;
echo $password;

exec("python account.py $username $password 2>&1",$output,$my_return);
print_r($output);
echo $my_return;
echo "@@@@@@@@@@@@@@@@@@@";
echo "-------------------------------------------";
if ($output[0]==True){
    echo "1111";
    echo "TRUE";
	exec("python SignNum.py $username",$mykey,$return_val);

	print_r($mykey);
	echo $return_val;

    echo "<script type='text/javascript'>independentModeLogin($username,$mykey);</script>";
}
if ($output[0]==False){
    echo "2222";
    echo "FALSE";
}
?>