var LeftMenu;
window.onload = function() {
	LeftMenu = new SDMenu("leftmenu");
	LeftMenu.init();
};
function SDMenu(id) {
	if (!document.getElementById || !document.getElementsByTagName)
		return false;
	this.menu		= document.getElementById(id);
	this.submenus	= this.menu.getElementsByTagName("div");
	this.speed		= 4;
	this.markCurrent= true;
}
SDMenu.prototype.init = function() {
	var mainInstance = this;
	for (var i = 0; i < this.submenus.length; i++) {
		this.submenus[i].getElementsByTagName("span")[0].onclick = function() {
			mainInstance.toggleMenu(this.parentNode);
		};
	}
	if (this.markCurrent) {
		var links = this.menu.getElementsByTagName("a");
		for (var i = 0; i < links.length; i++) {
			if (links[i].href == document.location.href) {
				links[i].className = "current";
				break;
			}
			links[i].onclick = function() {
				for (var k = 0; k < links.length; k++) {
					links[k].className = "";
				}
				this.className = "current";
				this.blur();
			}
		}
	} else {
		var links = this.menu.getElementsByTagName("a");
		for (var i = 0; i < links.length; i++) {
			links[i].onclick = function() {
				for (var k = 0; k < links.length; k++) {
					links[k].className = "";
				}
				this.className = "current";
				this.blur();
			}
		}
	}
};
SDMenu.prototype.toggleMenu = function(submenu) {
	if (submenu.className == "collapsed")
		this.expandMenu(submenu);
	else
		this.collapseMenu(submenu);
};
SDMenu.prototype.expandMenu = function(submenu) {
	var fullHeight = submenu.getElementsByTagName("span")[0].offsetHeight;
	var links = submenu.getElementsByTagName("a");
	for (var i = 0; i < links.length; i++)
		fullHeight += links[i].offsetHeight;
	var moveBy = Math.round(this.speed * links.length);

	var mainInstance = this;
	var intId = setInterval(function() {
		var curHeight = submenu.offsetHeight;
		var newHeight = curHeight + moveBy;
		if (newHeight < fullHeight)
			submenu.style.height = newHeight + "px";
		else {
			clearInterval(intId);
			submenu.style.height = "";
			submenu.className = "";
		}
	}, 30);
	for (var i = 0; i < this.submenus.length; i++) {
		if (this.submenus[i] != submenu && this.submenus[i].className != "collapsed") {
			this.collapseMenu(this.submenus[i]);
		}
	}
};
SDMenu.prototype.collapseMenu = function(submenu) {
	var minHeight = submenu.getElementsByTagName("span")[0].offsetHeight;
	var moveBy = Math.round(this.speed * submenu.getElementsByTagName("a").length);
	var mainInstance = this;
	var intId = setInterval(function() {
		var curHeight = submenu.offsetHeight;
		var newHeight = curHeight - moveBy;
		if (newHeight > minHeight)
			submenu.style.height = newHeight + "px";
		else {
			clearInterval(intId);
			submenu.style.height = "";
			submenu.className = "collapsed";
		}
	}, 30);
};