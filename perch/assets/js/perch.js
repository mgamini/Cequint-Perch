if (typeof(Perch) == 'undefined') {
	Perch	= {};
	Perch.UI	= {};
	Perch.Apps	= {};
}

Perch.UI.Global	= function()
{
	var doresize = false;
	
	var init	= function() {
		$('body').addClass('js');
		initAppMenu();
		enhanceCSS();
		initPopups();
		hideMessages();
		initEditForm();
		
	};
	
	var enhanceCSS = function() {
		$('#content #main-panel form div.error').prev().css('border-bottom', '0');
		$('#content #main-panel form div.edititem').prev().find('div:last').css('border-bottom', '0');
		$('#content form div.field').append('<div class="clear"></div>');
	};
	
	var initPopups = function() {
		$('a.assist, a.draft-preview').click(function(e){
			e.preventDefault();
			window.open($(this).attr('href'));
		});
	};
	
	var hideMessages = function() {
		if ($('p.alert-success')) {
			setTimeout("$('p.alert-success').selfHealingRemove()", 5000);
		};
	};
	
	var initEditForm = function() {
		$(window).bind('load', stickButtons);
		$(window).bind('resize', function(){
			doresize = true;
			setTimeout(function(){
				if (doresize) {
					stickButtons;
					doresize = false;
				}
			}, 1000);
		});
		
		$('form#content-edit').submit(function(){
            $('input:file[value=""]').attr('disabled', true);
        });
	};
	
	var stickButtons = function() {
		if ($.browser.msie && parseInt($.browser.version,10)<7) return;
		
		var btns = $('#content-edit p.submit');
		if (btns.length && !btns.hasClass('nonstick')) {
			var w = $(window);
		
			var t = btns.position().top;
			var bh = (btns.outerHeight(1));
			var wh = w.height();
			
			var msg = $('p.alert-success');
			
			if (msg) t=t-msg.outerHeight(1);
		
			w.unbind('scroll');
			
			var oldie = false;
			if ($.browser.msie && parseInt($.browser.version,10)<9) {
				oldie = true;
			}
		
			if ($('body').height() > wh) {
				w.scroll(function(){
					var position = w.scrollTop() + wh-bh-10;
					if (t > position) {
						btns.addClass('stuck');
						btns.parents('form').addClass('with-stuck');
						var pos_t = position-t;
						if (-pos_t<50) {
							var transparency = (0.8/100)*((-pos_t/50)*100);
						}else{
							var transparency = 0.8;
						}
						if (oldie) {
							btns.css('background-color', 'rgb(191, 191, 191)');
						}else{
							btns.css('background-color', 'rgba(191, 191, 191, '+transparency+')');
						}
					}else{
						btns.removeClass('stuck');
						btns.parents('form').removeClass('with-stuck');
						if (oldie) {
							btns.css('background-color', 'rgb(255, 255, 255)');	
						}else{
							btns.css('background-color', 'rgba(255, 255, 255, 1)');	
						}					
					}
				});
				w.scroll();
			}
		}
	};
	
	
	var initAppMenu = function() {
		var appmenu = $('#nav ul.appmenu');
		var items = appmenu.find('li');
		
		if (items.length>1) {
			appmenu.addClass('menu');
			var cont = $('#nav li.apps');
			cont.addClass('menucont');
			var selectedText = appmenu.find('li.selected a').text();
			if (selectedText) {
				var select = true;
			}else{ 
				selectedText = Perch.Lang.get('Apps');
				var select = false;
			}
			var trigger = $('<a class="trigger" href="#">'+selectedText+'<span></span></a>');
			appmenu.before(trigger).hide();
			if (select) trigger.parent('li').addClass('selected');
			appmenu.prepend($('<li><a class="trigger" href="#">'+selectedText+'<span></span></a></li>'));
			cont.hover(function(){
				appmenu.show();
			}, function(){
				appmenu.hide();
			});
			trigger.click(function(e){
				e.preventDefault();
				appmenu.show();
			});
			appmenu.find('a.trigger').click(function(e){
				e.preventDefault();
				appmenu.hide();
			});
		}
		$('#nav').show();
	};

	
	return {
		init: init
	};
	
}();


Perch.Lang	= function()
{
	var translations = {};
	
	var init = function(t) {
		translations = t;
	};
	
	var get = function(str) {
		if (translations[str]) {
			return translations[str];
		}
		
		return str;
	};
	
	return {
		init: init,
		get: get
	};
}();


jQuery.fn.selfHealingRemove = function(settings, fn) {
	if (jQuery.isFunction(settings)){
		fn = settings;
		settings = {};
	}else{
		settings = jQuery.extend({
			speed: 'slow'
		}, settings);
	};
	
	return this.each(function(){
		var self = jQuery(this); 
		self.animate({
			opacity: 0
		}, settings.speed, function(){
			self.slideUp(settings.speed, function(){
				self.remove();
				if (jQuery.isFunction(fn)) fn();
			});
		});
	});
};


jQuery(function($) { Perch.UI.Global.init(); });