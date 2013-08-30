var tSelect = function (name, ajaxUrl, additionalQuery, functions, length2sendRequest) {
	var self = this;
	
	this.functions = functions;
	this.name = name;
	this.addQuery = additionalQuery;
	this.length = length2sendRequest || 3;
	this.ajaxUrl = ajaxUrl;
	this.elements = {
		text:   $('#'+name+'_text').addClass('tSelect'),
		div:    $('#'+name+'_div'),
		hidden: $('#'+name+'_hidden'),
		form:   $('#'+name+'_text').length ? $($('#'+name+'_text')[0].form) : ''
	};
	
	this.getValues = function(data) {
		self.elements.hidden.val(0);
		var str = self.elements.text.val();
		if (str.length >= self.length) {
			$.ajax({
				type: 'POST',
				url: self.ajaxUrl,
				dataType: 'json',
				data: 'str='+str+'&'+self.addQuery,
				success: self.showValues,
				error: function() {
				alert('Ошибка в получении данных для '+name);
			}
			});
		}
	};
	
	this.showValues = function(data) {
		if (data && data.length) {
			var text_position = {
				top: self.elements.text.css('top'),
				left: self.elements.text.css('left')
			};
			
			self.elements.div.css({
				display: 'block',
				position: 'absolute',
				border: '1px solid black',
				background: 'white',
				padding: '0'

			});
			var html = '<ul id="'+self.name+'_ul" style="list-style: none; margin: 0; padding: 0">';
			for ( var i = 0; i < data.length; i++) {
				var element = data[i];
				html += '<li style="margin: 0; padding: 1px 16px;"><span style="cursor: pointer;">'+element.text+'</span><input type="hidden" value="'+element.value+'">'+'</li>';
			}
			html += '</ul>';
			self.elements.div.html(html);
			self.initList();
		} else {
            var html = ''; 
            
            self.elements.div.html(html);
            self.initList();
        }
	};

	this.initList = function () {
		$('#'+name+'_ul li span').click(function() {  
			self.elements.text.val(this.innerHTML);
			self.elements.hidden.val($(this).parents('li').find('input').val());
			self.elements.div.hide();
			self.functions.click(self.elements.hidden.val(), self.elements.text.val(), self.name, self.elements);
		}).mouseout(function() {
			$(this).css({
				'text-decoration': '',
				'color': ''
			});
		}).mouseover(function() {
			$(this).css({
				'text-decoration': 'underline',
				'color': 'red'
			});
		});
		
		var timeoutId;
		self.elements.text.blur(function() {
			setTimeout(function() {
				self.elements.div.hide();
			}, 200);
		});
	};
	
	self.elements.text.keyup(function(event) {
		switch (event.keyCode) {
			case 9:
				break;
			case 13:
				break;
			case 27:
				self.elements.div.hide();
				break;
			case 38:
				if (self.elements.div.css('display') != 'none') {
					var cur = $('li.current', self.elements.div);
					if (cur.length) {
						cur.removeClass('current').css({
							'text-decoration': '',
							'color': ''
						}).prev().addClass('current').css({
							'text-decoration': 'underline',
							'color': 'red'
						});
					} else {
						$('li', self.elements.div).last().addClass('current').css({
							'text-decoration': 'underline',
							'color': 'red'
						});
					}
				}
				break;
			case 39:
				if (self.elements.div.css('display') != 'none') {
					$('li.current span', self.elements.div).click();
				}
				break;
			case 40:
				if (self.elements.div.css('display') == 'none') {
					self.getValues();
				}
				if (self.elements.div.css('display') != 'none') {
					var cur = $('li.current', self.elements.div);
					if (cur.length) {
						cur.removeClass('current').css({
							'text-decoration': '',
							'color': ''
						}).next().addClass('current').css({
							'text-decoration': 'underline',
							'color': 'red'
						});
					} else {
						$('li', self.elements.div).first().addClass('current').css({
							'text-decoration': 'underline',
							'color': 'red'
						});
					}
				}
				break;
			default:
				self.getValues();
				break;
		}
	});
	self.elements.text.keypress(function(event) {
		if (event.keyCode == 13 && self.elements.div.css('display') != 'none') {
			$('li.current span', self.elements.div).click();
			return false;
		} else if (event.keyCode == 9 && self.elements.div.css('display') != 'none') {
				$('li:first span', self.elements.div).click();
		}
	});
	return this;
};