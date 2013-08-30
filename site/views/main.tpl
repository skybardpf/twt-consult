<!DOCTYPE HTML>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<title>{$meta.title|default:$title}</title>
	<meta name="keywords" content="{$meta.keywords}">
	<meta name="description" content="{$meta.description}">
    <meta name="author" content="{$meta.author}">
    {if $meta.meta_additional }
        {$meta.meta_additional}
    {/if}
    {*<meta name="HandheldFriendly" content="true">*}
    {*<meta name="MobileOptimized" content="960">*}
    {*<meta name="Viewport" content="width=device-width">*}

    <link rel="stylesheet" href="/public/site/css/handheld.css" media="handheld,only screen and (max-device-width:480px)"/>
	<!-- CSS -->
{foreach from=$pageCSS item=item}
	<link href='{$item}' rel='stylesheet' type='text/css'>
{/foreach}

    <link href='http://fonts.googleapis.com/css?family=Ubuntu:500&amp;subset=latin,cyrillic-ext,latin-ext,cyrillic' rel='stylesheet' type='text/css'>


	<!-- JS -->
	<script type="text/javascript">
		var root_url = '{$root_url}';
		var ctrlName = '{$ctrlName}';
        var siteuser = {if !$logged_site_user}{literal}{}{/literal}{else}{$logged_site_user|@json_encode}{/if};
	</script>
{foreach from=$pageJS item=item}
	<script src='{$item}' type='text/javascript'></script>
{/foreach}
	<!--zf::debug:head-->
</head>    

<body>

<div class="wrapper_outer">
    <div class="wrapper_inner">

        {loadview name=header}

        <div class="content">

        {if $page_content.id == 1}
            {loadview name=main_page}
        {else}

            {if $page_content.content}
                <div class="content_static">
                    {loadview name=breadcrumbs}
                    {*{loadview name=inner_menu}*}

                    {loadview name=banners}
                    <div class="static_text">
                        <h2>{$page_content.title}</h2>
                        {$page_content.content}

                        {loadview name=form_urid}

                        {loadview name=form_schet}

                        {loadview name=form_transport}
                    </div>

                </div>
            {else}
                <div class="content_inner">
                    {loadview name=breadcrumbs}
                    {*{loadview name=inner_menu}*}
                    {if $ctrlName == 'services' && $request.parr[0] != 'price_list'}
                        {loadview name=inner_menu}
                    {/if}
                    {if $ctrlName != 'cabinet'}{loadview name=banners}{/if}
                    {$content}
                    <div class="clear"></div>

                    {loadview name=form_urid}

                    {loadview name=form_schet}

                    {loadview name=form_transport}

                </div>
            {/if}

        {/if}


        </div>

        <div class="clear"></div>

        {loadview name=footer}

    </div>
</div>

    <!--zf::debug:body-->
</body>
</html>