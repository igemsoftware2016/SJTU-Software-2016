showUserInfo=function()
{
	
    var xmlhttp;
	var sel = document.getElementById("TeamFormPos");
var str = sel.options[sel.selectedIndex].text;
    if (str=="")
    {
        document.getElementById("UserInfoPos").innerHTML="";
        return;
    }
    if (window.XMLHttpRequest)
    {
        xmlhttp=new XMLHttpRequest();
    }
    else
    {
        xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
    }
    xmlhttp.onreadystatechange=function()
    {
        if (xmlhttp.readyState==4 && xmlhttp.status==200)
        {
            document.getElementById("UserInfoPos").innerHTML=xmlhttp.responseText;
        }
    }
    xmlhttp.open("GET","userInteract.php?q="+str,true);
    xmlhttp.send();
	
}

showTeamName=function()
{
    var xmlhttp;
    if (window.XMLHttpRequest)
    {
        xmlhttp=new XMLHttpRequest();
    }
    else
    {
        xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
    }
    xmlhttp.onreadystatechange=function()
    {
        if (xmlhttp.readyState==4 && xmlhttp.status==200)
        {
            document.getElementById("TeamNamePos").innerHTML=xmlhttp.responseText;
			
        }
    }
    xmlhttp.open("GET","teaminfo/nameInteract.php",true);
    xmlhttp.send();
}
showTeamForm=function()
{
    var xmlhttp;
    if (window.XMLHttpRequest)
    {
        xmlhttp=new XMLHttpRequest();
    }
    else
    {
        xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
    }
    xmlhttp.onreadystatechange=function()
    {
        if (xmlhttp.readyState==4 && xmlhttp.status==200)
        {
            document.getElementById("list").innerHTML=xmlhttp.responseText;
        }
    }
    xmlhttp.open("GET","teaminfo/formInteract.php",true);
    xmlhttp.send();
}

searchteam=function(str)
{
	/*
    var xmlhttp;
	if (str=="")
    {
        document.getElementById("TeamInfoPos").innerHTML="";
        return;
    }
    if (window.XMLHttpRequest)
    {
        xmlhttp=new XMLHttpRequest();
    }
    else
    {
        xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
    }
    xmlhttp.onreadystatechange=function()
    {
        if (xmlhttp.readyState==4 && xmlhttp.status==200)
        {
            document.getElementById("list").innerHTML=xmlhttp.responseText;
        }
    }
    xmlhttp.open("GET","searchteam.php?t="+str,true);
    xmlhttp.send();
	*/
	var listr="";
	
	var cNode =document.getElementById('list').getElementsByTagName('li');

	 for( var i=0; i<cNode.length; i++){
            listr=cNode[i].getAttribute("name");
		//alert(listr+"+"+str+"+");
			if(listr.indexOf(str)==-1)
			{
				alert("no");
				cNode[i].style.display="none"; 
			}
			else{
				alert("yes");
				cNode[i].style.display="inherit";
			}
        }
}
turnblue=function(e)
{
	e.style.backgroundColor='#66CCFF';
}
turnwhite=function(e)
{
	e.style.backgroundColor='#FFFFFF';
	}
	
showTeamForm();

//showTeamName();



DOWNLOAD=function(str)
{
	//获取download地址
		var xmlhttp;
	 if (window.XMLHttpRequest)
    {
        xmlhttp=new XMLHttpRequest();
    }
    else
    {
        xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
    }
    xmlhttp.onreadystatechange=function()
    {
        if (xmlhttp.readyState==4 && xmlhttp.status==200)
        {
            document.getElementById("infoframe").contentWindow.document.getElementById("download").innerHTML=xmlhttp.responseText;
        }
    }
    xmlhttp.open("GET","teaminfo/teamPaper.php?q="+str,true);
    xmlhttp.send();   
	}
CURVE=function(str)
{
	//获取curve
 var xmlhttp;
    if (window.XMLHttpRequest)
    {
        xmlhttp=new XMLHttpRequest();
    }
    else
    {
        xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
    }
    xmlhttp.onreadystatechange=function()
    {
        if (xmlhttp.readyState==4 && xmlhttp.status==200)
        {
            document.getElementById("infoframe").contentWindow.document.getElementById("page1").backgroundImage=xmlhttp.responseText;
        }
    }
    xmlhttp.open("GET","teaminfo/teamCurve.php?q="+str,true);
    xmlhttp.send();   

	}
TITLEMEMBER=function(str)
{
	 var xmlhttp;
	//获取title和member
	 if (window.XMLHttpRequest)
    {
        xmlhttp=new XMLHttpRequest();
    }
    else
    {
        xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
    }
    xmlhttp.onreadystatechange=function()
    {
        if (xmlhttp.readyState==4 && xmlhttp.status==200)
        {
            document.getElementById("infoframe").contentWindow.document.getElementById("sec2").innerHTML=xmlhttp.responseText;
        }
    }
    xmlhttp.open("GET","teaminfo/teamTitleMember.php?q="+str,true);
    xmlhttp.send();   
	}


showTeamInfo=function(str)
{
    var xmlhttp;
	//获取abstract
    if (str=="")
    {
        document.getElementById("TeamInfoPos").innerHTML="";
        return;
    }
    if (window.XMLHttpRequest)
    {
        xmlhttp=new XMLHttpRequest();
    }
    else
    {
        xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
    }
    xmlhttp.onreadystatechange=function()
    {
        if (xmlhttp.readyState==4 && xmlhttp.status==200)
        {
            document.getElementById("infoframe").contentWindow.document.getElementById('track').innerHTML=xmlhttp.responseText;
			//document.getElementById("infoframe").contentWindow.document.getElementById('page1').innerHTML=xmlhttp.responseText;
        }
    }
    xmlhttp.open("GET","teaminfo/teamInteract.php?q="+str,true);
    xmlhttp.send(); 
	
	DOWNLOAD(str);
	CURVE(str);
	TITLEMEMBER(str);
		
	

}
