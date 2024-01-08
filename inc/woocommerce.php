<?php

define('MINI_CART', false); //If True - don't forget to enable AJAX add to cart on archives in Woocommerce > Settings > Products

/**
 * Disable CSS Blocks
 */
function disable_wc_css_blocks()
{

	wp_enqueue_style('theme-woocommerce', get_core_enqueue_path('woocommerce.css'), [], null);
	// wp_enqueue_script('theme-woocommerce-async', get_core_enqueue_path('woocommerce.js'), ['jquery'], null, true);

	$styles = array(
		'wc-blocks-style',
		'wc-blocks-style-active-filters',
		'wc-blocks-style-add-to-cart-form',
		'wc-blocks-packages-style',
		'wc-blocks-style-all-products',
		'wc-blocks-style-all-reviews',
		'wc-blocks-style-attribute-filter',
		'wc-blocks-style-breadcrumbs',
		'wc-blocks-style-catalog-sorting',
		'wc-blocks-style-customer-account',
		'wc-blocks-style-featured-category',
		'wc-blocks-style-featured-product',
		'wc-blocks-style-mini-cart',
		'wc-blocks-style-price-filter',
		'wc-blocks-style-product-add-to-cart',
		'wc-blocks-style-product-button',
		'wc-blocks-style-product-categories',
		'wc-blocks-style-product-image',
		'wc-blocks-style-product-image-gallery',
		'wc-blocks-style-product-query',
		'wc-blocks-style-product-results-count',
		'wc-blocks-style-product-reviews',
		'wc-blocks-style-product-sale-badge',
		'wc-blocks-style-product-search',
		'wc-blocks-style-product-sku',
		'wc-blocks-style-product-stock-indicator',
		'wc-blocks-style-product-summary',
		'wc-blocks-style-product-title',
		'wc-blocks-style-rating-filter',
		'wc-blocks-style-reviews-by-category',
		'wc-blocks-style-reviews-by-product',
		'wc-blocks-style-product-details',
		'wc-blocks-style-single-product',
		'wc-blocks-style-stock-filter',
		'wc-blocks-style-cart',
		'wc-blocks-style-checkout',
		'wc-blocks-style-mini-cart-contents',
	);

	foreach ($styles as $style) {
		wp_deregister_style($style);
	}
}
add_action('wp_enqueue_scripts', 'disable_wc_css_blocks', 100);

/**
 * WooCommerce Widgets
 */
function woocommerce_widgets()
{
	register_sidebar(
		array(
			'name'          => esc_html__('Shop Sidebar', 'core'),
			'id'            => 'shop-sidebar-1',
			'before_widget' => '<div class="site-sidebar__widget %2$s">',
			'after_widget'  => '</div>',
			'before_title'  => '<h3 class="site-sidebar__title h5">',
			'after_title'   => '</h3>',
		)
	);
}
add_action('widgets_init', 'woocommerce_widgets');

/**
 * WooCommerce Star Font
 */
function woocommerce_star_font()
{
	if (wc_review_ratings_enabled()) {
		$font_path   = WC()->plugin_url() . '/assets/fonts/';
		echo '<style>
@font-face{
font-family: "star";
src: url("' . $font_path . 'star.eot");
src: url("' . $font_path . 'star.eot?#iefix") format("embedded-opentype"),
url("' . $font_path . 'star.woff") format("woff"),
url("' . $font_path . 'star.ttf") format("truetype"),
url("' . $font_path . 'star.svg#star") format("svg");
font-weight: normal;
font-style: normal;
}</style>';
	}
}
add_action('wp_head', 'woocommerce_star_font');

/**
 * WooCommerce Compatibility File
 */
function core_woocommerce_setup()
{
	add_theme_support(
		'woocommerce',
		array(
			'product_grid'          => array(
				'min_rows'        => 1,
				'min_columns'     => 1,
				'max_columns'     => 4,
				'default_rows'    => 3,
				'default_columns' => 4,
			),
		)
	);
	add_theme_support('wc-product-gallery-zoom');
	add_theme_support('wc-product-gallery-lightbox');
	add_theme_support('wc-product-gallery-slider');
}
add_action('after_setup_theme', 'core_woocommerce_setup');

/**
 * Disable The Default WooCommerce Stylesheet
 */
add_filter('woocommerce_enqueue_styles', '__return_empty_array');

/**
 * Related Products Args
 */
function core_woocommerce_related_products_args($args)
{
	$defaults = array(
		'posts_per_page' => 4,
		'columns'        => 4,
	);
	$args = wp_parse_args($defaults, $args);
	return $args;
}
add_filter('woocommerce_output_related_products_args', 'core_woocommerce_related_products_args');

