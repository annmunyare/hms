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

<body onload="getServices()">
<nav class="navbar navbar-expand-lg navbar-light bg-light">
	<div class="collapse navbar-collapse" id="navbarSupportedContent">
	    <ul class="navbar-nav mr-auto">

			<li class="nav-item">
				<a class="nav-link" href="#"  > Patients</a>
			
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
			<a class="nav-link" href="/groups">Authenticate</a>
			</li>

		</ul>
	</div>
</nav>
<div class = "container">
<div id="inputForm" >
	<form action="#" method="POST"  id="saveService" name="servicesForm" >
		@csrf
		<div class="inputItems">
			<label> Service Name:</label>
			<input class= "form-control" type="text" name="serviceName" required>
		</div>

		<div class="inputItems">
			<label>  Service Amount</label>
			<input class= "form-control" type="number" name="serviceAmount" required>
		</div>

		<div  class="inputButton">
			<button  class="btn btn-warning" type="button" onclick="hideInputForm()" > Cancel</button>
			<button   class="btn btn-primary" type="submit">Add Service</button>
		</div>
	</form>
</div>

<div id ="allServices"></div>

<div id ="updateForm">
	<form  class = "form-horizontal" action="#" method="POST"  id="updateService" name="updateForm1" >

	@csrf

	<div class="inputItems">
			<input class= "form-control" type="hidden" name="serviceId" required>
		</div>

		<div class="inputItems">
			<label> Service Name:</label>
			<input class= "form-control" type="text" name="serviceName" required>
		</div>

		<div class="inputItems">
			<label> Service Amount</label>
			<input class= "form-control" type="number" name="serviceAmount" required>
		</div>

		<div  class="inputButton">
			<button class="btn btn-warning " type="button" onclick="hideInputForm()" > Cancel</button>
			<button  class="btn btn-primary " type="submit" >Update Service</button>
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
	
	function displayServices(jsonResponse)
	{
	
	    var responseObj = JSON.parse(jsonResponse);
	    var tData, count=0; 
	    var tableData ="<button  class= 'btn btn-primary' type = 'button' onclick='showInputForm()'> Add Service</button><table class ='table table-bordered table-striped table-condensed'><tr> <th>ID</th><th>Service Name</th> <th>Amount</th><th  colspan ='3'>Action</th></tr>";
	    for(tData in responseObj)
	    {
	        count++;
	        tableData+= "<tr><td>" + count +"</td>";
	        tableData+= "<td>" + responseObj[tData].serviceName +"</td>";
	      	tableData+= "<td>" + responseObj[tData].serviceAmount +"</td>";
			tableData+= "<td> <a href = '#' class= 'btn btn-info btn-sm' onclick ='showService("+responseObj[tData].serviceId+")'> View</a></td>";
	        tableData+= "<td> <a href = '#' class= 'btn btn-success btn-sm' onclick = 'updateService("+responseObj[tData].serviceId+", \""+responseObj[tData].serviceName+"\", \""+responseObj[tData].serviceAmount +"\" )'> Edit</a></td>";
	        tableData+= "<td> <a href = '#' class= 'btn btn-danger btn-sm' onclick ='deleteService("+responseObj[tData].serviceId+", \""+responseObj[tData].serviceName+"\" )'> Delete</a></td></tr>";
	
	    }
	    tableData+="</table>";
	    document.getElementById("allServices").innerHTML= tableData;
	}
	
	function getServices()
	{
	    createObject(displayServices, methods[0], baseUrl + "getService");
	    document.getElementById("inputForm").style.display="none";
	    document.getElementById("updateForm").style.display="none";
		document.getElementById("allServices").style.display="block";
	    
	}
	
	function submitService(e)
	{   //get serviceault 
		e.preventDefault();
		var serviceName = document.forms["servicesForm"]["serviceName"].value;
		var serviceAmount = document.forms["servicesForm"]["serviceAmount"].value;

		// alert(serviceName+serviceAmount);
	    //validate
	    if((serviceName != "") && (serviceAmount != ""))
	    {
			var sendData = "serviceName="+serviceName+"&serviceAmount=" +serviceAmount;
			// console.log(sendData);
	        createObject(getServices, methods[1], baseUrl+"saveService", sendData);
	    }
	}

	function showService(serviceId)
	{
	    createObject(displaySingleService, methods[0], baseUrl+"getSingleService/"+serviceId); 
	    return false;
	}

	function updateService(serviceId, serviceName, serviceAmount)
	{
	    document.getElementById("updateForm").style.display="block";
	    document.getElementById("allServices").style.display="none";
	    //get updateservice
	    document.forms["updateForm1"]["serviceName"].value = serviceName;
	    document.forms["updateForm1"]["serviceAmount"].value = serviceAmount;
		document.forms["updateForm1"]["serviceId"].value = serviceId;
	}

	function updateService2(e)
	{
		e.preventDefault();
		var serviceName = document.forms["updateForm1"]["serviceName"].value;
	    var serviceAmount = document.forms["updateForm1"]["serviceAmount"].value;
		var serviceId = document.forms["updateForm1"]["serviceId"].value;

		var sendData = "serviceName=" +serviceName+"&serviceAmount=" +serviceAmount+"&serviceId=" +serviceId;
			console.log(sendData);
	        createObject(getServices, methods[1], baseUrl+"updateService", sendData); 
	}
	
	function displaySingleService(jsonResponse)
	{
	    var responseObj2 = JSON.parse(jsonResponse);
		 var htmlString= "<h1>" + responseObj2.serviceName+"</h1>" + "<p>" + responseObj2.serviceAmount +"</p>"+"<button class= 'btn btn-warning ' type='button' onclick='getServices()'>Go Back</button>";
	
	    document.getElementById("allServices").innerHTML= htmlString;
	}
	
	function showInputForm()
	{
	    document.getElementById("inputForm").style.display="block";
	    document.getElementById("allServices").style.display="none";
	}
	
	function hideInputForm()
	{
	    document.getElementById("inputForm").style.display="none";
	    document.getElementById("allServices").style.display="block";
	    document.getElementById("updateForm").style.display="none";
	}
	function submitNewService() 
	{
		
	    //get service
	    var serviceName = document.forms["updateForm1"]["serviceName"].value;
	    var serviceAmount = document.forms["updateForm1"]["serviceAmount"].value;
	
	        // alert(serviceName+serviceAmount);
	    //validate
	    if((serviceName != "") && (serviceAmount != ""))
	    {
	        createObject(getServices, methods[1], baseUrl +"updateService"); 
	    }
	    else
	    {
	        alert("invalid input");
	    }
	    
	}
	function deleteService(serviceId, serviceName)
	{   var text;
	    if(confirm( "Do you want to delete" + " "+serviceName + "?"))
	    {
	        text = "You are pressed ok";
	        createObject(getServices, methods[0], baseUrl +"deleteService/"+serviceId); 
	        alert("You have deleted" + " "+serviceName );
	    }
	    else
	    {
	        text = "You are pressed cancel"
	    }
	    return false;

	
	    
	}
	document.getElementById("saveService").addEventListener("submit", submitService);
	document.getElementById("updateService").addEventListener("submit", updateService2);

</script>
</body>

</html>