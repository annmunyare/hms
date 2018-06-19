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
			<label> Patient Description:</label>
			<textarea class= "form-control" name="patientDescription" required></textarea>
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
			<label> Patient Description:</label>
			<textarea  class= "form-control" name="patientDescription" required></textarea>
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
	    // var '<button type = 'button' onclick='showInputForm()> show Patient</button>';
	    var tableData ="<button  class= 'btn btn-primary' type = 'button' onclick='showInputForm()'> Add Patient</button><table class ='table table-bordered table-striped table-condensed'><tr> <th>ID</th><th>Name</th><th>Description</th><th  colspan ='3'>Action</th></tr>";
	    for(tData in responseObj)
	    {
	        count++;
	        tableData+= "<tr><td>" + count +"</td>";
	        tableData+= "<td>" + responseObj[tData].name +"</td>";
	        tableData+= "<td>" + responseObj[tData].description +"</td>";
	        tableData+= "<td> <a href = '#' class= 'btn btn-info btn-sm' onclick ='showPatient("+responseObj[tData].id+")'> View</a></td>";
	        tableData+= "<td> <a href = '#' class= 'btn btn-success btn-sm' onclick = 'updatePatient("+responseObj[tData].id+", \""+responseObj[tData].name+"\", \""+responseObj[tData].description+"\" )'> Edit</a></td>";
	        tableData+= "<td> <a href = '#' class= 'btn btn-danger btn-sm' onclick ='deletePatient("+responseObj[tData].id+", \""+responseObj[tData].name+"\" )'> Delete</a></td></tr>";
	
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
		var patientDescription = document.forms["patientsForm"]["patientDescription"].value;

		// alert(patientName+patientDescription);
	    //validate
	    if((patientName != "") && (patientDescription != ""))
	    {
			var sendData = "name="+patientName+"&description=" +patientDescription;
			console.log(sendData);
	        createObject(getPatients, methods[1], baseUrl+ "savePatient", sendData);
	    }
	}

	function showPatient(id)
	{
	    createObject(displaySinglePatient, methods[0], baseUrl+"getSinglePatient/"+id); 
	    return false;
	}

	function updatePatient(id, name, description)
	{
	    document.getElementById("updateForm").style.display="block";
	    document.getElementById("allPatients").style.display="none";
	    //get updatepatient
	    document.forms["updateForm1"]["patientName"].value = name;
	    document.forms["updateForm1"]["patientDescription"].value = description;
		document.forms["updateForm1"]["patientId"].value = id;
	}

	function updatePatient2(e)
	{
		e.preventDefault();
		var patientName = document.forms["updateForm1"]["patientName"].value;
	    var patientDescription = document.forms["updateForm1"]["patientDescription"].value;
		var patientId = document.forms["updateForm1"]["patientId"].value;

		var sendData = "name="+patientName+"&description=" +patientDescription+"&id=" +patientId;
			console.log(sendData);
	        createObject(getPatients, methods[1], baseUrl+"updatePatient", sendData); 
	}
	
	function displaySinglePatient(jsonResponse)
	{
	    var responseObj2 = JSON.parse(jsonResponse);
	    // var tableData ="<button type = 'button' onclick='showInputForm()'> show Patient</button>";
	    var htmlString= "<h1>" + responseObj2.name +"</h1>" + "<p>" + responseObj2.description +"</p>"+"<button class= 'btn btn-warning ' type='button' onclick='getPatients()'>Go Back</button>";
	
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
	    var patientDescription = document.forms["updateForm1"]["patientDescription"].value;
	
	        // alert(patientName+patientDescription);
	    //validate
	    if((patientName != "") && (patientDescription != ""))
	    {
	        createObject(getPatients, methods[1], baseUrl +"updatePatient"); 
	    }
	    else
	    {
	        alert("invalid input");
	    }
	    
	}
	function deletePatient(id, name)
	{   var text;
	    if(confirm( "Do you want to delete" + " "+name + "?"))
	    {
	        text = "You are pressed ok";
	        createObject(getPatients, methods[0], baseUrl +"deletePatient/"+id); 
	        alert("You have deleted" + " "+name );
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