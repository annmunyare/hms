
<!doctype html>
<html lang="en">
	<head>
		<!-- Required meta tags -->
		<!-- <meta charset="utf-8"> -->
		<meta charset="utf-8"/>
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		<meta name = "csrf-token" content="{{csrf_token()}}">
        <!-- Latest compiled and minified CSS -->
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
      

		<!-- jQuery library -->
			<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <!-- Latest compiled and minified JavaScript -->
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>		
		<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
        <title>Kaizala</title>

	</head>

	<body onload="hideForm()">  

	<nav class="navbar  navbar-light bg-blue">
	<div class="collapse navbar-collapse" id="navbarSupportedContent">
    <div class="container-fluid">
        <ul class="nav nav-pills">  

			<li class="nav-item">
				<a class="nav-link" href="/patients"> Patients</a>
			
			</li>

            <li class="nav-item">
			<a class="nav-link" href="/services"> Services</a>
			</li>

			<li class="nav-item">
			<a class="nav-link" href="/visits"  > Visits</a>
			</li>

			<li class="nav-item">
			<a class="nav-link" href="/bills"  > Bills</a>
			</li>

            <li class="nav-item">
				<a class="nav-link" href="#"  > Authenticate</a>
			</li>     


		</ul>
	</div>
    </div>
</nav>
<div class = "container">
<button  class="btn btn-info " onclick="authenticate('{{$applicationId}}', '{{$mobileNumber}}')" > <i class="material-icons">vpn_key</i>
 Authenticate </button> <button  class="btn btn-success " onclick="showGroupsForm()" ><i class="material-icons">group_add</i>
 Create a Group </button> 
<div id="inputForm" >
	<form action="#" method="POST"  id="savePin" name="pinsForm" >
		@csrf

        <div class="inputItems">
			<input class= "form-control" type="hidden" name="kaizalaMobileNo"  value ={{$mobileNumber}} required  >
		</div>

        <div class="inputItems">
			<input class= "form-control" type="hidden" name="kaizalaConnectorId"   value ={{$applicationId}} required>
		</div>

		<div class="inputItems">
			<input class= "form-control" type="hidden" name="kaizalaConnectorSecret" value ={{$applicationSecret}} required >
		</div>

		<div class="inputItems">
			<label> Authenticate Pin:</label>
			<input class= "form-control" type="number" name="authpin" required>
		</div>
		<br> 
		<div  class="inputButton">
			<button   class="btn btn-primary "type="submit">Submit</button> <br> 
		</div>
	</form>
</div>
<div id="createGroup" >
	<form action="#" method="POST"  id="saveGroup" name="groupsForm" >
		@csrf

        <div class="inputItems">
			<input class= "form-control" type="hidden" name="accesToken" id ="accessToken"  >
		</div>

        <div class="inputItems">
			<input class= "form-control" type="hidden" name="groupId" id ="groupId"  >
		</div>

		<div class="inputItems">
			<input class= "form-control" type="hidden" name="groupType" id ="groupType"  >
		</div>

		<div class="inputItems">
			<label> Name of Group</label>
			<input class= "form-control" type="text" name="GroupName" required>
		</div>

		<div class="inputItems">
			<label> Welcome Message</label>
			<input class= "form-control" type="text" name="welcomeMessage" required>
		</div>

		<div class="inputItems">
			<label> New Member's Number</label>
			<input class= "form-control" type="text" name="membersNumber" required>
		</div>

		<div class="inputItems">
			<input class= "form-control" type="hidden" name="kaizalaConnectorId"   value ={{$applicationId}} >
		</div>

		<div class="inputItems">
			<label> Group Type</label>
			<input class= "form-control" type="text" name="groupType" required>
		</div>

		<div  class="inputButton">
			<button   class="btn btn-primary "type="submit">Submit</button>
		</div>
	</form>
</div>

<div id="textMessage" >
	<form action="#" method="POST"  id="textMessage" name="textMessage" >
		@csrf

		<div class="inputItems">
		
			<input class= "form-control" type="hidden" name="TextMessageCreated" value = "TextMessageCreated">
		</div>


	</form>
</div>

<div id ="allPatients"></div>


