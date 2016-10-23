<?php
    error_reporting(0);
    header('Access-Control-Allow-Origin:*');
    header('Access-Control-Allow-Methods:GET');
    error_reporting(0);
    $db=new mysqli("localhost","root","sjtuigem2016","IGEM");

    if($db->connect_error) {
            echo "连接失败".$db->connect_error;
    } else {
            // echo "连接成功";
    }


    $teamID = $_GET["team_ID"] ? $_GET["team_ID"] : "1875";
    $type = $_GET["type"] ? $_GET["type"] : "instrument"; // instrument


    if($type == "reagent") {  // 查询试剂信息
        $sql = "select * from Reagent where From_Team_ID={$teamID}";
    if (!$result=$db->query($sql))
    {
        die("There was an error running the query [".$db->error."]");
    }
    $resStr = "[";
    while ($row = $result->fetch_assoc()) {
        // 试剂的CAS编号
        $CAS = $row["CAS"];
        // 试剂所属队伍的ID
        $From_Team_ID = $row["From_Team_ID"];
        // 试剂的品质
        $Quantity = $row["Quantity"];
        // 试剂的剩余量
        $Remaining_Available = $row["Remaining_Available"];
        // 试剂的到期时间
        $Expiration_Time = $row["Expiration_Time"];
	$NO_ = $row["No_"];

        // 试剂的使用记录
        $sql = "select * from Reagent_use_record where From_Team_ID={$From_Team_ID} and CAS={$CAS}";
        if (!$result1=$db->query($sql))
        {
            die("There was an error running the query [".$db->error."]");
        }
        $Reagent_use_record = "[";
	$myIndex = 0;
        while ($row = $result1->fetch_assoc()) {
		$myIndex++;
            // 这次使用记录所属实验的PN
            $PN = $row["PN"];
            // 这次使用记录所属实验的编号
            $Art_No = $row["Art_No"];
            // 地点
            $Location = $row["Location"];
            // 这次试验该种试剂的使用量
            $Size = $row["Size"];
            // 其他信息
            $Tag = $row["Tag"];
            $Reagent_use_record = $Reagent_use_record.'{"PN":"'.$PN.'" , "Art_No":"'.$Art_No.'" , "Location":"'.$Location.'" , "Size":"'.$Size.'" , "Tag":"'.$Tag.'"},';
        }
        $Reagent_use_record = substr($Reagent_use_record , 0 , -1);
        $Reagent_use_record = $Reagent_use_record."]";
	if($myIndex == 0) {
		$Reagent_use_record = "[]";
	}
        $resStr = $resStr.'{"CAS":"'.$CAS.'" , "No_":"'.$NO_.'" , "From_Team_ID":"'.$From_Team_ID.'" , "Quantity":"'.$Quantity.'" , "Remaining_Available":"'.$Remaining_Available.'" , "Expiration_Time":"'.$Expiration_Time.'" , "Reagent_use_record":'.$Reagent_use_record.'},';

    }
    // echo $resStr."<br>";
    $resStr = substr($resStr , 0 , -1);
	if(strlen($resStr) == 0){
                echo '{"status":"error" , "info":"暂时没数据"}';
        } else {
                echo $resStr."]";
        }  
//  echo $resStr."]";
    } else if ($type == "instrument") {  // 查询仪器信息
        $sql = "select * from Instrument where From_Team_ID={$teamID}";
        if (!$result=$db->query($sql))
        {
            die("There was an error running the query [".$db->error."]");
        }
        $resStr = "[";
        while ($row = $result->fetch_assoc()) {
            // 仪器的ID编号
            $No_ = $row["No_"];
            // 试剂所属队伍的ID
            $From_Team_ID = $row["From_Team_ID"];
            // 仪器类型/名称
            $Model = $row["Model"];
            // 仪器管理者
            $Manager = $row["Manager"];
            // 管理者联系方式
            $Telephone_Number = $row["Telephone_Number"];
            // 允许使用次数
            $Available_Number = $row["Available_Number"];

            // 仪器的使用记录
            $sql = "select * from Instrument_use_record where From_Team_ID={$From_Team_ID} and Instrument_ID={$No_}";
            if (!$result1=$db->query($sql))
            {
                die("There was an error running the query [".$db->error."]");
            }
            $Instrument_use_record = "[";
            while ($row = $result1->fetch_assoc()) {
                // 实验管理者
                $PN = $row["PN"];
                // 实验编号
                $Art_No = $row["Art_No"];
                // 位置
                $Location = $row["Location"];
                // 仪器状态
                $Status_ = $row["Status_"];
                // 标签
                $Tag = $row["Tag"];
                $Instrument_use_record = $Instrument_use_record.'{"PN":"'.$PN.'" , "Art_No":"'.$Art_No.'" , "Location":"'.$Location.'" , "Status_":"'.$Status_.'" , "Tag":"'.$Tag.'"},';
            }
            $Instrument_use_record = substr($Instrument_use_record , 0 , -1);
            $Instrument_use_record = $Instrument_use_record."]";
            $resStr = $resStr.'{"No_":"'.$No_.'" , "From_Team_ID":"'.$From_Team_ID.'" , "Model":"'.$Model.'" , "Manager":"'.$Manager.'" , "Telephone_Number":"'.$Telephone_Number.'" , "Available_Number":"'.$Available_Number.'" , "Instrument_use_record":'.$Instrument_use_record.'},';

        }

//	echo "我是人";        // echo $resStr."<br>";
        $resStr = substr($resStr , 0 , -1);
	if(strlen($resStr) == 0){
		echo '{"status":"error" , "info":"暂时没数据"}';
	} else {
		echo $resStr."]";
	}
        //echo $resStr."]";
    }
?>
