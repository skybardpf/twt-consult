<?php
Yii::app()->clientScript->registerCoreScript('jquery');

Yii::app()->clientScript->registerCssFile($this->baseAsset.'/css/main.css');
Yii::app()->clientScript->registerCssFile($this->baseAsset.'/css/handheld.css');
Yii::app()->clientScript->registerCssFile($this->baseAsset.'/css/jquery-ui.css');
Yii::app()->clientScript->registerCssFile($this->baseAsset.'/css/jquery.pnotify.css');
Yii::app()->clientScript->registerCssFile($this->baseAsset.'/css/jquery-ui-1.9.1.custom.css');
Yii::app()->clientScript->registerCssFile('http://fonts.googleapis.com/css?family=Ubuntu:500&amp;subset=latin,cyrillic-ext,latin-ext,cyrillic');

//Yii::app()->clientScript->registerCssFile(Yii::app()->clientScript->getCoreScriptUrl().'/jui/css/base/jquery-ui.css' );
Yii::app()->clientScript->registerScriptFile($this->baseAsset.'/js/common.js');
Yii::app()->clientScript->registerScriptFile($this->baseAsset.'/js/jquery.pnotify.js');
Yii::app()->clientScript->registerScriptFile($this->baseAsset.'/js/jquery-ui-1.9.1.custom.js');
Yii::app()->clientScript->registerScriptFile($this->baseAsset.'/js/iflabel.js');

?>
<!DOCTYPE HTML>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title>ЗАО «ТВТ консалт»: сопровождение ВЭД. Услуги по организации ВЭД</title>
    <meta name="keywords"
          content="сопровождение вэд, регистрация интеллектуальной собственности, услуги вэд, регистрация компаний за рубежом, вэд услуги, регистрация компаний, организация вэд, открыть оффшорную компанию, консалтинг вэд">
    <meta name="description"
          content="Организация ВЭД. Услуги по сопровождению ВЭД, а также услуги таможенного оформления грузов, международное налоговое планирование, регистрация иностранных компаний, таможенное оформление ВЭД">
    <meta name='yandex-verification' content='5bf43eeeee5bbad8'/>

</head>

<body>

<div class="wrapper_outer">
<div class="wrapper_inner">

<div class="header main">
    <div class="blue"></div>
    <div class="header_inner">
        <div class="logo">
            <img alt="ТВТ Консалт" title="ТВТ Консалт: организация ВЭД" src="<?= $this->baseAsset.'/img/logo.png'; ?>">
        </div>
        <div class="top_menu">
            <table>
                <tr>
                    <td>
                        <table class="inner_table">
                            <tr>


                                <td class="zayavki-menu"><a href="/requests">Онлайн-заявки</a></td>
                                <td><a href="/about">О компании</a></td>
                                <td class="delimiter">|</td>
                                <td><a href="/news">новости</a></td>
                                <td class="delimiter">|</td>
                                <td><a href="/countries">Страны</a></td>
                                <td class="delimiter">|</td>
                                <td><a href="/contacts">КОНТАКТЫ</a></td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
        </div>
        <div class="contacts">
            <a class="location" href="/services/price_list">
                <img alt="Прайс-лист" title="Наши прайс-листы" src="<?= $this->baseAsset.'/img/header_pricelist.png'; ?>">
                <span class="wrp">
					<span class="price">Прайс-лист</span>
                    <span class="bottom">посмотреть</span>
                </span>
            </a>
            <a class="earphones" href="#" id="call_back1">
                <img alt="Номер телефона" title="Телефон ТВТ Консалт" src="<?= $this->baseAsset.'/img/header_earphones.png'; ?>">
                <span class="wrp">
                    <span class="code">+7 (495) </span>660-81-11
                    <span class="bottom">заказать обратный звонок</span>
                    <span id="div_call_back"></span>
                </span>
            </a>
            <a class="lk" href="javascript:void(0);" data-auth="1" data-url="/checkauth">
                <img alt="Авторизация/регистрация" title="Вход на сайт" src="<?= $this->baseAsset.'/img/header_user.png'; ?>">
					<span class="wrp">
						<span class="price">ЛИЧНЫЙ КАБИНЕТ</span>
						<span class="bottom">
							авторизация/регистрация
						</span>
					</span>
            </a>
        </div>

    </div>
    <div class="main_menu">
        <div class="main_menu inner">

            <div class="layer1">
                <table>
                    <tr>
                        <td>
                            <div id="id1">
                                <a href="/services/finansy">Финансовый сервис</a>
                            </div>
                        </td>
                        <td>
                            <div id="id2">
                                <a href="/services/uridicheskiy_servis">Юридический сервис</a>
                            </div>
                        </td>
                        <td>
                            <div id="id3">
                                <a href="/services/tamogennoe_oformlenie">Таможенное оформление</a>
                            </div>
                        </td>
                        <td>
                            <div id="id4">
                                <a href="/services/megdunarodnoe_planirovanie">Международное налоговое и финансовое
                                    планирование</a>
                            </div>
                        </td>
                        <td>
                            <div id="id5" class="no_arrowed">
                                <a href="/services/avtomatizaciya_ucheta">Автоматизация учета</a>
                            </div>
                        </td>
                    </tr>
                </table>
            </div>


        </div>
    </div>
