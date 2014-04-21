/**
 * @package:		WordPress
 * @subpackage:		Admin Bar Button Plugin
 * @Description:	Custom jQuery UI 'adminBar' widget for implementing a sliding admin bar, and the invokation of the widget
 */

$ = jQuery.noConflict();

$(function(){
	
	$.widget('DJGUI.adminBar', {
	
		options : {
		
			text:				'Admin bar',	// The text to display in the button
			text_direction:		'ltr',			// The direction of the text ('ltr' or 'rtl')
			button_position:	'left',			// Where to place the button ('left' or 'right')
			button_direction:	'left',			// The direction that the 'Show admin bar' button sldes on/off the screen ('up', 'down', 'left' or 'right')
			button_duration:	500,			// The lenght of time (in miliseconds) to take to show/hide the 'Show admin menu' button
			bar_direction:		'right',		// The direction that the WordPress admin bar sldes on/off the screen ('up', 'down', 'left' or 'right')
			bar_duration:		500,			// The length of time (in miliseconds) to take to show/hide the admin menu
			show_time:			5000			// The length of time (in miliseconds) to show the admin bar for
			
        }, // options
	
		/**
		 * Constructor
		 */
		_create : function(){
		
			/** Ensure that this is a valid '#wpadminbar' element */
			this._validate_element();
			if(!this.valid){
				return false;
			}
			
			this._can_show(true);
			
			/** Initialise the layout of the widget */
			this._create_layout();
			
			/** Initialise the events which can be triggered by this widget */			
			this._create_events();
			
		}, // _create
		
		/**
		 * Validate the selector that this instance of 'adminBar' was called upon and ensure it is the WordPress admin bar
		 */
		_validate_element : function(){
		
			this.valid = (this.element.attr('id') === 'wpadminbar') ? true : false;
			
		}, // _validate_element
		
		/**
		 * Create the layout of the widget
		 */
		_create_layout : function(){
			
			/** Create the relevant DOM objects for the 'Show admin bar' button */
            this.button = $('<div>').addClass('dd-show-admin-bar');
			this.button_text = $('<span>').addClass('text');
			this.button_icon = $('<span>').addClass('ab-icon-position-'+this.options.button_position);
			
            /** Insert the 'Show admin bar' button in to the DOM */
            this.button.insertAfter(this.element);
			if(this.options.button_position === 'right') this.button.append(this.button_icon);
			this.button.append(this.button_text);
			if(this.options.button_position === 'left') this.button.append(this.button_icon);
			
            /** Format the 'Show admin bar' button */
            this._format_button();
			
		}, // _create_layout
		
		/**
		 * Format the layout of the widget (using the options, either default or supplied by the user)
		 */
		_format_button : function(){
		
			/** Work out if the 'Show admin bar' button should be shown on the left or the right */
			var left = (this.options.button_position === 'left') ? '0' : 'auto';
			var right = (this.options.button_position === 'right') ? '0' : 'auto';
			
			/** Add text to the 'Show admin bar' button */
			this.button_text.html(this.options.text);
			
			/** Format the 'Show admin bar' button */
			this.button.css({
				'background-repeat':	'repeat',
				'height':				'32px',
				'position':				'fixed',
				'left':					left,
				'right':				right,
				'top':					'0',
				'z-index':				'100000'
			});
			
			/** Format the 'Show admin bar' button text */
			var margin = '0 20px';
			if(this.options.button_position === 'left'){
				margin = '0 5px 0 20px';
			} else if(this.options.button_position === 'right'){
				margin = '0 20px 0 5px';
			}
			this.button_text.css({
				'direction':		this.options.text_direction,
				'margin':			margin
			});
			
		}, // _format_layout
		
		/**
		 * Create events triggered by actions on this widget
		 */
		_create_events : function(){
		
			var t = this;	// This object
			
			/** Capture when the mouse is hovered over the 'Show admin bar' button */
			t.button.on('mouseenter', function(e){
				t._start_show_admin_bar_timeout();	// Restart the timout
			});
			
			/** Capture when the mouse leaves the 'Show admin bar' button */
			t.button.on('mouseleave', function(e){
				t._clear_show_admin_bar_timeout();	// Clear the existing timeout
			});
			
			/** Capture when the mouse is hovered over the WordPress admin bar */
			t.element.on('mouseenter', function(e){
				t._clear_hide_admin_bar_timeout();	// Clear the existing timeout
			});
			
			/** Capture when the mouse leaves the WordPress admin bar */
			t.element.on('mouseleave', function(e){
				t._start_hide_admin_bar_timeout();	// Restart the timout
			});
			
		}, // _create_events
		
		/**
		 * Get/set whether or not the WordPress admin bar can be shown
		 *
		 * @param boolean|null can_show	If used as a setter, whether or not the WordPress admin bar can be shown
		 * @return boolean|null			If uses as a getter, whether or not the WordPress admin bar can be shown
		 */
		_can_show : function(can_show){
		
			if(typeof can_show !== 'boolean'){
				return this.can_show;
			} else {
				this.can_show = can_show;
			}
			
		}, // _can_show
		
		/**
		 * Setup a timeout to show the WordPress admin bar (if the mouse does not move away for 0.5 seconds)
		 */
		_start_show_admin_bar_timeout : function(){
		
			var t = this;	// This object
			
			this.timer_show_admin_bar = setTimeout(function(){
				
				var can_show = t._can_show();	// Whether or not the WordPress admin bar can currently be shown
				if(can_show === true){
				
					t._show_admin_bar();				// Show the WordPress admin bar and hide the 'Show admin bar' button
					t._start_hide_admin_bar_timeout();	// Start a new timeout (to hide the admin bar if it's not hovered on)
					t._clear_show_admin_bar_timeout()	// Clear the timeout for showing the admin bar
					
				}
				
			}, 500);
			
		}, // _timeout
		
		/**
		 * Clear the timout that would otherwise show the WordPress admin bar
		 */
		_clear_show_admin_bar_timeout : function(){
		
			clearTimeout(this.timer_show_admin_bar);
			
		}, // _clear_timeout
		
		/**
		 * Setup a timeout to hide the WordPress admin bar (if the mouse does not move over it for 5 seconds)
		 */
		_start_hide_admin_bar_timeout : function(){
		
			var t = this;	// This object
			
			this.timer = setTimeout(function(){
				
				t._hide_admin_bar();				// Hide the WordPress admin bar and shwo the 'Show admin bar' button
				t._clear_hide_admin_bar_timeout();	// Clear the existing timeout
				
			}, t.options.show_time);
			
		}, // _timeout
		
		/**
		 * Clear the timout that would otherwise hide the WordPress admin bar
		 */
		_clear_hide_admin_bar_timeout : function(){
		
			clearTimeout(this.timer);
			
		}, // _clear_timeout
		
		/**
		 * Show the WordPress admin bar (and hide the 'Show admin bar' button)
		 */
		_show_admin_bar : function(){
		
			this._can_show(false);		// Set the 'can_show' object variable to 'false' (meaning the WordPress admin bar can not be shown again at present)
			this.element.show('slide', { 'direction': this.options.bar_direction }, this.options.bar_duration);	// Show the WordPress admin bar
			this.button.hide('slide', { 'direction': this.options.button_direction }, this.options.button_duration);	// Hide the 'Show admin bar' button
			
		}, // _show_admin_bar
		
		/**
		 * Hide the WordPress admin bar (and show the 'Show admin bar' button)
		 */
		_hide_admin_bar : function(){
		
			var t = this;	// This object
			
			this.element.hide('slide', { 'direction': this.options.bar_direction }, this.options.bar_duration);				// Hide the WordPress admin bar
			this.button.show('slide', { 'direction': this.options.button_direction }, this.options.button_duration, function(){	// Show the 'Show admin bar' button
			
				t._can_show(true);	// Set the 'can_show' object variable to 'true' (meaning the WordPress admin bar can be shown again)
				
			});
			
		} // _hide_admin_bar
		
	});
	
});

/**
 * Invoke the 'adminBar' widget, hiding the WordPress admin bar and showing a more subtle button
 */
$(document).ready(function(){
	$('#wpadminbar').adminBar();
});