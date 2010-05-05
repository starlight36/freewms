/* 系统初始化 */

//点击链接用AJAX加载页面
$(document).ready(function() {
	/* URL链接事件 */
	$(".OpenMain").click(function() {
			var url = $(this).attr("href");
			$.get(url, function(data) {
				$("#mainframe").html(data);
			});
			return false;
	});
	//提交dialog里面的表单
	$(".dialog_form").submit(function() {
		
	});
});

//打开对话框
function ajax_dialog(obj, width, height, lock) {
	artDialog({
		content: '<div id="dialog_msg"></div><div id="dialog_content">Loading...</div>',
		title: obj.title,
		lock: lock,
		width: width,
		height: height,
		id: 'dialog_form'
	});
	//AJAX加载内容
	$.get(obj.href, function(data) {
		$("#dialog_content").html(data);
	});
	return false;
}


