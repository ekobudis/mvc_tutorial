<?php

class Coa extends Model{

    protected $table_name = 'list_akun';
    
    public function getList(){
        $rows = $this->db->getRows($this->table_name,array('order_by'=>'id ASC'));
        return $rows;
    }
    
    public function getById($id){
        $id = (int)$id;
        $result = $this->db->getRows($this->table_name,array('where'=>array('id'=>$id),'return_type'=>'single'));
        return isset($result) ? $result : null;
    }
    
    public function getByAccountTypeId($id){
        $id = (int)$id;
        $result = $this->db->getRows($this->table_name,array('where'=>array('acc_type'=>$id),'return_type'=>'single'));
        return isset($result) ? $result : null;
    }

    /**
     * @param $data
     * @param null $id
     * @return bool
     */
    public function save($data, $id = null){
        if ( !isset($data['account_no']) || !isset($data['account_name']) || !isset($data['account_type']) ){
            return false;
        }

        $id = (int)$id;
        $acc_no = $this->db->escape($data['account_no']);
        $acc_name = $this->db->escape($data['account_name']);
        $acc_type = $this->db->escape($data['account_type']);
        $sub_acc = $this->db->escape($data['account_group']);
        $curr_pk = $this->db->escape($data['account_curr']);

        $user_pk = Session::get('login');
        $comp_pk = Session::get('comp_id');

        if ( !$id ){ // Add new record
            $data_array = array(
                'acc_no'=> $acc_no,
                'acc_name' => $acc_name,
                'sub_acc_no' => $sub_acc,
                'acc_type' => $acc_type,
                'curr_pk' => $curr_pk,
                'comp_pk' => $comp_pk,
                'user_pk' => $user_pk
            );

            return $this->db->insert($this->table_name,$data_array);

        } else { // Update existing record
            $data_array = array(
                'acc_no'=> $acc_no,
                'acc_name' => $acc_name,
                'sub_acc_no' => $sub_acc,
                'acc_type' => $acc_type,
                'curr_pk' => $curr_pk
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