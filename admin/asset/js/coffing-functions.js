

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


		add_product_caja : function (obj , btn = '') {
			
			var ID   = $(obj).val();
		 	if (!ID) return false;

		 	if ( $('._product_include[value="'+ID+'"]').size() ) return ;
		 	
			jQuery.ajax({
				beforeSend : function(){
						fn.disableSave();
						$(btn).attr('disabled',true).addClass('bg-btn-loading-3');
				},
	            type: "post",
	            url: ajax_coffing.url,
	            data: {action : ajax_coffing.action, 
	            	   nonce : ajax_coffing.nonce , 
	            	   opc : 'add_product_coffing',
	            	   product_id : ID
	            	  },
	            
	            success: function(result){
				    $('#table-incluye-caja ul').append(result)
					$(btn).removeAttr('disabled').removeClass('bg-btn-loading-3');
					fn.enabledSave();
	            }

	        });


			 
			this.apply_plugins();

		},

		apply_plugins : function(){

				$('.on').numeric()
				
				$( ".sortable" ).sortable({
					items: "li:not(.li-state-disabled)"
				});

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


		,disableSave : function(){ $('#post').submit(function(e){ e.preventDefault() }) }
		,enabledSave : function(){ $('#post').unbind('submit') }

		
}