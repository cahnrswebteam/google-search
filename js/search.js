jQuery( document ).ready( function( $ ){
	
	function init_search_window( is ){
		this.tab = is;
		this.sect = $( '#'+ this.tab.data('type') );
		this.res_sect = this.sect.find('.cs-results-content');
		this.res_count = 0;
		this.more = this.sect.find('.cs-more-results');
		this.query = false;
		this.adv_sort = false;
		this.adv_sort_dpw = false;
		this.adv_sort_sub = false;
		this.nw_search = $('#search-form > a , #site-search a');
		this.nw_search_inpt = $('#search-term');
		var s = this;
		
		s.tab.click( function( e ){
			e.preventDefault();
			s.tab.addClass('activesearch').siblings().removeClass('activesearch');
			s.sect.show().siblings('.search-section').hide();
			if( !$( this ).hasClass('search-loaded') ){
				s.set_query();
				s.load_results();
				$( this ).addClass('search-loaded');
			} else {
				s.res_sect.removeClass('loading-search');
			}
		});
		
		s.more.click( function( e ){
			e.preventDefault();
			s.set_res_count();
			s.load_results();
		});
		
		s.nw_search_inpt.change( function(){
			$('#site-search-field').val( s.nw_search_inpt.val() );
		});
		
		s.nw_search.click( function( e ){
			e.preventDefault();
			$( "#site-search" ).submit();
			
		});
		
		s.set_res_count = function(){
			s.res_count = s.res_sect.find('.search-result').length;
		}
		
		s.set_query = function(){
			var url = $('#search-form').data('serviceurl');
			var term = $('#search-term').val();
			var type = s.tab.data('type');
			s.query = url+'?is-search-service=true&search-type='+type+'&term='+encodeURIComponent( term ).replace(/%20/g, '+');
		}
		
		s.load_results = function(){
			var query = ( s.res_count > 1 )? s.query+'&start='+s.res_count : s.query;
			s.res_sect.addClass('loading-search');
			if( s.res_count == 0 ) s.res_sect.html('');
			$.get( query , function(data) {
				s.res_sect.append( data );
				s.res_sect.removeClass('loading-search');
				s.res_sect.addClass('search-loaded');
				s.set_res_count();
			});
		}
		
		s.activate_sort = function( adv_sort ){
			s.adv_sort = adv_sort;
			s.adv_sort_dpw = s.adv_sort.children('ul').children('li');
			s.adv_sort_sub = s.adv_sort.children('a');
			var cs = this;
			
			s.adv_sort_dpw.find('li').click( function(){
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
			
			s.adv_sort_dpw.hover(
				function(){ $( this ).find('li').slideDown('fast'); },
				function(){ $( this ).find('li:not(.cs-active-option)').slideUp('fast'); }
			)
			
			cs.presel = function(){
				s.adv_sort_dpw.find( 'input').each( function(){
					if( $( this ).prop( 'checked' ) ){
						$(this).parent().slideDown( 'fast', function() { $(this).addClass( 'cs-active-option' ) } );
					}
				});
			}
			
			s.adv_sort_sub.click( function( e ){
				e.preventDefault();
				var term = $('#search-term').val();
				s.query = $('#search-form').data('serviceurl');				
				s.query = s.query + '?is-search-service=true&'
				if( term ) s.query = s.query + '&term='+encodeURIComponent( term ).replace(/%20/g, '+');
				s.adv_sort_dpw.children('ul').each( function( index ){
					var sec = $(this);
					var checked = $(this).find( 'input:checked');
					if( checked.length > 0 ){
						s.query = s.query + '&';
						s.query = s.query + sec.data('key') + '=';
						checked.each( function( i ){
							if( i != 0 ) s.query = s.query + '|';
							s.query = s.query + $(this).val();
						});
					}
				} );
				s.res_count = 0;
				s.load_results();
			});
			
			cs.presel();
		}
		
		
		s.set_query();
		s.set_res_count();
		if( s.sect.find('.cs-advanced').length > 0 ) { s.activate_sort( s.sect.find('.cs-advanced').first() ); }
	}
	
	$('#search-nav a').each( function(index){
		window['search-section-'+index ] = new init_search_window( $(this) );
	});
});

jQuery( document ).ready( function( $ ){
	
	var ttps = $( 'body' ).find( '[data-tooltip]' );
	
	ttps.each( function() {
		
		var c_item = $( this );
		
		c_item.append( '<span class="tooltip-icon"></span>' );
		
		c_item.find( 'span.tooltip-icon' ).hover( 
		
			function(){
				
				if( c_item.find( '.tooltip-wrapper' ).length == 0 ) {
				
					var tooltip = c_item.data( 'tooltip');
					
					var t = '<div class="tooltip-wrapper">' + tooltip + '</div>';
					
					$( this ).append( t );
				
				}
				
				c_item.find( '.tooltip-wrapper').show();
				
			},
			function(){
				
				c_item.find( '.tooltip-wrapper').hide();
			}
		);
		
	});
	
	console.log( ttps.length );
	
});