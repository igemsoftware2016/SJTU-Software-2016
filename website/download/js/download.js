DOWNLOAD=function()
{
	//获取download地址
		var xmlhttp;
		var index=window.document.getElementById("selectt").selectedIndex;
//根据索引获得该选项的value值
var str=window.document.getElementById("selectt").options[index].value;
alert(str);
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
            document.getElementById("wheredownload").innerHTML=xmlhttp.responseText;
        }
    }
    xmlhttp.open("GET","download/download.php?q="+str,true);
    xmlhttp.send();   
	}
