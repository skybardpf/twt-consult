var metroSelect = function(id, stations, selectOne, lines, districts) {
	var self = this;
	this.id = id;
	this.selectOne = selectOne;
	this.stations = stations;
	this.lines = lines || false;
	this.districts = districts || false;
	this.mapIsInit = false;
	this.selectedStations = {};
	

	this.elements = {
		select: $('#'+id+' select'),
		aopen: $('#'+id+' a.openmap'),
		aclose: $('#'+id+' a.closemap'),
		station: $('#'+id+' a.station'),
		map: $('#'+id+' .metromap')
	};
	
	this.elements.aopen.click(function(event) {
		if (event.altKey && event.ctrlKey) {
			var img = $('img:first', self.elements.map);
			img.attr('src', img.attr('src').replace('moscow', '2033'));
		}
		self.elements.map.show();
		self.initMap();
		var selectedStations = $('option[selected]', self.elements.select);
		for ( var i = 0; i < selectedStations.length; i++) {
			var station = selectedStations[i];
			$('#marker'+$(station).attr('value')).click();
		}
		
		return false;
	});
	
	this.elements.aclose.click(function() {
		self.elements.map.hide();
		return false;
	});
	
	this.initMap = function() {
		if (self.mapIsInit) return true;
		self.elements.stations = $('<div class="metro-stations">').appendTo(self.elements.map);
		for ( var i = 0; i < self.stations.length; i++) {
			(function() {				
				var station = self.stations[i];
				$('img', self.elements.station
					.clone()
					.appendTo(self.elements.stations)
					.css({
						display: '',
						position: 'absolute',
						top: station.top,
						left: station.left
					})
					.attr('id', 'marker'+station.id)
					.click(function() {
						$(this).blur();
						if (self.selectedStations[station.id] == undefined) {
							if (self.selectOne) {
								$('img.placeholder', self.elements.map).show();
								$('img.marker', self.elements.map).hide();
								self.selectedStations = {};
							}
							self.selectedStations[station.id] = {images: $('img', this)};
							$('img.placeholder', this).hide();
							$('img.marker', this).show();
							$('option[value='+station.id+']', self.elements.select).attr('selected', true);
						} else {
							$('option[value='+station.id+']', self.elements.select).attr('selected', false);
							delete self.selectedStations[station.id];
							$('img.placeholder', this).show();
							$('img.marker', this).hide();
						}
						return false;
					})
				).attr({
					alt: station.title,
					title: station.title
				});
			})();
		}
		if (lines) {
			self.elements.lines = $('<div class="metro-lines">').appendTo(self.elements.map);
			for ( var i = 0; i < lines.length; i++) {
				(function(line) {
					$('<a>').html(line.title).attr({
						'class': 'metro-line',
						'href': '#'
					}).css({
						'background-color': '#'+line.color,
						'color':'#000'
					}).click(function() {
						if (line.stations) {
							for ( var j = 0; j < line.stations.length; j++) {
								$('#marker'+line.stations[j]).click();
							}
						}
						return false;
					}).appendTo(self.elements.lines);
				})(lines[i]);
			}
		}
		
		if (districts) {
			self.elements.districts = $('<div class="metro-districts">').appendTo(self.elements.map);
			for ( var i = 0; i < districts.length; i++) {
				(function(district) {
					$('<a>').html(district.title).attr({
						'class': 'metro-district',
						'href': '#'
					}).css({
						'background-color': '#fff',
						'color':'#000'
					}).click(function() {
						if (district.stations) {
							for ( var j = 0; j < district.stations.length; j++) {
								$('#marker'+district.stations[j]).click();
							}
						}
						return false;
					}).appendTo(self.elements.districts);
				})(districts[i]);
			}
		}
	};
	var hidden = true;
	setInterval(function() {
		if (hidden) {
			self.elements.stations.hide();
			for(var i in self.selectedStations) {
				$(self.selectedStations[i].images[0]).hide();
				$(self.selectedStations[i].images[1]).show();
			}
			self.elements.stations.show();
			hidden = false;
		} else {
			self.elements.stations.hide();
			for(var i in self.selectedStations) {
				$(self.selectedStations[i].images[0]).show();
				$(self.selectedStations[i].images[1]).hide();
			}
			self.elements.stations.show();
			hidden = true;
		}
	}, 500);
	
	return this;
};