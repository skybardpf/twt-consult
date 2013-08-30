<div class="header{if $page_content.id == 1} main{else} inner{/if}">
    <div class="blue"></div>
    <div class="header_inner">
        <div class="logo">{if $page_content.id != 1}<a href="/">{/if}<img alt="" title="" src="/public/site/img/logo.png">{if $page_content.id != 1}</a>{/if}</div>
        <div class="top_menu">
            <table>
                <tr>
                    <td>
                        <table class="inner_table">
                            <tr>

                                {assign var=prev_match value=false}
                                {*<td{if $page_content.id == 1} class="active"{assign var=prev_match value=true}{/if}><a href="/">Главная</a></td>*}

                                {foreach from=$main_menu item=m name=menu}
                                    {if !($request.parr[0] == $m.url || $ctrlName == $m.url || $current_url == $m.url) && !$prev_match && $m.url != 'requests' && !$smarty.foreach.menu.first}
										<td class="delimiter">|</td>
									{/if}
                                    {if $prev_match}
                                        {assign var=prev_match value=false}
                                    {/if}
                                    <td{if $m.url == 'requests'} class="zayavki-menu"{/if}{if $request.parr[0] == $m.url || $ctrlName == $m.url || $current_url == $m.url} class="active"{/if}{if ($request.parr[0] == $m.url || $ctrlName == $m.url || $current_url == $m.url) || $m.url == 'requests'}{assign var=prev_match value=true}{/if}><a href="/{$m.url}">{$m.title}</a></td>
                                {/foreach}
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
        </div>
        <div class="contacts">
            <a class="location" href="/services/price_list">
                <img alt="" title="" src="/public/site/img/header_pricelist.png">
                <span class="wrp">
					<span class="price">Прайс-лист</span>
                    <span class="bottom">посмотреть</span>
                </span>
            </a>
            <a class="earphones" href="#" id="call_back1">
                <img alt="" title="" src="/public/site/img/header_earphones.png">
                <span class="wrp">
                    <span class="code">+7 (495) </span>660-81-11
                    <span class="bottom">заказать обратный звонок</span>
                    <span id="div_call_back"></span>
                </span>
            </a>
			{if $logged_site_user}
				<div class="lk logged_in">
					<img alt="" title="" src="/public/site/img/header_user.png">
					<span class="wrp">
						<span class="bottom">
							Добро пожаловать,<br><a href="/cabinet">{$logged_site_user.name}</a> | <a href="/logout">Выход</a>
						</span>
					</span>
				</div>
			{else}
				<a class="lk" href="javascript:void(0);" data-auth="1" data-url="/checkauth">
					<img alt="" title="" src="/public/site/img/header_user.png">
					<span class="wrp">
						<span class="price">ЛИЧНЫЙ КАБИНЕТ</span>
						<span class="bottom">
							авторизация/регистрация
						</span>
					</span>
				</a>
			{/if}
        </div>

    </div>
    <div class="main_menu">
        <div class="main_menu inner">

            <div class="layer1">
                <table>
                    <tr>
                        {foreach from=$services item=service name=services}
                            <td{if $service_ids[0] == $service.id} class="active default"{/if}>
                                    <div id="id{$smarty.foreach.services.iteration}"{if !$service.children} class="no_arrowed"{/if} >
                                        <a href="/services/{$service.url}">{$service.title}</a>
                                    </div>
                                    {*<div class="for_arrow">*}
                                        {*<img alt="" title="" src="/public/site/img/white_arrow.png">*}
                                    {*</div>*}
                            </td>
                        {/foreach}
                    </tr>
                </table>
            </div>

            {foreach from=$services item=service name=services}
                {if $service.children}
                        <div class="id{$smarty.foreach.services.iteration} layer2{foreach from=$service.children item=s_child name=s_children}{if ($s_child.id == $service_ids[1]) || ($service_ids[0] == $service.id)} default{/if}{/foreach}">
                            <table>
                                <tr>
                                {foreach from=$service.children item=s_child name=s_children}
                                    <td class="imaged">{if $s_child.icon}<img alt="" title="" src="{$s_child.icon|replace:'[dir]':'small'}">{/if}</td>
                                    <td{if $service_ids[1] == $s_child.id} class="active default"{/if}{if $smarty.foreach.services.iteration == 1 && $smarty.foreach.s_children.last} style="width: 45%;"{/if}{if $smarty.foreach.services.iteration == 3 && $smarty.foreach.s_children.last} style="width: 30%;"{/if}><div{*if $s_child.children} class="arrowed"{/if*} id="id{$smarty.foreach.services.iteration}_{$smarty.foreach.s_children.iteration}"><a href="/services/{$s_child.url|trim}">{$s_child.title}</a></div></td>
                                    {if $smarty.foreach.services.iteration == 2 && $smarty.foreach.s_children.iteration == 4}
                                        </tr>
                                        <tr>
                                    {/if}
                                    {if $smarty.foreach.services.iteration == 3 && $smarty.foreach.s_children.iteration == 4}
                                        </tr>
                                        <tr>
                                    {/if}
                                    {if $smarty.foreach.services.iteration == 3 && $smarty.foreach.s_children.iteration == 8}
                                        </tr>
                                    </table>
                                    <table>
                                        <tr>
                                    {/if}
                                   {* {if $smarty.foreach.services.iteration == 3 && $smarty.foreach.s_children.iteration == 9}
                                    </tr>
                                    </table>
                                    <table>
                                    <tr>
                                    {/if}*}
                                    {if $smarty.foreach.services.iteration == 1 && $smarty.foreach.s_children.iteration == 3}
                                    </tr>
                                    </table>
                                    <table>
                                    <tr>
                                    {/if}
                                {/foreach}
                                </tr>
                            </table>
                        </div>
                {/if}
            {/foreach}

            {*{foreach from=$services item=service name=services}
                {if $service.children}
                    {foreach from=$service.children item=s_child name=s_children}
                        {if $s_child.children}

                        <div class="id{$smarty.foreach.services.iteration}_{$smarty.foreach.s_children.iteration} layer3 inner_menu">
                                    {foreach from=$s_child.children item=s_s_child name=s_s_children}

                                        <div class="menu_item{if $smarty.foreach.s_s_children.iteration % 4 == 0} right{/if}">
                                            {if $s_s_child.icon}<img alt="" title="" src="{$s_s_child.icon|replace:'[dir]':'middle'}">{/if}
                                            <div><a href="/services/{$s_s_child.url}">{$s_s_child.title}</a></div>
                                        </div>

                                    {/foreach}

                        </div>

                            *}{*<div class="id{$smarty.foreach.services.iteration}_{$smarty.foreach.s_children.iteration} layer3">*}{*
                                *}{*<table>*}{*
                                    *}{*<tr>*}{*
                                    *}{*{foreach from=$s_child.children item=s_s_child name=s_s_children}*}{*
                                        *}{*<td class="imaged">{if $s_s_child.image}<img alt="" title="" src="{$s_s_child.image|replace:'[dir]':'middle'}">{/if}</td>*}{*
                                        *}{*<td{if $request.parr[0] == $s_s_child.url} class="active"{/if}><div{if $s_s_child.children} class="arrowed"{/if} id="id{$smarty.foreach.services.iteration}_{$smarty.foreach.s_children.iteration}_{$smarty.foreach.s_s_children.iteration}"><a href="/services/{$s_s_child.url}">{$s_s_child.title}</a></div></td>*}{*
                                            *}{*{if $smarty.foreach.services.iteration == 2 && $smarty.foreach.s_children.iteration == 4}*}{*
                                                *}{*</tr>*}{*
                                                *}{*<tr>*}{*
                                            *}{*{/if}*}{*
                                            *}{*{if $smarty.foreach.services.iteration == 3 && $smarty.foreach.s_children.iteration == 3}*}{*
                                                *}{*</tr>*}{*
                                                *}{*<tr>*}{*
                                            *}{*{/if}*}{*
                                            *}{*{if $smarty.foreach.services.iteration == 3 && $smarty.foreach.s_children.iteration == 6}*}{*
                                                *}{*</tr>*}{*
                                            *}{*</table>*}{*
                                            *}{*<table>*}{*
                                                *}{*<tr>*}{*
                                            *}{*{/if}*}{*
                                    *}{*{/foreach}*}{*
                                    *}{*</tr>*}{*
                                *}{*</table>*}{*
                            *}{*</div>*}{*
                        {/if}
                    {/foreach}
                {/if}
            {/foreach}*}

