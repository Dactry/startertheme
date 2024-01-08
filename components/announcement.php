<?php
$announcement = get_field('announcement', 'option');
if (!$announcement) return;

$enable = $announcement['enable'];
if (!$enable) return;

$content = $announcement['content'];
if (!$content) return;
?>
<div class="announcement bg-primary text-white">
    <div class="container fs-sm"><?= $content; ?></div>
</div>