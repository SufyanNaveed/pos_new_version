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

class Locations_model extends CI_Model
{


    public function locations_list()
    {
        $query = $this->db->query("SELECT * FROM geopos_locations ORDER BY id DESC");
        return $query->result_array();
    }

    public function locations_list2()
    {
        $where = '';
        if ($this->aauth->get_user()->loc) $where = 'WHERE id=' . $this->aauth->get_user()->loc . '';
        $query = $this->db->query("SELECT * FROM geopos_locations $where ORDER BY id DESC");
        return $query->result_array();
    }


    public function view($id)
    {

        $this->db->from('geopos_locations');
        $this->db->where('id', $id);
        $query = $this->db->get();
        $result = $query->row_array();
        return $result;
    }

    public function create($name, $address, $city, $region, $country, $postbox, $phone, $email, $taxid, $image, $cur_id, $ac_id, $wid)
    {
        $data = array(
            'cname' => $name,
            'address' => $address,
            'city' => $city,
            'region' => $region,
            'country' => $country,
            'postbox' => $postbox,
            'phone' => $phone,
            'email' => $email,
            'taxid' => $taxid,
            'logo' => $image,
            'ext' => $ac_id,
            'cur' => $cur_id,
            'ware' => $wid
        );

        if ($this->db->insert('geopos_locations', $data)) {
            echo json_encode(array('status' => 'Success', 'message' =>
                $this->lang->line('ADDED')));
        } else {
            echo json_encode(array('status' => 'Error', 'message' =>
                $this->lang->line('ERROR')));
        }

    }

    public function edit($id, $name, $address, $city, $region, $country, $postbox, $phone, $email, $taxid, $image, $cur_id, $ac_id, $wid)
    {
        $data = array(
            'cname' => $name,
            'address' => $address,
            'city' => $city,
            'region' => $region,
            'country' => $country,
            'postbox' => $postbox,
            'phone' => $phone,
            'email' => $email,
            'taxid' => $taxid,
            'logo' => $image,
            'ext' => $ac_id,
            'cur' => $cur_id,
            'ware' => $wid
        );

        $this->db->set($data);
        $this->db->where('id', $id);

        if ($this->db->update('geopos_locations')) {
            echo json_encode(array('status' => 'Success', 'message' =>
                $this->lang->line('UPDATED')));
        } else {
            echo json_encode(array('status' => 'Error', 'message' =>
                $this->lang->line('ERROR')));
        }

    }

    public function currencies()
    {

        $this->db->select('*');
        $this->db->from('geopos_currencies');

        $query = $this->db->get();
        return $query->result_array();

    }

    public function currency_d($id)
    {
        $this->db->select('*');
        $this->db->from('geopos_currencies');
        $this->db->where('id', $id);
        $query = $this->db->get();
        return $query->row_array();
    }

    public function accountslist()
    {
        $this->db->select('*');
        $this->db->from('geopos_accounts');

        if ($this->aauth->get_user()->loc) {
            $this->db->where('loc', $this->aauth->get_user()->loc);
            $this->db->or_where('loc', 0);
        }

        $query = $this->db->get();
        return $query->result_array();
    }

    public function online_pay_settings($id)
    {

        $this->db->select('geopos_accounts.id,geopos_accounts.holder,');
        $this->db->from('geopos_locations');
        $this->db->where('geopos_locations.id', $id);
        $this->db->join('geopos_accounts', 'geopos_locations.ext = geopos_accounts.id', 'left');
        $query = $this->db->get();
        return $query->row_array();

    }

    public function warehouses()
    {
        $this->db->select('*');
        $this->db->from('geopos_warehouse');
        if ($this->aauth->get_user()->loc) {
            $this->db->where('loc', $this->aauth->get_user()->loc);
        } elseif (!BDATA) {
            $this->db->where('loc', 0);
        }
        $query = $this->db->get();
        return $query->result_array();
    }


}