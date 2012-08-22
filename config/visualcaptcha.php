<?php

# --------------------------------------------------------------------
# -- NOTE: jQuery AND jQueryUI are required for VisualCaptcha to work!
# --------------------------------------------------------------------

# -- Set your Image path --
# the full path to your publicly available images directory
# this is where the images for visualcaptcha will live 
$config["public_image_path"] = site_url('assets/img/icons/vc/');

# Include jQueryUI?
#	true will include a reference to jQueryUI via http://www.google.com/jsapi
#	false will omit the jQueryUI reference - you should only set this to false if your page has already loaded jQueryUI
$config['include_jqueryui'] = true;

# Show the wrapper UI for VisualCaptcha?
#	true will include the gray box UI styling
#	false will include only the core styling needed for VisualCaptcha
$config['include_wrapper_UI'] = true;
?>