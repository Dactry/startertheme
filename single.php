<?php
get_header();
get_template_part('components/page-header');
$post_type = get_post_type();
while (have_posts()) :
	the_post(); ?>
	<div class="section-py">
		<div class="container-md" data-animate>
			<?php the_content(); ?>
			<?php
			$cats = get_core_categories();
			$tags = get_core_tags();
			if ($cats || $tags) {
				echo "<hr>$cats$tags";
			}
			?>
		</div>
	</div>
<?php
endwhile;
get_template_part('content-blocks/posts', null, ['class' => 'section-pb']);
get_footer();
