<?php
/**
 * @var CountriesController $this
 * @var Country[] $data
 */
?>

<div class="content_inner">
    <div class="breadcrumbs">

        <a href="<?= $this->createAbsoluteUrl('/'); ?>">Главная</a> /
        <em>Страны</em></div>

    <div class="banners">
        <div id="ban">
            <?= $this->renderPartial('/common/banners'); ?>
        </div>
    </div>

    <div class="list_countries">
        <h2>Страны</h2>
        <br>
        <ul class="list">
            <?php foreach ($data as $country): ?>
                <li>
                    <div class="hdng">
                        <img alt="<?= $country->title; ?>" title="<?= $country->title . ' - открыть бизнес'; ?>"
                             src="<?= $this->baseAssets . $country->getUrlFlag(); ?>"
                             align="left">&nbsp;<a
                            href="<?= $this->createUrl('view', array('c' => $country->url)); ?>"><?= $country->title; ?></a>
                    </div>
                </li>
            <?php endforeach; ?>
        </ul>

    </div>
    <div class="clear"></div>
</div>