/**
 * visualCaptchaHTML class by emotionLoop - 2012.04.26
 *
 * This file handles the JS for the main visualCaptcha class.
 *
 * This license applies to this file and others without reference to any other license.
 *
 * @author emotionLoop | http://emotionloop.com
 * @link http://visualcaptcha.net
 * @package visualCaptcha
 * @license CC BY-SA 3.0 | http://creativecommons.org/licenses/by-sa/3.0/
 * @version 3.0
 */
jQuery(document).ready(function($) {
	var isMobile = false;

	var uAgent = navigator.userAgent.toLowerCase();

	//-- Check if the user agent is a mobile one
	if (uAgent.indexOf('iphone') != -1 || uAgent.indexOf('ipad') != -1 || uAgent.indexOf('ipod') != -1 ||
	uAgent.indexOf('android') != -1 ||
	uAgent.indexOf('windows phone') != -1 || uAgent.indexOf('windows ce') != -1 ||
	uAgent.indexOf('bada') != -1 ||
	uAgent.indexOf('meego') != -1 ||
	uAgent.indexOf('palm') != -1 ||
	uAgent.indexOf('blackberry') != -1 ||
	uAgent.indexOf('nokia') != -1 || uAgent.indexOf('symbian') != -1 ||
	uAgent.indexOf('pocketpc') != -1 ||
	uAgent.indexOf('smartphone') != -1 ||
	uAgent.indexOf('mobile') != -1) {
		isMobile = true;
	}
	
	if (!isMobile) { //-- If it's not mobile, load normal drag/drop behavior
		$('div.eL-captcha > div.eL-possibilities > img').draggable( { opacity: 0.6, revert: 'invalid' } );
		$('div.eL-captcha > div.eL-possibilities').droppable( {
			drop: function(event, ui) {
				if (!$('#' + vCVals.n).length) {
					return false;
				}
				if ($('#' + vCVals.n).val() == $(ui.draggable).data('value')) {
					$('#' + vCVals.n).remove();
				}
				$('div.eL-captcha > div.eL-where2go').droppable('enable');
			},
			accept: 'div.eL-captcha > div.eL-possibilities > img'
		} );
		
		$('div.eL-captcha > div.eL-where2go').droppable( {
			drop: function(event, ui) {
				if ($('#' + vCVals.n).length) {
					return false;
				}
				var validElement = '<input type="hidden" name="' + vCVals.n + '" id="' + vCVals.n + '" readonly="readonly" value="' + $(ui.draggable).data('value') + '" />';
				$('#' + vCVals.f).append(validElement);
				$(this).droppable('disable');
			},
			accept: 'div.eL-captcha > div.eL-possibilities > img'
		} );
	} else { //-- If it's mobile, we're going to make it possible to just tap an image and move it to the drop area automagically
		$('div.eL-captcha > div.eL-possibilities > img').live('click touchstart', function() { //-- Add tap behavior, but keep click in case that also works. There is no "duplication" problem since this code won't run twice
			var xPos = $('div.eL-captcha > div.eL-where2go').offset().left - 5;
			var yPos = $('div.eL-captcha > div.eL-where2go').offset().top;
			var wDim = $('div.eL-captcha > div.eL-where2go').width();
			var hDim = $('div.eL-captcha > div.eL-where2go').height();
			var iwDim = $(this).width();
			var ihDim = $(this).height();

			//-- If it was dragged already to the droppable zone, move it back to the beginning
			if ($(this).css('position') == 'absolute') {
				if (!$('#' + vCVals.n).length) {
					return false;
				}
				if ($('#' + vCVals.n).val() == $(this).data('value')) {
					$('#' + vCVals.n).remove();
				}

				$(this).css({
					'position': 'relative',
					'left': 'auto',
					'top': 'auto'
				} );
			} else {
				if ($('#' + vCVals.n).length) {
					return false;
				}
				var validElement = '<input type="hidden" name="' + vCVals.n + '" id="' + vCVals.n + '" readonly="readonly" value="' + $(this).data('value') + '" />';
				$('#' + vCVals.f).append(validElement);

				var xPos2Go = Math.round(xPos + (wDim/2) - (iwDim/2));
				var yPos2Go = Math.round(yPos + (hDim/2) - (ihDim/2));

				$(this).css( {
					'position': 'absolute',
					'left': xPos2Go,
					'top': yPos2Go
				} );
			}
		} );
	}
});