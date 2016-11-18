<?php
/**
 * TODO finish contact us form
 */

class ContactController extends Controller{

    public function __construct($data = array())
    {
        parent::__construct($data);
        $this->model = new Message();
    }

    public function index()
    {
        if ($_POST) {
            if ($this->model->save($_POST)) {
                Session::setFlash('Thank you! Your message was sent successfully!');
            } else {
                Session::setFlash('There is some problems');
            }
        }
    }

    public function admin_index()
    {
        $this->data = $this->model->getList();
    }
}