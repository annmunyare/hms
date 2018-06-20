@extends("layouts.master")
@section("content")
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
	    var tableData ="<button  class= 'btn btn-primary' type = 'button' onclick='showInputForm()'> Add Patient</button><table class ='table table-bordered table-striped table-condensed'><tr> <th>ID</th><th>Patient Name</th> <th>D.O.B</th><th  colspan ='3'>Action</th></tr>";
	    for(tData in responseObj)
	    {
	        count++;
	        tableData+= "<tr><td>" + count +"</td>";
	        tableData+= "<td>" + responseObj[tData].patientName +"</td>";
	      	tableData+= "<td>" + responseObj[tData].patientDateOfBirth +"</td>";
			tableData+= "<td> <a href = '#' class= 'btn btn-info btn-sm' onclick ='showPatient("+responseObj[tData].patientId+")'> View</a></td>";
	        tableData+= "<td> <a href = '#' class= 'btn btn-success btn-sm' onclick = 'updatePatient("+responseObj[tData].patientId+", \""+responseObj[tData].patientName+"\", \""+responseObj[tData].patientDateOfBirth +"\" )'> Edit</a></td>";
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
	document.getElementById("savePatient").addEventListener("submit", submitPatient);
	document.getElementById("updatePatient").addEventListener("submit", updatePatient2);

</script>
@endsection