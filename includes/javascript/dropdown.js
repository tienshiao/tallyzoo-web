/************************************************************************
Do not remove this notice.
Revenge of the Menu Bar Demo
Copyright 2000-2004 by Mike Hall
Please see http://www.brainjar.com for terms of use. 
************************************************************************/
//	var dom = (document.getElementById)? true:false;

//<![CDATA[
function Browser() {
  var ua, s, i;
  this.isIE    = false;  // Internet Explorer
  this.isOP    = false;  // Opera
  this.isNS    = false;  // Netscape
  this.version = null;

  ua = navigator.userAgent;

  s = "Opera";
  if ((i = ua.indexOf(s)) >= 0) {
    this.isOP = true;
    this.version = parseFloat(ua.substr(i + s.length));
    return;
  }

  s = "Netscape6/";
  if ((i = ua.indexOf(s)) >= 0) {
    this.isNS = true;
    this.version = parseFloat(ua.substr(i + s.length));
    return;
  }

  // Treat any other "Gecko" browser as Netscape 6.1.

  s = "Gecko";
  if ((i = ua.indexOf(s)) >= 0) {
    this.isNS = true;
    this.version = 6.1;
    return;
  }

  s = "MSIE";
  if ((i = ua.indexOf(s))) {
    this.isIE = true;
    this.version = parseFloat(ua.substr(i + s.length));
    return;
  }
}

var browser = new Browser();
var activeButton = null;

function bClck(event, menuId) {
  var button;
	button = (browser.isIE) ? window.event.srcElement:event.currentTarget;
	// Associate the named menu to this button if not already done. Additionally, initialize menu display.

  if (button.menu == null) {
    button.menu = document.getElementById(menuId);
    if (button.menu.isInitialized == null) {menuInit(button.menu);
		}
  }

  if (button.onmouseout == null) { button.onmouseout = buttonOrMenuMouseout;}
  if (button == activeButton) {return false;}

  // Reset the currently active button, if any.
  if (activeButton != null) {resetButton(activeButton);}

  // Activate this button, unless it was the currently active one.

  if (button != activeButton) {depressButton(button);activeButton = button;} else {activeButton = null;}
  return false;
}

function bMovr(event, menuId) {
  var button;
  if (activeButton == null) {bClck(event, menuId);return;}
	button = (browser.isIE) ? window.event.srcElement:event.currentTarget;
  if (activeButton != null && activeButton != button) {bClck(event, menuId);}
}

function findPos(obj) {
	var curleft = curtop = 0;
	if (obj.offsetParent) {
		do {
					curleft += obj.offsetLeft;
					curtop += obj.offsetTop;
		} while (obj = obj.offsetParent);
		
	return [curleft];
}
}
function findPos_y(obj) {
	var curleft = curtop = 0;
	if (obj.offsetParent) {
		do {
					curleft += obj.offsetLeft;
					curtop += obj.offsetTop;
		} while (obj = obj.offsetParent);
		
	return [curtop];
}
}


function depressButton(button) {
  var x, y;
  button.className += " mActive";
  if (button.onmouseout == null){button.onmouseout = buttonOrMenuMouseout;}
  if (button.menu.onmouseout == null){button.menu.onmouseout = buttonOrMenuMouseout;}


//  x = button.offsetLeft;
	x = findPos(button);
	button3 = document.getElementById('header');
	x33 = findPos(button3); 
  
  x = x - x33 -261;
  
//  alert(" X " + x + " X33 " + x33 );
	//y = (button.offsetTop - 1) + button.offsetHeight;
	y = findPos_y(button);

	y = y - 35;

  // For IE, adjust position.

/*  if (browser.isIE) {
    x += button.offsetParent.clientLeft;
    y += button.offsetParent.clientTop;
  }  */

	if (x > 700) {x = button.offsetLeft - (button.offsetWidth + 17);}

  button.menu.style.left = x + "px";
  button.menu.style.top  = y + "px";
  button.menu.style.visibility = "visible";

  // For IE; size, position and show the menu's IFRAME as well.

  if (button.menu.iframeEl != null) {
    button.menu.iframeEl.style.left = button.menu.style.left;
    button.menu.iframeEl.style.top  = button.menu.style.top;
    button.menu.iframeEl.style.width  = button.menu.offsetWidth + "px";
    button.menu.iframeEl.style.height = button.menu.offsetHeight + "px";
    button.menu.iframeEl.style.display = "";
  }

	var e=document.createElement("DIV");
	e.className="menuShadow";
	var sLeft = button.menu.style.left;
	e.style.left = (x + 2) + "px" ;
	e.style.top  = (y + 2) + "px" ;
	e.style.width  = button.menu.offsetWidth + "px";
	e.style.height = button.menu.offsetHeight + "px";
	button.menu.e = button.menu.parentNode.insertBefore(e, button.menu);
}

