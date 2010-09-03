<?php
/**
 * This is the Controller for the Blog OpenBama page.
 *
 */
class Blog extends Controller {

    /**
     * This is method Blog
     *
     * @return mixed This is the return value description
     *
     */
    function Blog() {
        parent::Controller();

    }

    /**
     * This is method index
     *
     * @return void This is the return value description
     *
     */
    function index() {

        header("Location: http://blog.openbama.org");
    }
}