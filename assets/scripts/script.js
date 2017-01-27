/**
 * File customizer.js.
 *
 * Theme Customizer enhancements for a better user experience.
 *
 * Contains handlers to make Theme Customizer preview reload changes asynchronously.
 */
/**
( function( $ ) {
  // Site title and description.
  wp.customize( 'blogname', function( value ) {
    value.bind( function( to ) {
      $( '.site-title a' ).text( to );
    });
  });

  wp.customize( 'blogdescription', function( value ) {
    value.bind( function( to ) {
      $( '.site-description' ).text( to );
    });
  });

  // Header text color.
  wp.customize( 'header_textcolor', function( value ) {
    value.bind( function( to ) {
      if ( 'blank' === to ) {
        $( '.site-title a, .site-description' ).css( {
          'clip': 'rect(1px, 1px, 1px, 1px)',
          'position': 'absolute'
        });
      } else {
        $( '.site-title a, .site-description' ).css( {
          'clip': 'auto',
          'position': 'relative'
        } );
        $( '.site-title a, .site-description' ).css( {
          'color': to
        });
      }
    });
  });
} )( jQuery );
*/

jQuery(document).ready(function( $ ) {
  // Load Events
  console.log('ready!');
  $('.simple-marquee-container').SimpleMarquee();
}); // Fully reference jQuery after this point.

/**
 * File navigation.js.
 *
 * Handles toggling the navigation menu for small screens and enables TAB key
 * navigation support for dropdown menus.
 */
( function() {
	var container, button, menu, links, subMenus, i, len;

	container = document.getElementById( 'site-navigation' );
	if ( ! container ) {
		return;
	}

	button = container.getElementsByTagName( 'button' )[0];
	if ( 'undefined' === typeof button ) {
		return;
	}

	menu = container.getElementsByTagName( 'ul' )[0];

	// Hide menu toggle button if menu is empty and return early.
	if ( 'undefined' === typeof menu ) {
		button.style.display = 'none';
		return;
	}

	menu.setAttribute( 'aria-expanded', 'false' );
	if ( -1 === menu.className.indexOf( 'nav-menu' ) ) {
		menu.className += ' nav-menu';
	}

	button.onclick = function() {
		if ( -1 !== container.className.indexOf( 'toggled' ) ) {
			container.className = container.className.replace( ' toggled', '' );
			button.setAttribute( 'aria-expanded', 'false' );
			menu.setAttribute( 'aria-expanded', 'false' );
		} else {
			container.className += ' toggled';
			button.setAttribute( 'aria-expanded', 'true' );
			menu.setAttribute( 'aria-expanded', 'true' );
		}
	};

	// Get all the link elements within the menu.
	links    = menu.getElementsByTagName( 'a' );
	subMenus = menu.getElementsByTagName( 'ul' );

	// Set menu items with submenus to aria-haspopup="true".
	for ( i = 0, len = subMenus.length; i < len; i++ ) {
		subMenus[i].parentNode.setAttribute( 'aria-haspopup', 'true' );
	}

	// Each time a menu link is focused or blurred, toggle focus.
	for ( i = 0, len = links.length; i < len; i++ ) {
		links[i].addEventListener( 'focus', toggleFocus, true );
		links[i].addEventListener( 'blur', toggleFocus, true );
	}

	/**
	 * Sets or removes .focus class on an element.
	 */
	function toggleFocus() {
		var self = this;

		// Move up through the ancestors of the current link until we hit .nav-menu.
		while ( -1 === self.className.indexOf( 'nav-menu' ) ) {

			// On li elements toggle the class .focus.
			if ( 'li' === self.tagName.toLowerCase() ) {
				if ( -1 !== self.className.indexOf( 'focus' ) ) {
					self.className = self.className.replace( ' focus', '' );
				} else {
					self.className += ' focus';
				}
			}

			self = self.parentElement;
		}
	}

	/**
	 * Toggles `focus` class to allow submenu access on tablets.
	 */
	( function( container ) {
		var touchStartFn, i,
			parentLink = container.querySelectorAll( '.menu-item-has-children > a, .page_item_has_children > a' );

		if ( 'ontouchstart' in window ) {
			touchStartFn = function( e ) {
				var menuItem = this.parentNode, i;

				if ( ! menuItem.classList.contains( 'focus' ) ) {
					e.preventDefault();
					for ( i = 0; i < menuItem.parentNode.children.length; ++i ) {
						if ( menuItem === menuItem.parentNode.children[i] ) {
							continue;
						}
						menuItem.parentNode.children[i].classList.remove( 'focus' );
					}
					menuItem.classList.add( 'focus' );
				} else {
					menuItem.classList.remove( 'focus' );
				}
			};

			for ( i = 0; i < parentLink.length; ++i ) {
				parentLink[i].addEventListener( 'touchstart', touchStartFn, false );
			}
		}
	}( container ) );
} )();

