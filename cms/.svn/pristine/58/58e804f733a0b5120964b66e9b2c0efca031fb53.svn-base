<!DOCTYPE HTML>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>{$title|default:'CMS'}</title>
<!-- CSS -->
<link rel="stylesheet" type="text/css" href="/public/cms/css/style.css" />
<link rel="stylesheet" type="text/css" href="/public/cms/css/style2.css" />
{foreach from=$pageCSS item=item}
<link href='{$item}' rel='stylesheet' type='text/css'>
{/foreach}
<!-- JS -->
{literal}
<script>
function toggle_left() {
	if(document.getElementById('left').style.display!='none')
		document.getElementById('left').style.display='none';
	else
		document.getElementById('left').style.display='table-cell';
};
</script>
{/literal}
<script type="text/javascript">
var root_url = '{$root_url}';
var ctrlName = '{$ctrlName}';
</script>
{foreach from=$pageJS item=item}
<script src='{$item}' type='text/javascript'></script>
{/foreach}

<!--zf::debug:head-->

</head>

<body>
<table id="content">
<tr id="header">
<td colspan="3">
    <div id="logo">
        <a href="/"><img src="img/logo.png" style="float:left;"></a> <h1 style="float:left; margin:6px 0 0 5px;">/</h1>
    </div>
    <div id="project_title">
        <h1>Интернет-магазин "Италкер"</h1>
        <span id="site_settings"> <a href="#">Настройки сайта</a></span> <span id="meta_tags"> <a href="#">Мета-теги</a></span>
    </div>
    <div id="log_in">
        <table>
            <tr>
                <td id="user_td">
                    Вы вошли как <a href="#">Николай Валуев</a>
                </td>
                <td id="exit_td">
                    <a href="#">Выйти</a>
                </td>
            </tr>
            <tr>
                <td id="manage_users_td">
                    <a href="#">Управление пользователями</a>
                </td>
                <td>
                </td>
            </tr>
        </table>
    </div>
</td>
</tr>
<tr id="topmenu">
<td colspan="3" style="padding:0; overflow:hidden;">
    <table style="width:110%; margin-left:-10px;">
        <tr>
            <td>&nbsp;</td>
            <td>
                    <a href="#">Разделы</a>
            </td>
            <td>
                    <a href="#">Новости</a>
            </td>
            <td>
                    <a href="#">Статьи</a>
                <ul>
                    <li><a href="#">Заказы</a></li>
                    <li><a href="#">Заказы (оператор)</a></li>
                    <li><a href="#">Заказы (дилер)</a></li>
                    <li><a href="#">Импорт остатков</a></li>
                </ul>
            </td>
            <td>
                    <a href="#">Каталог</a>
                <ul>
                    <li><a href="#">Заказы</a></li>
                    <li><a href="#">Заказы (оператор)</a></li>
                    <li><a href="#">Заказы (дилер)</a></li>
                    <li><a href="#">Импорт остатков</a></li>
                </ul>
            </td>
            <td>
                    <a href="#">Магазин</a>
                <ul>
                    <li><a href="#">Заказы</a></li>
                    <li><a href="#">Заказы (оператор)</a></li>
                    <li><a href="#">Заказы (дилер)</a></li>
                    <li><a href="#">Импорт остатков</a></li>
                </ul>
            </td>
            <td>
                    <a href="#">Справочники</a>
            </td>
            <td style="width:100%;"></td>
        </tr>
    </table>
</td>
</tr>
<tr>
<td id="left">
    <div class="menu">
        <hr>
        <div class="m-item"><a href="#">Главная</a></div>
        <hr>
        <div class="m-item"><a href="#">Оплата</a></div>
        <hr>
        <div class="m-item"><a href="#">О компании</a></div>
        <div class="submenu">
            <hr>
            <div class="m-item"><a href="#">Миссия компании</a></div>
            <hr>
            <div class="m-item"><a href="#">Наши сотрудники</a></div>
            <hr>
        </div>
        <div class="m-item"><a href="#">Доставка</a></div>
        <hr>
        <div class="m-item"><a href="#">Контакты</a></div>
        <hr>
        <div class="m-item"><a href="#">Проверить заказ</a></div>
        <hr>
    </div>
</td>
<td id="content_divider" onClick="toggle_left();"></td>
<td id="center">
	<table style="width:100%; height:100%;">
        <tr>
            <td style="height:50px;">
                <h1>Разделы &rarr; Добавить раздел</h1>
            </td>
        </tr>
        <tr>
            <td id="content_table">
                <div class="rc10">
                <table style="width:100%;" class="pages">
                    <tr class="pages-head">
                        <td colspan="2" style="border-right:none;">
                        </td>
                        <td colspan="2">
                        Страница
                        </td>
                        <td colspan="4" style="text-align:center;border-right:none;">
                        Управление
                        </td>
                    </tr>
                    <tr>
                        <td colspan="8">
                        </td>
                    </tr>
                    <tr class="m-item-center">
                        <td style="width:25px;"></td>
                        <td style="width:25px;"></td>
                        <td style="width:25px;"><img src="img/house.png"></td>
                        <td><a href="#">Главная</a></td>
                        <td style="width:25px;"><a href="#"><img src="img/cross-green.png"></a></td>
                        <td style="width:25px;"><a href="#"><img src="img/lymph.png"></a></td>
                        <td style="width:25px;"><a href="#"><img src="img/pencil.png"></a></td>
                        <td style="width:25px;"></td>
                    </tr>
                    <tr class="m-item-center" style="background-color:#e4e4e4;">
                        <td></td>
                        <td><a href="#"><img src="img/downarrow-green.png"></a></td>
                        <td><img src="img/sheet-icon.png"></td>
                        <td><a href="#">О компании</a></td>
                        <td><a href="#"><img src="img/cross-green.png"></a></td>
                        <td><a href="#"><img src="img/lymph.png"></a></td>
                        <td><a href="#"><img src="img/pencil.png"></a></td>
                        <td><a href="#"><img src="img/cross-red.png"></a></td>
                    </tr>
                    <tr class="m-item-center">
                        <td><a href="#"><img src="img/uparrow-green.png"></a></td>
                        <td><a href="#"><img src="img/downarrow-green.png"></a></td>
                        <td><img src="img/sheet-icon.png"></td>
                        <td><a href="#">Доставка</a></td>
                        <td><a href="#"><img src="img/cross-green.png"></a></td>
                        <td><a href="#"><img src="img/lymph.png"></a></td>
                        <td><a href="#"><img src="img/pencil.png"></a></td>
                        <td><a href="#"><img src="img/cross-red.png"></a></td>
                    </tr>
                    <tr class="m-item-center" style="background-color:#e4e4e4;">
                        <td><a href="#"><img src="img/uparrow-green.png"></a></td>
                        <td></td>
                        <td><img src="img/sheet-icon.png"></td>
                        <td><a href="#">Контакты</a></td>
                        <td><a href="#"><img src="img/cross-green.png"></a></td>
                        <td><a href="#"><img src="img/lymph.png"></a></td>
                        <td><a href="#"><img src="img/pencil.png"></a></td>
                        <td><a href="#"><img src="img/cross-red.png"></a></td>
                    </tr>
                </table>
                </div>
                <a href="#" class="button-blue">Добавить раздел</a>
            </td>
        </tr>
        <tr>
            <td id="footer">
                {if !isset($copyrights.link)}
                	© <a href="http://www.artektiv.ru">artektiv</a>
                {elseif $copyrights.link}
                	{$copyrights.link}
                {/if}
            </td>
        </tr>
    </table>
</td>
</tr>
</table>
<!--zf::debug:body-->
</body>
</html>