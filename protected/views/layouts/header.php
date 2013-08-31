<div class="blue"></div>
<div class="header_inner">
    <div class="logo">
        <img alt="ТВТ Консалт" title="ТВТ Консалт: организация ВЭД" src="<?= $this->baseAssets.'/img/logo.png'; ?>">
    </div>
    <div class="top_menu">
        <table>
            <tr>
                <td>
                    <table class="inner_table">
                        <tr>


                            <td class="zayavki-menu"><a href="/requests">Онлайн-заявки</a></td>
                            <td><a href="<?= $this->createUrl('about'); ?>">О компании</a></td>
                            <td class="delimiter">|</td>
                            <td><a href="/news">Новости</a></td>
                            <td class="delimiter">|</td>
                            <td><a href="/countries">Страны</a></td>
                            <td class="delimiter">|</td>
                            <td><a href="<?= $this->createUrl('contacts'); ?>">КОНТАКТЫ</a></td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
    </div>
    <div class="contacts">
        <a class="location" href="/services/price_list">
            <img alt="Прайс-лист" title="Наши прайс-листы" src="<?= $this->baseAssets.'/img/header_pricelist.png'; ?>">
                <span class="wrp">
					<span class="price">Прайс-лист</span>
                    <span class="bottom">посмотреть</span>
                </span>
        </a>
        <a class="earphones" href="#" id="call_back1">
            <img alt="Номер телефона" title="Телефон ТВТ Консалт" src="<?= $this->baseAssets.'/img/header_earphones.png'; ?>">
                <span class="wrp">
                    <span class="code">+7 (495) </span>660-81-11
                    <span class="bottom">заказать обратный звонок</span>
                    <span id="div_call_back"></span>
                </span>
        </a>
        <a class="lk" href="javascript:void(0);" data-auth="1" data-url="/checkauth">
            <img alt="Авторизация/регистрация" title="Вход на сайт" src="<?= $this->baseAssets.'/img/header_user.png'; ?>">
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