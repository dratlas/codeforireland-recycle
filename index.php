<?php

ob_start("ob_gzhandler");

?>
<!DOCTYPE html>
<html lang="en">
<head>
	<title> RecycleThis! </title>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
	<meta name="author" content="NKM,ibis" />
	<meta name="keywords" content="" />
	<meta name="description" content="Code for Ireland's RecycleThis! app lets you report vacant houses and other issues." />
	<meta name="theme-color" content="#6666FF" />
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<style>
		body,td,p,input,textarea{font:10pt Verdana}
	</style>
    <link rel='manifest' href='manifest.json'>
    <meta name='mobile-web-app-capable' content='yes'>
    <meta name='apple-mobile-web-app-capable' content='yes'>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
	<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCN4-WY6nEjUZWfTdv-cU5JAYRQMvDfZt8&libraries=places" async defer></script>
	<SCRIPT LANGUAGE="JavaScript">
	<!--
	if (navigator.serviceWorker.controller) {
		//console.log('[PWA Builder] active service worker found, no need to register')
	} 
	else {
	//*Register the ServiceWorker
	navigator.serviceWorker.register('/codeforireland/pwa/pwabuilder-sw.js', {scope: './'
	}).then(function(reg) {
		//console.log('Service worker has been registered for scope:'+ reg.scope);
	});
	}
	//**get the user's location if available 
	function getLocation() {
	  if (navigator.geolocation) {
		  //alert("Trying");
		navigator.geolocation.getCurrentPosition(showPosition,onPosError);
	  } else {
		//x.innerHTML = "Geolocation is not supported by this browser.";
	  }
	}
	//**get the address from the location via Google Maps API
	function getAddress() {
		var lat = parseFloat(document.getElementById("lat").value);
		var lng = parseFloat(document.getElementById("long").value);
		var latlng = new google.maps.LatLng(lat, lng);
		var geocoder = geocoder = new google.maps.Geocoder();
		geocoder.geocode({ 'latLng': latlng }, function (results, status) {
			if (status == google.maps.GeocoderStatus.OK) {
				if (results[1]) {
					bits=results[1].formatted_address.split(", ");
					//*should give the county as second from end
					document.getElementById("address").value=results[1].formatted_address;
					county=bits[bits.length-2];
					document.getElementById("county").value=county;
				}
			}
		});
	}
	
	function showPosition(position) {
		//alert("showPosition");
		var lat = document.getElementById("lat");
		var lng = document.getElementById("long");
		lat.value = position.coords.latitude;
		lng.value = position.coords.longitude;
		getAddress();
	}
	function onPosError(error){
		alert('Error occurred. Error code: ' + error.code);;
	}
	function encodeFile() {
		var preview = document.querySelector('img');
		var data = document.getElementById('imgdata');
		var file    = document.querySelector('input[type=file]').files[0];
		var reader  = new FileReader();

		reader.addEventListener("load", function () {
			preview.src = reader.result;
			data.value=reader.result;
		}, false);

		if (file) {
			reader.readAsDataURL(file);
		}
		getLocation();
	}
	//**encodes the form data as JSON
	function encodeJSON(){
		ptype=document.getElementById('ptype').options[document.getElementById('ptype').selectedIndex].value;
		plat=document.getElementById('lat').value;
		plong=document.getElementById('long').value;
		paddress=document.getElementById('address').value;
		pcounty=document.getElementById('county').value;
		pcomments=document.getElementById('comments').value;
		imgdata=document.getElementById('imgdata').value;
		rjson=document.getElementById('rjson').value;
		if(document.getElementById('rjson').checked){rjson="Yes";}
		else{rjson="No";}
		chars=[];
		chks=document.getElementsByName('chars');//*assume this array of checkboxes only used for characteristics
		for(let i=0;i<chks.length;i++){
			val="No";
			if(chks[i].checked){
				val="Yes";
			}
			chara={"var":chks[i].value,"val":val};
			chars.push(chara);
		}
		json={"type":ptype,"lat":plat,"long":plong,"address":paddress,"county":pcounty,"comments":pcomments,"img":imgdata,"chars":chars,"rjson":rjson}
		document.getElementById('jsondata').value=JSON.stringify(json);
	}
	//-->
	</SCRIPT>
</head>

<body>
<div class="container">
<nav class="navbar navbar-expand-lg navbar-dark bg-primary">
  <a class="navbar-brand" style="color:white" href="#">RecycleThis!</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
    <div class="navbar-nav">
      <a class="nav-item nav-link active" href="index.php">Home <span class="sr-only">(current)</span></a>
      <a class="nav-item nav-link" href="gallery.php">Gallery</a>
      <a class="nav-item nav-link" href="contact.html">Contact</a>
      <a class="nav-item nav-link disabled" href="#">Disabled</a>
    </div>
  </div>
