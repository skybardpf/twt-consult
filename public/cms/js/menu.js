window.onload = function()
{
	var lis = document.getElementById('top-menu').getElementsByTagName('li');
	for(i = 0; i < lis.length; i++)
	{
		var li = lis[i];
		if (li.className.indexOf('top-menu-li') != -1)
		{
			if (li.getElementsByTagName('div').length) {
				li.onmouseover = function() { this.getElementsByTagName('div')[0].style.display = 'block'; };
				li.onmouseout = function() { this.getElementsByTagName('div')[0].style.display = 'none'; };
			}
		}
	}
};
/* or with jQuery:
$(document).ready(function(){
	$('#cssdropdown li.headlink').hover(
		function() { $('ul', this).css('display', 'block'); },
		function() { $('ul', this).css('display', 'none'); });
});
*/