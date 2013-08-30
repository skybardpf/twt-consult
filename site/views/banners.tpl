
{if $banners}
    <div class="banners">
        <div id="ban">
            {if $banners.top}
                <div id="banner1">
                    <a href="/{$banners.top.url}"><img alt="" title="" src="{$banners.top.image|replace:'[dir]':'resized'}" style="width: 338px; height: 132px;"></a>
                </div>
            {/if}
            {if $banners.middle}
                <div id="banner2">
                    <a href="/{$banners.middle.url}"><img alt="" title="" src="{$banners.middle.image|replace:'[dir]':'resized'}" style="width: 338px; height: 132px;"></a>
                </div>
            {/if}
            {if $banners.bottom}
                <div id="banner3">
                    <a href="/{$banners.bottom.url}"><img alt="" title="" src="{$banners.bottom.image|replace:'[dir]':'resized'}" style="width: 338px; height: 132px;"></a>
                </div>
            {/if}
        </div>
    </div>
{/if}