<div class="prices">
<h2>Прайс-лист</h2>
<ul>
    {foreach from=$price_list item=service name=price_list}
        {assign var=first_level value=false}
        {assign var=second_level value=false}
        {if $service.children}
            {foreach from=$service.children item=s_child}
                {if $s_child.price}
                    {assign var=first_level value=true}
                {/if}
                {if $s_child.children}
                    {foreach from=$s_child.children item=s_s_child}
                        {if $s_s_child.price}
                            {assign var=second_level value=true}
                            {*{assign var=first_level value=2}*}
                        {/if}
                    {/foreach}
                {/if}
            {/foreach}
        {/if}

        {if $service.price || $first_level || $second_level}
        <li> <h3>
            {if $service.price}
                <a href="/services/{$service.url}/price" class="hdng">{$service.title}</a>
            {else}
                {$service.title}
            {/if}
            </h3>

            {if $service.children}
            <ul style="padding-left: 40px;">
                {foreach from=$service.children item=s_child name=s_children}

                {assign var=third_level value=false}

                {if $s_child.children}
                    {foreach from=$s_child.children item=s_s_child}
                        {if $s_s_child.price}
                            {assign var=third_level value=true}
                        {*{assign var=first_level value=2}*}
                        {/if}
                    {/foreach}
                {/if}


                    {if $s_child.price || $third_level}
                    <li><h4>
                        {if $s_child.price}
                            <a href="/services/{$s_child.url}/price" class="hdng">{$s_child.title}</a>
                        {else}
                            {$s_child.title}
                        {/if}
                        </h4>
                        {if $s_child.children}
                        <ul style="padding-left: 40px;">
                            {foreach from=$s_child.children item=s_s_child name=s_s_children}
                                {if $s_s_child.price}
                                    <li>
                                        <h5>
                                            <a href="/services/{$s_s_child.url}/price" class="hdng">{$s_s_child.title}</a>
                                        </h5>
                                    </li>
                                {/if}
                            {/foreach}
                        </ul>
                        {/if}
                    </li>
                    {/if}
                {/foreach}
            </ul>
            {/if}
        </li>
        {/if}

    {/foreach}
</ul>
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