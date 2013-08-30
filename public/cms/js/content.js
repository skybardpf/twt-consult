function changePid(obj)
{
	pid = obj.options[obj.selectedIndex].value;
	form   = document.forms['modify'];

	if (window.location.href.indexOf('pid') == -1) {
		action = window.location.href + 'pid/' + pid + '/';	
	} else {
		action = window.location.href.replace(/pid\/.*\//, 'pid/' + pid + '/');
	}
	var input_ns = document.createElement('input');
	input_ns.name = 'dont_save';
	input_ns.type = 'hidden';
	input_ns.value = 1;
	form.appendChild(input_ns);
	form.action = action;
	form.submit();
}