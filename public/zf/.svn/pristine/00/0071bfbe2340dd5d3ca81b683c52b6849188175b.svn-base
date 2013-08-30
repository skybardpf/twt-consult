var AudioPlayer = function () {
	var instances = [];
	var activePlayerID;
	var playerURL = "";
	var defaultOptions = {};
	var currentVolume = -1;
    var mute = -1;
	var requiredFlashVersion = "9";
	
	function getPlayer(playerID) {
		if (document.all && !window[playerID]) {
			for (var i = 0; i < document.forms.length; i++) {
				if (document.forms[i][playerID]) {
					return document.forms[i][playerID];
					break;
				}
			}
		}
		return document.all ? window[playerID] : document[playerID];
	}
	
	function addListener (playerID, type, func) {
		getPlayer(playerID).addListener(type, func);
	}
	
	return {
		setup: function (url, options) {
			playerURL = url;
			defaultOptions = options;
			if (swfobject.hasFlashPlayerVersion(requiredFlashVersion)) {
				swfobject.switchOffAutoHideShow();
				swfobject.createCSS("p.audioplayer_container span", "visibility:hidden;height:24px;overflow:hidden;padding:0;border:none;");
			}
		},

		getPlayer: function (playerID) {
			return getPlayer(playerID);
		},
		
		addListener: function (playerID, type, func) {
			addListener(playerID, type, func);
		},
		
		embed: function (elementID, options) {
			var instanceOptions = {};
			var key;
			
			var flashParams = {};
			var flashVars = {};
			var flashAttributes = {};
	
			// Merge default options and instance options
			for (key in defaultOptions) {
				instanceOptions[key] = defaultOptions[key];
			}
			for (key in options) {
				instanceOptions[key] = options[key];
			}
			
			if (instanceOptions.transparentpagebg == "yes") {
				flashParams.bgcolor = "#FFFFFF";
				flashParams.wmode = "transparent";
			} else {
				if (instanceOptions.pagebg) {
					flashParams.bgcolor = "#" + instanceOptions.pagebg;
				}
				flashParams.wmode = "opaque";
			}
			
			flashParams.menu = "false";
			
			for (key in instanceOptions) {
				if (key == "pagebg" || key == "width" || key == "transparentpagebg") {
					continue;
				}
				flashVars[key] = instanceOptions[key];
			}
			
			flashAttributes.name = elementID;
			flashAttributes.style = "outline: none";
			
			flashVars.playerID = elementID;
			
			swfobject.embedSWF(playerURL, elementID, instanceOptions.width.toString(), "24", requiredFlashVersion, false, flashVars, flashParams, flashAttributes);
			
			instances.push(elementID);
		},
		
		syncVolumes: function (playerID, volume) {	
			currentVolume = volume;
			for (var i = 0; i < instances.length; i++) {
				if (instances[i] != playerID) {
					getPlayer(instances[i]).setVolume(currentVolume);
				}
			}
		},
		mute: function(playerID) {
            if (currentVolume != 0) {
                mute = (currentVolume == -1) ? ( defaultOptions.initialvolume ? defaultOptions.initialvolume : 60 ) : currentVolume;
                getPlayer(playerID).setVolume(0);
                currentVolume = 0;
            } else {
                getPlayer(playerID).setVolume(mute);
                currentVolume = mute;
            }
        },
        muteAll: function(playerID) {
            if (currentVolume != 0) {
                mute = (currentVolume == -1) ? ( defaultOptions.initialvolume ? defaultOptions.initialvolume : 60 ) : currentVolume;
                for (var i = 0; i < instances.length; i++) {
                    getPlayer(instances[i]).setVolume(0);
                }
                currentVolume = 0;
            } else {
                for (var i = 0; i < instances.length; i++) {
                    getPlayer(instances[i]).setVolume(mute);
                }
                currentVolume = mute;
            }
        },
		activate: function (playerID, info) {
			if (activePlayerID && activePlayerID != playerID) {
				getPlayer(activePlayerID).close();
			}

			activePlayerID = playerID;
		},
		
		load: function (playerID, soundFile, titles, artists) {
			getPlayer(playerID).load(soundFile, titles, artists);
		},
		
		close: function (playerID) {
			getPlayer(playerID).close();
			if (playerID == activePlayerID) {
				activePlayerID = null;
			}
		},
		
		open: function (playerID, index) {
			if (index == undefined) {
				index = 1;
			}
			getPlayer(playerID).open(index == undefined ? 0 : index-1);
		},
		
		getVolume: function (playerID) {
			return currentVolume;
		},
		getEmbed: function (playerID) {
			function getAddr(file, location) {
				if (file.indexOf('http') == -1 && file.indexOf('/') != 0) {
					var file_arr = file.split('/');
					addr = location.pathname.split('/');
					addr.pop();
					addr.shift();
					if (file_arr.length > 0) {
						if (file_arr[0] == '.') {
							file_arr.shift();
						}
						while (file_arr[0] == '..') {
							file_arr.shift();
							addr.shift();
						}
						var arr_dif = Array();
						for (var key in addr ) {
							var found = false;
							for (var key_c in file_arr) {
								if (file_arr[key_c] == addr[key]) {
									found = true;
									break;
								}
							}
							if (!found) {
								arr_dif[key] = addr[key];
							}
						}
						file = location.protocol + '//' + location.host + '/' + arr_dif.join('/') + (arr_dif.length > 0 ? '/' : '') + file_arr.join('/');
					}
			    } else if (file.indexOf('/') == 0){
			    	file = location.protocol + '//' + location.host + file;
			    }
				return file;
			}
			
		    playerID = (playerID == undefined ? ( activePlayerID == null ? instances[0] : activePlayerID ) : playerID);
		    var code = document.getElementById(playerID).parentNode.innerHTML.match(new RegExp('<object[^>]*?id..'+playerID+'[\'"][\\s\\S]*?</object>', 'im')).toString();
		    var mp3files = code.match(/&amp;soundFile=(.*?)&amp;/)[1].split(',');
		    for ( var i = 0; i < mp3files.length; i++) {
		    	mp3files[i] = getAddr(mp3files[i], window.location);
			}
		    return code.replace(/&amp;soundFile=(.*?)&amp;/,'&amp;soundFile='+mp3files.join(',')+'&amp;').replace(/data="(.*?)"/,'data="'+getAddr(code.match(/ data=.(.*?). /)[1], window.location)+'"');
		}
	}
}();

AudioPlayer.setup("/public/zf/audioplayer/player.swf", {  
    width: 290,
    initialvolume: 100
});  