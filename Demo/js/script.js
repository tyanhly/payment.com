$(document).ready(function(){
				
		var currentPosition;		
				
		/*  input focus in */
		$("input, textarea, select").focusin(function(){
		
			var titleInput = $( this ).parents(".list-item-form ").find(".list-item-desc").addClass("text-focus");
			
			currentPosition = $( this ).offset().top
			
			titleInput =  currentPosition - 112;
			
			//alert(titleInput);
			
			 $("html, body").animate({ scrollTop: titleInput }, 600);			
		});

		
		/*  input focus out */	
		$("input, textarea, select").focusout(function(){	
		
			var titleInput = $( this ).parents(".list-item-form ").find(".list-item-desc").removeClass("text-focus");
			
			titleInput =  currentPosition - 224;
			
			//alert(titleInput);
			
			 $("html, body").animate({ scrollTop: titleInput }, 600);	
			
			
		});
						
		
		
		/* tabs  */
		
		$( ".tabs li" ).click(function() {
		  
		  var index = $( ".tabs li" ).index( this );
		  
		  $( ".tabs li" ).removeClass("active");
		  $( ".tab-content " ).removeClass("active");
		  
		  $( this ).addClass("active");
		  
		  var tabItem = ".tab-content:eq(" + index + ")";
		  $(tabItem).addClass("active");
		  		  		
		});
		
		
		
		/*  toggle event for Main Menu button  */
		
		  var _toggle = 0;
	
			$(".fa-bars, .fade-bg").click(function(){		
			if(_toggle == 0)
			{
				$('.main-menu').addClass('expanded-menu');
				$('.header').addClass('expanded-header');
				$('.fade-bg').addClass('fade-bg-fx');
				
				_toggle = 1;
			}
			else
			{
				$('.main-menu').removeClass('expanded-menu');
				$('.header').removeClass('expanded-header');
				$('.fade-bg').removeClass('fade-bg-fx');
								
				_toggle = 0;
			}						
		
		});
		
		
		/*  toggle event for Menu Bottom button  */
	var _toggle2 = 0;

    $(".bottom-menu").click(function () {
        if (_toggle2 == 0) {
            $('.bottom-sheets-grid').addClass('slide-up');
            $('.bottom-sheets-grid').removeClass('slide-down');

            _toggle2 = 1;
        }
        else {
            $('.bottom-sheets-grid').addClass('slide-down');
            $('.bottom-sheets-grid').removeClass('.slide-up');

            _toggle2 = 0;
        }

    });

	/*  toggle event for MORE button  */
		_toggle3 = 0;
		
		$(".btn-more").click(function(){
		
				
			if (_toggle3 == 0) {
            $(".hide").show(500);	

            _toggle3 = 1;
        }
        else {
            $(".hide").hide(500);	

            _toggle3 = 0;
        }
				
			
		});
		
		
		
		/*  toggle event for MORE button  */
		_toggle4 = 0;
		$(".context-menu, .drop-menu").click(function(){
		
		if (_toggle4 == 0) {
			var contextMenu = $(this);
				contextMenu.find('ul').show(500);	
				 _toggle4 = 1;
			}
			else
			{
				$(".context-menu ul, .drop-menu ul").hide(500);			
				 _toggle4 = 0;
			}
		});
		
					
			
		$('.snack-bar').addClass('go-up');
			
}); //end jQuery ready
		