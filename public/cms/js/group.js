$(document).ready(function() {
	var uris = window.location.href.split("/");
	var uri = "/"+uris[3]+"/"+uris[4]+"/"+uris[5]+"/";
	$(".meta, .group").click(function(node) {
		$(node.currentTarget.nextSibling).toggle("slow", function() {
			$.cookie("group_id_"+this.id, this.style.display, {path: uri, expires: 30});
			var meta_name = $.cookie('groups_name');
			if (meta_name) {
				if(meta_name.indexOf(this.id) == -1) meta_name += this.id+",";
			}
			else {
				meta_name = this.id+",";
			}
			$.cookie("groups_name", meta_name, {path: uri, expires: 30});
		});
	});
	var meta_name = $.cookie('groups_name');
	if (meta_name) {
		var meta_arr = meta_name.split(",");
		for ( var i = 0; i < meta_arr.length - 1; i++) {
			var name = meta_arr[i];
			$("#"+name).css('display', $.cookie('group_id_'+name));
		}
	}
});