</div>

<div class="content">


<div class="main_content_slider">
    <div class="main_slider">

        <div class="con">
            <div class="monitor">
                <div class="cont">
                    <a href="/countries/singapur">
                        <img alt="" title="" style="width: 660px; height: 398px;" src="<?= $this->baseAsset.'/img/announcies/original/singapore_new.jpg'; ?>">
                    </a>
                </div>
            </div>

            <div id="program">
                <ul>
                    <li class="tv_program_li">
                        <a href="/services/oformlenie_tamogennogo_predstavitelya/"><img alt="" title=""
                                                                                        src="<?= $this->baseAsset.'/img/announcies/original/oformlenie_tamogennogo_predstavitelya.jpg'; ?>"
                                                                                        style="width: 338px; height: 132px;"></a>
                    </li>
                    <li class="tv_program_li">
                        <a href="/services/pravovoe_soprovogdenie"><img alt="" title=""
                                                                        src="<?= $this->baseAsset.'/img/announcies/original/oformlenie_tamogennogo_predstavitelya.jpg'; ?>"
                                                                        style="width: 338px; height: 132px;"></a>
                    </li>
                    <li class="tv_program_li">
                        <a href="/services/registraciya_offshorov/"><img alt="" title=""
                                                                         src="<?= $this->baseAsset.'/img/announcies/original/registraciya_offshorov.jpg'; ?>"
                                                                         style="width: 338px; height: 132px;"></a>
                    </li>
                </ul>
            </div>
            <div class="clear"></div>
        </div>
    </div>
</div>

<div class="company_info">
<div class="main_descr">
    <div class="descr_title">
        <h4>
            Информация о компании</h4>
    </div>
    <p>
        <img alt="" src="<?= $this->baseAsset.'/img/text1.png'; ?>" title=""/> Компания TWT COM специализируется на комплексном
        сопровождении&nbsp; внешне-экономической деятельности, включая экспорт, импорт и транзит товаров по РФ. Мы
        выступаем надёжным партнером в области организации международной торговли и it-интеграции бизнес операций в ERP
        системах.<br/>
        <br/>
        Наши услуги отличает комплексный подход. Мы оказываем услуги в качестве финансового, юридического, таможенного и
        логистического партнёра, а так же налогового консультанта. TWT COM так же выступает консультантом по
        взаимоотношениям с банками и иностранными контрагентами, предоставляет полное документарное сопровождение
        внешнеэкономической деятельности своих клиентов.<br/>
        <br/>
        Целью нашего бизнеса является разработка высокотехнологичных решений по международной дистрибуции товаров, а
        также предоставление нашим клиентам технологий бизнеса, которые дают им преимущества над остальными конкурентами
        и позволяют выходить на любые конкурентные рынки.<br/>
        <br/>
        Мы предлагаем клиентам комплексные сервисы предоставляющие возможность осуществлять операции по импорту и
        экспорту товаров что подразумевает полную автоматизацию и стандартизацию учета в ERP системе. Это не только
        выход на рынок внешнеторговых операций, но и путь к рынку международного капитала. Конкурентным преимуществом
        работы с нашей компанией является комплексность бизнес решений системность работы международной дистрибьюторской
        сети. Совместными усилиями мы сможем реализовать эффективную международную дистрибуцию товаров на территорию
        России.<br/>
        <br/>
        Сотрудничая с нами, Вы получаете структурированный, вертикально интегрированный холдинг, осуществляющий торговлю
        продукцией по всему миру, где вашими партнерами являются лучшие поставщики товаров, логистические компании,
        таможенные и страховые брокеры, а также крупнейшие европейские банки. Мы так же предлагаем нашим партнёрам
        уникальную систему автоматизации учёта бизнеса, которая позволяет эффективно управлять компанией из любой страны
        мира.<br/>
        <br/>
        Миссия нашей компании: Мы всегда стараемся развиваться совместно с Вами и ради Вашего успеха.<br/>
        <br/>
        Наш девиз: Эффективные технологии международной торговли.<br/>
        <br/>
        С уважением, Команда TWT COM.</p>

