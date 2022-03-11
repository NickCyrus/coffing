

var btnSuccessColor = "#B65F4F"
var btnCancelColor  = "#DD6B55" 


fn = {

		welcome : function(){

				Swal.fire({
				  title: 'Bienvenido a Coffing Control',
				  text: '',
				  imageUrl: COFCOURLADMIN+'images/mobile-cafe.svg',
				  imageWidth: 300,
				  confirmButtonColor : btnSuccessColor,
				  //imageHeight: 200,
				  imageAlt: 'Coffing Control',
				})

		},


		add_product_caja : function (obj) {
			
			var ID   = $(obj).val();
		 	if (!ID) return false;

		 	if ( $('._product_include[value="'+ID+'"]').size() ) return ;
		 	
			jQuery.ajax({
	            type: "post",
	            url: ajax_coffing.url,
	            data: {action : ajax_coffing.action, 
	            	   nonce : ajax_coffing.nonce , 
	            	   opc : 'add_product_coffing',
	            	   product_id : ID
	            	  },
	            
	            success: function(result){
	                $('#table-incluye-caja ul').append(result)
	            }

	        });


			/*
			jQuery.ajax({
		            type: "POST",
		            url: ajax_var.url,
		            data: "action=" + ajax_var.action + "&nonce=" + ajax_var.nonce,
		            success: function(result){
		                $('#my-events-list').html(result);
		            }
        	});
			var select = '<input class="on tc" name="_cantidad_product['+ID+']" value="0" /> - <a class="hand" onclick="fn.removeThisElement(this, \'li\')" data-question="Desea eliminar este producto '+text+'"> Eliminar </a>';

			if ( $('._product_include[value="'+ID+'"]').size() ) return ;

			var rowHTML = '<li class="item">\
	        					<div class="grid col-620">\
	        						<i class="fa"></i>\
	        						<input type="hidden" class="_product_include" name="_product_include[]" value="'+ID+'" />'+text+'</div>\
	        					<div class="grid col-320">'+select+'</div>\
	        					<div class="clear"></div>\
			        	   </li>';

			$('#table-incluye-caja ul').append(rowHTML)
			*/
			this.apply_plugins();

		},

		apply_plugins : function(){

				$('.on').numeric() 

		},

		removeThisElement : function(obj , padre = ''){

				var title =  ($(obj).data('question')) ? $(obj).data('question') : 'Desea eliminar este registro ?';
				
				if (confirm(title)){

					if (!padre){
						$(obj).fadeOut(500,function(){
							$(obj).remove();
						})
					}else{
						$(obj).parents(padre).fadeOut(500,function(){
							$(obj).parents(padre).remove();
						})
					}

				}

		}

		
}