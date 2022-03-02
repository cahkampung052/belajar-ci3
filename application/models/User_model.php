<?php

class User_model extends CI_Model
{
    public function __construct()
    {
        $this->load->database();
    }
    
    /**
     * Method validasi username dan password untuk login
     *
     * @param  string $email
     * @param  string $password
     * 
     * @return object
     */
    public function auth($email, $password)
    {
        $query = $this->db
                    ->select('id, email, nama')
                    ->from('m_user')
                    ->where('email', $email)
                    ->where('password', sha1($password))
                    ->get();

        return $query->first_row();
    }

    /**
     * Mengambil semua data user dengan parameter nama dan email
     *
     * @param  string $nama parameter ini bisa dikosongi
     * @param  string $email parameter ini bisa dikosongi
     * 
     * @return object
     */
    public function getAllUser($nama = '', $email = '') {
        $query = $this->db
                    ->select('id, email, nama')
                    ->from('m_user');
        
        if(!empty($nama)) {
            $query->like('nama', $nama);
        }

        if(!empty($email)) {
            $query->like('email', $email);
        }

        return $query->get()->result();
    }

    /**
     * Ambil data user berdasarkan id
     *
     * @param  int $id
     * @return object
     */
    public function getById($id) {
        $query = $this->db
                    ->select('*')
                    ->from('m_user')
                    ->where('id', $id)
                    ->get();
        
        return $query->first_row();
    }

    /**
     * Input data user
     *
     * @param  array $data
     * $data['nama']
     * $data['email']
     * $data['password']
     * 
     * @return array
     */
    public function create($data) {
        try {
            $this->db->insert('m_user', $data);
            $getId = $this->db->insert_id();
            
            return [
                'status' => true,
                'data' => $this->getById($getId),
            ];
        } catch (\Throwable $th) {
            return [
                'status' => false,
                'error' => $th->getMessage()
            ];
        }
    }

    /**
     * Update data user
     *
     * @param  array $data
     * $data['id']
     * $data['nama']
     * $data['email']
     * $data['password']
     * 
     * @return array
     */
    public function update($data) {
        try {
            $this->db->where('id', $data['id']);
            $this->db->update('m_user', $data);
            
            return [
                'status' => true,
                'data' => $this->getById($data['id']),
            ];
        } catch (\Throwable $th) {
            return [
                'status' => false,
                'error' => $th->getMessage()
            ];
        }
    }

    /**
     * Hapus data user
     *
     * @param int $id
     * 
     * @return array
     */
    public function delete($id) {
        try {
            $this->db->where('id', $id);
            $this->db->delete('m_user');
            
            return [
                'status' => true,
                'data' => [],
            ];
        } catch (\Throwable $th) {
            return [
                'status' => false,
                'error' => $th->getMessage()
            ];
        }
    }
}
