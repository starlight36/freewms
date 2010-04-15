/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/* 系统初始化 */
$(document).ready(function() {
	/* URL链接事件 */
	$("a").click(function() {
			var url = $(this).attr("href");
			$.get(url, function(data) {
				$("#mainframe").html(data);
			});
			return false;
		}
	);
});

