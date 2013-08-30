function afterClick(id, str, inp_name, inp_elems) {
	var arr = inp_name.split('_');
	var type = arr[arr.length-1];
	var tmp_name = arr;
	tmp_name.pop();
	tmp_name = tmp_name.join('_');
	switch (type) {
		case 'street':
			initPreValues('ad', 'street', id, {
				hidden: $('#'+tmp_name+'_ad_hidden'),
				text: $('#'+tmp_name+'_ad_text')
			});
			initPreValues('pd', 'street', id, {
				hidden: $('#'+tmp_name+'_pd_hidden'),
				text: $('#'+tmp_name+'_pd_text')
			});
		break;
		case 'pd':
			initPreValues('ad', 'pd', id, {
				hidden: $('#'+tmp_name+'_ad_hidden'),
				text: $('#'+tmp_name+'_ad_text')
			});
		break;
		case 'metro':
			initPreValues('metroline', 'metro', id, {
				hidden: $('#'+tmp_name+'_metrolines_hidden'),
				text: $('#'+tmp_name+'_metrolines_text')
			});
		break;
	}
	$.ajax({
		type: 'POST',
		url: root_url+ctrlName+'/load_control/'+type+'/',
		dataType: 'json',
		data: ({id: id}),
		success: function(data) {
			var tmp_data = Array();
			var tmp_names = Array();
			if (data) {
				for ( var name in data) {
					tmp_data.push('"'+name+'": ' + JSON.stringify(data[name]));
					tmp_names.push(name);
				}
				
				getInputs('{'+tmp_data.join(', ')+'}', inp_elems, tmp_names);
			}
		},
		error: function() {
			alert('Ошибка запроса');
		}
	});
}

function getInputs(fields, inp_elems, names) {
	$.ajax({
		type: 'POST',
		url: root_url+ctrlName+'/get_elements/',
		dataType: 'html',
		data: 'elements=' + encodeURIComponent(fields),
		success: function(data) {
			if (data && data.length > 2) {
				var obj = $('<div>'+data+'</div>');
				var scripts = '';
				for ( var i = 0; i < obj.length; i++) {
					var element = obj[i];
					if (element.tagName && element.tagName.toLowerCase() == 'script') {
						scripts += element.innerHTML + "\n";
					}
					else {
						var div = $(element);
					}
				}
				var for_delete = $('.geo4edit');
				var prev = $(for_delete.parent()[0]).prev().prev().prev().prev();
				$.ajax({
					type: 'POST',
					url: root_url+ctrlName+'/load_control/',
					dataType: 'json',
					data: ({id: 0}),
					success: function(data) {
						var tmp_data = Array();
						var tmp_names = Array();
						if (data) {
							for ( var name in data) {
								tmp_data.push('"'+name+'": ' + JSON.stringify(data[name]));
								tmp_names.push(name);
							}
							$.ajax({
								type: 'POST',
								url: root_url+ctrlName+'/get_elements/',
								dataType: 'html',
								data: 'elements=' + encodeURIComponent('{'+tmp_data.join(', ')+'}'),
								success: function(data) {
									prev.after('<br>'+data);
								}
							});
						}
					},
					error: function() {
						alert('Ошибка запроса');
					}
				});
				for ( var i = 0; i < for_delete.length; i++) {
					var elem = for_delete[i];
					var elem4del = $('label[for='+elem.id+']');
					if (!elem4del.length) {
						var elem4del = $('label[for='+elem.id.split('_', 3).join('_')+']');
					}
					elem4del.prev().remove();
					elem4del.next().remove();
					elem4del.remove();
					$(elem).prev().remove();
					$(elem).next().remove();
					$(elem).parent().remove();
				}
				
				if ($('div.childrens', inp_elems.text.parent()).length == 0) {
					inp_elems.text.parent().append('<div class="childrens"></div>');
				}
				var parent = $('div.childrens', inp_elems.text.parent());
				parent.html('');
				for ( var i = 0; i < names.length; i++) {
					var name = names[i];
					name = name.split('[').join('_').split(']').join('');
					if ($('div#loaded_element_'+name).length) {
						$('div#loaded_element_'+name).html($('#get_element_id_'+name, div).html());
					}
					else {
						parent.append('<div id="loaded_element_'+name+'"><br>'+$('#get_element_id_'+name, div).html()+'</div>');
					}
				}
				if (scripts){
					eval(scripts);
				}
			}
		},
		error: function() {
			alert('Ошибка запроса');
		}
	});
}

function initPreValues(type, field, id, obj) {
	$.ajax({
		type: 'POST',
		url: root_url+ctrlName+'/get_pre_value/',
		dataType: 'json',
		data: ({
			type: type,
			field: field,
			id: id
		}),
		success: function(data) {
			if (data && data.length == 1) {
				obj.hidden.val(data[0].value);
				obj.text.val(data[0].text);
			} else if (data && data.length > 1) {
				var html = '<select name="'+obj.hidden.attr('name')+'">';
				html += '<option>не выбрано</option>';
				for ( var i = 0; i < data.length; i++) {
					var element = data[i];
					html += '<option value="'+element.value+'">'+element.text+'</option>';
				}
				html += '</select>';
				obj.text.parent().html(html);
			}
		},
		error: function() {
			alert('Ошибка получения данных родителя');
		}
	});
}