</div>
<div class="main_geografy">
<div class="descr_title">
    Открываем компанию за <br>один день в:
</div>
<table>

<tr>
    <td><img alt="" title="" src="<?= $this->baseAsset.'/img/arrow-green.png'; ?>"></td>
    <td><a href="/countries/beliz"><img alt="" title=""
                                        src="<?= $this->baseAsset.'/img/countries/small/bz_copy(1354047939_1587683042).png'; ?>"></a>
    </td>
    <td><a href="/countries/beliz">Белиз</a></td>
    <td style="width: 60px;"><span class="price">750 €</span></td>
</tr>


<tr>
    <td><img alt="" title="" src="<?= $this->baseAsset.'/img/arrow-green.png'; ?>"></td>
    <td><a href="/countries/britanskie_virginskie_ostrova"><img alt="" title=""
                                                                src="<?= $this->baseAsset.'/img/countries/small/vg.png'; ?>"></a></td>
    <td><a href="/countries/britanskie_virginskie_ostrova">Британские Виргинские острова</a></td>
    <td style="width: 60px;"><span class="price">750 €</span></td>
</tr>


<tr>
    <td><img alt="" title="" src="<?= $this->baseAsset.'/img/arrow-red.png'; ?>"></td>
    <td><a href="/countries/germania"><img alt="" title="" src="<?= $this->baseAsset.'/img/countries/small/de.png'; ?>"></a></td>
    <td><a href="/countries/germania">Германия</a></td>
    <td style="width: 60px;"><span class="price">14 000 €</span></td>
</tr>


<tr>
    <td><img alt="" title="" src="<?= $this->baseAsset.'/img/arrow-red.png'; ?>"></td>
    <td><a href="/countries/italia"><img alt="" title="" src="<?= $this->baseAsset.'/img/countries/small/it.png'; ?>"></a></td>
    <td><a href="/countries/italia">Италия</a></td>
    <td style="width: 60px;"><span class="price">14 000 €</span></td>
</tr>


<tr>
    <td><img alt="" title="" src="<?= $this->baseAsset.'/img/arrow-red.png'; ?>"></td>
    <td><a href="/countries/mavrikiy"><img alt="" title="" src="<?= $this->baseAsset.'/img/countries/small/mu.png'; ?>"></a></td>
    <td><a href="/countries/mavrikiy">Маврикий</a></td>
    <td style="width: 60px;"><span class="price">1 600 €</span></td>
</tr>


<tr>
    <td><img alt="" title="" src="<?= $this->baseAsset.'/img/arrow-red.png'; ?>"></td>
    <td><a href="/countries/panama"><img alt="" title="" src="<?= $this->baseAsset.'/img/countries/small/pa.png'; ?>"></a></td>
    <td><a href="/countries/panama">Панама</a></td>
    <td style="width: 60px;"><span class="price">3 500 €</span></td>
</tr>


<tr>
    <td><img alt="" title="" src="<?= $this->baseAsset.'/img/arrow-red.png'; ?>"></td>
    <td><a href="/countries/malta"><img alt="" title="" src="<?= $this->baseAsset.'/img/countries/small/mt.png'; ?>"></a></td>
    <td><a href="/countries/malta">Мальта</a></td>
    <td style="width: 60px;"><span class="price"></span></td>
</tr>


<tr>
    <td><img alt="" title="" src="<?= $this->baseAsset.'/img/arrow-red.png'; ?>"></td>
    <td><a href="/countries/litva"><img alt="" title="" src="<?= $this->baseAsset.'/img/countries/small/lt.png'; ?>"></a></td>
    <td><a href="/countries/litva">Литва</a></td>
    <td style="width: 60px;"><span class="price">14 000 €</span></td>
</tr>


<tr>
    <td><img alt="" title="" src="<?= $this->baseAsset.'/img/arrow-red.png'; ?>"></td>
    <td><a href="/countries/grecia"><img alt="" title="" src="<?= $this->baseAsset.'/img/countries/small/gr.png'; ?>"></a></td>
    <td><a href="/countries/grecia">Греция</a></td>
    <td style="width: 60px;"><span class="price">14 000 €</span></td>
