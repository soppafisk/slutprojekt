<?php

$topUsers = sqlQuery("SELECT username, nr_posts FROM users
LEFT JOIN 
	(SELECT COUNT(*) as nr_posts, user_id FROM posts GROUP BY user_id) p
ON users.id = p.user_id
ORDER BY nr_posts DESC
LIMIT 0, 10");
?>

<div class="col-4">
	<h4>Mest aktiva användare</h4>
	<table border='1'>
	<?php
	$useri = 0;
	foreach ($topUsers as $topUser) {
		$useri++;
		print "<tr>";
		print "<td>$useri</td><td><a href='?p=profile&u=" . $topUser['username'] . "'>" . $topUser['username'] . "</a></td><td>" . ($topUser['nr_posts']? $topUser['nr_posts'] : "0") . " poster</td>";
		print "</tr>";
	}
	?>

	</table>
</div>