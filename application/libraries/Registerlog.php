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


if (!defined('BASEPATH')) exit('No direct script access allowed');


class Registerlog
{
    public $RI;

    public function __construct()
    {
        // get main CI object
        $this->RI = &get_instance();
    }

    public function check($id)
    {
        $this->RI->db->from('geopos_register');
        $this->RI->db->where('uid', $id);
        $this->RI->db->where('active', 1);
        $query = $this->RI->db->get();
        $result = $query->row_array();
        if ($result) {
            return $result;
        } else {
            return false;
        }

    }

    public function view($id)
    {
        $this->RI->db->from('geopos_register');
        $this->RI->db->where('geopos_register.id', $id);
              $this->RI->db->join('geopos_users', 'geopos_register.uid=geopos_users.id', 'left');
            if ($this->RI->aauth->get_user()->loc) {
            $this->RI->db->group_start();
            $this->RI->db->where('geopos_users.loc', $this->RI->aauth->get_user()->loc);
            if (BDATA) $this->RI->db->or_where('geopos_users.loc', 0);
            $this->RI->db->group_end();
        } elseif (!BDATA) {
            $this->RI->db->where('geopos_users.loc', 0);
        }
        $query = $this->RI->db->get();
        $result = $query->row_array();
        if ($result) {
            return $result;
        } else {
            return false;
        }

    }


    public function create($id, $cash, $card, $bank, $cheque)
    {
        $data = array(
            'uid' => $id,
            'o_date' => date('Y-m-d H:i:s'),
            'cash' => $cash,
            'card' => $card,
            'bank' => $bank,
            'cheque' => $cheque,
            'active'=>1
        );
        return $this->RI->db->insert('geopos_register', $data);
    }

    public function update($id, $cash = 0,  $card = 0, $bank = 0, $cheque = 0,$change = 0)
    {

        $this->RI->db->set('cash', "cash+$cash", FALSE);
        $this->RI->db->set('card', "card+$card", FALSE);
        $this->RI->db->set('bank', "bank+$bank", FALSE);
        $this->RI->db->set('cheque', "cheque+$cheque", FALSE);
        $this->RI->db->set('r_change', "r_change+$change", FALSE);
        $this->RI->db->where('uid', $id);
        $this->RI->db->where('active', 1);
        $this->RI->db->update('geopos_register');
    }


    public function close($id)
    {
        $this->RI->db->set('active', 0);
          $this->RI->db->set('c_date',  date('Y-m-d H:i:s'));
        $this->RI->db->where('uid', $id);
        $this->RI->db->where('active', 1);
        $this->RI->db->update('geopos_register');
    }

    public function lists($loc=0)
    {
       $this->RI->db->select('geopos_register.*,geopos_users.username,geopos_users.loc');
        $this->RI->db->from('geopos_register');
       $this->RI->db->join('geopos_users','geopos_register.uid=geopos_users.id','left');
       if($loc)    $this->RI->db->where('geopos_users.loc',$loc);
        $query = $this->RI->db->get();
        $result = $query->result_array();

            return $result;

    }

}