jQuery( document ).ready( function( $ ){
	
	var init_search_js = function(){
		this.query = false;
		var self = this;
		
		self.init_tabs = function(){
			$('body').on('click', '#search-nav a', function( event ){
				event.preventDefault();
				if( !$( this ).hasClass('search-loaded') ){
					var sec = $( '#search-'+ $( this ).data('type') )
					self.set_query( $( this ) );
					self.load_results( sec );
				}
				$(this).addClass('activesearch').siblings().removeClass('activesearch');
				sec.show().siblings('.search-section').hide();
				});
		}
		self.set_query = function( ic ){
			var url = $('#search-form').data('serviceurl');
			var term = $('#search-term').val();
			var type = ic.data('type');
			self.query = url+'?search-service='+type+'&term='+term;
		}
		
		self.load_results = function( loc ){
			loc.load( self.query );
		}
		
		self.init_tabs();
	}
	
	var search_js = new init_search_js();
});