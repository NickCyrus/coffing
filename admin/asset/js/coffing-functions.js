

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

		add_product_variante : function (btn) {

				var datos = { name : $('#_coffproducto_name').val() , price : $('#_coffproducto_price').val() , image :  $('#coffing-img-thumb-id').val()  }

				if (!datos.name) { $('#_coffproducto_name').focus() ; return false }

				jQuery.ajax({
					beforeSend : function(){
							fn.disableSave();
							$(btn).attr('disabled',true).addClass('bg-btn-loading-3');
					},
					type: "post",
					url: ajax_coffing.url,
					data: {action : ajax_coffing.action, 
						   nonce : ajax_coffing.nonce , 
						   opc : 'add_product_variante',
						   field : datos
						  },
					
					success: function(result){
						$('#table-variacion-caja ul').append(result)
						$(btn).removeAttr('disabled').removeClass('bg-btn-loading-3');
						$('#coffing-img-thumb-src').hide();
						$('#_coffproducto_name , #_coffproducto_price , #coffing-img-thumb-id').val('');

						fn.enabledSave();
					}
	
				});
	
	
				 
				this.apply_plugins();

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

		, openMedia : function(obj , opc = {} ){

			var defaul = { title : 'Cargar imagen' , setImage : '' , setId: '' ,setUrl : '' };

			opc  = $.extend( defaul , opc );

			var image = wp.media({ 
				title: opc.title,
				multiple: false
			}).open()
			.on('select', function(e){
				// This will return the selected image from the Media Uploader, the result is an object
				var uploaded_image = image.state().get('selection').first();
				// We convert uploaded_image to a JSON object to make accessing it easier
				// Output to the console uploaded_image
				// console.log(uploaded_image);
				
				var img = uploaded_image.toJSON()
 
				if (opc.setImage) $(opc.setImage).attr( 'src', img.url).show();
				if (opc.setId) $(opc.setId).val(img.id);
				
				// Let's assign the url value to the input field
				$(obj).val(img.url);

			});

		}

		
}