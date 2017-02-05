<?php

class Currency extends Model{

    protected $table_name = 'm_currency';

    public function getList(){
        $rows = $this->db->getRows($this->table_name,array('order_by'=>'id DESC'));
        return $rows;
    }

    public function getById($id){
        $id = (int)$id;
        $result = $this->db->getRows($this->table_name,array('where'=>array('id'=>$id),'return_type'=>'single'));
        return isset($result) ? $result : null;
    }

    /**
     * @param $data
     * @param null $id
     * @return bool
     */
    public function save($data, $id = null){
        if ( !isset($data['curr_id']) || !isset($data['curr_name']) || !isset($data['curr_rate']) || !isset($data['curr_symbol'])){
            return false;
        }

        $id = (int)$id;
        $curr_id = $this->db->escape($data['curr_id']);
        $curr_name = $this->db->escape($data['curr_name']);
        $curr_rate = $this->db->escape($data['curr_rate']);
        $curr_symbol = $this->db->escape($data['curr_symbol']);

        $user_pk = Session::get('login');
        $comp_pk = Session::get('comp_id');

        if ( !$id ){ // Add new record
            $data_array = array(
                'curr_id'=> $curr_id,
                'curr_name' => $curr_name,
                'curr_rate' => $curr_rate,
                'curr_symbol' => $curr_symbol,
                'comp_pk' => $comp_pk,
                'user_pk' => $user_pk
            );

            return $this->db->insert($this->table_name,$data_array);

        } else { // Update existing record
            $data_array = array(
                'curr_id'=> $curr_id,
                'curr_name' => $curr_name,
                'curr_rate' => $curr_rate,
                'curr_symbol' => $curr_symbol
            );

            $condition = array('id' => $id);
            return $this->db->update($this->table_name,$data_array,$condition);
        }

    }

    public function delete($id){
        $id = (int)$id;
        $condition = array('id' => $id);

        return $this->db->delete($this->table_name, $condition);

    }

}