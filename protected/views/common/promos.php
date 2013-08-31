<?php
/**
 * Промо-баннер.
 */

$banner = Banner::model()->gerRandomPromo();
?>
<a href="<?= $this->createUrl($banner->url); ?>">
    <img alt="<?= $banner->title; ?>" title="<?= $banner->title; ?>" style="width: 660px; height: 398px;"
         src="<?= $this->baseAssets . $banner->getImageUrl(); ?>">
</a>