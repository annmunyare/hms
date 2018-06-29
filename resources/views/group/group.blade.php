
<!doctype html>
<html lang="en">
	<head>
		<!-- Required meta tags -->
		<!-- <meta charset="utf-8"> -->
		<meta charset="utf-8"/>
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		<meta name = "csrf-token" content="{{csrf_token()}}">
        <!-- Latest compiled and minified CSS -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

        <!-- Optional theme -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">

        <!-- Latest compiled and minified JavaScript -->
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
		
        <title>Kaizala</title>

	</head>

	<body>  

	<nav class="navbar navbar-inverse">
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
				<a class="nav-link" href="/groups"   onclick="authenticate('{{$applicationId}}', '{{$mobileNumber}}')"> Authenticate</a>
			</li>     


		</ul>
	</div>
    </div>
</nav>
<div class = "container">

<div id="getPinForm" >
	<form action="#" method="POST"  id="getPin" name="getPin" >
		@csrf

        <div class="inputItems">
			<input class= "form-control" type="hidden" name="kaizalaConnectorId" required>
		</div>

        <div class="inputItems">
			<input class= "form-control" type="hidden" name="kaizalaMobileNo" required>
		</div>






	</form>
</div>

<div id="inputForm2" >
	<form action="#" method="POST"  id="savePin" name="pinsForm2" >
		@csrf

        <div class="inputItems">
			<input class= "form-control" type="hidden" name="kaizalaConnectorId" required>
		</div>

        <div class="inputItems">
			<input class= "form-control" type="hidden" name="kaizalaMobileNo" required>
		</div>

		<div class="inputItems">
			<label> Authenticate Pin:</label>
			<input class= "form-control" type="number" name="authpin" required>
		</div>



		<div  class="inputButton">
			<button  class="btn btn-warning " type="button" onclick="hideInputForm()" > Cancel</button>
			<button   class="btn btn-primary "type="submit">Submit</button>
		</div>
	</form>
</div>


<div id ="allPatients"></div>


</div>

<script type="text/javascript">
	var methods = ["GET", "POST"];
	var rootUrl = "https://api.kaiza.la/";
    var contentType = ["application/x-www-form-urlencoded", "application/json"];
	//vars akina id s
	function createObject(readyStateFunction, requestMethod, contentType, requestUrl, sendData=null )
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
				obj.setRequestHeader("Content-Type", contentType);
				obj.setRequestHeader("X-CSRF-token",  document.querySelector('meta[name = "csrf-token"]').getAttribute('content'));    
				obj.send(sendData);
			}
			else
			{
				obj.send();
			}
	 
	}

    function authenticate( kaizalaConnectorId, kaizalaMobileNo)

	{
	    

       
			var sendData = '{"mobileNumber": "' +kaizalaMobileNo+'", applicationId:"'+kaizalaConnectorId+'"}';

			console.log(sendData);
	        createObject(SubmitPin, methods[1],  contentType[1], rootUrl+"v1/generatePin", sendData);
	    
	    
	}


	
    function showPinForm()
    {
        document.getElementById("inputForm").style.display="block";
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
	
	function SubmitPin(e)
	{   //get pin 
		e.preventDefault();
		var kaizalaMobileNo = document.forms["pinsForm"]["kaizalaMobileNo "].value;
		var kaizalaConnectorId = document.forms["pinsForm"]["kaizalaConnectorId"].value;
        var authpin = document.forms["pinsForm"]["authpin"].value;

		// alert(patientName+patientDateOfBirth);
	    //validate
	    if((kaizalaMobileNo != "") && (kaizalaConnectorId != "") && (authpin != "") )
	    {
			var sendData = "kaizalaMobileNo="+kaizalaMobileNo +"&kaizalaConnectorId=" +kaizalaConnectorId +"&authpin=" + authpin;

			console.log(sendData);
	        createObject(authenticate, methods[1],  contentType[1], rootUrl+"v1/generatePin"+"savePin", sendData);
	    }
	}

	function showPatient(patientId)
	{
	    createObject(displaySinglePatient, methods[0], baseUrl+"getSinglePatient/"+patientId); 
	    return false;
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

	



	
	// document.getElementById("savePin").addEventListener("submit", postPin);

</script>
</body>

</html>