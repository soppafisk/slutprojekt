<?php

print "<img src='img/uparrow.png'>";
print "<img src='img/downarrow.png'>";
if ($post['nsfw']) {
	print " ";
	print "NSFW";
}
print "<h4 class='post_title'><a href='" . $post['link'] .  "'>" . $post['title'] . "</a></h4>";
print $post['username'];

print "<br>";
print "<a href='index.php?p=post&id={$post['id']}'>Kommentarer</a>";
print "<hr>";