/**
 * Cross Sells Columns
 */
function change_cross_sells_columns()
{
	return 4;
}
add_filter('woocommerce_cross_sells_columns', 'change_cross_sells_columns');

/**
 * Number Of Orders Per Page In My Account – Orders
 */

add_filter('woocommerce_my_account_my_orders_query', 'custom_my_account_orders', 10, 1);
function custom_my_account_orders($args)
{
	$args['limit'] = 10;

	return $args;
}


/**
 * Cart Fragments
 * You can add the wooCommerce mini cart to header.php like so:
 */
// 
// if ( function_exists( 'core_woocommerce_header' ) ) {
// 	core_woocommerce_header();
// }
// 

if (!function_exists('core_woocommerce_cart_fragment')) {

	function core_woocommerce_cart_fragment($fragments)
	{
		if (!MINI_CART) return;
		ob_start();
		core_woocommerce_cart_counter();
		$fragments['.custom-mini-cart__counter'] = ob_get_clean();

		return $fragments;
	}
}
add_filter('woocommerce_add_to_cart_fragments', 'core_woocommerce_cart_fragment');

/**
 * Cart Counter
 */
if (!function_exists('core_woocommerce_cart_counter')) {

	function core_woocommerce_cart_counter()
	{
		if (!MINI_CART) return;
?>
		<span class="custom-mini-cart__counter"><?= esc_html(WC()->cart->get_cart_contents_count()); ?></span>
	<?php
	}
}

/**
 * Display Header
 */
if (!function_exists('core_woocommerce_header')) {

	function core_woocommerce_header()
	{
	?>
		<?php
		$show_mini_cart_condition = !is_cart() && !is_checkout() && MINI_CART;
		?>
		<ul class="site-menu user-menu">
			<li>
				<?php $account_link = get_permalink(get_option('woocommerce_myaccount_page_id')); ?>
				<a href="<?= esc_url($account_link); ?>" aria-label="Account"><?php get_template_part('components/site-icon', null, ['icon' => 'person']); ?>Account</a>
				<?php if (is_user_logged_in()) { ?>
					<ul class="dropdown">
						<?php foreach (wc_get_account_menu_items() as $endpoint => $label) : ?>
							<li class="<?= wc_get_account_menu_item_classes($endpoint); ?>">
								<a href="<?= esc_url(wc_get_account_endpoint_url($endpoint)); ?>"><?= esc_html($label); ?></a>
							</li>
						<?php endforeach; ?>
					</ul>
				<?php } ?>
			</li>
			<li>
				<a <?= $show_mini_cart_condition ? "data-custom-mini-cart-toggle='main-link'" : null; ?> href="<?= esc_url(wc_get_cart_url()); ?>">
					<?php
					core_woocommerce_cart_counter();
					get_template_part('components/site-icon', null, ['icon' => 'cart']);
					?>
					Cart
				</a>
			</li>
		</ul>

		<?php
		if ($show_mini_cart_condition) {
			$instance = array(
				'title' => '',
			);
			ob_start();
			get_template_part('components/site-icon', null, ['icon' => 'close', 'class' => 'toggle-button__icon']);
			$close_icon = ob_get_clean();

			$args = array(
				'before_widget' => 	'<div class="custom-mini-cart">
									<div class="custom-mini-cart__header">
										<h2 class="custom-mini-cart__header-title">Cart</h2>
										<button type="button" class="toggle-button" data-custom-mini-cart-toggle><span class="toggle-button__label">Close</span>' . $close_icon . '</button>
									</div>',
				'after_widget'	=> 	'</div><div data-custom-mini-cart-toggle class="curtain curtain--cart curtain--hidden stretch pos-fixed"></div>',
			);
			the_widget('WC_Widget_Cart', $instance, $args);
		}
		?>
	<?php
	}
}

//Edit Store Notice
remove_action('wp_footer', 'woocommerce_demo_store');
add_action('wp_body_open', 'woocommerce_demo_store');

add_filter('woocommerce_demo_store', 'demo_store_filter', 10, 1);
function demo_store_filter($text)
{
	ob_start();
	get_template_part('components/site-icon', null, ['icon' => 'close']);
	$icon =  ob_get_clean();
	$text = str_replace(array('Dismiss'), array("<span class='screen-reader-text'>Dismiss</span>$icon"), $text);
	return $text;
}


//If Mini Cart Is Empty Show "Shop Now" button
add_action('woocommerce_after_mini_cart', function () {
	if (WC()->cart->is_empty()) {
		$shop_link = esc_url(get_permalink(woocommerce_get_page_id('shop')));
		echo "<a href='$shop_link' class='button'>Shop Now</a>";
	}
});


