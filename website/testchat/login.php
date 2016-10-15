<?php
if(!isset($_POST['submit'])){
    exit('invalid visit!');
}
$username = $_POST['username'];
$password = $_POST['password'];
echo $username;
echo $password;
//$output=shell_exec("python test.py");
//exec("python account.py $username $password",$output,$return_val);
exec("python test.py $username $password",$output,$return_val);
//exec("python test.py",$output,$return_val);
echo $output[0];
echo $return_val;
//echo $return_val;
//echo $return_val;
/*
 if ($output==TRUE)
    echo "fuck";
if ($output==FALSE)
    echo "shit";

*/
?>