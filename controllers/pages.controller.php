<?php
/**
 * Created by PhpStorm.
 * User: ADAM
 * Date: 05.10.2016
 * Time: 16:12
 */

class PagesController extends Controller {
    
    public function __construct($data = array())
    {
        parent::__construct($data);
        $this->model = new Page();
    }

    public function index() {
        $this->data['pages'] = $this->model->getList();
    }

    public function view() {
        $params = App::getRouter()->getParams();

        if (isset($params[0])) {
            $alias = strtolower($params[0]);

            $this->data['page'] = $this->model->getByAlias($alias);
        }
    }

    public function admin_index() {
        $this->data['pages'] = $this->model->getList();
    }
    
    public function admin_edit() {
        if($_POST) {
            $id = isset($_POST['id']) ? $_POST['id'] : null;
            echo "<pre>";
            print_r($_POST);
            die;
            $result = $this->model->save($_POST, $id);
            if ($result) {
                Session::setFlash('Page was saved.');
            } else {
                Session::setFlash('Page was not saved. Error.');
            }
            Router::redirect('/Academy/Test/Devionity_mvc/admin/pages/');
        }

        if (isset($this->params[0])) {
            $this->data['pages'] = $this->model->getById($this->params[0]);
        } else {
            Session::setFlash('Wrong page id.');
            Router::redirect('/Academy/Test/Devionity_mvc/admin/pages/');
        }
    }

    public function admin_add() {
        if($_POST) {
            $result = $this->model->save($_POST);
            if ($result) {
                Session::setFlash('Page was saved.');
            } else {
                Session::setFlash('Page was not saved. Error.');
            }
            Router::redirect('/Academy/Test/Devionity_mvc/admin/pages/');
        }
    }

    public function admin_delete() {
        if (isset($this->params[0])) {
            $result = $this->model->delete($this->params[0]);
            if ($result) {
                Session::setFlash('Page was deleted.');
            } else {
                Session::setFlash('Page was not deleted. Error.');
            }
            Router::redirect('/Academy/Test/Devionity_mvc/admin/pages/');
        }
    }
    
}