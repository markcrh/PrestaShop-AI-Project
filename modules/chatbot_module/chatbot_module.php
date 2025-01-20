<?php
if(!defined('_PS_VERSION_')){
    exit;
}
class Chatbot_Module extends Module {

    public function __construct() {
        $this->name = "chatbot_module";
        $this->version = '1.0.0';
        $this->author = 'RebootAcademy';
        $this->need_instance = 0;
        $this->bootstrap = true;
        $this->displayName = $this->l('Chatbot');
        $this->description = $this->l('Chatbot Module');
        parent::__construct();
    }

    public function install()
    {
        return parent::install()
            && $this->registerHook('displayHome');
    }

    public function uninstall()
    {
        if (!parent::uninstall() || !Configuration::deleteByName('NEW_MODULE_CONFIG')) {
            return false;
        }
        return true;
    }

    public function hookDisplayHome($params)
    {
        $url='https://api.spoonacular.com/food/ingredients/9266/information?apiKey=f81e18bd218a47d990c2acffac028a49';
        $response=$this->makeApiCall($url);
        $this->context->controller->addCSS($this->_path.'views/css/chatbot_module.css');
        $this->context->smarty->assign([
            'message' => $response,
        ]);
        return $this->display(__FILE__, '/views/templates/hook/displayHome.tpl');
        //abc
    }

    private function makeApiCall($url)
    {
        $curl = curl_init();

        curl_setopt_array($curl, [
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_TIMEOUT => 30,
//            CURLOPT_HTTPHEADER => [
//                'Content-Type: application/json',
//                'Authorization: Bearer f81e18bd218a47d990c2acffac028a49'
//            ],
        ]);

        $response = curl_exec($curl);
        $err = curl_error($curl);
        curl_close($curl);

        if ($err) {
            return 'Curl Error: ' . $err;
        } else {
            return json_decode($response, true); // Decode JSON for easy debugging
        }
    }
}
