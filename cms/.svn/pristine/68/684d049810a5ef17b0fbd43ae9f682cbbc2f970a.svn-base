Категрии:
<div style="padding-left: 20px;" id="categories">
{foreach from=$categories item=category}
	<div style="padding-top: 10px;" id="div_category_{$category.id}">
		<input type="hidden" value="0" name="categories[{$category.id}][enable]">
		<input
			type="checkbox"
			value="1"
			name="categories[{$category.id}][enable]
			id="checkbox_category_{$category.id}"
			{if $categories_values[$category.id].categ_id == $category.id}checked="checked"{/if}
		>
		<label for="checkbox_category_{$category.id}">{$category.title}</label><br>
		<div {if $categories_values[$category.id].categ_id != $category.id}style="display: none;"{/if}>
			{$categories_title.sdescr}:<br>
			<div class="input">
				<textarea name="categories[{$category.id}][sdescr]">{$categories_values[$category.id].sdescr}</textarea><br>
			</div>
			{$categories_title.image}:<br>
			{if $categories_values[$category.id].image}
				<img src="{$categories_values[$category.id].image|replace:'[dir]':'icon'}">
				<a href="{$root_url}{$ctrlName}/delete_image_category/id/{$category.id}/pid/{$request.id}/field/image/">Удалить</a>
			{/if}
			<input type="file" name="categories[{$category.id}][image]"><br>
		</div>
	</div>
{/foreach}
</div>