</div>

<script type="text/javascript">
	var methods = ["GET", "POST"];
	var rootUrl =['https://api.kaiza.la/', 'https://kms.kaiza.la//', 'https://putsreq.com/dty3onca9Rnc5uYdabNy'];
	var contentType = ["application/x-www-form-urlencoded", "application/json"];
	// var vars = ["fa7dbf9e-108a-4ed0-9b76-3c4589754464", "EYYD8UWB92"];

	//vars akina id s
	function createObject(readyStateFunction, requestMethod, contentType=null, requestUrl, sendData=null , refreshToken = null, accessToken = null, vars = null)
	{

	    var obj = new  XMLHttpRequest();
		obj.onreadystatechange = function() {
			if ((this.readyState == 4) && (this.status == 200)) {
				readyStateFunction(this.responseText);
			}
		};

		obj.open(requestMethod, requestUrl, true);

		if (refreshToken != null) {

			obj.setRequestHeader("refreshToken", refreshToken);
			obj.setRequestHeader("applicationSecret", vars[1]);
			obj.setRequestHeader("applicationId", vars[0]);
		}

		if (accessToken != null) {
			obj.setRequestHeader("accessToken", accessToken);
		}

		if (requestMethod == 'POST') {
			obj.setRequestHeader("Content-Type", "application/json");
			// obj.setRequestHeader("X-CSRF-token",  document.querySelector('meta[name = "csrf-token"]').getAttribute('content'));  

			console.log(sendData);
			obj.send(sendData);
		} else {
			obj.send();
		}
	 
	}

    function authenticate( kaizalaConnectorId, kaizalaMobileNo)
	{
			var sendData = '{"mobileNumber": "'+kaizalaMobileNo+'", applicationId:"'+kaizalaConnectorId+'"}';
			console.log(sendData);
	        createObject( showPinForm, methods[1],  contentType[1], rootUrl[0]+"v1/generatePin", sendData);
    
	}

    function showPinForm()
    {
        document.getElementById("inputForm").style.display="block";
		
		
    }

	function hideForm()
	{
		document.getElementById("createGroup").style.display="none";
	}

	document.getElementById("savePin").addEventListener("submit", submitPin);
	document.getElementById("saveGroup").addEventListener("submit", submitGroup);
	
	function showGroupsForm()
	{
	    document.getElementById("createGroup").style.display="block";
	    document.getElementById("allPatients").style.display="none";
		document.getElementById("inputForm").style.display="none";
	}

	function submitPin(e)
	{    
		e.preventDefault();
		var kaizalaMobileNo = document.forms["pinsForm"]["kaizalaMobileNo"].value;
		var kaizalaConnectorId = document.forms["pinsForm"]["kaizalaConnectorId"].value;
		var kaizalaConnectorSecret = document.forms["pinsForm"]["kaizalaConnectorSecret"].value;
        var authpin = document.forms["pinsForm"]["authpin"].value;




	    if((kaizalaMobileNo != "") && (kaizalaConnectorId != "") && (kaizalaConnectorSecret != "")  && (authpin != "") )
	    {
			var sendData = '{"mobileNumber": "'+kaizalaMobileNo+'", "applicationId": "'+kaizalaConnectorId+'", "applicationSecret":"'+kaizalaConnectorSecret+'",  "pin":'+authpin+'}';

			// console.log(sendData);
	        createObject(refreshToken, methods[1],  contentType[1], rootUrl[0]+"v1/loginWithPinAndApplicationId", sendData);
	    }
	}


	function refreshToken(jsonResponse)
	{ 
		var responseObj = JSON.parse(jsonResponse);
		var refreshToken = responseObj.refreshToken;
		var endpointUrl = responseObj.endpointUrl;


    	console.log(responseObj);

		var kaizalaConnectorId = document.forms["pinsForm"]["kaizalaConnectorId"].value;
		var kaizalaConnectorSecret = document.forms["pinsForm"]["kaizalaConnectorSecret"].value;

    	var vars = [kaizalaConnectorId, kaizalaConnectorSecret];
		console.log(kaizalaConnectorId);

      createObject(getAccessToken, methods[0], null, endpointUrl+"v1/accessToken", null,  refreshToken,   null, vars);
		
	}

	function getAccessToken(jsonResponse)
	 {
   		var responseObj = JSON.parse(jsonResponse);
		var  accessToken  = responseObj.accessToken ;
		document.getElementById("accessToken").value= accessToken;

    	console.log(accessToken);

    
		createObject(fetchGroups, methods[0], null, rootUrl[1] + 'v1/groups?fetchAllGroups=true&showDetails=true', null, null, accessToken);
	}


	function fetchGroups(jsonResponse)
	{
		var tData;
		var responseObj = JSON.parse(jsonResponse);
		
		console.log(responseObj);
		var groups = responseObj.groups;
		var groupId = responseObj.groups.groupId;
		var groupType = responseObj.groups.groupType;

		document.getElementById("groupId").value= groupId;
		document.getElementById("groupType").value= groupType;
	  
		var count=0; 
	    var tableData ="<table class ='table table-bordered table-striped table-condensed'><tr> <th>#</th><th>Group Name</th> <th>Group Type</th><th  colspan ='4'>Action</th></tr>";
	    for(i = 0; i < groups.length; i++)
	    {
	    	 count++;
	        tableData+= "<tr><td>" + count +"</td>";
	        tableData+= "<td>" +  responseObj.groups[i].groupName +"</td>";
	      	tableData+= "<td>" +  responseObj.groups[i].groupType  +"</td>";
			  console.log(responseObj.groups);
		tableData+= "<td> <a href = '#' class= 'btn btn-info btn-sm' onclick ='getChats(\""+responseObj.groups[i].groupId+"\", \""+responseObj.groups[i].groupType+"\")'>   <i class='material-icons'>message</i>Get Chats</a></td>";

	       
	    }
	    tableData+="</table>";
	    document.getElementById("allPatients").innerHTML= tableData;
	}

	function submitGroup(e)
	{    
		e.preventDefault();

		var GroupName = document.forms["groupsForm"]["GroupName"].value;
		var welcomeMessage = document.forms["groupsForm"]["welcomeMessage"].value;
		var membersNumber = document.forms["groupsForm"]["membersNumber"].value;
        var kaizalaConnectorId = document.forms["groupsForm"]["kaizalaConnectorId"].value;
		var groupType = document.forms["groupsForm"]["groupType"].value;
		var accesToken = document.forms["groupsForm"]["accesToken"].value;




	    if((GroupName != "") && (welcomeMessage != "") && (membersNumber != "")  && (kaizalaConnectorId != "")  && (groupType != "") )
	    {
			var sendData = '{name: "'+GroupName+'", welcomeMessage: "'+welcomeMessage+'", members: ["'+membersNumber+'"],  memberUserIds:["'+kaizalaConnectorId+'"], groupType: "'+groupType+'"}';

			// console.log(sendData);
	        createObject(getChats, methods[1],  contentType[1], rootUrl[1]+"v1/groups", sendData, null, accesToken);
	    }

	}


//  function getChats(groupId, groupType)
// {
	
// 	var accesToken = document.forms["groupsForm"]["accesToken"].value;
// 	// var TextMessageCreated = document.forms["textMessage"]["TextMessageCreate"].value;

// 	var sendData = '{"objectId": '+groupId+', "objectType": "'+groupType+'", "eventTypes": ["'+TextMessageCreated+'"],  "callBackUrl": "'+ rootUrl[2] +'"}';


// 	createObject(sendMessage, methods[1],  contentType[1], rootUrl[1]+"v1/webhook", sendData, null, accesToken);
	   
// }

// function showPatient()
// {
// 	    createObject(sendMessage, methods[0], rootUrl[1]+"getChats/"); 
// }	   


function sendMessage (jsonResponse)
{
	var responseObj = JSON.parse(jsonResponse);
		
	console.log(responseObj);
	// chck the word bomb

	var accesToken = document.forms["groupsForm"]["accesToken"].value;
	createObject(responseText, methods[1],  contentType[1], rootUrl[1]+"v1/groups/+'groupId'+/messages", sendData, null, accesToken);
	   
}

</script>
</body>

</html>