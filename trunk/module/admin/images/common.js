//==============================
//选项卡部分
//==============================
function SelectTab(ShowContent,selfObj) {
	// 操作标签
	var Tab = document.getElementById("tabs").getElementsByTagName("li");
	var Tablength = Tab.length;
	for (i=0; i<Tablength; i++) {
		Tab[i].className = "";
	}
	document.getElementById(selfObj).className = "selecttab";
	// 操作内容
	for(i=1; j=document.getElementById("tabcontent"+i); i++){
		j.style.display = "none";
	}
	document.getElementById(ShowContent).style.display = "block";
}
//==============================
//显示右上角Loading信息
//==============================
function ShowLoadMsg() {
	var MsgDiv = parent.document.getElementById('topmsg');
	if (MsgDiv != undefined) {
		MsgDiv.style.display = '';
	}
}
//==============================
//隐藏右上角Loading信息
//==============================
function HiddenLoadMsg() {
	var MsgDiv = parent.document.getElementById('topmsg');
	if (MsgDiv != undefined) {
		MsgDiv.style.display = 'none';
	}
}
//==============================
//checkbox选择相关
//==============================
//全选
function SelectAll(boxname) {
	var el	= document.getElementsByTagName("input");
	var len	= el.length;
	for (var i=0; i<len; i++) {
		if (boxname == "NoName") {
			if (el[i].type == "checkbox") {
				el[i].checked = true;
			}
		}
		else {
			if ((el[i].type == "checkbox") && (el[i].name == boxname)) {
				el[i].checked = true;
			}
		}
	}
}
//取消全选
function ClearAll(boxname) {
	var el	= document.getElementsByTagName("input");
	var len	= el.length;
	for (var i=0; i<len; i++) {
		if (boxname == "NoName") {
			if (el[i].type == "checkbox") {
				el[i].checked = false;
			}
		}
		else {
			if ((el[i].type == "checkbox") && (el[i].name == boxname)) {
				el[i].checked = false;
			}
		}
	}
}
//反选操作
function ReverseAll(form) {
	for (var i=0; i<form.elements.length; i++){
		var e = form.elements[i];
		e.checked = !e.checked;
	}
}
//选中后变色
function ChangeColor(field) {
	if(field == "All") {
		var el = document.getElementsByTagName('input');
		var len = el.length;
		for(var i=0; i<len; i++) {
			if(el[i].type == "checkbox") {
				el[i].checked ? el[i].parentNode.parentNode.style.backgroundColor="#FFFDD7" : el[i].parentNode.parentNode.style.backgroundColor="";
			}
		}
	}
	else {
		var TheObj = field.checked;
		TheObj ? field.parentNode.parentNode.style.backgroundColor="#FFFDD7" : field.parentNode.parentNode.style.backgroundColor="";
	}
}
window.onunload = function() {
	this.barref = null;
}