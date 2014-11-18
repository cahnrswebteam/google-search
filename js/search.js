jQuery( document ).ready( function( $ ){
	
	var init_search_js = function(){
		this.query = false;
		this.dwnselects = new Array();
		var self = this;
		
		self.init_tabs = function(){
			$('body').on('click', '#search-nav a', function( event ){
				event.preventDefault();
				var sec = $( '#'+ $( this ).data('type') )
				sec.show().siblings('.search-section').hide();
				if( !$( this ).hasClass('search-loaded') ){
					self.set_query( $( this ) );
					self.load_results( sec.find('.cs-results-content') );
				} else {
					sec.removeClass('loading-search');
				}
				$(this).addClass('activesearch').siblings().removeClass('activesearch');
				
				});
		}
		self.set_query = function( ic ){
			var url = $('#search-form').data('serviceurl');
			var term = $('#search-term').val();
			var type = ic.data('type');
			self.query = url+'?is-search-service=true&search-type='+type+'&term='+encodeURIComponent( term ).replace(/%20/g, '+');
			console.log( self.query );
		}
		
		self.load_results = function( loc ){
			loc.addClass('loading-search');
			loc.load( self.query , function(){
				loc.removeClass('loading-search');
				loc.addClass('search-loaded');
			});
		}
		
		var drpsel = function( cur ){
			this.c = cur;
			this.c_dp = this.c.children('ul').children('li');
			this.subm = this.c.children('a')
			var c_self = this;
			
			c_self.presel = function(){
				c_self.c_dp.find( 'input').each( function(){
					if( $( this ).prop( 'checked' ) ){
						$(this).parent().slideDown( 'fast', function() { $(this).addClass( 'cs-active-option' ) } );
					}
				});
			}
			
			c_self.c_dp.hover(
				function(){ $( this ).find('li').slideDown('fast'); },
				function(){ $( this ).find('li:not(.cs-active-option)').slideUp('fast'); }
			)
			
			c_self.c_dp.find('li').click( function(){
				if( !$( this ).hasClass( 'cs-active-option' ) ) {
					$( this ).addClass('cs-active-option');
					$( this ).children('input').prop('checked', true );
					if( $( this ).parent().hasClass('cs-radio') ){
						$( this ).siblings().removeClass('cs-active-option');
						$( this ).siblings().children('input').prop('checked', false); 
					}
				} else {
					$( this ).removeClass('cs-active-option');
					$( this ).children('input').prop('checked', false);
				}
			});
			
			c_self.subm.click( function( event ){
				event.preventDefault();
				var term = c_self.c.find('.cs-term').val();
				self.query = c_self.c.data('requesturl');				
				self.query = self.query + '?is-search-service=true&'
				if( term ) self.query = self.query + '&term='+encodeURIComponent( term ).replace(/%20/g, '+');
				c_self.c_dp.children('ul').each( function( index ){
					var sec = $(this);
					var checked = $(this).find( 'input:checked');
					if( checked.length > 0 ){
						self.query = self.query + '&';
						self.query = self.query + sec.data('key') + '=';
						checked.each( function( i ){
							if( i != 0 ) self.query = self.query + '|';
							self.query = self.query + $(this).val();
						});
					}
				} );
				var sec = $( '#'+ c_self.c.data('type') ).find('.cs-results-content');
				console.log( self.query );
				self.load_results( sec );
				
			});
			
			c_self.presel();
		}
		
		$('.cs-advanced').each( function( index ){ 
			self.dwnselects[ index ] = new drpsel( $( this ) ); 
			});
		
		self.init_tabs();
	}
	
	var search_js = new init_search_js();
});