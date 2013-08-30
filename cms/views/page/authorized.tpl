<tr id="header">
    <td colspan="3">
        <div id="logo"{if !isset($copyrights.logo)} class="artektiv"{/if}>
            <a href="{$root_url}">{if !isset($copyrights.logo)}<img src="/public/cms/img/logo.png" style="float:left;">{elseif $copyrights.logo}<img src="{$copyrights.logo}" style="float: left;">{else}<h1 style="float:left; margin:6px 0 0 5px; color: #c11f49;">{$copyrights.title}</h1>{/if}</a>{if $pageTitleLast} <h1 style="float:left; margin:6px 0 0 5px;">/</h1>{/if}
        </div>
        <div id="project_title">
            <h1>{$pageTitleLast|default:'&nbsp;'}</h1>
            {can ctrl='settings' action="access"}
                <span id="site_settings"> <a href="{$root_url}settings/">Настройки сайта</a></span>
            {/can}
            {can ctrl='meta_tags' action="access"}
                <span id="meta_tags"> <a href="{$root_url}meta_tags/">Мета-теги</a></span>
            {/can}
        </div>
        <div id="log_in">
            <table>
                <tr>
                    <td id="user_td">
                        Вы вошли как <a href="{$root_url}users/show/id/{$user.id}/">{$user.name}</a>
                    </td>
                    <td id="exit_td">
                        <a href="{$root_url}logout/">Выйти</a>
                    </td>
                </tr>
                {can ctrl='users' action="access"}
                    <tr>
                        <td id="manage_users_td">
                            <a href="{$root_url}users/">Управление пользователями</a>
                        </td>
                        <td>
                        </td>
                    </tr>
                {/can}
            </table>
        </div>
    </td>
</tr>
{literal}
<script language="javascript">
$(document).ready(function() {
	$('#top-menu table td').mouseover(function(){
		$(this).children('div').addClass('hover');
	});
	$('#top-menu table td').mouseout(function(){
		$(this).children('div').removeClass('hover');
	});
});
</script>
{/literal}
<tr id="top-menu">
    <td colspan="3" style="padding:0;">
        <table style="width:100%;">
            <tr>
                <td><!--[if IE]><img src="/public/cms/img/top-menu-divider.png" class="right" style="margin-left:12px;"><![endif]--></td>
                {foreach from=$main_menu item=menu key=key}
                {if $menu.link}
                {can ctrl=$menu.link action="access"}
                    <td>
                    	<!--[if IE]><img src="/public/cms/img/top-menu-divider.png" class="left"><![endif]-->
                        {if $menu.link}
                        	<a href="{$root_url}{$menu.link}/" {if $menu.target}target="{$menu.target}" {/if}>{$menu.title}</a>
                        {else}
                        	<span style="font-size:14px; cursor:default;">{$menu.title}</span>
                        {/if}
                    	<!--[if IE]><img src="/public/cms/img/top-menu-divider.png" class="right"><![endif]-->
                        {if $menu.submenu}
                        <div>
                        <ul>
                        {foreach from=$menu.submenu item=submenu}
                            {if $submenu != 'hr'}
                                {can url=$submenu.link}
                                    <li><a href="{$root_url}{$submenu.link}/">{$submenu.title}</a></li>
                                {/can}
                            {else}
                                <li class="hr"><hr></li>
                            {/if}
                        {/foreach}
                        </ul>
                        </div>
                        {/if}
                    </td>
                {/can}
                {else}
                	<td>
                    	<!--[if IE]><img src="/public/cms/img/top-menu-divider.png" class="left"><![endif]-->
                        	<span style="font-size:14px; cursor:default;">{$menu.title}</span>
                    	<!--[if IE]><img src="/public/cms/img/top-menu-divider.png" class="right"><![endif]-->
                        {if $menu.submenu}
                        <div>
                        <ul>
                        {foreach from=$menu.submenu item=submenu}
                            {if $submenu != 'hr'}
                                {can url=$submenu.link}
                                    <li><a href="{$root_url}{$submenu.link}/">{$submenu.title}</a></li>
                                {/can}
                            {else}
                                <li class="hr"><hr></li>
                            {/if}
                        {/foreach}
                        </ul>
                        </div>
                        {/if}
                    </td>
                {/if}
                {/foreach}
                {foreach from=$main_smenu item=menu name=menu}
				{if $menu.link}
                {can ctrl=$menu.link action="access"}
                    <td>
                    	<!--[if IE]><img src="/public/cms/img/top-menu-divider.png" class="left"><![endif]-->
                        <a href="{$root_url}{$menu.link}/">{$menu.title}</a>
                    	<!--[if IE]><img src="/public/cms/img/top-menu-divider.png" class="right"><![endif]-->
                        {if $menu.submenu}
                        <div>
                        <ul {if $smarty.foreach.menu.last} class="last"{/if}>
                        {foreach from=$menu.submenu item=submenu}
                            {if $submenu != 'hr'}
                                {can url=$submenu.link}
                                    <li><a href="{$root_url}{$submenu.link}/">{$submenu.title}</a></li>
                                {/can}
                            {else}
                                <li class="hr"><hr></li>
                            {/if}
                        {/foreach}
                        </ul>
                        </div>
                        {/if}
                    </td>
                {/can}
				{else}
					<td{if $menu.color} class="red"{/if}>
                    	<!--[if IE]><img src="/public/cms/img/top-menu-divider.png" class="left"><![endif]-->
                        <span style="font-size:14px; cursor:default;">{$menu.title}</span>
                    	<!--[if IE]><img src="/public/cms/img/top-menu-divider.png" class="right"><![endif]-->
                        {if $menu.submenu}
                        <div>
                        <ul {if $smarty.foreach.menu.last} class="last"{/if}>
                        {foreach from=$menu.submenu item=submenu}
                            {can url=$submenu.link}
                            	{if $submenu != 'hr'}
                                <li><a href="{$root_url}{$submenu.link}/">{$submenu.title}</a></li>
                                {else}
                                <li class="hr"><hr></li>
                                {/if}
                            {/can}
                        {/foreach}
                        </ul>
                        </div>
                        {/if}
                    </td>
				{/if}
                {/foreach}
                <td style="width:100%;"><!--[if IE]><img src="/public/cms/img/top-menu-divider.png" class="left"><![endif]--></td>
            </tr>
        </table>
    </td>
