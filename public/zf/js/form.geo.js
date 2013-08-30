var geoInput;
geoInput = function(id, transport) {
	var self = this;
	this.id = id;
	this.transport = transport;
	this.elems = {
		text:   $('#' + id),
		div:	$('#' + id + '_div'),
		hidden: $('#' + id + '_hidden')
	};
	this.results = null;
	this.timer_id = null;
	this.prevFound = null;
	this.events = {
		placeSelected: function(title, lnglat, index){},
		initInput: function(title, lnglat){}
	};
	this.elems.div.css({
		display: 'block',
		position: 'absolute',
		border: '1px solid black',
		background: 'white',
		padding: '0',
		'z-index': '100'
	}).hide();

	if (this.elems.hidden.val().length > 5 && this.elems.text.val().length == 0) {
		if (transport == 'yandex') {
			var geocoder = new YMaps.Geocoder(this.elems.hidden.val());
			YMaps.Events.observe(geocoder, geocoder.Events.Load, function () {
				self.elems.text.val(this.get(0).text);
				self.events.initInput(this.get(0).text, self.elems.hidden.val());
			});
		} else if (transport == 'google') {
			var geocoder = new google.maps.Geocoder();
			var latlngStr = this.elems.hidden.val().split(",",2);
			var lat = parseFloat(latlngStr[1]);
			var lng = parseFloat(latlngStr[0]);
			var latlng = new google.maps.LatLng(lat, lng);
			geocoder.geocode({'latLng': latlng}, function(results, status) {
				if (status == google.maps.GeocoderStatus.OK) {
					self.elems.text.val(results[0].formatted_address);
				} else {
					self.elems.div.html('<span style="color:red; padding: 10px;">' + response.Status.code + '</span>').slideDown('slow');
					setTimeout(function() {
						self.elems.div.slideUp('slow');
					}, 3000);
				}
				self.events.initInput(results[0].formatted_address, self.elems.hidden.val());
			});
		}
	} else {
		self.events.initInput(this.elems.text.val(), self.elems.hidden.val());
	}

	this.geocode = function() {
		if (transport == 'yandex') {
			var geocoder = new YMaps.Geocoder(self.elems.text.val());
			YMaps.Events.observe(geocoder, geocoder.Events.Load, function () {
				self.results = this;
				if (this.found == 0) {
					self.elems.div.html('<span style="color:red; padding: 10px;">Данный адрес не найден.</span>').slideDown('slow');
					setTimeout(function() {
						self.elems.div.slideUp('slow');
					}, 3000);
				} else {
					self.elems.hidden.val(this.get(0).getGeoPoint());
					var html = '<ul id="' + self.id + '_ul" style="list-style: none; margin: 0; padding: 0">';
					for (var i = 0; i < this.length(); i++) {
						var element = this.get(i);
						html += '<li style="margin: 0; padding: 1px 16px;"><span style="cursor: pointer;">' + element.text + '</span><input type="hidden" value="' + element.getGeoPoint() + '">' + '</li>';
					}
					html += '</ul>';
					self.elems.div.html(html).slideDown('slow');
					self.initList();
				}
			});
			YMaps.Events.observe(geocoder, geocoder.Events.Fault, function (geocoder, errorMessage) {
				self.elems.div.html('<span style="color:red; padding: 10px;">Произошла ошибка при геокодировании: ' + errorMessage + '</span>').slideDown('slow');
				setTimeout(function() {
					self.elems.div.slideUp('slow');
				}, 3000);
			});
		} else if (transport == 'google') {
			var geocoder = new google.maps.Geocoder();
			geocoder.geocode( { 'address': self.elems.text.val()}, function(results, status) {
				self.results = results;
				if (status == google.maps.GeocoderStatus.OK) {
					self.elems.hidden.val(results[0].geometry.location.lng()+','+results[0].geometry.location.lat());
					var html = '<ul id="' + self.id + '_ul" style="list-style: none; margin: 0; padding: 0">';
					for (var i = 0; i < results.length; i++) {
						var element = results[i];
						html += '<li style="margin: 0; padding: 1px 16px;"><span style="cursor: pointer;">'
							+ element.formatted_address
							+ '</span><input type="hidden" tabindex="' + i + '" value="'
							+ element.geometry.location.lng()+','+element.geometry.location.lat() + '">' + '</li>';
					}
					html += '</ul>';
					self.elems.div.html(html).slideDown('slow');
					self.initList();
				} else {
					self.elems.div.html('<span style="color:red; padding: 10px;">Geocode was not successful for the following reason: ' + status + '.</span>').slideDown('slow');
					setTimeout(function() {
						self.elems.div.slideUp('slow');
					}, 3000);
				}
			});
		}
	};

	this.initList = function () {
		$('#' + self.id + '_ul li span').click(
			function() {
				self.elems.text.val(this.innerHTML);
				self.elems.hidden.val($(':hidden', this.parentNode).val());
				self.elems.div.slideUp('slow');
				self.events.placeSelected(this.innerHTML, $(':hidden', this.parentNode).val(), $(':hidden', this.parentNode).attr('tabindex'));
		}).mouseout(
			function() {
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
	};

	self.elems.text.keyup(function(event) {
		clearTimeout(self.timer_id);
		switch (event.keyCode) {
			case 9:
				break;
			case 13:
				break;
			case 27:
				self.elems.div.slideUp('slow');
				break;
			case 38:
				if (self.elems.div.css('display') != 'none') {
					var cur = $('li.current', self.elems.div);
					if (cur.length) {
						cur.removeClass('current').css({
							'text-decoration': '',
							'color': ''
						}).prev().addClass('current').css({
							'text-decoration': 'underline',
							'color': 'red'
						});
					} else {
						$('li', self.elems.div).last().addClass('current').css({
							'text-decoration': 'underline',
							'color': 'red'
						});
					}
				}
				break;
			case 39:
				if (self.elems.div.css('display') != 'none') {
					$('li.current span', self.elems.div).click();
				}
				break;
			case 40:
				if (self.elems.div.css('display') == 'none') {
					if (self.elems.text.val().length > 5) {
						self.timer_id = setTimeout(self.geocode, 600);
					}
				}
				if (self.elems.div.css('display') != 'none') {
					var cur = $('li.current', self.elems.div);
					if (cur.length) {
						cur.removeClass('current').css({
							'text-decoration': '',
							'color': ''
						}).next().addClass('current').css({
							'text-decoration': 'underline',
							'color': 'red'
						});
					} else {
						$('li', self.elems.div).first().addClass('current').css({
							'text-decoration': 'underline',
							'color': 'red'
						});
					}
				}
				break;
			default:
				self.elems.div.slideUp('slow');
				if (self.elems.text.val().length > 5) {
					self.timer_id = setTimeout(self.geocode, 600);
				}
				break;
		}
	});
	self.elems.text.keypress(function(event) {
		if (event.keyCode == 13 && self.elems.div.css('display') != 'none') {
			$('li.current span', self.elems.div).click();
			return false;
		} else if (event.keyCode == 9 && self.elems.div.css('display') != 'none') {
			$('li:first span', self.elems.div).click();
		}
	});

	return this;
};