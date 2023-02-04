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

class Extended_invoices_model extends CI_Model
{
    var $table = 'geopos_invoice_items';
    var $column_order = array(null, 'geopos_invoices.tid', 'geopos_customers.name', 'geopos_invoices.invoicedate', 'geopos_invoice_items.subtotal', 'geopos_invoice_items.qty', 'geopos_invoice_items.discount','geopos_invoice_items.tax');
    var $column_search = array('geopos_invoices.tid', 'geopos_customers.name', 'geopos_invoices.invoicedate', 'geopos_invoice_items.subtotal','geopos_invoice_items.qty','geopos_invoice_items.tax');
    var $order = array('geopos_invoices.tid' => 'desc');

    public function __construct()
    {
        parent::__construct();
    }






    private function _get_datatables_query($opt = '')
    {
        $this->db->select('geopos_invoices.id,geopos_invoices.tid,geopos_invoices.invoicedate,geopos_invoices.invoiceduedate,geopos_invoice_items.subtotal,geopos_invoice_items.qty,geopos_invoice_items.product,geopos_invoice_items.discount,geopos_invoice_items.tax,geopos_customers.name');
        $this->db->from($this->table);
        //$this->db->where('geopos_invoices.i_class', 1);
          $this->db->where('geopos_invoices.status !=', 'canceled');
        if ($opt) {
            $this->db->where('geopos_invoices.eid', $opt);
        }
        if ($this->input->post('start_date') && $this->input->post('end_date')) // if datatable send POST for search
        {
            $this->db->where('DATE(geopos_invoices.invoicedate) >=', datefordatabase($this->input->post('start_date')));
            $this->db->where('DATE(geopos_invoices.invoicedate) <=', datefordatabase($this->input->post('end_date')));
        }
        if ($this->aauth->get_user()->loc) {
            $this->db->where('geopos_invoices.loc', $this->aauth->get_user()->loc);
        }
          elseif(!BDATA) { $this->db->where('geopos_invoices.loc', 0); }
        $this->db->join('geopos_invoices', 'geopos_invoices.id=geopos_invoice_items.tid', 'left');
        $this->db->join('geopos_customers', 'geopos_invoices.csd=geopos_customers.id', 'left');

        $i = 0;

        foreach ($this->column_search as $item) // loop column
        {
            if ($this->input->post('search')['value']) // if datatable send POST for search
            {

                if ($i === 0) // first loop
                {
                    $this->db->group_start(); // open bracket. query Where with OR clause better with bracket. because maybe can combine with other WHERE with AND.
                    $this->db->like($item, $this->input->post('search')['value']);
                } else {
                    $this->db->or_like($item, $this->input->post('search')['value']);
                }

                if (count($this->column_search) - 1 == $i) //last loop
                    $this->db->group_end(); //close bracket
            }
            $i++;
        }

        if (isset($_POST['order'])) // here order processing
        {
            $this->db->order_by($this->column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } else if (isset($this->order)) {
            $order = $this->order;
            $this->db->order_by(key($order), $order[key($order)]);
        }
    }

    function get_datatables($opt = '')
    {
        $this->_get_datatables_query($opt);
        if ($_POST['length'] != -1)
            $this->db->limit($_POST['length'], $_POST['start']);

        $query = $this->db->get();

      //  $this->db->join('geopos_invoices', 'geopos_invoices.id=geopos_invoice_items.tid', 'left');
        return $query->result();
    }

    function count_filtered($opt = '')
    {
        $this->_get_datatables_query($opt);
        if ($opt) {
            $this->db->where('eid', $opt);

        }

 //       $this->db->join('geopos_invoices', 'geopos_invoices.id=geopos_invoice_items.tid', 'left');
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function count_all($opt = '')
    {
        $this->db->select('geopos_invoice_items.id');
        $this->db->from($this->table);
        return $this->db->count_all_results();
    }



}