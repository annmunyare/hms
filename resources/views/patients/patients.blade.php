
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

	<body onload="getPatients()">  

	<nav class="navbar navbar-expand-lg navbar-light bg-light">
	<div class="collapse navbar-collapse" id="navbarSupportedContent">
	    <ul class="navbar-nav mr-auto">

			<li class="nav-item">
				<a class="nav-link" href="#"  onload="getPatients()"> Patients</a>
			
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

<div id="inputForm" >
	<form action="#" method="POST"  id="savePatient" name="patientsForm" >
		@csrf
		<div class="inputItems">
			<label> Patient Name:</label>
			<input class= "form-control" type="text" name="patientName" required>
		</div>

		<div class="inputItems">
			<label> Date of Birth</label>
			<input class= "form-control" type="date" name="patientDateOfBirth" required>
		</div>

		<div  class="inputButton">
			<button  class="btn btn-warning " type="button" onclick="hideInputForm()" > Cancel</button>
			<button   class="btn btn-primary "type="submit">Add Patient</button>
		</div>
	</form>
</div>

<div id="bookForm" >
	<form action="#" method="POST"  id="bookPatient" name="bookForm1" >
		@csrf

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

		<div class="inputItems">
			<input class= "form-control" type="hidden" name="visitId" required>
		</div>
		
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
			<button   class="btn btn-primary "type="submit">Book Patient</button>
		</div>
	</form>
</div>

<div id ="allPatients"></div>

<div id ="updateForm">
	<form  class = "form-horizontal" action="#" method="POST"  id="updatePatient" name="updateForm1" >

	@csrf

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

		<div  class="inputButton">
			<button class="btn btn-warning " type="button" onclick="hideInputForm()" > Cancel</button>
			<button  class="btn btn-primary " type="submit" >Update Patient</button>
		</div>

	</form>
