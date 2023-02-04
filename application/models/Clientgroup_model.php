<?php
/**
 * Geo POS -  Accounting,  Invoicing  and CRM Application
 * Copyright (c) Rajesh Dukiya. All Rights Reserved
 * ***********************************************************************
 *
 *  Email: support@ultimatekode.com
 *  Website: https://www.ultimatekode.com
 *
 *  ************************************************************************
 *  * This software is furnished under a license and may be used and copied
 *  * only  in  accordance  with  the  terms  of such  license and with the
 *  * inclusion of the above copyright notice.
 *  * If you Purchased from Codecanyon, Please read the full License from
 *  * here- http://codecanyon.net/licenses/standard/
 * ***********************************************************************
 */

defined('BASEPATH') OR exit('No direct script access allowed');

class Clientgroup_model extends CI_Model
{


    public function details($id)
    {

        $this->db->select('*');
        $this->db->from('geopos_cust_group');
        $this->db->where('id', $id);
        $query = $this->db->get();
        return $query->row_array();
    }

    public function recipients($id)
    {

        $this->db->select('id,name,email');
        $this->db->from('geopos_customers');
        $this->db->where('gid', $id);
        $query = $this->db->get();
        return $query->result_array();
    }


    public function add($group_name, $group_desc)
    {
        $data = array(
            'title' => $group_name,
            'summary' => $group_desc
        );

        if ($this->db->insert('geopos_cust_group', $data)) {
            $this->aauth->applog("[Group Created] $group_name ID " . $this->db->insert_id(), $this->aauth->get_user()->username);
            echo json_encode(array('status' => 'Success', 'message' =>
                $this->lang->line('ADDED')));
        } else {
            echo json_encode(array('status' => 'Error', 'message' =>
                $this->lang->line('ERROR')));
        }

    }


    public function editgroupupdate($gid, $group_name, $group_desc)
    {
        $data = array(
            'title' => $group_name,
            'summary' => $group_desc
        );


        $this->db->set($data);
        $this->db->where('id', $gid);

        if ($this->db->update('geopos_cust_group')) {
            $this->aauth->applog("[Group updated] $group_name ID " . $gid, $this->aauth->get_user()->username);
            echo json_encode(array('status' => 'Success', 'message' =>
                $this->lang->line('UPDATED')));
        } else {
            echo json_encode(array('status' => 'Error', 'message' =>
                $this->lang->line('ERROR')));
        }

    }

    public function editgroupdiscountupdate($gid, $disc_rate)
    {
        $data = array(
            'disc_rate' => $disc_rate
        );
        $this->db->set($data);
        $this->db->where('id', $gid);

        if ($this->db->update('geopos_cust_group')) {

            $data = array(
                'discount_c' => $disc_rate
            );
            $this->db->set($data);
            $this->db->where('gid', $gid);
            $this->db->update('geopos_customers');

            $this->aauth->applog("[Group discount updated] %" . $disc_rate . " GID-" . $gid, $this->aauth->get_user()->username);
            echo json_encode(array('status' => 'Success', 'message' =>
                $this->lang->line('UPDATED')));
        } else {
            echo json_encode(array('status' => 'Error', 'message' =>
                $this->lang->line('ERROR')));
        }

    }
}