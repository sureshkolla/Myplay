var scrolled=0; 
$(document).ready(function() {
  $('.responsive tr.middle-header').prepend('<th class="cumulative-returns appendedth"></th>');
  var switched = false;
  var updateTables = function() {
    if (($(window).width() < 767) && !switched ){
      switched = true;
      $("table.responsive").each(function(i, element) {
        splitTable($(element));
      });
      return true;
    }
    else if (switched && ($(window).width() > 767)) {
      switched = false;
      $("table.responsive").each(function(i, element) {
        unsplitTable($(element));
      });
    }
 
};
   
  $(window).load(updateTables);
  $(window).on("redraw",function(){switched=false;updateTables();}); // An event to listen for
  $(window).on("resize", updateTables);
   
	
	function splitTable(original)
	{
		original.wrap("<div class='table-wrapper' />");
		
		var copy = original.clone();
		copy.find("td:not(:first-child), th:not(:first-child)").css("display", "none");
		copy.removeClass("responsive");
		
		original.closest(".table-wrapper").append(copy);
		copy.wrap("<div class='pinned' />");
		original.wrap("<div class='scrollable'> <a href='#' class='handle left min' ></a> <a href='#' class='handle right' ></a></div>");

    setCellHeights(original, copy);
	}
	
	function unsplitTable(original) {
    original.closest(".table-wrapper").find(".pinned").remove();
    original.unwrap();
    original.unwrap();
	}

  function setCellHeights(original, copy) {
    var tr = original.find('tr'),
        tr_copy = copy.find('tr'),
        heights = [];

    tr.each(function (index) {
      var self = $(this),
          tx = self.find('th, td');

      tx.each(function () {
        var height = $(this).outerHeight(true);
        heights[index] = heights[index] || 0;
        if (height > heights[index]) heights[index] = height;
      });

    });

    tr_copy.each(function (index) {
		if($(this).hasClass('top-header'))
      $(this).height(heights[index]/2);
  else
      $(this).height(heights[index]);
    });
  }

 
 var oldleftPos=0;
 
 $(".performance-page").delegate(".right", "click", function(e) {
      e.preventDefault(); 

    /* find click event count */
      var $this = $(this),
      clickNum = $this.data('clickNum');
      if (!clickNum) clickNum = 1;
      if(clickNum==1){oldleftPos=0;leftPos=0;}
      $this.data('clickNum', ++clickNum);

      var leftPos = $(this).parent().scrollLeft();      
      console.log(leftPos+""+oldleftPos);
       
       $(this).parent().animate({scrollLeft: leftPos + 50}, 200);         
      
       if(leftPos ==oldleftPos && oldleftPos%50 !=0) {
             $(this).addClass('max');
         } else  $(this).prev().removeClass('min');        
         oldleftPos= leftPos;     
        
		});    

    $(".performance-page").delegate(".left", "click", function(e) {
      e.preventDefault();
        var leftPos2 =  $(this).parent().scrollLeft();  
        $(this).parent().animate({scrollLeft: leftPos2 - 50}, 200); 

        if( $(this).parent().scrollLeft() <= 50) {
            $(this).parent().find('.left').addClass('min');
         }else  $(this).parent().find('.right').removeClass('max');
         
		});

    $(window).scroll(".scrollable", function() {
      
    });
});

   