function resetButton(button) {
  removeClassName(button, "mActive");
  if (button.menu != null) {button.menu.previousSibling.style.display = "none";closeSubMenu(button.menu); button.menu.style.visibility = "hidden";}
	if (button.menu.iframeEl != null){button.menu.iframeEl.style.display = "none";}
}

function mOvr(event) {
  var menu;
	menu = (browser.isIE) ? getContainerWith(window.event.srcElement, "DIV", "hnMnu"):event.currentTarget;
  if (menu.activeItem != null){closeSubMenu(menu);}
}

function iOvr(event, menuId) {
  var item, menu, x, y;

	item = (browser.isIE) ? getContainerWith(window.event.srcElement, "A", "mItem"):event.currentTarget;
  menu = getContainerWith(item, "DIV", "hnMnu");

  if (menu.activeItem != null){closeSubMenu(menu);}
  menu.activeItem = item;
  item.className += " miActive";

  if (item.subMenu == null) {
    item.subMenu = document.getElementById(menuId);
    if (item.subMenu.isInitialized == null){menuInit(item.subMenu);}
  }

  if (item.subMenu.onmouseout == null){item.subMenu.onmouseout = buttonOrMenuMouseout;}

	x = (item.parentNode.offsetLeft + item.parentNode.offsetWidth) - 2;
  y = getPageOffsetTop(item) - 65;

  // Adjust position to fit in view.

  var maxX, maxY;

  if (browser.isIE) {
    maxY = Math.max(document.documentElement.scrollTop, document.body.scrollTop) +
							  (document.documentElement.clientHeight != 0 ? document.documentElement.clientHeight : document.body.clientHeight);
  }
  if (browser.isOP) {
    maxY = document.documentElement.scrollTop  + window.innerHeight;
  }
  if (browser.isNS) {
    maxY = window.scrollY + window.innerHeight;
  }
	
  maxX = (x + item.offsetWidth);
  maxY -= item.subMenu.offsetHeight;

  if (maxX > 730) {
   x = Math.max(0, x - item.offsetWidth - item.subMenu.offsetWidth
      + (menu.offsetWidth - item.offsetWidth));
  }
	y = Math.max(0, Math.min(y, maxY));

  // Position and show the sub menu.

  item.subMenu.style.left = x + "px";
  item.subMenu.style.top = y + "px";
  item.subMenu.style.visibility = "visible";

  // For IE; size, position and display the menu's IFRAME as well.
  if (item.subMenu.iframeEl != null) {
    item.subMenu.iframeEl.style.left = item.subMenu.style.left;
    item.subMenu.iframeEl.style.top = item.subMenu.style.top;
    item.subMenu.iframeEl.style.width = item.subMenu.offsetWidth + "px";
    item.subMenu.iframeEl.style.height = item.subMenu.offsetHeight + "px";
    item.subMenu.iframeEl.style.display = "";
  }

	var e=document.createElement("DIV");
	e.className="menuShadow";
	var sLeft = item.subMenu.style.left;
	e.style.left = (x + 2) + "px" ;
	e.style.top  = (y + 2) + "px" ;
	e.style.width  = item.subMenu.offsetWidth + "px";
	e.style.height = item.subMenu.offsetHeight + "px";
	item.subMenu.e = item.subMenu.parentNode.insertBefore(e, item.subMenu);

  // Stop the event from bubbling.
  if (browser.isIE){window.event.cancelBubble = true;} else {event.stopPropagation();}
}

