<?php
/**
 * Случайные баннеры.
 */

$banners = Banner::model()->gerRandomBanners();
?>
<div class="banners">
    <div id="ban" class="">
        <?php foreach($banners as $key=>$banner): ?>
            <div id="<?= 'banner'.$key; ?>">
                <a href="<?= $this->createUrl($banner->url); ?>">
                    <img alt="<?= $banner->title; ?>"
                         title="<?= $banner->title; ?>"
                         src="<?= $this->baseAssets . $banner->getImageUrl(); ?>"
                         style="width: 338px; height: 132px;">
                </a>
            </div>
        <?php endforeach; ?>
    </div>
</div>