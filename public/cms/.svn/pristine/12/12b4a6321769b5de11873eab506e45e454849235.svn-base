var simpleTreeCollection;
var timerIDs = new Array();
$(document).ready(function(){
	
	simpleTreeCollection = $('.simpleTree').simpleTree({
		autoclose: false,
		drag: false,
		animate:true,
		dblClickTime: 200,
		/*afterClick:function(node){
			window.location.href = node[0].getElementsByTagName('a')[0].href;
		},
		afterDblClick:function(node){
			window.location.href = node[0].getElementsByTagName('a')[0].title;
		},*/
		afterMove:function(destination, source, pos){
			/*var id = source[0].id.substring(5);
			var pid =  destination[0].id.substring(5);
			$.ajax({
				url: "/admin/content/move_tree/",
				type: "POST",
				data: "id="+id+"&pos="+pos+"&pid="+pid,
				success: function(data, textStatus) {
					var ret = eval("("+data+")");
					if (!ret.status) {
						alert(ret.msg);
					}
				}
			});
			alert("id="+id+"&pos="+pos+"&pid="+pid);
			window.location.href = "/admin/content/move_tree/?id="+id+"&pos="+pos+"&pid="+pid;*/
			
		},
		afterAjax:function()
		{
			//alert('Loaded');
		},
		afterContextMenu:function(node)
		{
//			alert(node[0].innreHTML);
		},
		afterOver:function(node) {
			$("a.tree-hover", node).css('visibility', 'visible');
		},
		afterOut:function(node) {
			$("a.tree-hover", node).css('visibility', 'hidden');
		}
		//,docToFolderConvert:true
	});
});