function closeSubMenu(menu) {
  if (menu == null || menu.activeItem == null){return;}

  if (menu.activeItem.subMenu != null) {
    closeSubMenu(menu.activeItem.subMenu);
    menu.activeItem.subMenu.style.visibility = "hidden";
    if (menu.activeItem.subMenu.iframeEl != null) {menu.activeItem.subMenu.iframeEl.style.display = "none";}
		menu.activeItem.subMenu.previousSibling.style.display = "none";
    menu.activeItem.subMenu = null;
  }
  removeClassName(menu.activeItem, "miActive");
  menu.activeItem = null;
}


function buttonOrMenuMouseout(event) {
  var el;
  if (activeButton == null) return;
  if (browser.isIE){el = window.event.toElement;}  else if (event.relatedTarget != null) {el = (event.relatedTarget.tagName ? event.relatedTarget : event.relatedTarget.parentNode);}
  if (getContainerWith(el, "DIV", "hnMnu") == null) { resetButton(activeButton); activeButton = null;}
}


function menuInit(menu) {
  if (browser.isIE) {
    var iframeEl = document.createElement("IFRAME");
    iframeEl.frameBorder = 1;
    iframeEl.src = "javascript:;";
    iframeEl.style.display = "none";
    iframeEl.style.position = "absolute";
    menu.iframeEl = menu.parentNode.insertBefore(iframeEl, menu);
  }
	menu.isInitialized = true;
}

function initPg() {
	var mLyr = document.getElementById("topMenu");
	var sMnu = mLyr.getElementsByTagName("div");	
	for(k = 0; k < sMnu.length; k++) {
		if (sMnu[k].id != "mnuBar" && sMnu[k].className != "mSep") {sMnu[k].className = "hnMnu";}		
	}
	for(k = 0; k < sMnu.length; k++) {
		if(sMnu[k].className == "hnMnu" ) {
			var sLnk = sMnu[k].getElementsByTagName("a");
			for(m = 0; m < sLnk.length; m++) {
				sLnk[m].className = (sLnk[m].onclick) ? "mItem hSub":"mItem";
			}
		}		
	}
	document.getElementById("topMenu").style.display = "block";
}

//----------------------------------------------------------------------------
// General utility functions.
//----------------------------------------------------------------------------

function getContainerWith(node, tagName, className) {
// Starting with the given node, find the nearest containing element with the specified tag name and style class.
  while (node != null) {
    if (node.tagName != null && node.tagName == tagName && hasClassName(node, className)) {return node;}
    node = node.parentNode;
  }
  return node;
}

function hasClassName(el, name) {
  var i, list;
// Return true if the given element currently has the given class name.

  list = el.className.split(" ");
  for (i = 0; i < list.length; i++) {
    if (list[i] == name) {return true;}
	}
  return false;
}

function removeClassName(el, name) {
  var i, curList, newList;
  if (el.className == null){return;}
// Remove the given class name from the element's className property.
  newList = new Array();
  curList = el.className.split(" ");
  for (i = 0; i < curList.length; i++)
    if (curList[i] != name)
      newList.push(curList[i]);
  el.className = newList.join(" ");
}

function getPageOffsetLeft(el) {
  var x = el.offsetLeft;
  if (el.offsetParent != null){x += getPageOffsetLeft(el.offsetParent);}
  return x;
}

function getPageOffsetTop(el) {
  var y = el.offsetTop;
  if (el.offsetParent != null){y += getPageOffsetTop(el.offsetParent);}
  return y;
}

//]]>
