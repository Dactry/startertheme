<?php
if (!is_active_sidebar('blog-sidebar-1')) {
	return;
}
?>
<aside class="col-md-4 col-lg-3 section-pb">
	<div class="site-sidebar underline-reverse">
		<?php dynamic_sidebar('blog-sidebar-1'); ?>
	</div>
</aside>