// const contentType = ['application/x-www-form-urlencoded', 'application/json'];
// const methods = ['POST', 'GET'];
// const baseUrl = ['https://api.kaiza.la/', 'https://kms.kaiza.la/'];



// function ajaxRequest(readyStateFunction, method, url, sendDetails = null, refreshToken = null, vars = null, accessToken = null) {
//     let xhr = new XMLHttpRequest();

//     xhr.onreadystatechange = function() {
//         if ((this.readyState == 4) && (this.status == 200)) {
//             readyStateFunction(this.responseText, accessToken = null);
//         }
//     };

//     xhr.open(method, url, true);

//     if (refreshToken != null) {
//         xhr.setRequestHeader("applicationId", vars[0]);
//         xhr.setRequestHeader("applicationSecret", vars[1]);
//         xhr.setRequestHeader("refreshToken", refreshToken);
//     }

//     if (accessToken != null) {
//         xhr.setRequestHeader("accessToken", accessToken);
//     }

//     if (method == 'POST') {
//         xhr.setRequestHeader("Content-Type", "application/json");

//         console.log(sendDetails);
//         xhr.send(sendDetails);
//     } else {
//         xhr.send();
//     }
// }

// const kaizalGroups = document.getElementById('kaizalaGroups');

// kaizalGroups.addEventListener('click', generatePin);

// function showPinForm() {

// }

// function generatePin() {
//     document.getElementById('pinGenerate').classList.remove('display-none');
//     let phone = document.getElementById('kaizalaPhone').value;
//     let connectorId = document.getElementById('connectorId').value;

//     let sendDetails = '{"mobileNumber":"' + phone + '", applicationId:"' + connectorId + '"}';

//     ajaxRequest(showPinForm, methods[0], baseUrl[0] + 'v1/generatePin', sendDetails);
// }

// const generatedPinForm = document.getElementById('pinGenerate');
// generatedPinForm.addEventListener('submit', postPin);

// function postPin(event) {
//     event.preventDefault();
//     const mobileNumber = document.getElementById('kaizalaPhone').value;
//     const applicationId = document.getElementById('connectorId').value;
//     const applicationSecret = document.getElementById('connectorSecret').value;
//     const pin = document.getElementById('generatedPin').value;

//     let sendDetails = '{"mobileNumber":"' + mobileNumber + '","applicationId":"' + applicationId + '", "applicationSecret":"' + applicationSecret + '",' + '"pin":' + pin + '}';
//     ajaxRequest(getRefreshToken, methods[0], baseUrl[0] + 'v1/loginWithPinAndApplicationId', sendDetails);
// }

// function getRefreshToken(jsonResponse) {
//     const refreshToken = JSON.parse(jsonResponse);

//     console.log(refreshToken);

//     const applicationId = document.getElementById('connectorId').value;
//     const applicationSecret = document.getElementById('connectorSecret').value;

//     const vars = [applicationId, applicationSecret];

//     ajaxRequest(getAccessToken, methods[1], baseUrl[1] + '/v1/accessToken', null, refreshToken.refreshToken, vars);
// }

// function getAccessToken(jsonResponse) {
//     const accessToken = JSON.parse(jsonResponse);

//     console.log(accessToken);

//     //ajaxRequest(getUser, methods[1], baseUrl[1] + '/v1/users/me', null, null, null, accessToken.accessToken);
//     ajaxRequest(fetchGroups, methods[1], baseUrl[1] + '/v1/groups?fetchAllGroups=true&showDetails=true', null, null, null, accessToken.accessToken);
// }

// function getUser(jsonResponse, accessToken) {
//     const user = JSON.parse(jsonResponse);

//     console.log(user);
//     ajaxRequest(fetchGroups, methods[1], baseUrl[1] + '/v1/groups?fetchAllGroups=true&showDetails=true', null, null, null, accessToken);
// }


// let table = '';
// table += "<table class='table table-bordered table-striped table-condensed'><tr><th class='text-centre'>Group Name</th><th class='text-centre'>Sub Groups</th>";
// table += "<th class='text-centre'>Group Type</th><th class='text-centre'>Welcome Message</th></tr><tbody id='tbody'></tbody></table>";

// function fetchGroups(jsonResponse) {
//     const responseObj = JSON.parse(jsonResponse);


//     let groups = responseObj.groups;

//     console.log(groups);

//     let tbody = '';
//     for (let i = 0; i < groups.length; i++) {
//         tbody += '<tr><td>' + responseObj.groups[i].groupName + '</td>';
//         tbody += '<td>' + responseObj.groups[i].hasSubGroups + '</td>';
//         tbody += '<td>' + responseObj.groups[i].groupType + '</td>';                
//         tbody += '<td>' + responseObj.groups[i].welcomeMessage + '</td></tr>';

//         document.getElementById('kaizala').innerHTML = table;
//         document.getElementById('tbody').innerHTML = tbody;
//     }
// }