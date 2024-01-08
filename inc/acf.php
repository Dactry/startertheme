<?php
//Options 
if (function_exists('acf_add_options_page')) {
	acf_add_options_page();
}

//Hide ACF menu and show it for specific users only
if (is_user_logged_in() && get_current_user_id() !== 1 && get_current_user_id() !== 2) {
	add_filter('acf/settings/show_admin', '__return_false');
}