</tr>


<tr>
    <td><img alt="" title="" src="<?= $this->baseAsset.'/img/arrow-red.png'; ?>"></td>
    <td><a href="/countries/avstria"><img alt="" title="" src="<?= $this->baseAsset.'/img/countries/small/at.png'; ?>"></a></td>
    <td><a href="/countries/avstria">Австрия</a></td>
    <td style="width: 60px;"><span class="price">14 000 €</span></td>
</tr>


<tr>
    <td><img alt="" title="" src="<?= $this->baseAsset.'/img/arrow-red.png'; ?>"></td>
    <td><a href="/countries/francia"><img alt="" title="" src="<?= $this->baseAsset.'/img/countries/small/fr.png'; ?>"></a></td>
    <td><a href="/countries/francia">Франция</a></td>
    <td style="width: 60px;"><span class="price">14 000 €</span></td>
</tr>


<tr>
    <td><img alt="" title="" src="<?= $this->baseAsset.'/img/arrow-red.png'; ?>"></td>
    <td><a href="/countries/cheshskaya_respublika"><img alt="" title="" src="<?= $this->baseAsset.'/img/countries/small/cz.png'; ?>"></a>
    </td>
    <td><a href="/countries/cheshskaya_respublika">Чешская Республика</a></td>
    <td style="width: 60px;"><span class="price"></span></td>
</tr>


<tr>
    <td><img alt="" title="" src="<?= $this->baseAsset.'/img/arrow-green.png'; ?>"></td>
    <td><a href="/countries/kipr_trasty"><img alt="" title=""
                                              src="<?= $this->baseAsset.'/img/countries/small/cy_copy(1356599736_1180170530).png'; ?>"></a>
    </td>
    <td><a href="/countries/kipr_trasty">Кипр (Трасты)</a></td>
    <td style="width: 60px;"><span class="price">2 500 €</span></td>
</tr>


<tr>
    <td><img alt="" title="" src="<?= $this->baseAsset.'/img/arrow-red.png'; ?>"></td>
    <td><a href="/countries/seishelskie_ostrova"><img alt="" title=""
                                                      src="<?= $this->baseAsset.'/img/countries/small/sc.png'; ?>"></a></td>
    <td><a href="/countries/seishelskie_ostrova">Сейшельские Острова</a></td>
    <td style="width: 60px;"><span class="price">750 €</span></td>
</tr>


<tr>
    <td><img alt="" title="" src="<?= $this->baseAsset.'/img/arrow-green.png'; ?>"></td>
    <td><a href="/countries/niderlandi"><img alt="" title="" src="<?= $this->baseAsset.'/img/countries/small/nl.png'; ?>"></a></td>
    <td><a href="/countries/niderlandi">Нидерланды</a></td>
    <td style="width: 60px;"><span class="price">14 000 €</span></td>
</tr>


<tr>
    <td><img alt="" title="" src="<?= $this->baseAsset.'/img/arrow-red.png'; ?>"></td>
    <td><a href="/countries/angilya"><img alt="" title="" src="<?= $this->baseAsset.'/img/countries/small/ai.png'; ?>"></a></td>
    <td><a href="/countries/angilya">Ангилья</a></td>
    <td style="width: 60px;"><span class="price">750 €</span></td>
</tr>


<tr>
    <td><img alt="" title="" src="<?= $this->baseAsset.'/img/arrow-green.png'; ?>"></td>
    <td><a href="/countries/latvia"><img alt="" title="" src="<?= $this->baseAsset.'/img/countries/small/lv.png'; ?>"></a></td>
    <td><a href="/countries/latvia">Латвия</a></td>
    <td style="width: 60px;"><span class="price">14 000 €</span></td>
</tr>


<tr>
    <td><img alt="" title="" src="<?= $this->baseAsset.'/img/arrow-green.png'; ?>"></td>
    <td><a href="/countries/lihtenshtein"><img alt="" title="" src="<?= $this->baseAsset.'/img/countries/small/liht.jpg'; ?>"></a>
    </td>
    <td><a href="/countries/lihtenshtein">Лихтенштейн</a></td>
    <td style="width: 60px;"><span class="price">14 000  €</span></td>
</tr>


<tr>
    <td><img alt="" title="" src="<?= $this->baseAsset.'/img/arrow-green.png'; ?>"></td>
    <td><a href="/countries/kipr"><img alt="" title="" src="<?= $this->baseAsset.'/img/countries/small/cy.png'; ?>"></a></td>
    <td><a href="/countries/kipr">Кипр</a></td>
    <td style="width: 60px;"><span class="price">1 700 €</span></td>
