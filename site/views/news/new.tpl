
<div class="one_news">

    <div class="list articles">

            <div class="hdng">
                <h2>{$new.title}</h2>
                <div class="date">{$new.created|date_format:"%d.%m.%Y"}</div>
            </div>
            <div class="text floatcontainer">
            {if $new.image}
                <img alt="" title="" src="{$new.image|replace:'[dir]':'icon'}" style="width: 77px;height: 77px;">
            {/if}
                <div class="descr">
                {$new.text}
                </div>
            </div>
        <div class="clear"></div>
            <div class="allnews">
                <a href="/news">все новости</a>
            </div>

    </div>

</div>