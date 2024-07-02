<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Note extends CI_Model
{
    protected $table = 'notes';
    public function __construct()
    {
        parent::__construct();
    }
    public function getAll($limit = null, $offset = null)
    {
        $this->db->order_by('created_at', 'DESC');
        if ($limit !== null && $offset !== null) {
            $query = $this->db->get($this->table, $limit, $offset);
        } else {
            $query = $this->db->get($this->table);
        }
        return $query->result();
    }
    function get($id)
    {
        $this->db->get_where($this->table, array('id' => $id));
    }
    function add($data)
    {
        $query = $this->db->insert($this->table, $data);
        return $query;
    }
    function update($data)
    {
        $this->db->where('id', $data['id']);
        unset($data['id']);
        $query = $this->db->update('notes', $data);
        return $query;
    }
    function delete($id)
    {
        $this->db->where('id', $id);
        $query = $this->db->delete('notes');
        return $query;
    }
}

/* End of file ModelName.php */