</tr>


<tr>
    <td><img alt="" title="" src="<?= $this->baseAsset.'/img/arrow-green.png'; ?>"></td>
    <td><a href="/countries/beliz_trasty"><img alt="" title="" src="<?= $this->baseAsset.'/img/countries/small/bz.png'; ?>"></a></td>
    <td><a href="/countries/beliz_trasty">Белиз (трасты)</a></td>
    <td style="width: 60px;"><span class="price">2 500 €</span></td>
</tr>


<tr>
    <td><img alt="" title="" src="<?= $this->baseAsset.'/img/arrow-green.png'; ?>"></td>
    <td><a href="/countries/ispania"><img alt="" title="" src="<?= $this->baseAsset.'/img/countries/small/es.png'; ?>"></a></td>
    <td><a href="/countries/ispania">Испания</a></td>
    <td style="width: 60px;"><span class="price">17 000 €</span></td>
</tr>


<tr>
    <td><img alt="" title="" src="<?= $this->baseAsset.'/img/arrow-green.png'; ?>"></td>
    <td><a href="/countries/bagamskie_ostrova"><img alt="" title="" src="<?= $this->baseAsset.'/img/countries/small/bs.png'; ?>"></a>
    </td>
    <td><a href="/countries/bagamskie_ostrova">Багамские острова</a></td>
    <td style="width: 60px;"><span class="price">1 350 €</span></td>
</tr>


<tr>
    <td><img alt="" title="" src="<?= $this->baseAsset.'/img/arrow-green.png'; ?>"></td>
    <td><a href="/countries/oae"><img alt="" title="" src="<?= $this->baseAsset.'/img/countries/small/ae.png'; ?>"></a></td>
    <td><a href="/countries/oae">ОАЭ</a></td>
    <td style="width: 60px;"><span class="price">3 000 €</span></td>
</tr>


<tr>
    <td><img alt="" title="" src="<?= $this->baseAsset.'/img/arrow-red.png'; ?>"></td>
    <td><a href="/countries/brunei"><img alt="" title="" src="<?= $this->baseAsset.'/img/countries/small/bn.png'; ?>"></a></td>
    <td><a href="/countries/brunei">Бруней</a></td>
    <td style="width: 60px;"><span class="price">3 500 €</span></td>
</tr>


<tr>
    <td><img alt="" title="" src="<?= $this->baseAsset.'/img/arrow-red.png'; ?>"></td>
    <td><a href="/countries/dominikanskaya_respublika"><img alt="" title=""
                                                            src="<?= $this->baseAsset.'/img/countries/small/do.png'; ?>"></a></td>
    <td><a href="/countries/dominikanskaya_respublika">Доминиканская республика</a></td>
    <td style="width: 60px;"><span class="price">3 900 €</span></td>
</tr>


<tr>
    <td><img alt="" title="" src="<?= $this->baseAsset.'/img/arrow-red.png'; ?>"></td>
    <td><a href="/countries/dania"><img alt="" title="" src="<?= $this->baseAsset.'/img/countries/small/dk.png'; ?>"></a></td>
    <td><a href="/countries/dania">Дания</a></td>
    <td style="width: 60px;"><span class="price">14 000 €</span></td>
</tr>


<tr>
    <td><img alt="" title="" src="<?= $this->baseAsset.'/img/arrow-red.png'; ?>"></td>
    <td><a href="/countries/hongkong"><img alt="" title="" src="<?= $this->baseAsset.'/img/countries/small/hk.png'; ?>"></a></td>
    <td><a href="/countries/hongkong">Гонконг</a></td>
    <td style="width: 60px;"><span class="price">2 500 €</span></td>
</tr>


<tr>
    <td><img alt="" title="" src="<?= $this->baseAsset.'/img/arrow-green.png'; ?>"></td>
    <td><a href="/countries/velikobritania"><img alt="" title="" src="<?= $this->baseAsset.'/img/countries/small/gb.png'; ?>"></a>
    </td>
    <td><a href="/countries/velikobritania">Великобритания</a></td>
    <td style="width: 60px;"><span class="price">700 €</span></td>
</tr>


