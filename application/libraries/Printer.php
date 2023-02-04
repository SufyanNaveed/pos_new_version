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

class Printer
{
    function __construct()
    {
          $this->PI = &get_instance();
    }

    function check($id=0)
    {
        $this->PI->db->where('type', 1);
        $this->PI->db->where('val4', $id);
        $this->PI->db->order_by('id', 'DESC');
        $query = $this->PI->db->get('geopos_config');
        $result = $query->row_array();
        if ($result) {
            return $result;
        } else {
            return false;
        }
    }
}