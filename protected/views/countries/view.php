<?php
/**
 * @var CountriesController $this
 * @var Country $model
 */
?>

<div class="content_inner">
    <div class="breadcrumbs">
        <a href="<?= $this->createAbsoluteUrl('/'); ?>">Главная</a> /
        <a href="<?= $this->createUrl('countries/'); ?>">Страны</a> /
        <em><?= CHtml::encode($model->title); ?></em></div>

    <?= $this->renderPartial('/common/banners'); ?>

    <div class="service_cont">

        <div class="list articles">

            <div class="hdng">
                <h2><?= CHtml::encode($model->title); ?></h2>
            </div>
            <div class="text floatcontainer" style="font-size: 12px;">
                <div class="descr">
                    <?= $model->text; ?>
                </div>
            </div>
            <div class="clear"></div>

        </div>

    </div>
    <div class="clear"></div>
</div>