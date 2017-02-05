<?php

class CoasController extends Controller{

    public function __construct($data = array()){
        parent::__construct($data);
        $this->model = new Coa();
    }

    public function index(){
        $this->data['coas'] = $this->model->getList();
    }

    public function view(){
        $params = App::getRouter()->getParams();

        if ( isset($params[0]) ){
            $id = strtolower($params[0]);
            //print_r($params[0]);
            $this->data['coa'] = $this->model->getById($id);
        }
    }

    public function lookup(){
        $params = App::getRouter()->getParams();

        if ( isset($params[0]) ){
            $id = strtolower($params[0]);
            //print_r($params[0]);
            $this->data['acctype'] = $this->model->getByAccountTypeId($id);
        }
    }

    public function add(){
        //getByAccountTypeId
        if ( $_POST ){
            $result = $this->model->save($_POST);
            if ( $result ){
                Session::setFlash('User data has been insert successfully.');
            } else {
                Session::setFlash('Some problem occurred, please try again.');
            }
            Router::redirect(Config::get('url_path').'coas/');
        }
    }

    public function edit(){
        if ( $_POST ){
            $id = isset($_POST['id']) ? $_POST['id'] : null;
            $result = $this->model->save($_POST, $id);
            if ( $result ){
                Session::setFlash('User data has been update successfully.');
            } else {
                Session::setFlash('Some problem occurred, please try again.');
            }
            Router::redirect(Config::get('url_path').'coas/');
        }

        if ( isset($this->params[0]) ){
            $this->data['coa'] = $this->model->getById($this->params[0]);
        } else {
            Session::setFlash('Wrong page id.');
            Router::redirect(Config::get('url_path').'coas/');
        }
    }

    public function delete(){
        if ( isset($this->params[0]) ){
            $result = $this->model->delete($this->params[0]);
            if ( $result ){
                Session::setFlash('Page was deleted.');
            } else {
                Session::setFlash('Error.');
            }
        }
        Router::redirect(Config::get('url_path').'coas/');
    }

}