</nav>
<img src="" id="preview" height="200" alt="Image preview...">
  <div class="form-group">
    <label for="imgfile">Photo</label>
    <input type="file" id="imgfile" class="form-control-file"  NAME="image" onchange="encodeFile()" accept="image/*" placeholder="Photo">
    <small id="imgfile-Help" class="form-text text-muted">From camera, photoroll, or file.</small>
  </div>
  <div class="form-group">
    <label for="ptype">Report Type</label>
		<SELECT id="ptype" class="form-control">
			<OPTION VALUE="Vacant House" SELECTED>Vacant House
			<OPTION VALUE="Other">Other
		</SELECT>	
    <small id="ptype-Help" class="form-text text-muted">Not sure what types we have. Could use DCC reporting types?</small>
  </div>
  <div class="form-group">
    <label for="lat">Latitude</label>
    <input type="number" id="lat" class="form-control" id="exampleInputEmail1" aria-describedby="lat-Help" placeholder="Latitude" value="53.27141455">
    <small id="lat-Help" class="form-text text-muted">From phone.</small>
  </div>
  <div class="form-group">
    <label for="long">Longitude</label>
    <input type="number" id="long" class="form-control" id="exampleInputEmail1" aria-describedby="long-Help" placeholder="Latitude" value="-7.48637259">
    <small id="long-Help" class="form-text text-muted">From phone.</small>
  </div>
  <div class="form-group">
    <label for="address">Address</label>
    <input type="text" id="address" class="form-control" id="exampleInputEmail1" aria-describedby="address-Help" placeholder="Latitude" value="Glenaulin, Bachelor's Walk, Tullamore, Co. Offaly, Ireland">
    <small id="address-Help" class="form-text text-muted">Reverse geocode client-side or server-side?</small>
  </div>
  <div class="form-group">
    <label for="county">County</label>
    <input type="text" id="county" class="form-control" id="exampleInputEmail1" aria-describedby="county-Help" placeholder="Latitude" value="Offaly">
    <small id="county-Help" class="form-text text-muted">From address geocode.</small>
  </div>
  <div class="form-group">
    <label for="comments">Comments</label>
	<TEXTAREA id="comments" class="form-control" id="exampleInputEmail1" aria-describedby="comments-Help" ROWS="3" COLS="40"></textarea>
    <small id="comments-Help" class="form-text text-muted">From address geocode.</small>
  </div>
  <h4>Problems</h4>
<div class="form-check">
  <input class="form-check-input" type="checkbox" name="chars" value="Boarded Windows" id="BoardedWindows">
  <label class="form-check-label" for="BoardedWindows">
    Boarded Windows
  </label>
</div>
<div class="form-check">
  <input class="form-check-input" type="checkbox" name="chars" value="Broken Windows" id="BrokenWindows">
  <label class="form-check-label" for="BrokenWindows">
    Broken Windows
  </label>
</div>
<p>
  <h4>Technical</h4>
	<button style="display:none" id="homeAdd" class="btn btn-info">Add to Home Screen</button>
<div class="form-check">
  <input class="form-check-input" type="checkbox" name="rjson" value="Yes" id="rjson">
  <label class="form-check-label" for="rjson">
    Return JSON (whether to return JSON or web page after submission)
  </label>
</div>

<input type="hidden" id="imgdata">

<FORM METHOD=POST ACTION="../insert/index.php" onsubmit="encodeJSON()">
<INPUT TYPE="submit" class="form-control btn-secondary">
  <div class="form-group">
    <label for="jsondata">Comments</label>
	<TEXTAREA id="jsondata" class="form-control" name="json" aria-describedby="json-Help" ROWS="5" COLS="80"></textarea>
    <small id="json-Help" class="form-text text-muted"><button onclick="encodeJSON();return false;" class="btn btn-info">Show JSON</button> Displays the JSON.</small>
  </div>


</FORM>
<SCRIPT LANGUAGE="JavaScript">
<!--
btnAdd=document.getElementById('homeAdd');
window.addEventListener('beforeinstallprompt', (e) => {
	// Prevent Chrome 67 and earlier from automatically showing the prompt
	e.preventDefault();
	// Stash the event so it can be triggered later.
	deferredPrompt = e;
	// Update UI notify the user they can add to home screen
	btnAdd.style.display = 'block';
});
btnAdd.addEventListener('click', (e) => {
  // hide our user interface that shows our A2HS button
  btnAdd.style.display = 'none';
  // Show the prompt
  deferredPrompt.prompt();
  // Wait for the user to respond to the prompt
  deferredPrompt.userChoice
    .then((choiceResult) => {
      if (choiceResult.outcome === 'accepted') {
        console.log('User accepted the A2HS prompt');
      } else {
        console.log('User dismissed the A2HS prompt');
      }
      deferredPrompt = null;
    });
});

//-->
</SCRIPT>
<nav class="navbar navbar-expand-lg navbar-dark bg-primary">
  <a class="navbar-brand" style="color:white" href="#">&copy; RecycleThis 2018</a>
</nav>
</div>
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
</body>
</html>
