<?php
$args = wp_parse_args($args, [
    'icon' => '',
    'class' => null,
    'holder' => false
]);

extract($args);

if (!$icon) return;

$icon_class = 'site-icon';

if ($class) {
    $icon_class .= " $class";
}
if ($holder) echo "<span class='site-icon-holder'>";
?>
<svg class="<?= $icon_class ?>">
    <use href="#<?= $icon ?>"></use>
</svg>
<?php if ($holder) echo "</span>";
