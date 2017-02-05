<?php

class CurrencysController extends Controller{

    public function __construct($data = array()){
        parent::__construct($data);
        $this->model = new Currency();
    }

    public function index(){
        $this->data['currencys'] = $this->model->getList();
    }

    public function view(){
        $params = App::getRouter()->getParams();

        if ( isset($params[0]) ){
            $id = strtolower($params[0]);
            //print_r($params[0]);
            $this->data['currency'] = $this->model->getById($id);
        }
    }

    public function add(){
        if ( $_POST ){
            $result = $this->model->save($_POST);
            if ( $result ){
                Session::setFlash('User data has been inserted successfully.');
            } else {
                Session::setFlash('Some problem occurred, please try again.');
            }
            Router::redirect(Config::get('url_path').'currencys/');
        }
    }

    public function edit(){

        if ( $_POST ){
            $id = isset($_POST['id']) ? $_POST['id'] : null;
            $result = $this->model->save($_POST, $id);
            if ( $result ){
                Session::setFlash('Page was saved.');
            } else {
                Session::setFlash('Error.');
            }
            Router::redirect(Config::get('url_path').'currencys/');
        }

        if ( isset($this->params[0]) ){
            $this->data['currency'] = $this->model->getById($this->params[0]);
        } else {
            Session::setFlash('Wrong page id.');
            Router::redirect(Config::get('url_path').'currencys/');
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
        Router::redirect(Config::get('url_path').'currencys/');
    }

}