{*            <div class="id0101 layer3">
                <table>
                    <tr>
                        <td><div>Открытие  счетов  в  иностранных  банках</div></td>
                        <td><div>Управление  счетами  и  взаиморасчетами</div></td>
                    </tr>
                </table>
            </div>*}

{*            <div class="id01 layer2">
                <table>
                    <tr>
                        <td><img src="http://cs301510.userapi.com/g24673198/e_a9d20129.jpg"></td>
                        <td><div id="id0101">Расчетное  обслуживание</div></td>
                        <td><img src="http://www.povarenok.ru/images/anket/22205/91613647849b3ddce75d54.jpg"></td>
                        <td><div id="id0102">Кредитный  консалтинг</div></td>
                        <td><img src="http://cs305612.userapi.com/g39656748/e_bd258c9b.jpg"></td>
                        <td><div id="id0103">Международное  товарное  финансирование</div></td>
                        <td><img src="http://profile.ak.fbcdn.net/hprofile-ak-ash3/174776_185227304833433_241579_q.jpg"></td>
                        <td><div id="id0104">Депозитные  вклады</div></td>
                        <td><img src="http://cs5731.userapi.com/g34628038/e_18a8ff50.jpg"></td>
                        <td><div id="id0105">Инвестиции</div></td>
                    </tr>
                </table>
            </div>*}

           {* <div class="id0101 layer3">
                <table>
                    <tr>
                        <td><div>Открытие  счетов  в  иностранных  банках</div></td>
                        <td><div>Управление  счетами  и  взаиморасчетами</div></td>
                    </tr>
                </table>
            </div>
            <div class="id0102 layer3">
                <table>
                    <tr>
                        <td><div>Кредитный  брокеридж  в  банках  РФ</div></td>
                        <td><div>Кредитный  брокеридж  в иностранных банках </div></td>
                    </tr>
                </table>
            </div>
            <div class="id0103 layer3">
                <table>
                    <tr>
                        <td><div>Банковские  гарантии</div></td>
                        <td><div>Управление  кредиторской  задолженностью</div></td>
                    </tr>
                </table>
            </div>
            <div class="id0104 layer3">
                <table>
                    <tr>
                        <td><div>Депозитные  вклады  в  иностранных  банках</div></td>
                    </tr>
                </table>
            </div>
            <div class="id0105 layer3">
                <table>
                    <tr>
                        <td><div>Инвестиции  в  недвижимость</div></td>
                        <td><div>Инвестиции  в ценные  бумаги</div></td>
                    </tr>
                </table>
            </div>*}

           {* <div class="id02 layer2">
                <table>
                    <tr>
                        <td><div id="id0201">Регистрация компаний</div></td>
                        <td><div id="id0202">Номинальные сервисы</div></td>
                        <td><div id="id0203">Международное налоговое планирование</div></td>
                        <td><div id="id0204">Виртуальный офис</div></td>
                    </tr>
                    <tr>
                        <td><div id="id0205">Открытие счетов в иностранных банках</div></td>
                        <td><div id="id0206">Правовое  сопровождение</div></td>
                        <td><div id="id0207">Интеллектуальная собственность</div></td>
                        <td><div id="id0208">Трудовое законодательство</div></td>
                    </tr>
                </table>
            </div>

            <div class="id03 layer2">
                <table>
                    <tr>
                        <td><div id="id0301">Аутсорсинг  ВЭД</div></td>
                        <td><div id="id0302">Консалтинг  ВЭД</div></td>
                        <td><div id="id0303">Оформление  на  таможенного  представителя</div></td>

                    </tr>
                    <tr>
                        <td><div id="id0304">Оформление  экспортных  контрактов</div></td>
                        <td><div id="id0305">Оформление  импорных  контрактов</div></td>
                        <td><div id="id0306">Оформление  за  пределами  РФ</div></td>

                    </tr>
                </table>
                <table>
                    <tr>
                        <td><div id="id0307">Сертификация</div></td>
                        <td><div id="id0308">Страхование  грузов</div></td>
                        <td><div id="id0309">Охрана грузоперевозок</div></td>
                        <td><div id="id0310">Сопровождение проверок</div></td>
                        <td><div id="id0311">Логистика</div></td>
                    </tr>
                </table>
            </div>



            <div class="id04 layer2">
                <table>
                    <tr>
                        <td><div id="id0401">Управленческий  учет</div></td>
                        <td><div id="id0402">Финансовый учет</div></td>
                        <td><div id="id0403">Налоговый учет</div></td>
                    </tr>
                </table>
            </div>

            <div class="id05 layer2">
                <table>
                    <tr>
                        <td><div id="id0501">Управленческий  учет  нерезидентов</div></td>
                        <td><div id="id0502">Бухгалтерский  и  налоговый  учет  нерезидентов</div></td>
                        <td><div id="id0503">Финансовый учет  нерезидентов</div></td>
                        <td><div id="id0504">Информационная  безопасность</div></td>
                    </tr>
                </table>
            </div>*}


        </div>
    </div>
</div>