
<div class="service_cont">

    <div class="list articles">

            <div class="hdng">
                <h2>{$one_country.title}</h2>
                {*<div>{$one_country.price}</div>*}
            </div>
            <div class="text floatcontainer" style="font-size: 12px;">
                {*{if $one_country.flag}<img alt="" title="" src="{$one_country.flag|replace:'[dir]':'icon'}" style="width: 77px;height: 77px;">{/if}*}
                <div class="descr">
                {$one_country.text}
                </div>
            </div>
        <div class="clear"></div>
        {*    <div class="allnews">
                <a href="/countries/">все страны</a>
            </div>*}

    </div>

</div>