</tr>
<tr style="" id="i_hate_ie">
<td>
    {if $access_denied}
        <h1>Доступ запрещен!</h1>
    {else}



    <table id="center" style="position:relative; z-index:0;">
    	<tr>
        {if $panel}
            <td class="left-open" id="leftPanel">
                <div class="menu">
	            	{$panel}
                </div>	
            </td>
            <td class="action-close" id="closeDiv"></td>
            <td class="right" id="right">
                <table style="width:100%; height:100%;">
                    <tr class="bread-crumbs">
                        <td style="height:50px;">
                            <h1>
                                {if is_array($pageTitle) or $pageTitleLast}
                                    {if is_array($pageTitle)}
                                        {foreach from=$pageTitle item=tItem name="pTitle"}
                                            {if is_array($tItem)}
                                                <a href="{$root_url}{$tItem.link}/">{$tItem.title}</a>
                                            {else}
                                                {$tItem}
                                            {/if}
                                
                                            {if !$smarty.foreach.pTitle.last} / {/if}
                                        {/foreach}
                                    {else}
                                        {$pageTitle}
                                    {/if}
                                    {if $pageTitleLast} / <b>{$pageTitleLast}</b>{/if} &rarr; <span>{$actionTitle}</span>
                                {else}
                                    <b>{$pageTitle}</b> &rarr; <span>{$actionTitle}</span>
                                {/if}
                            </h1>
                        
                        </td>
                    </tr>
                    <tr>
                        <td id="content_table">
                            <div class="rc10">
                                {$content}
                            </div>
                            <!--<a href="#" class="button-blue">Добавить раздел</a>-->
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
        {else}
            <td class="right" id="right">
                <table style="width:100%; height:100%;">
                    <tr class="bread-crumbs">
                        <td style="height:50px;">
                            <h1>
                                {if is_array($pageTitle) or $pageTitleLast}
                                    {if is_array($pageTitle)}
                                        {foreach from=$pageTitle item=tItem name="pTitle"}
                                            {if is_array($tItem)}
                                                <a href="{$root_url}{$tItem.link}/">{$tItem.title}</a>
                                            {else}
                                                {$tItem}
                                            {/if}
                                
                                            {if !$smarty.foreach.pTitle.last} / {/if}
                                        {/foreach}
                                    {else}
                                        {$pageTitle}
                                    {/if}
                                    {if $pageTitleLast} / <b>{$pageTitleLast}</b>{/if} &rarr; <span>{$actionTitle}</span>
                                {else}
                                    <b>{$pageTitle}</b> &rarr; <span>{$actionTitle}</span>
                                {/if}
                            </h1>
                        
                        </td>
                    </tr>
                    <tr>
                        <td id="content_table">
                            <div class="rc10">
                        
                                {$content}
                            </div>
                            <!--<a href="#" class="button-blue">Добавить раздел</a>-->
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
        {/if}
    	</tr>
    </table>
    
	{/if}
</td>
</tr>
