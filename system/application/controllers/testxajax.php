<?php
class Testxajax extends Controller {

    function Testxajax() {
        parent::controller();
        $this->xajax->registerFunction(array('test_function',&$this,'test_function'));
        $this->xajax->processRequest();
    }

    function test_function($number) {
        $objResponse = new xajaxResponse();
        $objResponse->Assign("SomeElementId","innerHTML", "Xajax is working. Lets add: ".($number+3));
        return $objResponse;
    }
    function index() {
        $template['xajax_js'] = $this->xajax->getJavascript(base_url());

        //$template['content'] = '<div id="SomeElementId"></div><input type="button" value="test" onclick="xajax_test_function(2);">';

        $this->load->view('template/index', $template);

    }


}
?>