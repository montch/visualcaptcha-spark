<?php

/**
 * visualCaptchaHTML class by emotionLoop - 2012.04.26
 *
 * This class handles a visual image captcha system.
 *
 * This license applies to this file and others without reference to any other license.
 *
 * @author emotionLoop | http://emotionloop.com
 * @link http://visualcaptcha.net
 * @package visualCaptcha
 * @license CC BY-SA 3.0 | http://creativecommons.org/licenses/by-sa/3.0/
 * @version 3.0
 */
class visualcaptcha
{

//load config options
    public $CI;
    private $include_jqueryui = true;
    private $include_wrapper_UI = true;
    private $formId = 'frm_captcha';
    private $type = 0;
    private $fieldName = 'captcha-value';
    private $js = '';
    private $css = '';
    private $html = '';
    private $hash = '';
    private $answers = array();
    private $uiOptions = array("include_wrapper_UI" => true, "include_jqueryui" => true);
    private $options = array();
    private $optionsProperties = array();
    private $value = '';
    private $valueProperties = array();
    private $jsFile = 'js/visualcaptcha.js';
    private $cssFile = 'css/visualcaptcha.css';
    private $htmlClass = 'views/visualcaptcha.class.html.php';
    private $wrapperCss = 'css/sample.css';

    public function __construct($formId = NULL, $type = NULL, $fieldName = NULL)
    {
        // pull the UI options from the config
        $this->CI = &get_instance();
        $this->include_jqueryui = $this->CI->config->item('include_jqueryui');
        $this->include_wrapper_UI = $this->CI->config->item('include_wrapper_UI');
        $this->uiOptions = array("include_wrapper_UI" => $this->include_wrapper_UI, "include_jqueryui" => $this->include_jqueryui);

        $this->hash = sha1('emotionLoop::' . $_SERVER['REMOTE_ADDR'] . '::captcha::' . $this->nonceTick(1800) . '::tick');

        if (!is_null($formId)) {
            $this->formId = $formId;
        }
        if (!is_null($type)) {
            if (is_numeric($type)) {
                $this->type = (int) $type;
            } else {
                if ($type == "h") {
                    $this->type = 0;
                } else {
                    $this->type = 1;
                }
            }
        } else {
            $this->type = 0;
        }
        if (!is_null($fieldName)) {
            $this->fieldName = $fieldName;
        }

//-- Setup Image Names here: stringID, array(ImagePath, ImageName/Text to show)
        $imgPath = $this->CI->config->item('public_image_path');
        $this->uiOptions["imgPath"] = $imgPath;
        $this->answers = array(
            'clock' => array($imgPath . '/clock.png', 'Clock'),
            'airplane' => array($imgPath . '/airplane.png', 'Airplane'),
            'cat' => array($imgPath . '/cat.png', 'Cat'),
            'leaf' => array($imgPath . '/leaf.png', 'Leaf'),
            'lightbulb' => array($imgPath . '/lightbulb.png', 'Lightbulb'),
            'purse' => array($imgPath . '/purse.png', 'Purse'),
            'socks' => array($imgPath . '/socks.png', 'Socks'),
            'truck' => array($imgPath . '/truck.png', 'Truck'),
            'umbrella' => array($imgPath . '/umbrella.png', 'Umbrella'),
            'scissors' => array($imgPath . '/scissors.png', 'Scissors')
        );
    }

    public function show()
    {
        $this->setNewValue();

        shuffle($this->options);

//-- Include visualCaptchaHTML class
        $this->CI->load->view('visualcaptcha.class.html.php', array(), true);
        $this->html = visualCaptchaHTML::get($this->type, $this->fieldName, $this->formId, $this->getText(), $this->options, $this->optionsProperties, $this->jsFile, $this->cssFile, $this->wrapperCss, $this->uiOptions);

        echo $this->html;
    }

    public function isValid()
    {
        $this->CI->load->library('session');
        $ses_answer = $this->CI->session->userdata("hash");
        if (isset($_POST[$this->fieldName]) && isset($ses_answer) && ($_POST[$this->fieldName] == $ses_answer)) {
            return true;
        }
        return false;
    }

    private function setNewValue()
    {
        $this->CI->load->library('session');

        $this->answers = $this->shuffle($this->answers);
        $i = 0;
        switch ($this->type)
        {
            case 0://-- Horizontal
                $limit = 5;
                break;
            case 1://-- Vertical
                $limit = 4;
                break;
        }

        $rnd = rand(0, $limit - 1);

        foreach ($this->answers as $answer => $answer_props)
        {
            if ($i >= $limit)
                continue;
            $this->options[] = $answer;
            $this->optionsProperties[$answer] = $answer_props;
            if ($i == $rnd) {
                $ses = array("hash" => $answer);
                $this->CI->session->set_userdata($ses);
                $this->value = $answer;
                $this->valueProperties = $answer_props;
            }
            ++$i;
        }
    }

    private function getValue()
    {
        return $this->value;
    }

    private function getImage()
    {
        return $this->valueProperties[0];
    }

    private function getText()
    {
        return $this->valueProperties[1];
    }

    /**
     * Get the time-dependent variable for nonce creation.
     *
     * This function is based on Wordpress' wp_nonce_tick().
     *
     * @since 1.1
     *
     * @return int
     */
    private function nonceTick($life = 86400)
    {
        return ceil(time() / $life);
    }

    /**
     * Private shuffle() method. Shuffles an associative array. If $list is not an array, it returns $list without any modification.
     *
     * @since 1.1
     *
     * @param $list Array to shuffle.
     *
     * @return $random Array shuffled array.
     */
    private function shuffle($list)
    {
        if (!is_array($list))
            return $list;
        $keys = array_keys($list);
        shuffle($keys);
        $random = array();

        foreach ($keys as $key)
        {
            $random[$key] = $list[$key];
        }

        return $random;
    }

}

?>