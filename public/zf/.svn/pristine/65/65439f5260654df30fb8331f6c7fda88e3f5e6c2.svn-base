Calendar = function(year, month, date, days) {
	this.days = days;
	this.year = year;
	this.month = month;
	this.date = date;
	this.dayNames = {
		'1':'пн',
		'2':'вт',
		'3':'ср',
		'4':'чт',
		'5':'пт',
		'6':'сб',
		'7':'вс'
	};
	this.out = '';
	
	
	this.dayCountCalc = function(cyear, cmonth) {
		return new Date(cyear, cmonth, 0).getDate();
	};
	
	this.getFirstDay = function(cyear, cmonth) {
		return new Date(cyear, cmonth-1, 1).getDay();
	}
	
	this.dayCount = this.dayCountCalc(this.year, this.month);
	this.refresh = function() {
		
	};
	this.weeks = {};
	this.weeks[1] = {};
	this.weeks[2] = {};
	this.weeks[3] = {};
	this.weeks[4] = {};
	this.weeks[5] = {};
	this.weeks[6] = {};
	var procDate = 1;
	for (var i=1; i<=7; i++) {
		if (i<this.getFirstDay(this.year, this.month)) {
			this.weeks[1][i] = null;
		} else {
			this.weeks[1][i] = {
					'num' : procDate
				};
			if (this.days[procDate]>0) {
				var linkMonth = this.month<10?'0'+this.month:this.month;
				var linkDate = procDate<10?'0'+procDate:procDate;
				if (curRubric) {
                    var cur_link = '/news/rubric/id/'+curRubric+'/date/'+this.year+'-'+linkMonth+'-'+linkDate;
                } else {
                    var cur_link = '/news/date/'+this.year+'-'+linkMonth+'-'+linkDate;
                }

				this.weeks[1][i] = {
						'content' : '<a href="'+cur_link+'">'+procDate+'</a>'
					};
			} else {
				this.weeks[1][i] = {
						'content' : this.weeks[1][i].num
					};
			}
			procDate++;
		}
	}
	for (var w=2; w<7; w++) {
		for (var d=1; d<=7; d++) {
			if (procDate <= this.dayCount) {
				this.weeks[w][d] = {
						'num' : procDate
					};
				if (this.days[procDate]>0) {
					var linkMonth = this.month<10?'0'+this.month:this.month;
					var linkDate = procDate<10?'0'+procDate:procDate;
					if (curRubric) {
                        var cur_link = '/news/rubric/id/'+curRubric+'/date/'+this.year+'-'+linkMonth+'-'+linkDate;
                    } else {
                        var cur_link = '/news/date/'+this.year+'-'+linkMonth+'-'+linkDate;
                    }
					this.weeks[w][d] = {
							'content' : '<a href="'+cur_link+'">'+procDate+'</a>'
						};
				} else {
					this.weeks[w][d] = {
							'content' : this.weeks[w][d].num
						};
				}
				procDate++;
			}
		}
		
	}
	this.render = function() {
		this.out += '<tr>';
		for (var i in this.dayNames)
		{
			this.out += '<th>'+this.dayNames[i]+'</th>';
		}
		this.out += '</tr>';
		for (var i in this.weeks) {
			this.out += '<tr>'
				for (var j in this.weeks[i]) {
					if (this.weeks[i][j]==null) this.out += '<td>&nbsp;</td>';
					else {
						var weekend = (j==6||j==7)?' class="weekend"':'';
						this.out += '<td'+weekend+'>'+this.weeks[i][j].content+'</td>';
					}
				}
			this.out += '</tr>';
		}
		return this.out;
	};
};