// ---------------------------------
// ---------- SimpleMarquee ----------
// ---------------------------------
//Copyright (C) 2016  Fabian Valle
//An easy to implement marquee plugin. I know its easy because even I can use it.
//Forked from: https://github.com/conradfeyt/Simple-Marquee
//Re-Written by: Fabian Valle (www.fabian-valle.com) (www.obliviocompany.com)
//
// ------------------------
// Structure //
//
//  *********************************** - marque-container - *************************************
//  *                                                                                            *
//  *   ******************************* ******************************************************   *
//  *   *                             * *                                                    *   *
//  *   * - marquee-content-sibling - * *                 - marquee-content -                *   *
//  *   *                             * *                                                    *   *
//  *   ******************************* ******************************************************   *
//  *                                                                                            *
//  **********************************************************************************************
//
//// Usage //
//
//    Only need to call the createMarquee() function,
//    if desired, pass through the following paramaters:
//
//    $1 duration:                   controls the speed at which the marquee moves
//
//    $2 padding:                    right margin between consecutive marquees.
//
//    $3 marqueeClass:               the actual div or span that will be used to create the marquee -
//                                   multiple marquee items may be created using this item's content.
//                                   This item will be removed from the dom
//
//    $4 containerClass:             the container div in which the marquee content will animate.
//
//    $5 marquee-content-sibling :   (optional argument) a sibling item to the marqueed item  that
//                                   affects the end point position and available space inside the
//                                   container.
//
//    $6 hover:                     Boolean to indicate whether pause on hover should is required.
;(function ($, window, document, undefined){
  var pluginName = 'SimpleMarquee';

    function Plugin (element, options) {
        this.element          = element;
        this._name            = pluginName;
        this._defaults        = $.fn.SimpleMarquee.defaults;
        this.settings         = $.extend( {}, this._defaults, options );
        this.marqueeSpawned   = [];
        this.marqueeHovered   = false;
        this.documentHasFocus = false;
        //
        this.counter          = 0;

        this.timeLeft         = 0;
        this.currentPos       = 0;
        this.distanceLeft     = 0;
        this.totalDistance    = 0;
        this.contentWidth     = 0;
        this.endPoint         = 0;
        this.duration         = 0;
        this.hovered          = false;
        this.padding          = 0;


        this.init();
    }
    function marqueeObj(newElement){
      this.el            = newElement;
      this.counter       = 0;
      this.name          = '';
      this.timeTop       = 0;
      this.currentPos    = 0;
      this.distanceTop   = 0;
      this.totalDistance = 0;
      this.contentWidth  = 0;
      this.endPoint      = 0;
      this.duration      = 0;
      this.hovered       = false;
      this.padding       = 0;
    }
    //methods for plugin
    $.extend(Plugin.prototype, {

        // Initialization logic
        init: function () {
            this.buildCache();
            this.bindEvents();
            var config = this.settings;
            //init marquee
            if($(config.marqueeClass).width() === 0){
              console.error('FATAL: marquee css or children css not correct. Width is either set to 0 or the element is collapsing. Make sure overflow is set on the marquee, and the children are postitioned relatively');
              return;
          }

          if(typeof $(config.marqueeClass) === 'undefined'){
              console.error('FATAL: marquee class not valid');
              return;
          }

          if(typeof $(config.containerClass) === 'undefined'){
              console.error('FATAL: marquee container class not valid');
              return;
          }

          if(config.sibling_class != 0 && typeof $(config.sibling_class) === 'undefined'){
              console.error('FATAL: sibling class container class not valid');
              return;
          }

          //create the Marquee
          this.createMarquee();
        },

        // Remove plugin instance completely
        destroy: function() {
            this.unbindEvents();
            this.$element.removeData();
        },

        // Cache DOM nodes for performance
        buildCache: function () {
            this.$element = $(this.element);
        },

        // Bind events that trigger methods
        bindEvents: function() {
          var plugin = this;
          $(window).on('focus',function(){
            plugin.documentHasFocus = true;
            for (var key in plugin.marqueeSpawned){
                  plugin.marqueeManager(plugin.marqueeSpawned[key]);
                }
          });
          $(window).on('blur',function(){
            plugin.documentHasFocus = false;
            for (var key in plugin.marqueeSpawned){
                  plugin.marqueeSpawned[key].el.clearQueue().stop();
                  plugin.marqueeSpawned[key].hovered = true;
              }
          });

        },

        // Unbind events that trigger methods
        unbindEvents: function() {
          $(window).off('blur focus');
        },
        getPosition: function(elName){
          this.currentPos = parseInt($(elName).css('left'));
            return this.currentPos;
        },
        createMarquee: function(){
          var plugin = this;
          var config = plugin.settings;
          var marqueeContent =  $(config.marqueeClass).html();
            var containerWidth = $(config.containerClass).width();
            var contentWidth = $(config.marqueeClass).width();

            var widthToIgnore = 0;
            if (config.sibling_class != 0){
              widthToIgnore = $(config.sibling_class).width();
            }

            var spawnAmount = Math.ceil(containerWidth / contentWidth);

            $(config.marqueeClass).remove();

            if(spawnAmount<=2){
                spawnAmount = 3;
            } else {
              spawnAmount++;
            }

            var totalContentWidth = (contentWidth + config.padding)*spawnAmount;

            var endPoint = -(totalContentWidth - containerWidth);

            var totalDistance =  containerWidth - endPoint;




            for (var i = 0; i < spawnAmount; i++) {

              var newElement = false;

                if(config.hover === true){


                  newElement = $('<div class="marquee-' + (i+1) + '">' + marqueeContent + '</div>')
                  .mouseenter(function() {


                    if ((plugin.documentHasFocus === true) && (plugin.marqueeHovered === false)){
                      plugin.marqueeHovered = true;

                      for (var key in plugin.marqueeSpawned){
                        plugin.marqueeSpawned[key].el.clearQueue().stop();
                        plugin.marqueeSpawned[key].hovered = true;
                      }


                    }

                  })
                  .mouseleave(function() {


                      if ((plugin.documentHasFocus === true) && (plugin.marqueeHovered === true)){

                        for (var key in plugin.marqueeSpawned){
                          plugin.marqueeManager(plugin.marqueeSpawned[key]);
                        }

                        plugin.marqueeHovered = false;
                      }
                  });

                } else {

                  newElement = $('<div class="marquee-' + (i+1) + '">' + marqueeContent + '</div>') ;

                }

                plugin.marqueeSpawned[i] = new marqueeObj(newElement);

                $(config.containerClass).append(newElement);

                plugin.marqueeSpawned[i].currentPos = (widthToIgnore + (contentWidth*i))+(config.padding*i);  //initial positioning
                plugin.marqueeSpawned[i].name = '.marquee-'+(i+1);

                plugin.marqueeSpawned[i].totalDistance = totalDistance;
                plugin.marqueeSpawned[i].containerWidth = containerWidth;
                plugin.marqueeSpawned[i].contentWidth = contentWidth;
                plugin.marqueeSpawned[i].endPoint = endPoint;
                plugin.marqueeSpawned[i].duration = config.duration;
                plugin.marqueeSpawned[i].padding = config.padding;

                plugin.marqueeSpawned[i].el.css('left', plugin.marqueeSpawned[i].currentPos+config.padding +'px'); //setting left according to postition

                 if (plugin.documentHasFocus === true){
                  plugin.marqueeManager(plugin.marqueeSpawned[i]);
                }

            }
            //end for

            if(document.hasFocus()){
             plugin.documentHasFocus = true;
          }else{
            plugin.documentHasFocus = false;
          }

        },
        marqueeManager: function(marqueedElement){
          var plugin = this;
          var elName = marqueedElement.name;
          if (marqueedElement.hovered === false) {

                if (marqueedElement.counter > 0) {  //this is not the first loop

                      marqueedElement.timeLeft = marqueedElement.duration;
                      marqueedElement.el.css('left', marqueedElement.containerWidth +'px'); //setting margin
                      marqueedElement.currentPos = marqueedElement.containerWidth;
                      marqueedElement.distanceLeft = marqueedElement.totalDistance - (marqueedElement.containerWidth - plugin.getPosition(elName));

                } else {    // this is the first loop

                  marqueedElement.timeLeft = (((marqueedElement.totalDistance - (marqueedElement.containerWidth - plugin.getPosition(elName)))/ marqueedElement.totalDistance)) * marqueedElement.duration;
                }

            } else {
                  marqueedElement.hovered = false;
                  marqueedElement.currentPos = parseInt(marqueedElement.el.css('left'));
                  marqueedElement.distanceLeft = marqueedElement.totalDistance - (marqueedElement.containerWidth - plugin.getPosition(elName));
                  marqueedElement.timeLeft = (((marqueedElement.totalDistance - (marqueedElement.containerWidth - marqueedElement.currentPos))/ marqueedElement.totalDistance)) * marqueedElement.duration;
            }

          plugin.marqueeAnim(marqueedElement);
        },
        marqueeAnim: function(marqueeObject){
          var plugin = this;
          marqueeObject.counter++;
            marqueeObject.el.clearQueue().animate(
                {'left': marqueeObject.endPoint+'px'},
                marqueeObject.timeLeft,
                'linear',
                function(){
                  plugin.marqueeManager(marqueeObject);
              });
        },
        callback: function() {
            // Cache onComplete option
            var onComplete = this.settings.onComplete;

            if ( typeof onComplete === 'function' ) {
                onComplete.call(this.element);
            }
        }

    });
    //end methods for plugin

    $.fn.SimpleMarquee = function (options) {
        this.each(function() {
            if ( !$.data( this, "plugin_" + pluginName ) ) {
                $.data( this, "plugin_" + pluginName, new Plugin( this, options ) );
            }
        });
        return this;
    };
    $.fn.SimpleMarquee.defaults = {
            property: 'value',
            onComplete: null,
            duration: 20000,
            padding: 10,
            marqueeClass: '.marquee',
            containerClass: '.simple-marquee-container',
            sibling_class: 0,
            hover: true
    };

})( jQuery, window, document );

/**
 * File skip-link-focus-fix.js.
 *
 * Helps with accessibility for keyboard only users.
 *
 * Learn more: https://git.io/vWdr2
 */
( function() {
	var isWebkit = navigator.userAgent.toLowerCase().indexOf( 'webkit' ) > -1,
	    isOpera  = navigator.userAgent.toLowerCase().indexOf( 'opera' )  > -1,
	    isIe     = navigator.userAgent.toLowerCase().indexOf( 'msie' )   > -1;

	if ( ( isWebkit || isOpera || isIe ) && document.getElementById && window.addEventListener ) {
		window.addEventListener( 'hashchange', function() {
			var id = location.hash.substring( 1 ),
				element;

			if ( ! ( /^[A-z0-9_-]+$/.test( id ) ) ) {
				return;
			}

			element = document.getElementById( id );

			if ( element ) {
				if ( ! ( /^(?:a|select|input|button|textarea)$/i.test( element.tagName ) ) ) {
					element.tabIndex = -1;
				}

				element.focus();
			}
		}, false );
	}
})();
