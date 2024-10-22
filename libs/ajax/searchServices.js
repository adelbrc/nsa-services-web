function showResult(str) {

  if (str.length == 0) {
    document.getElementById("serviceSearch").innerHTML = "";
    document.getElementById("serviceSearch").style.border = "0px";
    return;
  }

  if (window.XMLHttpRequest) {
    // code for IE7+, Firefox, Chrome, Opera, Safari
    xmlhttp=new XMLHttpRequest();
  } else {  // code for IE6, IE5
    xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  }

  xmlhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
      document.getElementById("serviceSearch").innerHTML = this.responseText;
      document.getElementById("serviceSearch").style.padding = "5px 10px";
      document.getElementById("serviceSearch").style.border = "1px solid rgb(23, 133, 223)";
      document.getElementById("serviceSearch").style.borderRadius = "20px";
      document.getElementById("serviceSearch").style.marginTop = "5px";
      document.getElementById("serviceSearch").style.textAlign = "left";
    }
  }

  xmlhttp.open("GET","libs/php/controllers/searchService.php?q=" + str, true);
  xmlhttp.send();
}
