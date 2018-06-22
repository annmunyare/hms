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

<div id ="updateForm">
	<form  class = "form-horizontal" action="#" method="POST"  id="updateVisit" name="updateForm1" >

	@csrf

	<div class="inputItems">
			<input class= "form-control" type="hidden" name="visitId" required>
		</div>

		<div class="inputItems">
			<label> Visit Name:</label>
			<input class= "form-control" type="text" name="visitName" required>
		</div>

		<div class="inputItems">
			<label> Visit Amount</label>
			<input class= "form-control" type="number" name="visitAmount" required>
		</div>

		<div  class="inputButton">
			<button class="btn btn-warning " type="button" onclick="hideInputForm()" > Cancel</button>
			<button  class="btn btn-primary " type="submit" >Update Visit</button>
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
	
	function displayVisits(jsonResponse)
	{
	
	    var responseObj = JSON.parse(jsonResponse);
	    var tData, count=0; 
	    var tableData ="<table class ='table table-bordered table-striped table-condensed'><tr> <th>ID</th><th>Visit Name</th> <th>Amount</th><th  colspan ='3'>Action</th></tr>";
	    for(tData in responseObj)
	    {
	        count++;
	        tableData+= "<tr><td>" + count +"</td>";
	        tableData+= "<td>" + responseObj[tData].visitName +"</td>";
	      	tableData+= "<td>" + responseObj[tData].visitAmount +"</td>";
			tableData+= "<td> <a href = '#' class= 'btn btn-info btn-sm' onclick ='showVisit("+responseObj[tData].visitId+")'> View</a></td>";
	        tableData+= "<td> <a href = '#' class= 'btn btn-success btn-sm' onclick = 'updateVisit("+responseObj[tData].visitId+", \""+responseObj[tData].visitName+"\", \""+responseObj[tData].visitAmount +"\" )'> Edit</a></td>";
	        tableData+= "<td> <a href = '#' class= 'btn btn-danger btn-sm' onclick ='deleteVisit("+responseObj[tData].visitId+", \""+responseObj[tData].visitName+"\" )'> Delete</a></td></tr>";
	
	    }
	    tableData+="</table>";
	    document.getElementById("allVisits").innerHTML= tableData;
	}
	
	function getVisits()
	{
	    createObject(displayVisits, methods[0], baseUrl + "getVisit");
	    document.getElementById("inputForm").style.display="none";
	    document.getElementById("updateForm").style.display="none";
		document.getElementById("allVisits").style.display="block";
	    
	}
	
	

	function showVisit(visitId)
	{
	    createObject(displaySingleVisit, methods[0], baseUrl+"getSingleVisit/"+visitId); 
	    return false;
	}

	function updateVisit(visitId, visitName, visitAmount)
	{
	    document.getElementById("updateForm").style.display="block";
	    document.getElementById("allVisits").style.display="none";
	    //get updatevisit
	    document.forms["updateForm1"]["visitName"].value = visitName;
	    document.forms["updateForm1"]["visitAmount"].value = visitAmount;
		document.forms["updateForm1"]["visitId"].value = visitId;
	}

	function updateVisit2(e)
	{
		e.preventDefault();
		var visitName = document.forms["updateForm1"]["visitName"].value;
	    var visitAmount = document.forms["updateForm1"]["visitAmount"].value;
		var visitId = document.forms["updateForm1"]["visitId"].value;

		var sendData = "visitName=" +visitName+"&visitAmount=" +visitAmount+"&visitId=" +visitId;
			console.log(sendData);
	        createObject(getVisits, methods[1], baseUrl+"updateVisit", sendData); 
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
	    document.getElementById("inputForm").style.display="none";
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
	document.getElementById("saveVisit").addEventListener("submit", submitVisit);
	document.getElementById("updateVisit").addEventListener("submit", updateVisit2);

</script>
</body>
</html>