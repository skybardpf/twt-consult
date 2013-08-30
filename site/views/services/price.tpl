<div class="service_cont price">
    <div class="list articles">
        <div class="item">
            <div class="hdng">
                <h3>{$one_service.title} прайс-лист</h3>
            </div>
            <div class="text floatcontainer" style="font-size: 12px;">
                {$one_service.price}
            </div>
            <div class="allnews">
                <a href="/services/price_list">Полный перечень прайс листов</a>
            </div>
        </div>
    </div>
</div>


{*<div class="prices">
    <h2>Прайс-лист</h2>
    <ul class="list articles">
    {foreach from=$price_list item=pl}
        <li>
            <div class="hdng">
                <h3><a href="#" class="price_open">{$pl.title}</a></h3>
            </div>
            <div class="slide_up_down" style="display:none;">
                {$pl.price}
            </div>
        </li>
    {/foreach}
    </ul>
</div>*}
