(function($) {
  // Load Events
  $(document).ready(function() {
    $('[data-toggle="tooltip"]').tooltip();
  });

  var $siteHeader = $('.site-header');
  var className = 'affix-on';

  $('.affix-navigation')
    .on('affixed.bs.affix', function() {
      $siteHeader.addClass(className);
    })
    .on('affix-top.bs.affix', function() {
      if ($siteHeader.hasClass(className)) {
        $siteHeader.removeClass(className);
      }
    });
})(jQuery); // Fully reference jQuery after this point.
