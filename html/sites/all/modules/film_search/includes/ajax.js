var strdate;
var strguid;
var strname;
var strtopicId;


function getHttpObj(){
	var xmlHttp = null;
	try	{
		xmlHttp=new XMLHttpRequest();
	}
	catch (e){
		try	{
			xmlHttp=new ActiveXObject("Msxml2.XMLHTTP");
		}
		catch (ea)	{
			try	{
				xmlHttp=new ActiveXObject("Microsoft.XMLHTTP");
			}
			catch (eaa)	{
				alert("Your browser does not support AJAX!");
				return false;
			}
		}
	}
	return xmlHttp;
}



function new_page(id,guid,name){
	
	$('body').getReleaseDate(id,guid,name);
}

