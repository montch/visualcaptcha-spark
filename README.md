# VisualCaptcha Spark

## A drag and drop alternative to the traditional text based Captcha

This is a Spark version of the Captcha alternative from [http://visualcaptcha.net](http://visualcaptcha.net "http://visualcaptcha.net")

VisualCaptcha is the easiest to implement secure Captcha with images instead of text and drag & drop capabilities (and mobile-friendly).

- A better alternative to text based Captchas. 
- Decrease user frustration and improve conversion rates.
- Server side validation.
- Easy to style and add custom images.
- Easily translated text.
- Can be used in Views and Controllers.


![VisualCaptcha Spark](http://dl.dropbox.com/u/20041435/spark_vc.png)

## Installation


1. Install Spark
2. Copy, link or move the files in `spark/visualcaptcha/*version*/views/images/` to your publicly available images directory in your Codeigniter install. 
 - **Note**: \*version\* will be the version of the Spark you installed, something like `1.0.0`
3. Update `spark/visualcaptcha/*version*/config/visualcaptcha.php`
- Set the `$config["public_image_path"]` variable to the path of your  publicly available images directory. *(the same directory you moved the files to in step 2)*

		> example:

		> $config["public\_image\_path"] = site_url('assets/img/icons/vc/');

4.  You are good to go using the default settings. Feel free to look in the config and the code for other settings, as well as use your own images or css for the display.

### Note
 - Jquery and JqueryUI are required for this Spark to work. There is a config option to allow visualcaptcha to download both jQuery and jQueryUI if they have not already been loaded by your View.
 

## Usage

##### To display the Captcha:

Load the Spark in your View and call:
    
	$visualCaptcha = new visualcaptcha($formId, $type);
	$visualCaptcha->show();

	where:
		$formId is the id/name of your form. 
		$type is 'h' for a horizontal layout or 'v' for the vertical layout.



##### To validate the response of the Captcha:

Load the Spark in your Controller and call:

	$visualCaptcha = new visualcaptcha($formId, $type);
	$visualCaptcha->isValid();  // returns bool

	where:
		$formId is the id/name of your form. 
		$type is 'h' for a horizontal layout or 'v' for the vertical layout.

## Example

##### Display:
	$this->load->spark('visualcaptcha/0.0.1');
	$visualCaptcha = new visualcaptcha("login_form", "v");
	$visualCaptcha->show();

##### Validate:
	$this->load->spark('visualcaptcha/0.0.1');
	$visualCaptcha = new visualcaptcha("login_form", "v");
	$vc_passed = $visualCaptcha->isValid();

## Changes:

- VisualCaptcha by **emotionLoop** [http://visualcaptcha.net](http://visualcaptcha.net "http://visualcaptcha.net")
- visualcaptcha-spark by **Mark Montroy** [https://github.com/montch/visualcaptcha-spark](https://github.com/montch/visualcaptcha-spark "https://github.com/montch/visualcaptcha-spark") email: montch@gmail.com

Changes made from the original VisualCaptcha in visualcaptcha-spark.0.0.1

-	Broke original file structure up to be Spark compliant
-   File and source changes:

	`config/visualcaptcha.php`
	-	Added image path as an option since loading assets inside a Spark is cumbersome w/out using a cdn
	-	Added jQueryUI as a config option to avoid double loading (and to remind anyone that jQueryUI is required)
	-	Added the wrapper option to show a basic styled div as a holder, also allows anyone to easily restyle the holder

	`libraries/visualcaptcha.php`
	-	Added $uiOptions and $wrapperCss as properties of the main visualcaptcha class
	-	Added the core Codeigniter reference as $CI
	-	Changed constructor to pull options from the config in CI style
	-	Added 'h' and 'v' (technically its 'h' and any non-'h') as optional formats for the $type. 'h' and 'v' were easier for me to remember as horizontal and vertical.
	-	Update image paths to pull from the path in the config
	-	Update images to ones I felt 'popped' more, still used iconSweets, just another release.
	-	Switched session storage to CI sessions

	`views/css`
	-	Added a new more compact style for the vertical layout

	`views/js`
	-	Changed the packed visualcaptcha.js to be Dwoo complaint (at least to my version of Dwoo). This is just spacing changes, no code was changed.

	`views/visualcaptcha.class.html.php`

	-	Added a switch for the wrapper css styles for vertical and horizontal
	-	Added a check for jQuery, no need to load it twice if it is already defined.
	-	Changed style sheets to be an include instead of a rel link. This isnt ideal but its the best way I could find to do it inside of a Spark (outside of a cdn)
	-	Added a layout switch for the include_wrapper_ui config value
	-	Updated dropzone image, had to pull it out of the css in order to access the path config variable