<tr>
    <td><img alt="" title="" src="<?= $this->baseAsset.'/img/arrow-red.png'; ?>"></td>
    <td><a href="/countries/nevis"><img alt="" title="" src="<?= $this->baseAsset.'/img/countries/small/kn.png'; ?>"></a></td>
    <td><a href="/countries/nevis">Невис</a></td>
    <td style="width: 60px;"><span class="price">750 €</span></td>
</tr>


<tr>
    <td><img alt="" title="" src="<?= $this->baseAsset.'/img/arrow-green.png'; ?>"></td>
    <td><a href="/countries/terks_kaikos"><img alt="" title="" src="<?= $this->baseAsset.'/img/countries/small/tc.png'; ?>"></a></td>
    <td><a href="/countries/terks_kaikos">Острова Теркс и Кайкос</a></td>
    <td style="width: 60px;"><span class="price">1 150 €</span></td>
</tr>


<tr>
    <td><img alt="" title="" src="<?= $this->baseAsset.'/img/arrow-red.png'; ?>"></td>
    <td><a href="/countries/singapur"><img alt="" title="" src="<?= $this->baseAsset.'/img/countries/small/sg.png'; ?>"></a></td>
    <td><a href="/countries/singapur">Сингапур</a></td>
    <td style="width: 60px;"><span class="price">4 000 €</span></td>
</tr>


<tr>
    <td><img alt="" title="" src="<?= $this->baseAsset.'/img/arrow-red.png'; ?>"></td>
    <td><a href="/countries/shveitsariya"><img alt="" title="" src="<?= $this->baseAsset.'/img/countries/small/ch.png'; ?>"></a></td>
    <td><a href="/countries/shveitsariya">Швейцария</a></td>
    <td style="width: 60px;"><span class="price">14 000 €</span></td>
</tr>


</table>

<br/><br/>
</div>
</div>


</div>

<div class="clear"></div>

<div class="footer">
    <div class="footer_inner">

        <div class="footer_contacts">
            <div class="copyright">
                © 2012 - 2013. TWT Consult<br>
                Горячая линия +7 (495) 660-81-11<br>
            </div>
            <div class="counters">
                <!-- Yandex.Metrika counter -->
                <script type="text/javascript">
                    (function (d, w, c) {
                        (w[c] = w[c] || []).push(function () {
                            try {
                                w.yaCounter19010836 = new Ya.Metrika({id: 19010836,
                                    webvisor: true,
                                    clickmap: true,
                                    trackLinks: true,
                                    accurateTrackBounce: true});
                            } catch (e) {
                            }
                        });

                        var n = d.getElementsByTagName("script")[0],
                            s = d.createElement("script"),
                            f = function () {
                                n.parentNode.insertBefore(s, n);
                            };
                        s.type = "text/javascript";
                        s.async = true;
                        s.src = (d.location.protocol == "https:" ? "https:" : "http:") + "//mc.yandex.ru/metrika/watch.js";

                        if (w.opera == "[object Opera]") {
                            d.addEventListener("DOMContentLoaded", f, false);
                        } else {
                            f();
                        }
                    })(document, window, "yandex_metrika_callbacks");
                </script>
                <noscript>
                    <div><img src="//mc.yandex.ru/watch/19010836" style="position:absolute; left:-9999px;" alt=""/>
                    </div>
                </noscript>
                <!-- /Yandex.Metrika counter -->
                <script type="text/javascript">

                    var _gaq = _gaq || [];
                    _gaq.push(['_setAccount', 'UA-37247170-1']);
                    _gaq.push(['_trackPageview']);

                    (function () {
                        var ga = document.createElement('script');
                        ga.type = 'text/javascript';
                        ga.async = true;
                        ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
                        var s = document.getElementsByTagName('script')[0];
                        s.parentNode.insertBefore(ga, s);
                    })();

                </script>
            </div>
            <div class="search">
                <form action="/search" method="get" id="search_form">
                    <label class="infield" style="display: block; ">поиск по сайту</label>
                    <input type="text" name="q">
                    <input type="image" src="<?= $this->baseAsset.'/img/search.png'; ?>" alt="search" title="search">
                </form>
                <div class="search_sample" id="search_sample">
                    Например: <span>страхование груза</span>
                </div>
            </div>
            <div class="our_logo">
                <div>
                    <a href="http://artektiv.ru/" target="_blank">Разработка сайта</a>
                </div>
                <a href="http://artektiv.ru/" target="_blank"><img alt="" title="" src="<?= $this->baseAsset.'/img/art_logo.png'; ?>"></a>

            </div>

        </div>
    </div>
</div>

</div>
</div>

<!--zf::debug:body-->
</body>
</html>