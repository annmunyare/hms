<!doctype html>
<html lang="en">
	<head>
		<!-- Required meta tags -->
		<!-- <meta charset="utf-8"> -->
		<meta charset="utf-8"/>
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		<meta name = "csrf-token" content="{{csrf_token()}}">
		<!-- Bootstrap CSS -->
        
		<link rel="stylesheet" href="\css\bootstrap\css\bootstrap.min.css"> 
		<title>Hms</title>
	</head>
	<body onload="getVisits()">  
		
	
<nav class="navbar navbar-expand-lg navbar-light bg-light">
	<div class="collapse navbar-collapse" id="navbarSupportedContent">
	    <ul class="navbar-nav mr-auto">

			<li class="nav-item">
				<a class="nav-link" href="#"> Patients</a>
			
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

		</ul>
	</div>
</nav>


<div class = "container">

<div id ="allVisits"></div>

<div id="updateForm" >
	<form action="#" method="POST"  id="bookPatient" name="updateForm1" >
		@csrf

		<div class="inputItems">
			<input class= "form-control" type="hidden" name="visitId" required>
		</div>

		<div class="inputItems">
			<input class= "form-control" type="hidden" name="patientId" required>
		</div>

		<div class="inputItems">
			<label> Patient Name:</label>
			<input class= "form-control" type="text" name="patientName" required>
		</div>

		<div class="inputItems">
			<label> Date of Birth</label>
			<input class= "form-control" type="date" name="patientDateOfBirth" required>
		</div>

		<!-- <div class="inputItems">
			<input class= "form-control" type="hidden" name="visitId" required>
		</div> -->
		
		<div class="inputItems">
			<label> Visit Date:</label>
			<input class= "form-control" type="date" name="visitDate" required>
		</div>

		<div class="inputItems">
			<label> Visit Type</label>
			<input class= "form-control" type="number" name="visitType" required>
		</div>

		<div class="inputItems">
			<label> Exit Time:</label>
			<input class= "form-control" type="date" name="exitTime" required>
		</div>

		<div class="inputItems">
			<label> Visit Status</label>
			<input class= "form-control" type="number" name="visitStatus" required>
		</div>

		<div  class="inputButton">
			<button  class="btn btn-warning " type="button" onclick="hideInputForm()" > Cancel</button>
			<button   class="btn btn-primary "type="submit">Update Visit</button>
		</div>
	</form>
</div>

