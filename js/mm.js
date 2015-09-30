
$ = jQuery.noConflict();

window.fbAsyncInit = function() {
    FB.init({
	  appId  : '253291901540535',
      status : true, // check login status
      cookie : true, // enable cookies to allow the server to access the session
      xfbml  : true  // parse XFBML
    });
	$('#fbHolder').css('background', 'none').find('p').remove();	
};

//$(function() {
	var url, player;
	var bodyWidth, 
		prevBodyWidth, 
		FBBox = false,
	    $sidebar1 = $('.mmb-sidebar1'),
		$sidebar2 = $('.mmb-sidebar2');
	
	MM_Functions = {
		
		resizePage : function() {
			$('#fbHolder iframe, .fb_iframe_widget span').css('width', $('#facebooklikebox-2').width() + 'px');
			bodyWidth = $('body').width();
			if (bodyWidth >= 768 && prevBodyWidth < 768) {
				MM_Functions.sidebarToLeft();
				MM_Functions.fauxCols();
			} else if (bodyWidth < 768 && prevBodyWidth >= 768) {
				MM_Functions.sidebarToBottom();
				$sidebar1.css('min-height',0);
				$sidebar2.css('min-height',0);
			}
			if (bodyWidth >= 992) {
				MM_Functions.loadFB();
			}
			$(".fb-comments").attr("data-width", $("#FatPandaFacebookComments").width());
			FB.XFBML.parse($(".comments")[0]);
			prevBodyWidth = bodyWidth;
		},
		sidebarToBottom : function(){
			$('.mmb-content').after($sidebar1);
			$sidebar1.css('display','block');
		},
		sidebarToLeft : function(){
			$('.mmb-content').before($sidebar1);
			$sidebar1.css('display','block');
		},
		//Sidebars faux cols
		fauxCols : function() {
			if (typeof(bodyWidth) == 'undefined') bodyWidth = $('body').width();
			if (bodyWidth >= 768) {
				var	contentHeight = $sidebar1.parent().height();
				$sidebar1.css('min-height',contentHeight);
				$sidebar2.css('min-height',contentHeight);
			} 
		},
		loadFB : function(){

			if (!FBBox) {
				if (!document.getElementById('fb-root')) {
					$('#fbHolder').append('<div id="fb-root"></div>');
					//jQuery.getScript('http://connect.facebook.net/ca_ES/all.js#xfbml=1');
					(function() {
						var e = document.createElement('script');
						e.src = document.location.protocol + '//connect.facebook.net/ca_ES/all.js#xfbml=1&appId=253291901540535';
						e.async = true;
						document.getElementById('fb-root').appendChild(e);
						
											
					}());
				}
				$('#fbHolder').append('<fb:like-box href="https://www.facebook.com/pages/M%C3%B3n-de-M%C3%BAsica/381756028576254" width="' + $('#facebooklikebox-2').width() +'" colorscheme="light" show_faces="true" stream="true" header="true"></fb:like-box>');
				FBBox = true;				
			}
		},
		
		showCategoryText : function(e) {
			imgHeight = $(this).height();
			$text = $(this).find('.category-description');
			$text.css('max-height',imgHeight).stop().animate({bottom: 0},300, 'swing');
		},
		hideCategoryText : function(e) {
			imgHeight = $(this).height();
			//$(this).find('.category-description').stop().animate({top: (imgHeight + 60) + 'px'},1000, 'swing');
			$(this).find('.category-description').stop().animate({bottom: -250},1000, 'swing');
		},
		fixWidget : function(scrollTop) {
			this.scrollTop = scrollTop;
			this.fixed = false;
			this.widgets = $('#em_widget-2');
			this.update = function(scrolling) {
				bodyWidth = $('body').width();
				var nowFixed = scrolling >= this.scrollTop && bodyWidth > 992;
				if (this.fixed !== nowFixed) {
					this.fixed = nowFixed;
					$(this.widgets).each(function(index){
						if (nowFixed) {
							$(this).css({position: 'fixed', top: '50px', width: $(this).css('width')});
						} else {
							$(this).css({position: 'static', top: '', width: ''});
						}
					});
				}
			}
			return this;
		},
		
		myColorText : function() {
			var index;
			return {
				container: document,
				colors : ['#00A0E6','#7DC200','#FF9300'],
				init: function(myContainer, myColors) {
					if (typeof myContainer !== 'undefined') tis.container = myContainer;
					if (typeof myColors !== 'undefined') tis.container = myContainer;
					index = 0;
					return this;
				},
				apply: function() {
					var elements = (this.container).getElementsByClassName('colors-title');
					for (var j = elements.length-1;j>=0;j--) {
						var el = elements[j],
							text = el.childNodes[0].data,
							span;
						index = 0;
						for (var i in text) {
							span = document.createElement('span');
							span.setAttribute('style','color:' + this.colors[index++ % this.colors.length]);
							span.appendChild(document.createTextNode(text[i]));
							el.appendChild(span);
						}
						el.removeChild(el.childNodes[0]);
					}
					
					// This function must be executed only once per page
					MM_Functions.myColorText = function() {
						return {
							init: function() {
								return this;
							},
							apply: function() {
								return this;
							}
						};
					};
					return this;
				}
			
			};
		}
		
	}; //End MM_Functions
	
	$(document).ready(function() {
		var fixPos = MM_Functions.fixWidget(210);
		$(document).on('scroll', function() {fixPos.update($(document).scrollTop())});
		MM_Functions.myColorText().init().apply();
		MM_Functions.fauxCols();	
		
		var $subMenuLink = $('li.submenu > a'),
		    $nav =  $('nav'),
			$subMenu = $('.hidden-submenu');
			
			/*alert( " $subMenuLink: " + $subMenuLink);
			alert( " $subMenuLink(0): " + $subMenuLink.get(0));
			alert( " $subMenuLink(0): " + $subMenuLink[0]);*/
		var showSubMenuListener = function(event) {
			
				$nav.off('mouseover', showSubMenuListener);
				console.log("showSubMenuListener");
				event.stopPropagation();
				//alert("a mouseover :" + event.target.nodeName);
				//alert("event target :" + event.target);

				var target = $( event.target );
				
				if (target.is($subMenuLink)) {
					
					$subMenu.animate({
						top: "+=340"
						}, 500, function() {
							console.log("setup hideSubMenuListener");
							$(document).on('mouseover', hideSubMenuListener);
					});
					
				} else {
					$nav.on('mouseover', showSubMenuListener);
				}
			
		};
		
		var hideSubMenuListener =  function(event) {
			
				$(document).off('mouseover', hideSubMenuListener);
			    console.log("hideSubMenuListener");
				event.stopPropagation();
					
				//alert("target.parents('.hidden-submenu').length: " + target.parents('.hidden-submenu').length);
				
				console.log("event.target:" + event.target);
				
				var target = $( event.target );
				
				if (!(target.is($subMenuLink)) && target.parents('.hidden-submenu').length == 0) {
						
					$subMenu.animate({
						top: "-=340"
						}, 500, function() {
							
							$nav.on('mouseover', showSubMenuListener);
					});
						
				} else {
					$(document).on('mouseover', hideSubMenuListener);
				}
		
		};
		
		
		console.log("set up mouseover");
		$nav.on('mouseover', showSubMenuListener);
		
	
		
		
	});
	
	$(window).load(function(){ 
		
		
		
		/*$('#menu-principal .submenu a').on('mouseenter', MM_Functions.onEnterLinkSubmenu);
		$('.hidden-submenu').on('mouseenter', MM_Functions.onLeaveSubmenu);
		$('#menu-principal .submenu a').on('mouseenter', MM_Functions.showSubmenu);
		$('.hidden-submenu').on('mouseleave', MM_Functions.hideSubmenu);*/
		
		

		
		$(window).on('resize', MM_Functions.resizePage);
	
		bodyWidth = $('body').width();
		prevBodyWidth = bodyWidth;
		//Per dispositius x-small el sidebar va despres dels continguts
		if (bodyWidth < 768) {MM_Functions.sidebarToBottom();}
		
		//FB lazy load (only load for md and ld devices)	
		if (bodyWidth >= 992) {MM_Functions.loadFB();}
		
		//Afegir links a thumbnails de galeries
		$('.gallery_box > ul > li > .gallery_detail_box').each(function(){	
			var $this = $(this),
				$linkImg = $this.find('a').clone(),
				$img = $this.prev('img');
			$linkImg.text('').insertBefore($this).append($img);
		});
		
		//Animacions links seccions
		$('.category-item').on({mouseenter: MM_Functions.showCategoryText, mouseleave: MM_Functions.hideCategoryText});
		
		//Reproduir canço
		$('.open_song').click(function(){
			var title = $(this).prev().text(),
				$modalPlayer = $('#modal_player'),
				$modalPlayerTitle = $modalPlayer.find('.modal-title'),
				$modalPlayerContent = $modalPlayer.find('.modal-body');
			
			url = $(this).next().find('audio source').attr('src');
			
			$modalPlayerTitle.html(title);
			$modalPlayerContent.append($(this).next().html());
			
			$modalPlayer.on('shown.bs.modal', function() {
				var audio = document.createElement('audio');
				audio.setAttribute('src',url);
				audio.id = 'player';
				$modalPlayerContent.find('.mejs-container').remove();
				$modalPlayerContent.append(audio);
				$(audio).mediaelementplayer({
					audioWidth: 700,
					success: function (mediaElement, domObject) {
						mediaElement.play();
						player = mediaElement;
					}
				});
				$(this).off('shown.bs.modal');
			});
			
			$modalPlayer.on('hidden.bs.modal', function () {
				player.pause();
				$modalPlayerContent.html('');			
				player = null;
				$modalPlayer.off('hidden.bs.modal');
			});
			
			$modalPlayer.modal('show');
			
		});
		
		//, function() {
			//FB.init({status: true, cookie: true, xfbml: true});
			//FB.Canvas.setAutoResize();
		//});
		//Popover links footer
		$('.mmb-footer-text a').click(function(e){e.preventDefault();});
		var $foot_link_contents = $('#foot_link_contents > div');
		$('.footer-link').each(function(index){
			$(this).popover({placement : 'top', trigger: 'click', html: true, content : $foot_link_contents.get(index).innerHTML});			
		});
		
		//Ajustar mida de comentaris FB a contenidor
		$(".fb-comments").attr("data-width", $("#FatPandaFacebookComments").width());
		if (typeof FB != "undefined") FB.XFBML.parse($(".comments")[0], MM_Functions.fauxCols);
		
		MM_Functions.fauxCols();		
			
	});	
	
//});
