<?php require "incl/header.php"; ?>

<div class="row">
	<div class="col-8">
		<form action="" id="searchForm">
			<input type="search" name="searchField" placeholder="sök...">
		</form>
	</div>
</div>

<div class="row">
	<div class="col-8">
		<h4>Sökresultat för <span id="searchSpan"></span></h4>
		<div id="searchResult"></div>
	</div>
</div>
<script src="scripts/search.js"></script>