</div>
<script type="text/javascript">
	var methods = ["GET", "POST"];
	var baseUrl = "http://127.0.0.1:8000/";
	
	function createObject(readyStateFunction, requestMethod, requestUrl, sendData=null )
	{

	    var obj = new  XMLHttpRequest();
	    obj.onreadystatechange = function() 
	    {
	        if (this.readyState == 4 && this.status == 200) 
	        {
	            readyStateFunction(this.responseText);
	        }
	    };

	    obj.open(requestMethod, requestUrl, true )
			if(requestMethod=='POST')
			{
				obj.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
				obj.setRequestHeader("X-CSRF-token",  document.querySelector('meta[name = "csrf-token"]').getAttribute('content'));    
				obj.send(sendData);
			}
			else
			{
				obj.send();
			}
	 
	}
	
	function displayVisits(jsonResponse)
	{
	
	    var responseObj = JSON.parse(jsonResponse);
	    var tData, count=0; 
	    var tableData ="<table class ='table table-bordered table-striped table-condensed'><tr> <th>ID</th><th>Patient ID</th> <th>Patient Name</th> <th>Patient D.O.B</th> <th>Visit Date</th> <th>Visit Type</th> <th>Exit Time</th><th>Visit Status</th><th  colspan ='8'>Action</th></tr>";
	    for(tData in responseObj)
	    {
	        count++;
	        tableData+= "<tr><td>" + count +"</td>";
			tableData+= "<td>" + responseObj[tData].patientId +"</td>";
	        tableData+= "<td>" + responseObj[tData].patientName +"</td>";
	      	tableData+= "<td>" + responseObj[tData].patientDateOfBirth +"</td>";
			  tableData+= "<td>" + responseObj[tData].visitDate +"</td>";
			  tableData+= "<td>" + responseObj[tData].visitType +"</td>";
			  tableData+= "<td>" + responseObj[tData].exitTime +"</td>";
			  tableData+= "<td>" + responseObj[tData].visitStatus +"</td>";
			tableData+= "<td> <a href = '#' class= 'btn btn-info btn-sm' onclick ='showVisit("+responseObj[tData].visitId+")'> View</a></td>";
	        tableData+= "<td> <a href = '#' class= 'btn btn-success btn-sm' onclick = 'updateVisit("+responseObj[tData].visitId+", \""+responseObj[tData].patientId+"\",  \""+responseObj[tData].patientName+"\",  \""+responseObj[tData].patientDateOfBirth+"\",  \""+responseObj[tData].visitDate+"\" , \""+responseObj[tData].visiType+"\" , \""+responseObj[tData].exitTime+"\" , \""+responseObj[tData].visitStatus+"\")'> Edit</a></td>";
	        tableData+= "<td> <a href = '#' class= 'btn btn-danger btn-sm' onclick ='deleteVisit("+responseObj[tData].visitId+", \""+responseObj[tData].patientName+"\" )'> Delete</a></td></tr>";
	
	    }
	    tableData+="</table>";
	    document.getElementById("allVisits").innerHTML= tableData;
	}
	
	function getVisits()
	{
	    createObject(displayVisits, methods[0], baseUrl + "getVisit");
	    
	    document.getElementById("updateForm").style.display="none";
		document.getElementById("allVisits").style.display="block";
	
	    
	}
	
	

	function showVisit(visitId)
	{
	    createObject(displaySingleVisit, methods[0], baseUrl+"getSingleVisit/"+visitId); 
	    return false;
	}

	function updateVisit( visitId, patientId, patientName, patientDateOfBirth, visitDate, visitType, exitTime, visitStatus)
	{
	    document.getElementById("updateForm").style.display="block";
	    document.getElementById("allVisits").style.display="none";
	    
		document.forms["updateForm1"]["visitId"].value = visitId;
	    document.forms["updateForm1"]["patientName"].value = patientName;
	    document.forms["updateForm1"]["patientDateOfBirth"].value = patientDateOfBirth;
		document.forms["updateForm1"]["patientId"].value = patientId;
	    document.forms["updateForm1"]["visitDate"].value = visitDate;
		document.forms["updateForm1"]["visitType"].value = visitType;
		document.forms["updateForm1"]["exitTime"].value = exitTime;
	    document.forms["updateForm1"]["visitStatus"].value = visitStatus;
	}

	document.getElementById("bookPatient").addEventListener("submit", updateVisit2);

	function updateVisit2(e)
	{ 
		e.preventDefault();
		var patientName = document.forms["updateForm1"]["patientName"].value;
	    var patientDateOfBirth = document.forms["updateForm1"]["patientDateOfBirth"].value;
		var patientId = document.forms["updateForm1"]["patientId"].value;
		var visitId = document.forms["updateForm1"]["visitId"].value;
		var visitDate = document.forms["updateForm1"]["visitDate"].value;
		var visitType = document.forms["updateForm1"]["visitType"].value;
		var exitTime = document.forms["updateForm1"]["exitTime"].value;
	    var visitStatus = document.forms["updateForm1"]["visitStatus"].value;
		
		var sendData = "patientName=" +patientName+"&patientDateOfBirth=" +patientDateOfBirth+"&patientId=" +patientId +"&visitId=" +visitId
		+"&visitDate=" +visitDate+"&visitType=" +visitType+
		"&exitTime=" +exitTime+"&visitStatus=" +visitStatus;
			console.log(sendData);
	        
	    createObject(getVisits, methods[1], baseUrl + "updateVisit", sendData); 
	}
	
	function displaySingleVisit(jsonResponse)
	{
	    var responseObj2 = JSON.parse(jsonResponse);
		 var htmlString= "<h1>" + responseObj2.visitName+"</h1>" + "<p>" + responseObj2.visitAmount +"</p>"+"<button class= 'btn btn-warning ' type='button' onclick='getVisits()'>Go Back</button>";
	
	    document.getElementById("allVisits").innerHTML= htmlString;
	}
	
	function showInputForm()
	{
	    document.getElementById("inputForm").style.display="block";
	    document.getElementById("allVisits").style.display="none";
	}
	
	function hideInputForm()
	{
	    
	    document.getElementById("allVisits").style.display="block";
	    document.getElementById("updateForm").style.display="none";
	}

	function deleteVisit(visitId, visitName)
	{   var text;
	    if(confirm( "Do you want to delete" + " "+visitName + "?"))
	    {
	        text = "You are pressed ok";
	        createObject(getVisits, methods[0], baseUrl +"deleteVisit/"+visitId); 
	        alert("You have deleted" + " "+visitName );
	    }
	    else
	    {
	        text = "You are pressed cancel"
	    }
	    return false;

	
	    
	}
	
	

</script>
</body>
</html>