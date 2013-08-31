<?php
/**
 * @var AdminController $this
 * @var string $current_tab
 * @var string $tab_content
 */
?>

<h2>Админка</h2>
<div class="yur-tabs">
    <?php
//    $this->widget('bootstrap.widgets.TbMenu', array(
//        'type' => 'tabs', // '', 'tabs', 'pills' (or 'list')
//        'stacked' => false, // whether this is a stacked menu
//        'items' => array(
//            array(
//                'label' => 'Главная',
//                'url'   => $this->createUrl('/admin/'),
//                'active' => ($current_tab == 'home')
//            ),
//            array(
//                'label' => 'Страницы',
//                'url'   => $this->createUrl('page/'),
//                'active' => ($current_tab == 'pages')
//            ),
//            array(
//                'label' => 'Новости',
//                'url'   => $this->createUrl('news/'),
//                'active' => ($current_tab == 'news')
//            ),
//            array(
//                'label' => 'Пресса о нас',
//                'url'   => $this->createUrl('press_about_us/'),
//                'active' => ($current_tab == 'press_about_us'),
//            ),
//            array(
//                'label' => 'Заявки на тест-драйв',
//                'url'   => $this->createUrl('test_drive/'),
//                'active' => ($current_tab == 'test_drive'),
//            ),
//        ),
//    ));
    ?>
</div>
<div class="yur-content">
    <?= $tab_content; ?>
</div>