</div>
</div>
<script type="text/javascript">
	var methods = ["GET", "POST"];
	var baseUrl = "http://localhost:8000/";
	
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
	
	function displayPatients(jsonResponse)
	{
	
	    var responseObj = JSON.parse(jsonResponse);
	    var tData, count=0; 
	    var tableData ="<button  class= 'btn btn-primary' type = 'button' onclick='showInputForm()'> Add Patient</button><table class ='table table-bordered table-striped table-condensed'><tr> <th>ID</th><th>Patient Name</th> <th>D.O.B</th><th  colspan ='4'>Action</th></tr>";
	    for(tData in responseObj)
	    {
	        count++;
	        tableData+= "<tr><td>" + count +"</td>";
	        tableData+= "<td>" + responseObj[tData].patientName +"</td>";
	      	tableData+= "<td>" + responseObj[tData].patientDateOfBirth +"</td>";
			tableData+= "<td> <a href = '#' class= 'btn btn-info btn-sm' onclick ='showPatient("+responseObj[tData].patientId+")'> View</a></td>";
	        tableData+= "<td> <a href = '#' class= 'btn btn-success btn-sm' onclick = 'updatePatient("+responseObj[tData].patientId+", \""+responseObj[tData].patientName+"\", \""+responseObj[tData].patientDateOfBirth +"\" )'> Edit</a></td>";
			tableData+= "<td> <a href = '#' class= 'btn btn-warning btn-sm' onclick = 'bookVisit("+responseObj[tData].patientId+", \""+responseObj[tData].patientName+"\", \""+responseObj[tData].patientDateOfBirth +"\" )'> Book Visit</a></td>";
	        tableData+= "<td> <a href = '#' class= 'btn btn-danger btn-sm' onclick ='deletePatient("+responseObj[tData].patientId+", \""+responseObj[tData].patientName+"\" )'> Delete</a></td></tr>";
	
	    }
	    tableData+="</table>";
	    document.getElementById("allPatients").innerHTML= tableData;
	}
	
	function getPatients()
	{
	    createObject(displayPatients, methods[0], baseUrl + "getPatient");
	    document.getElementById("inputForm").style.display="none";
	    document.getElementById("updateForm").style.display="none";
		document.getElementById("allPatients").style.display="block";
		document.getElementById("bookForm").style.display="none";

	    
	}
	
	function submitPatient(e)
	{   //get patientault 
		e.preventDefault();
		var patientName = document.forms["patientsForm"]["patientName"].value;
		var patientDateOfBirth = document.forms["patientsForm"]["patientDateOfBirth"].value;

		// alert(patientName+patientDateOfBirth);
	    //validate
	    if((patientName != "") && (patientDateOfBirth != ""))
	    {
			var sendData = "patientName="+patientName+"&patientDateOfBirth=" +patientDateOfBirth;
			console.log(sendData);
	        createObject(getPatients, methods[1], baseUrl+ "savePatient", sendData);
	    }
	}

	function showPatient(patientId)
	{
	    createObject(displaySinglePatient, methods[0], baseUrl+"getSinglePatient/"+patientId); 
	    return false;
	}

	function updatePatient(patientId, patientName, patientDateOfBirth)
	{
	    document.getElementById("updateForm").style.display="block";
	    document.getElementById("allPatients").style.display="none";
	    //get updatepatient
	    document.forms["updateForm1"]["patientName"].value = patientName;
	    document.forms["updateForm1"]["patientDateOfBirth"].value = patientDateOfBirth;
		document.forms["updateForm1"]["patientId"].value = patientId;
	}

	function updatePatient2(e)
	{
		e.preventDefault();
		var patientName = document.forms["updateForm1"]["patientName"].value;
	    var patientDateOfBirth = document.forms["updateForm1"]["patientDateOfBirth"].value;
		var patientId = document.forms["updateForm1"]["patientId"].value;

		var sendData = "patientName=" +patientName+"&patientDateOfBirth=" +patientDateOfBirth+"&patientId=" +patientId;
			console.log(sendData);
	        createObject(getPatients, methods[1], baseUrl+"updatePatient", sendData); 
	}
	
	function displaySinglePatient(jsonResponse)
	{
	    var responseObj2 = JSON.parse(jsonResponse);
		 var htmlString= "<h1>" + responseObj2.patientName+"</h1>" + "<p>" + responseObj2.patientDateOfBirth +"</p>"+"<button class= 'btn btn-warning ' type='button' onclick='getPatients()'>Go Back</button>";
	
	    document.getElementById("allPatients").innerHTML= htmlString;
	}
	
	function showInputForm()
	{
	    document.getElementById("inputForm").style.display="block";
	    document.getElementById("allPatients").style.display="none";
	}
	
	function hideInputForm()
	{
	    document.getElementById("inputForm").style.display="none";
	    document.getElementById("allPatients").style.display="block";
	    document.getElementById("updateForm").style.display="none";
		document.getElementById("bookForm").style.display="none";
	}
	function submitNewPatient() 
	{
		
	    //get patient
	    var patientName = document.forms["updateForm1"]["patientName"].value;
	    var patientDateOfBirth = document.forms["updateForm1"]["patientDateOfBirth"].value;
	
	        // alert(patientName+patientDateOfBirth);
	    //validate
	    if((patientName != "") && (patientDateOfBirth != ""))
	    {
	        createObject(getPatients, methods[1], baseUrl +"updatePatient"); 
	    }
	    else
	    {
	        alert("invalid input");
	    }
	    
	}
	function deletePatient(patientId, patientName)
	{   var text;
	    if(confirm( "Do you want to delete" + " "+patientName + "?"))
	    {
	        text = "You are pressed ok";
	        createObject(getPatients, methods[0], baseUrl +"deletePatient/"+patientId); 
	        alert("You have deleted" + " "+patientName );
	    }
	    else
	    {
	        text = "You are pressed cancel"
	    }
	    return false;

	
	    
	}
	function bookVisit(patientId, patientName, patientDateOfBirth,visitId, visitDate, visitType, exitTime, visitStatus)
	{	
		document.getElementById("bookForm").style.display="block";
	    document.getElementById("updateForm").style.display="none";
	    document.getElementById("allPatients").style.display="none";
	    //get updatepatient
	    document.forms["bookForm1"]["patientName"].value = patientName;
	    document.forms["bookForm1"]["patientDateOfBirth"].value = patientDateOfBirth;
		document.forms["bookForm1"]["patientId"].value = patientId;
	    document.forms["bookForm1"]["visitDate"].value = visitDate;
		document.forms["bookForm1"]["visitType"].value = visitType;
		document.forms["bookForm1"]["exitTime"].value = exitTime;
	    document.forms["bookForm1"]["visitStatus"].value = visitStatus;
		
	}

	function bookVisit2(e)
	{
		e.preventDefault();
		var patientName = document.forms["bookForm1"]["patientName"].value;
	    var patientDateOfBirth = document.forms["bookForm1"]["patientDateOfBirth"].value;
		var patientId = document.forms["bookForm1"]["patientId"].value;
		var visitDate = document.forms["bookForm1"]["visitDate"].value;
		var visitType = document.forms["bookForm1"]["visitType"].value;
		var exitTime = document.forms["bookForm1"]["exitTime"].value;
	    var visitStatus = document.forms["bookForm1"]["visitStatus"].value;
		
		var sendData = "patientName=" +patientName+"&patientDateOfBirth=" +patientDateOfBirth+"&patientId=" +patientId
		+"&visitDate=" +visitDate+"&visitType=" +visitType+
		"&exitTime=" +exitTime+"&visitStatus=" +visitStatus;
			console.log(sendData);
	        createObject(getPatients, methods[1], baseUrl+"bookVisit", sendData); 
	}
	
	document.getElementById("savePatient").addEventListener("submit", submitPatient);
	document.getElementById("updatePatient").addEventListener("submit", updatePatient2);
	document.getElementById("bookPatient").addEventListener("submit", bookVisit2);

</script>
</body>

</html>