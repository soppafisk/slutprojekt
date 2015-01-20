function search() {
	var xmlhttp = new XMLHttpRequest();

	xmlhttp.onreadystatechange = function() {
		if (xmlhttp.status == 200 && xmlhttp.readyState == 4) {
            searchResult.innerHTML = xmlhttp.responseText;
        }
	}
	xmlhttp.open('GET', 'forms/sendsearch.php?s='+searchField.value, true);
    xmlhttp.send();

    searchResult.innerHTML = 'Laddar..';
    searchSpan.innerHTML = searchField.value;
}

var searchField = searchForm.searchField;
var searchSpan = document.getElementById('searchSpan');

searchField.addEventListener('keyup', search);