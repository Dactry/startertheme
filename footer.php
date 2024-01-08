</main>
<footer class="site-footer bg-surface section-py">
	<div class="container underline-reverse">
		<div class="row">
			<?php
			$footer_widget_counter = 1;
			while ($footer_widget_counter <= FOOTER_SIDEBAR_QUANTITY) {
				$sidebar_name = "footer-sidebar-$footer_widget_counter";
				if (is_active_sidebar($sidebar_name)) {
					dynamic_sidebar($sidebar_name);
				}
				$footer_widget_counter++;
			}
			?>
		</div>
		<div class="row section-pt">
			<div class="col">&copy;<?php bloginfo('name'); ?> <?= esc_html(date('Y')); ?></div>
			<div class="col-auto">Website by <a href="https://sgd.com.au/" target="_blank">SGD</a></div>
		</div>
	</div>
</footer>

<?php wp_footer(); ?>

</body>

</html>