jQuery( document ).ready( function( $ ){
	
	var init_search_js = function(){
		this.query = false;
		var self = this;
		
		self.init_tabs = function(){
			$('body').on('click', '#search-nav a', function( event ){
				event.preventDefault();
				var sec = $( '#'+ $( this ).data('type') )
				sec.show().siblings('.search-section').hide();
				if( !$( this ).hasClass('search-loaded') ){
					self.set_query( $( this ) );
					self.load_results( sec );
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
			loc.load( self.query , function(){
				loc.removeClass('loading-search');
				loc.addClass('search-loaded');
			});
		}
		
		self.init_tabs();
	}
	
	var search_js = new init_search_js();
});