<?php

/**
 * visualCaptchaHTML class by emotionLoop - 2012.04.26
 *
 * This class handles the HTML for the main visualCaptcha class.
 *
 * This license applies to this file and others without reference to any other license.
 *
 * @author emotionLoop | http://emotionloop.com
 * @link http://visualcaptcha.net
 * @package visualCaptcha
 * @license CC BY-SA 3.0 | http://creativecommons.org/licenses/by-sa/3.0/
 * @version 3.0
 */
class visualCaptchaHTML
{

    public function __construct()
    {
        
    }

    public static function get($type, $fieldName, $formId, $captchaText, $options, $optionsProperties, $jsFile, $cssFile, $wrapperCss, $uiOptions)
    {
        $html = '';
        $limit = count($options);
        $wrapperId = "wrapper";
        if ($type === 1) {
            $wrapperId = "wrapper-type-1";
        }

        ob_start();
        ?>


        <?php
        if (!empty($uiOptions["include_jqueryui"]) && $uiOptions["include_jqueryui"] === true) {
            ?>
            <script src="http://www.google.com/jsapi"></script>
            <script>
                // if jQuery is already defined, we dont need to reload it
                if (typeof jQuery == 'undefined') {  
                    google.load("jquery", "1.7");
                }
                google.load("jqueryui", "1.8");
            </script>
            <?php
        }
        ?>

        <script>
            var vCVals = {
                'f': '<?php echo $formId; ?>',
                'n': '<?php echo $fieldName; ?>'
            };
        </script>
        <script defer="defer">
        <?php include( $jsFile ); ?>
        </script>

        <style type="text/css" media="screen">
        <?php include( $cssFile ); ?>
        </style>


        <?php
        if (!empty($uiOptions["include_wrapper_UI"]) && $uiOptions["include_wrapper_UI"] === true) {
            ?>

            <style type="text/css" media="screen">
            <?php include( $wrapperCss ); ?>
            </style>

            <div id="<?php echo $wrapperId; ?>">
                <div id="content">

        <?php
        }
        ?>


                <div class="eL-captcha type-<?php echo $type; ?>">
                    <p><?php echo 'Drag the'; ?> <strong><?php echo $captchaText; ?></strong> <?php echo 'to the circle on the side'; ?>.</p>
                    <div class="eL-possibilities type-<?php echo $type; ?>">
                        <?php
                        for ($i = 0; $i < $limit; $i++)
                        {
                            $name = $options[$i];
                            $image = $optionsProperties[$name][0];
                            $text = $optionsProperties[$name][1];
                            ?>
                            <img src="<?php echo $image; ?>" class="vc-<?php echo $name; ?>" data-value="<?php echo $name; ?>" alt="" title="" />
                            <?php
                        }
                        ?>
                        <div class="clear"></div>
                    </div>
                    <div class="eL-where2go type-<?php echo $type; ?>"
                         style="background: transparent url('<?php echo $uiOptions["imgPath"] . "/dropzone2.png"; ?>') center center no-repeat;"
                         >
                        <div class="clear"></div>
                    </div>
                    <div class="clear"></div>
                </div>
                <div class="clear"></div>

                <?php
                if (!empty($uiOptions["include_wrapper_UI"]) && $uiOptions["include_wrapper_UI"] === true) {
                    ?>
                </div>
            </div>
            <?php
        }
        ?>






        <?php
        $html = ob_get_clean();
        return $html;
    }

}
?>


