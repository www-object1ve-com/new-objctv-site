<?php
    $social_medias = get_field('social_medias', 'option');
?>
<section class="social-area">
    <?php foreach ($social_medias as $key => $social_media): ?>
        <a href="<?= $social_media['social_url']; ?>" rel="nofollow noopener noreffer" target="_blank" class="social-anchor">
            <img src="<?= $social_media['social_icon']['url']; ?>" alt="<?= $social_media['social_icon']['alt']; ?>">
        </a>
    <?php endforeach; ?>
</section>