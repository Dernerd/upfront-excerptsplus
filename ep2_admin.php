<?php

/* All the WP admin backend functions */



function ep_admin_options_page() {
?>
		<h3>Refresh Excerpts+ Cache</h3>
		<p>If you update or change images in any posts,sometimes the image cache may get out-of-sync. In that case, you can refresh the Excerpts+ image cache to ensure your site visitors are seeing the correct images.</p> <p>Please note: Refreshing the cache causes no problems other than the next person who visits your site may have to wait a little longer as the cache images get recreated. <strong>No images in any post will be affected</strong>. </p><p>Click the button to refresh the Excerpts+ image cache.</p>
		<form action="admin.php?page=pizazz-tools" method="post">
			<input class="button-primary" type="submit" name="emptyepcache" value="Refresh Excerpts+ Image Cache">
		</form>
		<hr style="margin-top:20px;border-color:#eee;border-style:solid;"/>

<?php
}
