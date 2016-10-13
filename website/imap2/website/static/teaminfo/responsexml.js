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
    xmlhttp.open("GET","static/teaminfo/userInteract.php?q="+str,true);
    xmlhttp.send();
	
}
showTeamInfo=function(str)
{
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
            document.getElementById("infoframe").contentWindow.document.getElementById('page2').innerHTML=xmlhttp.responseText;
			
        }
    }
    xmlhttp.open("GET","static/teaminfo/teamInteract.php?q="+str,true);
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
    xmlhttp.open("GET","static/teaminfo/nameInteract.php",true);
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
    xmlhttp.open("GET","static/teaminfo/formInteract.php",true);
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
            listr=cNode[i].value;
			if(cNode[i].value.indexOf(str)==-1)
			{
				cNode[i].style.display="none";
			}
			else
				cNode[i].style.display="inline";
           
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
