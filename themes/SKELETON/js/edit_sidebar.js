(function($){
  Drupal.behaviors.adminPanel = {
    attach: function(context, settings) {
      $('#edit-sidebar', context).tabSlideOut({
        tabHandle: '.handle', //class of the element that will become your tab
        tabLocation: 'left', //side of screen where tab lives, top, right, bottom, or left
        speed: 300, //speed of animation
        action: 'click', //options: 'click' or 'hover', action to trigger animation
        topPos: '200px', //position from the top/ use if tabLocation is left or right
        leftPos: '20px', //position from left/ use if tabLocation is bottom or top
        fixedPosition: false //options: true makes it stick(fixed position) on scroll
      });
    }
  };
})(jQuery);
