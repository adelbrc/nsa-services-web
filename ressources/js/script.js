

// fonctions personnelles
function doAjax(url, form, obj) {

	let xhttp = new XMLHttpRequest();

	xhttp.onreadystatechange = function() {
		if (xhttp.readyState == 4 && xhttp.status == 200) {
			console.log(this.responseText);
			var jsonResponse = JSON.parse(this.responseText);
			console.log(jsonResponse);
			// on prend en charge les differentes actions possibles
			if (jsonResponse.action === "redirect") {
				window.location.replace("./"+jsonResponse.link);
			}
			
			// ne fonctionne pas en raison de l'asynchronicite, c galere g passé 30min dessus
			if (jsonResponse.action === "show") {
				return jsonResponse.message;
			} else {
				console.log("ok");
			}

		}
	};

	xhttp.open("GET", url+"?form=" + form + "&obj=" + obj, true);
	xhttp.send();
}
