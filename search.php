<?php require "incl/header.php"; ?>

<div class="row">
	<div class="col-xs-8">
		<form action="" id="searchForm">
			<div class="form-group">
				<input type="search" class="form-control" name="searchField" placeholder="Sök...">
			</div>
		</form>
	</div>
</div>

<div class="row">
	<div class="col-xs-8">
		<h4>Sökresultat för <span id="searchSpan"></span></h4>
		<div id="searchResult"></div>
	</div>
</div>
<script src="scripts/search.js"></script>