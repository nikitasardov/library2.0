$(document).ready(function(){
		$('.canHide').addClass('hide');    
		
		$('div.catalog__cardHeader').on('click',function(){
			$(this).siblings('.canHide').slideToggle(200);
            
		})
});