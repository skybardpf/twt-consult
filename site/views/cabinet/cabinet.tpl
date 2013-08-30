<div class="cabinet">
    <h1>Личный кабинет</h1>
	<div class="personal-menu">
        <div>{if $dataBlock != 'personal'}<a href="/cabinet/">{/if}Личные данные{if $dataBlock != 'personal'}</a>{/if}</div>
        <div>{if $dataBlock != 'companies'}<a href="/cabinet/companies/">{/if}Компании{if $dataBlock != 'companies'}</a>{/if}</div>
        <div>{if $dataBlock != 'orders'}<a href="/cabinet/orders/">{/if}Заявки{if $dataBlock != 'orders'}</a>{/if}</div>
	</div>
    <div class="data">
        {if $dataBlock == 'personal'}
            <div class="tabs personal">
                {loadview name=cabinet/cabinet_personal}
            </div>
        {elseif $dataBlock == 'companies'}
            <div class="tabs companies">
                {loadview name=cabinet/cabinet_companies}
            </div>
        {elseif $dataBlock == 'orders'}
            <div class="tabs orders">
                {loadview name=cabinet/cabinet_orders}
            </div>
        {elseif $dataBlock == 'change'}
            <div class="tabs personal">
                {loadview name=cabinet/cabinet_change_pass}
            </div>
        {/if}
    </div>
</div>