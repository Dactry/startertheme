<?php
$args = wp_parse_args($args, [
    'icon' => 'facebook',
    'url' => '#',
]);
extract($args);
if (!$url) return;
?>
<li class="social-icons__item">
    <?= get_core_icon_label($icon, false, $url, 'outher'); ?>
</li>