(function(){
	var wcmp_players = [],
		wcmp_player_counter = 0;

	window['generate_the_wcmp'] = function(isOnLoadEvent)
	{
		if(
			typeof isOnLoadEvent !== 'boolean' &&
			typeof wcmp_global_settings != 'undefined' &&
			wcmp_global_settings['onload']*1
		) return;

		if('undefined' !== typeof generated_the_wcmp) return;
		generated_the_wcmp = true;

		var $ = jQuery;
		$(document).on('click', '.wcmp-player-container', function(evt){evt.preventDefault();evt.stopPropagation();});

		/**
		 * Play next player
		 */
		function _playNext( playernumber )
		{
			if( playernumber+1 < wcmp_player_counter )
			{
				var toPlay = playernumber+1;
				if( wcmp_players[ toPlay ] instanceof $ && wcmp_players[ toPlay ].is( 'a' ) ){
					if(wcmp_players[ toPlay ].is(':visible')) wcmp_players[ toPlay ].click();
					else _playNext(playernumber+1);
				}
				else
				{
					if($(wcmp_players[ toPlay ].container).is(':visible')) wcmp_players[ toPlay ].play();
					else _playNext(playernumber+1);
				}
			}
		};

		function _setOverImage(p)
		{
			var i = p.data('product'),
				t = $('img.product-'+i);

			if(t.length && $('[data-product="'+i+'"]').length == 1)
			{
				var o = t.offset(),
					c = p.closest('div.wcmp-player');

				c.css({'position': 'absolute', 'z-index': 999999})
				 .offset({'left': o.left+(t.width()-c.width())/2, 'top': o.top+(t.height()-c.height())/2});
			}
		};

		$.expr[':'].regex = function(elem, index, match) {
			var matchParams = match[3].split(','),
				validLabels = /^(data|css):/,
				attr = {
					method: matchParams[0].match(validLabels) ?
								matchParams[0].split(':')[0] : 'attr',
					property: matchParams.shift().replace(validLabels,'')
				},
				regexFlags = 'ig',
				regex = new RegExp(matchParams.join('').replace(/^\s+|\s+$/g,''), regexFlags);
			return regex.test($(elem)[attr.method](attr.property));
		}

		//------------------------ MAIN CODE ------------------------
		var play_all = (typeof wcmp_global_settings != 'undefined') ? wcmp_global_settings[ 'play_all' ] : true, // Play all songs
			pause_others = (typeof wcmp_global_settings != 'undefined') ? !(wcmp_global_settings['play_simultaneously']*1) : true,
			ios_controls = (
				typeof wcmp_global_settings != 'undefined' &&
				('ios_controls' in wcmp_global_settings) &&
				wcmp_global_settings['ios_controls']*1
			) ? true : false,
			s = $('audio.wcmp-player:not(.track):not([playernumber])'),
			m = $('audio.wcmp-player.track:not([playernumber])'),
			c = {
					pauseOtherPlayers: pause_others,
					iPadUseNativeControls: ios_controls,
					iPhoneUseNativeControls: ios_controls,
					success: function( media, dom ){
						if($(dom).attr('volume')) media.setVolume(parseFloat($(dom).attr('volume')));
						var update_duration = function(e){
							var t = $(e.target),
								duration = t.data('duration');
							if(typeof duration != 'undefined')
							{
								t.closest('.wcmp-player-container')
								 .find('.mejs-duration')
								 .html(duration);
							}
						};

						media.addEventListener( 'timeupdate', function( e ){
							update_duration(e);
							if( !isNaN( this.currentTime ) && !isNaN( this.duration ) && this.src.indexOf( 'ms-action=secure' ) != -1 )
							{
								if( this.duration - this.currentTime < 4 )
								{
									this.setVolume( this.volume - this.volume / 3 );
								}
								else
								{
									if( typeof this[ 'bkVolume' ] == 'undefined' ) this[ 'bkVolume' ] = this.volume;
									this.setVolume( this.bkVolume );
								}

							}
						});

						media.addEventListener( 'volumechange', function( e ){
							if( !isNaN( this.currentTime ) && !isNaN( this.duration ) && this.src.indexOf( 'ms-action=secure' ) != -1 )
							{
								if( ( this.duration - this.currentTime > 4 ) && this.currentTime )  this[ 'bkVolume' ] = this.volume;
							}
						});

						media.addEventListener( 'ended', function( e ){
							if( play_all*1 )
							{
								var playernumber = $(this).attr('playernumber')*1;
								_playNext( playernumber );
							}
						});

						media.addEventListener('loadedmetadata', function( e ){
							update_duration(e);
						});
					}
				},
			selector = '.product-type-grouped :regex(name,quantity\\[\\d+\\])';
		s.each(function(){
			var e 	= $(this),
				src = e.find( 'source' ).attr( 'src' );

			e.attr('playernumber', wcmp_player_counter);
			wcmp_player_counter++;

			c['audioVolume'] = 'vertical';
			try{
				wcmp_players[ wcmp_player_counter ] = new MediaElementPlayer(e[0], c);
			}
			catch(err)
			{
				if('console' in window) console.log(err);
			}

			/* _setOverImage(e); */
		});


		m.each(function(){
			var e = $(this),
				src = e.find( 'source' ).attr( 'src' );

			e.attr('playernumber', wcmp_player_counter);
			wcmp_player_counter++;

			c['features'] = ['playpause'];
			try{
				wcmp_players[ wcmp_player_counter ] = new MediaElementPlayer(e[0], c);
			}
			catch(err)
			{
				if('console' in window) console.log(err);
			}

			_setOverImage(e);
			$(window).resize(function(){_setOverImage(e);});
		});

		if(!$(selector).length) selector = '.product-type-grouped [data-product_id]';
		$(selector).each(function(){
			var e = $(this),
				i = e.data( 'product_id' )||e.attr('name').replace(/[^\d]/g,''),
				c = $( '.wcmp-player-list.merge_in_grouped_products .product-'+i+':first .wcmp-player-title' ), /* Replaced :last with :first 2018.06.12 */
				t = $('<table></table>');

			if(c.length && !c.closest('.wcmp-first-in-product').length)
			{
				c.closest('tr').addClass('wcmp-first-in-product'); /* To identify the firs element in the product */
				if(c.closest('form').length == 0)
				{
					c.closest('.wcmp-player-list').prependTo(e.closest('form'));
				}
				t.append(e.closest('tr').prepend('<td>'+c.html()+'</td>'));
				c.html('').append(t);
			}
		});
	}

	window['wcmp_force_init'] = function()
	{
		delete window.generated_the_wcmp;
		generate_the_wcmp(true);
	}

	jQuery(generate_the_wcmp);
	jQuery(window).on('load', function(){
		generate_the_wcmp(true);
		var $ = jQuery,
			ua = window.navigator.userAgent;

		$('[data-lazyloading]').each(function(){ var e = $(this); e.attr('preload', e.data('lazyloading'));});
		if(ua.match(/iPad/i) || ua.match(/iPhone/i))
		{
			var p = (typeof wcmp_global_settings != 'undefined') ? wcmp_global_settings[ 'play_all' ] : true;
			if(p) // Solution to the play all in Safari iOS
			{
				$('.wcmp-player .mejs-play button').one('click', function(){

					if('undefined' != typeof wcmp_preprocessed_players) return;
					wcmp_preprocessed_players = true;

					var e = $(this);
					$('.wcmp-player audio').each(function(){
						this.play();
						this.pause();
					});
					setTimeout(function(){e.click();}, 500);
				});
			}
		}
	}).on('popstate', function(){
		if(jQuery('audio[data-product]:not([playernumber])').length) wcmp_force_init();
	});

	jQuery(document).on('scroll', wcmp_force_init);
})()