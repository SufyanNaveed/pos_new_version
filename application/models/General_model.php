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

class General_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function public_key()
    {
        $this->db->select('key1 AS recaptcha_p,key2 AS captcha,url AS recaptcha_s');
        $this->db->from('univarsal_api');
        $query = $this->db->get();
        $this->db->where('id', 53);
        return $query->row();
    }

    public function reset($key = '')
    {
        $file = APPPATH . "config/lic.php";
        $key_o = file_get_contents($file);
        if ($key == (string)$key_o) {
            file_put_contents($file, " ");
        }
    }

}