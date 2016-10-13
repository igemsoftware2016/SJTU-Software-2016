<?php
    error_reporting(0);
    $db=new mysqli("115.159.215.213:3306","root","sjtuigem2016","IGEM");

    if($db->connect_error) {
            echo "连接失败".$db->connect_error;
    } else {
            // echo "连接成功";
    }


    $teamID = $_GET["team_ID"] ? $_GET["team_ID"] : "1875";


    //利用Team_ID可以查到Teams表里对应这个队伍的所有信息，
    // Team_Name:bostonu , Member_Num:11 ,  Area_ID:90 ,                  School_ID:1683 , Project_ID:3462
    // Year:2016           Status:accepted  Track:foundational advance    Kind:undergrad
    $sql = "select * from Teams where Team_ID={$teamID}";
    if (!$result=$db->query($sql))
    {
        die("There was an error running the query [".$db->error."]");
    }
    while ($row = $result->fetch_assoc()) {
        $kind = $row["Kind"];
        $track = $row["Track"];
        $projectID = $row["Project_ID"];
        // 增加 $teamName
        $teamName = $row["Team_Name"];
        $areaID = $row["Area_ID"];

    }

    // 增加去头像和封面图片的地址
    // $avatarPath , $backgroundPath
    $sql="select * from Teamfile_Manager where Team_ID={$teamID}";
    $result=$db->query($sql);
    while ($row=$result->fetch_assoc()) {
        $avatarPath = $row["avatar"];
        $backgroundPath = $row["background"];
    }


    // Title  Abstract
    //根据Project_ID可以从Projects表里找到这个队伍的Title和Abstract
    $sql="select * from Projects where Project_ID={$projectID}";
    if (!$result=$db->query($sql))
    {
        die("There was an error running the query [".$db->error."]");
    }
    while ($row = $result->fetch_assoc()) {
        $title = $row["Title"];
        $abstract = $row["Abstract"];
    }


    // address
    //根据Area_ID可以从Area表里找到这个队伍的Address
    // Area_ID  Region  Country  Provice  City  Coordinate_x  Coordinate_y
    $sql="select * from Areas where Area_ID={$areaID}";
    
    if (!$result=$db->query($sql))
    {
        die("There was an error running the query [".$db->error."]");
    }
    $tempStr = "{";
    while ($row = $result->fetch_assoc()) {
        foreach($row as $key => $value)    
        {        
            $tempStr = $tempStr.'"'.$key.'":"'.$value.'",';      
        } 
        $tempStr = substr($tempStr , 0 , -1)."}";
    }


    // echo "<br>********<br>";
    // 获取所有的 Member
    $members = array();
    $sql="select Person_ID from Join_Team where Team_ID={$teamID}";
    if (!$result=$db->query($sql))
    {
        die("There was an error running the query [".$db->error."]");
    }
    while ($row = $result->fetch_assoc()) {
        $onePerson = '{"userId":"';
        // echo "ID:".$row["Person_ID"]."<br>";
        $personId = $row["Person_ID"];
        //利用这些ID(13865)可以从Person表里查到所有Member
        // [{"ID":"13865","Name":"Douglas Densmore","Gender":null,"Age":null,"Levels":"2","Account_Number":"densmore","IGEM_Password":null,"Identity":"Primary PI"}]
        $sql="select * from Person where ID={$row["Person_ID"]}";
        if (!$res=$db->query($sql))
        {
            die("There was an error running the query [".$db->error."]");
        }
        while ($row = $res->fetch_assoc()) {
            $onePerson = $onePerson . $personId . '" , "name":"' . $row["Name"] .'"}';
        }

        array_push($members , $onePerson);
    }

    $memberStr = implode("," , $members);
    $memberStr = "[".$memberStr."]";

    $result = '{"MyTeam":{"Kind":"'.$kind.'" , "teamName":"'.$teamName.'" , "avatarPath":"'.$avatarPath.'" , "backgroundPath":"'.$backgroundPath.'" , "Track":"'.$track.'" , "Title":"'.$title.'" , "Abstract":"'.$abstract.'" , "Address":'.$tempStr.' , "Members":'.$memberStr.'}}';
    echo $result;
?>