/**
 * Layout Changes
 */

//Remove Default WooCommerce Wrapper
remove_action('woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10);
remove_action('woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10);

//Archive - Banner
function woocommerce_page_banner()
{
	if (!is_product()) {
		$current_object = get_queried_object();
		$current_object_featured_img_id = get_term_meta($current_object->term_id ?? null, 'thumbnail_id', true);

		$shop_featured_img_id = get_post_thumbnail_id(wc_get_page_id('shop'));

		if ($current_object_featured_img_id) {
			$banner_id = $current_object_featured_img_id;
		} elseif ($shop_featured_img_id) {
			$banner_id = $shop_featured_img_id;
		} else {
			$banner_id = get_post_thumbnail_id();
		}

		$banner_default_args = [
			'title' => woocommerce_page_title(false),
			'img_id' => $banner_id
		];
		get_template_part('components/page-header', null, $banner_default_args);
	}
}
add_action('woocommerce_before_main_content', 'woocommerce_page_banner', 0);

//Archive - Container
add_action('woocommerce_before_main_content', function () {
	if (!is_product()) {
		echo "<div class='container section-pb' data-role='shop-container'>";
		echo "<div class='row' data-role='shop-row'>";
		echo "<div class='col-md' data-role='shop-main'>";
	}
}, 0);

add_action('woocommerce_after_main_content', function () {
	if (!is_product()) {
		echo "</div>"; //.data-role='shop-main'
	}
}, 100);

add_action('woocommerce_after_main_content', function () {
	if (!is_product()) {
		echo "</div>"; //data-role='shop-row'
		echo "</div>"; //data-role='shop-container'
	}
}, 1000);

//Archive - Remove Title
add_filter('woocommerce_show_page_title', function () {
	return false;
});

//Archive - Breadcrumbs
remove_action('woocommerce_before_main_content', 'woocommerce_breadcrumb', 20);
add_action('woocommerce_archive_description', 'woocommerce_breadcrumb', 5);

//Archive - Count And Sort
remove_action('woocommerce_before_shop_loop', 'woocommerce_result_count', 20);
remove_action('woocommerce_before_shop_loop', 'woocommerce_catalog_ordering', 30);

add_action('woocommerce_before_shop_loop', function () {
	echo "<div class='row gx-1 align-items-center' data-role='shop-count-order'>";
	echo "<div class='col'>";
}, 60);

add_action('woocommerce_before_shop_loop', 'woocommerce_result_count', 60);

add_action('woocommerce_before_shop_loop', function () {
	echo "</div>"; //.col
	echo "<div class='col-auto'>";
}, 60);

add_action('woocommerce_before_shop_loop', 'woocommerce_catalog_ordering', 60);

add_action('woocommerce_before_shop_loop', function () {
	echo "</div>"; //.col-auto
	echo "</div>"; //data-role='shop-count-order'
}, 60);

//Archive - Sidebar
remove_action('woocommerce_sidebar', 'woocommerce_get_sidebar', 10);
add_action('woocommerce_after_main_content', 'woocommerce_get_sidebar_custom', 200);

function woocommerce_get_sidebar_custom()
{
	if (!is_product()) {
		if (!is_active_sidebar('shop-sidebar-1')) {
			return;
		}
		echo "<div class='col-md-3' data-role='shop-sidebar'>";
		echo "<div class='site-sidebar underline-reverse element-my'>";
		dynamic_sidebar('shop-sidebar-1');
		echo "</div>"; //.site-sidebar
		echo "</div>"; //data-role='shop-sidebar'>"
	}
}




//Loop - Wrap Product
add_action('woocommerce_before_shop_loop_item', function () {
	echo "<div class='site-product'>";
}, 0);

add_action('woocommerce_after_shop_loop_item', function () {
	echo "</div>"; //.site-product
}, 100);


//Loop - Wrap Product Buttons
remove_action('woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart', 10);
if (MINI_CART) {
	add_action('woocommerce_after_shop_loop_item', function () {
		echo "<div class='site-product__buttons'>";
	}, 9);
	add_action('woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart', 10);
	add_action('woocommerce_after_shop_loop_item', function () {
		echo "</div>"; //.site-product__buttons
	}, 11);
}

//Single Product - Open Container
add_action('woocommerce_before_single_product_summary', function () {
	echo "<div class='container section-pb' data-role='product-container'>";
}, 0);

//Single Product - Breadcrumbs
add_action('woocommerce_before_single_product_summary', 'woocommerce_breadcrumb', 10);

//Single Product - Notices
remove_action('woocommerce_before_single_product', 'woocommerce_output_all_notices', 10);
add_action('woocommerce_before_single_product_summary', 'woocommerce_output_all_notices', 20);

//Single Product - Open Row And Left Column
add_action('woocommerce_before_single_product_summary', function () {
	echo "<div class='row' data-role='product-row'>";
	echo "<div class='col-md-6' data-role='product-left-column'>";
}, 20);

//Single Product - Gallery
remove_action('woocommerce_before_single_product_summary', 'woocommerce_show_product_images', 20);
add_action('woocommerce_before_single_product_summary', 'woocommerce_show_product_images', 30);

//Single Product - Close Left Column And Open Right Column
add_action('woocommerce_before_single_product_summary', function () {
	echo "</div>"; //data-role='product-left-column'
	echo "<div class='col-md-6' data-role='product-right-column'>";
}, 100);

//Single Product - Sale Label
remove_action('woocommerce_before_single_product_summary', 'woocommerce_show_product_sale_flash');
add_action('woocommerce_single_product_summary', 'woocommerce_show_product_sale_flash', 0);

//Single Product - Close Right Column, Row And Container
add_action('woocommerce_after_single_product_summary', function () {
	echo "</div>"; //data-role='product-right-column'
	echo "</div>"; //data-role='product-row'
	echo "</div>"; //data-role='product-container'
}, 10);

//Single Product - Upsells Products
add_action('woocommerce_after_single_product_summary', function () {
	//if upsells exist
	global $product;
	if ($product->upsell_ids) {
		echo "<div class='bg-surface section-py' data-role='single-product-upsells'>";
		echo "<div class='container'>";
	}
}, 14);

add_action('woocommerce_after_single_product_summary', function () {
	//if upsells exist
	global $product;
	if ($product->upsell_ids) {
		echo "</div>"; //.container
		echo "</div>"; //data-role='single-product-upsells'
	}
}, 16);

// Change "You may also like..." text
add_filter('woocommerce_product_upsells_products_heading', 'bbloomer_translate_may_also_like');
function bbloomer_translate_may_also_like()
{
	return 'You may also like';
}


//Single Product - Related Products
add_action('woocommerce_after_single_product_summary', function () {
	//if related products exist
	if (do_shortcode('[related_products limit="1"]')) {
		global $product;
		$spacer = $product->upsell_ids ? 'section-py' : 'section-pb';
		echo "<div class='$spacer' data-role='single-product-related'>";
		echo "<div class='container'>";
	}
}, 19);

add_action('woocommerce_after_single_product_summary', function () {
	//if related products exist
	if (do_shortcode('[related_products limit="1"]')) {
		echo "</div>"; //.container
		echo "</div>"; //data-role='single-product-related'
	}
}, 21);


//Change position of the proceed to checkout button
remove_action('woocommerce_proceed_to_checkout', 'woocommerce_button_proceed_to_checkout', 20);

add_action('woocommerce_before_cart', function () {
	echo '<div class="custom-cart">';
	echo '<div class="wc-proceed-to-checkout wc-proceed-to-checkout--custom">';
});
add_action('woocommerce_before_cart', 'woocommerce_button_proceed_to_checkout');
add_action('woocommerce_before_cart', function () {
	echo '</div>';
});
add_action('woocommerce_after_cart', function () {
	echo '</div><!--custom-cart-->';
}, 1000);


//Custom Checkout Form Header
add_filter('woocommerce_checkout_order_review', 'custom_checkout_form_header', 0);
function custom_checkout_form_header()
{ ?>
	<div class="row g-0 align-items-center">
		<div class="col">
			<h2 class='m-0 h5'>Your order</h2>
		</div>
		<div class="col-auto fs-sm"><a href="<?= esc_url(wc_get_cart_url()); ?>">Edit Order</a></div>
	</div>
<?php
}

//Display Product Image on Checkout
add_filter('woocommerce_cart_item_name', 'ywp_product_image_on_checkout', 10, 3);
function ywp_product_image_on_checkout($name, $cart_item, $cart_item_key)
{

	if (!is_checkout()) {
		return $name;
	}

	$_product = apply_filters('woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key);

	$thumbnail = $_product->get_image(IMG_SIZE_XS, ['class' => 'product_image']);

	return $thumbnail . $name;
}

//Custom "Remove" Icon
add_filter('woocommerce_cart_item_remove_link', 'custom_remove_icon', 10, 2);
function custom_remove_icon($string, $cart_item_key)
{
	ob_start();
	get_template_part('components/site-icon', null, ['icon' => 'trash']);
	$icon =  ob_get_clean();
	return str_replace('&times;', $icon, $string);
}

//Trim zeros in price decimals
add_filter('woocommerce_price_trim_zeros', '__return_true');
