jQuery(function($){ 

	setTimeout(function() {
		$('#subscription-box-two').modal();
	}, 2000)

	$(".more").toggle(function(){
	    $(this).text("-").siblings(".complete").show();    
	}, function(){
	    $(this).text("+").siblings(".complete").hide();    
	});

	$('.load-more-btn').click(function(){
 		var that = $(this);
		var button = that;
		var post_ids = [];
		var post_type =  that.parents( '.article-wrapper' ).find('.post_type').val();
		var term_id =  that.parents( '.article-wrapper' ).find('.term_id').val();
		var bootstrap_class = that.parents( '.article-wrapper' ).find('.bootstrap_class').val();
		var post_class = that.parents( '.article-wrapper' ).find('.post_class' ).val();
		var thumb_size = that.parents( '.article-wrapper' ).find('.thumb_size' ).val();
		var show_excerpt = that.parents( '.article-wrapper' ).find('.show_excerpt' ).val();
		var show_author = that.parents( '.article-wrapper' ).find('.show_author' ).val();
		var show_thumb_caption = that.parents( '.article-wrapper' ).find('.show_thumb_caption' ).val();

		$('.post_id').each(function() {			
			post_ids.push( this.value );
		});

	    data = {
			'action': 'loadmore',
			'term_id': term_id,
			'post_type': post_type,
			'post_ids': post_ids,
			'bootstrap_class' : bootstrap_class, 
			'post_class' : post_class,
			'thumb_size' : thumb_size,
			'show_excerpt' : show_excerpt,
			'show_author' : show_author,
			'show_thumb_caption' : show_thumb_caption,
		};		
 
		$.ajax({ 
			url : ajax_obj.ajaxurl,
			data : data,
			type : 'POST',
			beforeSend : function ( xhr ) {
				button.text('Loading...');
			},
			success : function( data ){
				if( data ) {
					button.text('More Stories');					
					that.parents( '.article-wrapper' ).find( $( '.load-more-stories' ) ).before( data );					
				} else {
					button.text('No post to show');					
					button.prop( 'disabled', true );
				}				
			}
		});
	});
});