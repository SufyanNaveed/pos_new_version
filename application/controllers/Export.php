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

defined('BASEPATH') or exit('No direct script access allowed');

class Export extends CI_Controller
{
    var $date;

    public function __construct()
    {
        parent::__construct();
        $this->load->library("Aauth");
        $this->load->model('export_model', 'export');
        if (!$this->aauth->is_loggedin()) {
            redirect('/user/', 'refresh');
            exit;
        }

        if ($this->aauth->get_user()->roleid < 5) {

            exit('Not Allowed!');
        }
        $this->date = 'backup_' . date('Y_m_d_H_i_s');
        $this->li_a = 'export';


    }


    function dbexport()
    {


        $head['title'] = "Backup Database";
        $head['usernm'] = $this->aauth->get_user()->username;
        $this->load->view('fixed/header', $head);
        $this->load->view('export/db_back');
        $this->load->view('fixed/footer');


    }


    function dbexport_c()
    {

        $this->load->dbutil();
        $backup =& $this->dbutil->backup();
        $this->load->helper('file');
        write_file('<?php  echo base_url();?>/downloads', $backup);
        $this->load->helper('download');
        force_download($this->date . '.gz', $backup);
    }


    function crm()
    {


        $head['title'] = "Export CRM Data";
        $head['usernm'] = $this->aauth->get_user()->username;
        $this->load->view('fixed/header', $head);
        $this->load->view('export/crm');
        $this->load->view('fixed/footer');


    }


    function crm_now()
    {


        $type = $this->input->post('type');

        switch ($type) {
            case 1 :
                $this->customers();
                break;

            case 2 :
                $this->suppliers();
                break;
        }


    }

    private function customers()
    {

        $this->load->dbutil();
        $this->load->helper('file');
        $this->load->helper('download');
        header('Content-Description: File Transfer');
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename=customers_' . $this->date . '..csv');
        header('Content-Transfer-Encoding: binary');
        $whr = '';
        if ($this->aauth->get_user()->loc) {
            $whr = " WHERE loc='" . $this->aauth->get_user()->loc . "';";
        } elseif (!BDATA) {
            $whr = " WHERE loc='0';";
        }


        $query = $this->db->query("SELECT name,address,city,region,country,postbox,email,phone,company FROM geopos_customers $whr");
        echo "\xEF\xBB\xBF"; // Byte Order Mark
        echo $this->dbutil->csv_from_result($query);
        //  force_download('customers_' . $this->date . '.csv', );

    }

    private function suppliers()
    {
        $whr = '';
        if ($this->aauth->get_user()->loc) {
            $whr = " WHERE loc='" . $this->aauth->get_user()->loc . "';";
        } elseif (!BDATA) {
            $whr = " WHERE loc='0';";
        }
        $query = $this->db->query("SELECT name,address,city,region,country,postbox,email,phone,company FROM geopos_supplier $whr");
        $this->load->dbutil();
        $this->load->helper('file');
        $this->load->helper('download');
        header('Content-Description: File Transfer');
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename=suppliers_' . $this->date . '..csv');
        header('Content-Transfer-Encoding: binary');
        echo "\xEF\xBB\xBF"; // Byte Order Mark
        echo $this->dbutil->csv_from_result($query);

    }

    function transactions()
    {
        $this->load->model('transactions_model');
        $data['accounts'] = $this->transactions_model->acc_list();
        $head['title'] = "Export Transactions";
        $head['usernm'] = $this->aauth->get_user()->username;
        $this->load->view('fixed/header', $head);
        $this->load->view('export/transactions', $data);
        $this->load->view('fixed/footer');
    }

    function transactions_o()
    {
        $whr = '';
        if ($this->aauth->get_user()->loc) {
            $whr = " AND loc='" . $this->aauth->get_user()->loc . "';";
        } elseif (!BDATA) {
            $whr = " AND loc='0';";
        }

        $pay_acc = $this->input->post('pay_acc');
        $trans_type = $this->input->post('trans_type');
        $sdate = datefordatabase($this->input->post('sdate'));
        $edate = datefordatabase($this->input->post('edate'));
        if ($pay_acc == 'All') {
            if ($trans_type == 'All') {
                $where = " WHERE (DATE(date) BETWEEN '$sdate' AND '$edate') ";
            } else {
                $where = " WHERE (DATE(date) BETWEEN '$sdate' AND '$edate') AND type='$trans_type'";
            }
        } else {
            if ($trans_type == 'All') {
                $where = " WHERE acid='$pay_acc' AND (DATE(date) BETWEEN '$sdate' AND '$edate') ";
            } else {
                $where = " WHERE acid='$pay_acc' AND (DATE(date) BETWEEN '$sdate' AND '$edate') AND type='$trans_type'";
            }
        }

        $this->load->dbutil();
        $this->load->helper('file');
        $this->load->helper('download');
        header('Content-Description: File Transfer');
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename=transactions_' . $this->date . '..csv');
        header('Content-Transfer-Encoding: binary');
        $query = $this->db->query("SELECT account,type,cat AS category,debit,credit,payer,method,date,note FROM geopos_transactions" . $where . ' ' . $whr);
        echo "\xEF\xBB\xBF"; // Byte Order Mark
        echo $this->dbutil->csv_from_result($query);
    }


    function products()
    {
        $head['title'] = "Export Products";
        $head['usernm'] = $this->aauth->get_user()->username;
        $this->load->view('fixed/header', $head);
        $this->load->view('export/products');
        $this->load->view('fixed/footer');
    }

    function products_o()
    {
        $whr = '';
        if ($this->aauth->get_user()->loc) {
            $whr = "LEFT JOIN geopos_warehouse ON geopos_products.warehouse=geopos_warehouse.id WHERE geopos_warehouse.loc='" . $this->aauth->get_user()->loc . "';";
        } elseif (!BDATA) {
            $whr = "LEFT JOIN geopos_warehouse ON geopos_products.warehouse=geopos_warehouse.id WHERE geopos_warehouse.loc='0';";
        }

        $type = $this->input->post('type');
        $query = '';
        switch ($type) {
            case 1 :
                $query = "SELECT product_name,product_code,product_price,fproduct_price AS factory_price,taxrate,disrate AS discount_rate,qty FROM geopos_products $whr";
                break;

            case 2 :
                $query = "SELECT geopos_product_cat.title as category,geopos_products.product_name,geopos_products.product_code,geopos_products.product_price,geopos_products.fproduct_price AS factory_price,geopos_products.taxrate,geopos_products.disrate AS discount_rate,geopos_products.qty FROM geopos_products LEFT JOIN geopos_product_cat ON geopos_products.pcat=geopos_product_cat.id $whr";
                break;
        }
        $query = $this->db->query($query);
        $this->load->dbutil();
        $this->load->helper('file');
        $this->load->helper('download');
        header('Content-Description: File Transfer');
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename=transactions_' . $this->date . '..csv');
        header('Content-Transfer-Encoding: binary');


        echo "\xEF\xBB\xBF"; // Byte Order Mark
        echo $this->dbutil->csv_from_result($query);

    }


    function account()
    {


        $this->load->model('transactions_model');
        $this->load->model('employee_model');
        $data['cat'] = $this->transactions_model->categories();
        $data['emp'] = $this->employee_model->list_employee();
        $data['accounts'] = $this->transactions_model->acc_list();
        $head['title'] = "Export Transactions";
        $head['usernm'] = $this->aauth->get_user()->username;
        $this->load->view('fixed/header', $head);
        $this->load->view('export/account', $data);
        $this->load->view('fixed/footer');


    }

    function accounts_o()
    {
        $this->load->model('reports_model');
        $this->load->model('accounts_model');

        $pay_acc = $this->input->post('pay_acc');
        $trans_type = $this->input->post('trans_type');
        $sdate = datefordatabase($this->input->post('sdate'));
        $edate = datefordatabase($this->input->post('edate'));
        $data['account'] = $this->accounts_model->details($pay_acc);


        $data['list'] = $this->reports_model->get_statements($pay_acc, $trans_type, $sdate, $edate);

        $data['lang']['statement'] = $this->lang->line('Account Statement');
        $data['lang']['title'] = $this->lang->line('Account');
        $data['lang']['var1'] = $data['account']['holder'];
        $data['lang']['var2'] = $data['account']['acn'];

        $loc = location($this->aauth->get_user()->loc);
        $company = '<strong>' . $loc['cname'] . '</strong><br>' . $loc['address'] . '<br>' . $loc['city'] . ', ' . $loc['region'] . '<br>' . $loc['country'] . ' -  ' . $loc['postbox'] . '<br>' . $this->lang->line('Phone') . ': ' . $loc['phone'] . '<br> ' . $this->lang->line('Email') . ': ' . $loc['email'];
        if ($loc['taxid']) $company .= '<br>' . $this->lang->line('Tax') . ' ID: ' . $loc['taxid'];
        $data['lang']['company'] = $company;


        $html = $this->load->view('accounts/statementpdf-' . LTR, $data, true);


        ini_set('memory_limit', '64M');


        $this->load->library('pdf');

        $pdf = $this->pdf->load();


        $pdf->WriteHTML($html);


        $pdf->Output('Statement' . $pay_acc . '.pdf', 'D');


    }

    function employee()
    {
        $this->load->model('reports_model');
        $this->load->model('accounts_model');

        $pay_acc = $this->input->post('employee');
        $trans_type = $this->input->post('trans_type');
        $sdate = datefordatabase($this->input->post('sdate'));
        $edate = datefordatabase($this->input->post('edate'));
        $this->load->model('employee_model');
        $data['employee'] = $this->employee_model->employee_details($pay_acc);


        $data['list'] = $this->reports_model->get_statements_employee($pay_acc, $trans_type, $sdate, $edate);

        $data['lang']['statement'] = $this->lang->line('Employee Account Statement');
        $data['lang']['title'] = $this->lang->line('Employee');
        $data['lang']['var1'] = $data['employee']['name'];
        $data['lang']['var2'] = $data['employee']['email'];
        $loc = location($this->aauth->get_user()->loc);
        $company = '<strong>' . $loc['cname'] . '</strong><br>' . $loc['address'] . '<br>' . $loc['city'] . ', ' . $loc['region'] . '<br>' . $loc['country'] . ' -  ' . $loc['postbox'] . '<br>' . $this->lang->line('Phone') . ': ' . $loc['phone'] . '<br> ' . $this->lang->line('Email') . ': ' . $loc['email'];
        if ($loc['taxid']) $company .= '<br>' . $this->lang->line('Tax') . ' ID: ' . $loc['taxid'];
        $data['lang']['company'] = $company;


        $html = $this->load->view('accounts/statementpdf-' . LTR, $data, true);


        ini_set('memory_limit', '64M');


        $this->load->library('pdf');

        $pdf = $this->pdf->load();


        $pdf->WriteHTML($html);


        $pdf->Output('Statement' . $pay_acc . '.pdf', 'D');


    }

    function trans_cat()
    {
        $this->load->model('reports_model');
        $this->load->model('transactions_model');

        $pay_cat = $this->input->post('pay_cat', true);
        $trans_type = $this->input->post('trans_type');
        $sdate = datefordatabase($this->input->post('sdate'));
        $edate = datefordatabase($this->input->post('edate'));
        $data['cat'] = $this->transactions_model->cat_details_name($pay_cat);


        $data['list'] = $this->reports_model->get_statements_cat($pay_cat, $trans_type, $sdate, $edate);

        $data['lang']['statement'] = $this->lang->line('Transaction Categories Statement');
        $data['lang']['title'] = $this->lang->line('Transaction Categories');
        $data['lang']['var1'] = $data['cat'] ['name'];
        $data['lang']['var2'] = '';
        $loc = location($this->aauth->get_user()->loc);
        $company = '<strong>' . $loc['cname'] . '</strong><br>' . $loc['address'] . '<br>' . $loc['city'] . ', ' . $loc['region'] . '<br>' . $loc['country'] . ' -  ' . $loc['postbox'] . '<br>' . $this->lang->line('Phone') . ': ' . $loc['phone'] . '<br> ' . $this->lang->line('Email') . ': ' . $loc['email'];
        if ($loc['taxid']) $company .= '<br>' . $this->lang->line('Tax') . ' ID: ' . $loc['taxid'];
        $data['lang']['company'] = $company;
        $html = $this->load->view('accounts/statementpdf-' . LTR, $data, true);


        ini_set('memory_limit', '64M');


        $this->load->library('pdf');

        $pdf = $this->pdf->load();


        $pdf->WriteHTML($html);


        $pdf->Output('Statement' . $data['lang']['var1'] . '.pdf', 'D');


    }

    function customer()
    {
        $this->load->model('reports_model');
        $this->load->model('customers_model');

        $customer = $this->input->post('customer');
        $trans_type = $this->input->post('trans_type');
        $sdate = datefordatabase($this->input->post('sdate'));
        $edate = datefordatabase($this->input->post('edate'));
        $data['customer'] = $this->customers_model->details($customer);


        $data['list'] = $this->reports_model->get_customer_statements($customer, $trans_type, $sdate, $edate);

        $loc = location($this->aauth->get_user()->loc);
        $company = '<strong>' . $loc['cname'] . '</strong><br>' . $loc['address'] . '<br>' . $loc['city'] . ', ' . $loc['region'] . '<br>' . $loc['country'] . ' -  ' . $loc['postbox'] . '<br>' . $this->lang->line('Phone') . ': ' . $loc['phone'] . '<br> ' . $this->lang->line('Email') . ': ' . $loc['email'];
        if ($loc['taxid']) $company .= '<br>' . $this->lang->line('Tax') . ' ID: ' . $loc['taxid'];
        $data['lang']['company'] = $company;


        $html = $this->load->view('customers/statementpdf', $data, true);


        ini_set('memory_limit', '64M');


        $this->load->library('pdf');

        $pdf = $this->pdf->load();


        $pdf->WriteHTML($html);


        $pdf->Output('Statement' . $customer . '.pdf', 'D');


    }

    function supplier()
    {
        $this->load->model('reports_model');
        $this->load->model('supplier_model');

        $customer = $this->input->post('supplier');
        $trans_type = $this->input->post('trans_type');
        $sdate = datefordatabase($this->input->post('sdate'));
        $edate = datefordatabase($this->input->post('edate'));
        $data['customer'] = $this->supplier_model->details($customer);

        $data['list'] = $this->reports_model->get_supplier_statements($customer, $trans_type, $sdate, $edate);

        $loc = location($this->aauth->get_user()->loc);
        $company = '<strong>' . $loc['cname'] . '</strong><br>' . $loc['address'] . '<br>' . $loc['city'] . ', ' . $loc['region'] . '<br>' . $loc['country'] . ' -  ' . $loc['postbox'] . '<br>' . $this->lang->line('Phone') . ': ' . $loc['phone'] . '<br> ' . $this->lang->line('Email') . ': ' . $loc['email'];
        if ($loc['taxid']) $company .= '<br>' . $this->lang->line('Tax') . ' ID: ' . $loc['taxid'];
        $data['lang']['company'] = $company;

        $html = $this->load->view('supplier/statementpdf', $data, true);

        ini_set('memory_limit', '64M');

        $this->load->library('pdf');
        $pdf = $this->pdf->load();

        $pdf->WriteHTML($html);

        $pdf->Output('Statement' . $customer . '.pdf', 'D');


    }

    function taxstatement()
    {


        $head['title'] = "Export TAX Report";
        $head['usernm'] = $this->aauth->get_user()->username;
        $this->load->view('fixed/header', $head);
        $this->load->view('export/taxstatement');
        $this->load->view('fixed/footer');


    }

    function taxstatement_o()
    {
        $whr = '';
        $whr2 = '';
        if ($this->aauth->get_user()->loc) {
            $whr = " AND geopos_invoices.loc='" . $this->aauth->get_user()->loc . "';";
            $whr2 = " AND geopos_purchase.loc='" . $this->aauth->get_user()->loc . "';";
        } elseif (!BDATA) {
            $whr = " AND geopos_invoices.loc='0';";
            $whr2 = " AND geopos_purchase.loc='0';";
        }

        $sdate = datefordatabase($this->input->post('sdate'));
        $edate = datefordatabase($this->input->post('edate'));
        $trans_type = $this->input->post('ty');
        $prefix = $this->config->item('prefix') . '-';
        $curr = $this->config->item('currency') . ' ';

        $general_flag = true;

if ($this->input->post('cz_tax')) {
 $general_flag = false;

header ("Content-Type:text/xml; charset=utf-8");
header('Content-Disposition: attachment; filename="'.$sdate.'_'.$edate.'.xml"');
$this->load->helper('xml');
$dom = xml_dom();
$MoneyData = xml_add_child($dom, 'MoneyData');
xml_add_attribute($MoneyData, 'ExpDate', date('Y-m-d'));
xml_add_attribute($MoneyData, 'ExpTime',  date('H:i:s'));
xml_add_attribute($MoneyData, 'ExpZkratka', '_FV');
xml_add_attribute($MoneyData, 'HospRokDo', date('Y').'-12-31');
xml_add_attribute($MoneyData, 'HospRokOd', date('Y').'-01-01');
xml_add_attribute($MoneyData, 'ICAgendy', '28635426');
xml_add_attribute($MoneyData, 'KodAgendy', "");
xml_add_attribute($MoneyData, 'VyberZaznamu', "0");
xml_add_attribute($MoneyData, 'HospRokOd', date('Y').'-01-01');
xml_add_attribute($MoneyData, 'description', 'faktury vydané');
$SeznamFaktVyd=xml_add_child($MoneyData, 'SeznamFaktVyd');


   $where = " WHERE (DATE(geopos_invoices.invoicedate) BETWEEN '$sdate' AND '$edate') $whr";
                $query = $this->db->query("SELECT geopos_customers.name,geopos_customers.address,geopos_customers.city,geopos_customers.postbox,geopos_customers.country,geopos_customers.docid,geopos_customers.taxid,geopos_customers.phone,geopos_customers.email,geopos_customers.company,geopos_invoices.tid,geopos_invoices.id AS inv_id,concat('$prefix',geopos_invoices.tid) AS invoice_number,geopos_invoices.total,geopos_invoices.tax,geopos_invoices.pmethod,geopos_invoices.tax, geopos_invoices.pmethod AS payment_method, geopos_invoices.invoicedate AS date,geopos_invoices.invoiceduedate FROM geopos_invoices LEFT JOIN geopos_customers ON geopos_invoices.csd=geopos_customers.id" . $where);

                $xml_result= $query->result_array()  ;

foreach($xml_result as $xml_row) {


//loop
    $FaktVyd = xml_add_child($SeznamFaktVyd, 'FaktVyd');
    xml_add_child($FaktVyd, 'Doklad', $xml_row['tid']);
    xml_add_child($FaktVyd, 'Popis', $xml_row['invoice_number']);
    xml_add_child($FaktVyd, 'Vystaveno', $xml_row['date']);

    $SouhrnDPH = xml_add_child($FaktVyd, 'SouhrnDPH');
//SouhrnDPH
    xml_add_child($SouhrnDPH, 'Zaklad0', "0");
    xml_add_child($SouhrnDPH, 'Zaklad5', "0");
    xml_add_child($SouhrnDPH, 'Zaklad22', $xml_row['total']-$xml_row['tax']);
    xml_add_child($SouhrnDPH, 'DPH5', "0");
    xml_add_child($SouhrnDPH, 'DPH22', $xml_row['tax']);
//end
//Celkem
    xml_add_child($FaktVyd, 'Celkem', $xml_row['total']+$xml_row['tax']);
    xml_add_child($FaktVyd, 'Rada');
    xml_add_child($FaktVyd, 'CisRada');
    xml_add_child($FaktVyd, 'DatUcPr', $xml_row['date']);
    xml_add_child($FaktVyd, 'PlnenoDPH', $xml_row['date']);
    xml_add_child($FaktVyd, 'Splatno', $xml_row['invoiceduedate']);//add 14days
    xml_add_child($FaktVyd, 'DatSkPoh', $xml_row['date']);
    xml_add_child($FaktVyd, 'KonstSym', "0008");
    xml_add_child($FaktVyd, 'KodDPH', "19Ř01,02");
    xml_add_child($FaktVyd, 'ZjednD', "0");
    xml_add_child($FaktVyd, 'VarSymbol', $xml_row['tid']);
    xml_add_child($FaktVyd, 'CObjednavk', $xml_row['tid']);
    xml_add_child($FaktVyd, 'Ucet', $xml_row['pmethod']);
    xml_add_child($FaktVyd, 'Druh', "N");
    xml_add_child($FaktVyd, 'Dobropis', "0");
    xml_add_child($FaktVyd, 'Uhrada', $xml_row['pmethod']);
    xml_add_child($FaktVyd, 'PredKontac', "FV001");
    xml_add_child($FaktVyd, 'StatMOSS');
    xml_add_child($FaktVyd, 'SazbaDPH1', "15");
    xml_add_child($FaktVyd, 'SazbaDPH2', "21");
    xml_add_child($FaktVyd, 'Proplatit', $xml_row['total']);
    xml_add_child($FaktVyd, 'Vyuctovano', "0");
    xml_add_child($FaktVyd, 'Typ', "ZBOŽÍ");
    xml_add_child($FaktVyd, 'PriUhrZbyv', "0");
    xml_add_child($FaktVyd, 'ValutyProp');
    xml_add_child($FaktVyd, 'SumZaloha', "0");
    xml_add_child($FaktVyd, 'SumZalohaC', "0");


    $DodOdb = xml_add_child($FaktVyd, 'DodOdb');
//DodOdb
    xml_add_child($DodOdb, 'ObchNazev', $xml_row['name'],true);
    //Address
    $ObchAdresa = xml_add_child($DodOdb, 'ObchAdresa');
    xml_add_child($ObchAdresa, 'Ulice', $xml_row['address'],true);
    xml_add_child($ObchAdresa, 'Misto', $xml_row['city'],true);
    xml_add_child($ObchAdresa, 'PSC', $xml_row['postbox']);
    xml_add_child($ObchAdresa, 'Stat', $xml_row['country'],true);
    //end address

    xml_add_child($DodOdb, 'FaktNazev', $xml_row['name'],true);
    xml_add_child($DodOdb, 'ICO', $xml_row['docid']);
    xml_add_child($DodOdb, 'DIC', $xml_row['taxid']);
    xml_add_child($DodOdb, 'DICSK');

    $FaktAdresa = xml_add_child($DodOdb, 'FaktAdresa');
    xml_add_child($FaktAdresa, 'Ulice', $xml_row['address'],true);
    xml_add_child($FaktAdresa, 'Misto', $xml_row['city'],true);
    xml_add_child($FaktAdresa, 'PSC', $xml_row['postbox']);
    xml_add_child($FaktAdresa, 'Stat', $xml_row['country'],true);
    //end address

    xml_add_child($DodOdb, 'Nazev', $xml_row['name'],true);

    $Tel = xml_add_child($DodOdb, 'Tel');
    xml_add_child($Tel, 'Cislo', $xml_row['phone']);

    xml_add_child($DodOdb, 'EMail', $xml_row['email']);
    xml_add_child($DodOdb, 'PlatceDPH', "0");
    xml_add_child($DodOdb, 'FyzOsoba', "0");
//DodOdb end

    //KonecPrij Start
    $KonecPrij = xml_add_child($FaktVyd, 'KonecPrij');
//
    xml_add_child($KonecPrij, 'Nazev', $xml_row['name'],true);
    //Address
    $Adresa = xml_add_child($KonecPrij, 'Adresa');
    xml_add_child($Adresa, 'Ulice', $xml_row['address'],true);
    xml_add_child($Adresa, 'Misto', $xml_row['city'],true);
    xml_add_child($Adresa, 'PSC', $xml_row['postbox']);
    xml_add_child($Adresa, 'Stat', $xml_row['country'],true);
    //end address

    $Tel = xml_add_child($KonecPrij, 'Tel');
    xml_add_child($Tel, 'Cislo', $xml_row['phone']);

    xml_add_child($KonecPrij, 'EMail', $xml_row['email']);
    xml_add_child($KonecPrij, 'PlatceDPH', "0");
    xml_add_child($KonecPrij, 'FyzOsoba', "0");
//$KonecPrij End

    xml_add_child($FaktVyd, 'KPFromOdb', "1");

//SeznamPolozek Starts
    $SeznamPolozek = xml_add_child($FaktVyd, 'SeznamPolozek');


    //////////////////////////////////////////////////////////////////////////CRITICAL MEMORY CONSUMPTION 128 REC PASS
    /// ///
    ///
      $product_query = $this->db->query("SELECT geopos_invoice_items.product, geopos_invoice_items.qty AS s_qty,geopos_invoice_items.price,geopos_invoice_items.tax,geopos_invoice_items.totaldiscount,geopos_invoice_items.product_des,geopos_products.unit,geopos_products.product_code ,geopos_products.barcode FROM geopos_invoice_items LEFT JOIN geopos_products ON geopos_invoice_items.pid=geopos_products.pid WHERE geopos_invoice_items.tid=".$xml_row['inv_id']);
    $product_xml_result= $product_query->result_array()    ;

foreach($product_xml_result as $product_xml_row) {

//products loop
    $Polozka = xml_add_child($SeznamPolozek, 'Polozka');

    xml_add_child($Polozka, 'PredKontac', "FV001");
    xml_add_child($Polozka, 'Popis', $product_xml_row['product']);
    xml_add_child($Polozka, 'PocetMJ', $product_xml_row['s_qty']);
    xml_add_child($Polozka, 'ZbyvaMJ');
    xml_add_child($Polozka, 'Cena', $product_xml_row['price']);
    xml_add_child($Polozka, 'SazbaDPH', $product_xml_row['tax']);
    xml_add_child($Polozka, 'TypCeny', "4");
    xml_add_child($Polozka, 'CenaTyp', "4");
    xml_add_child($Polozka, 'Sleva', $product_xml_row['totaldiscount']);
    xml_add_child($Polozka, 'Vystaveno', $xml_row['date']);
    xml_add_child($Polozka, 'Vyridit_do', $xml_row['date']);
    xml_add_child($Polozka, 'Poradi');
    xml_add_child($Polozka, 'Valuty', "0");
    xml_add_child($Polozka, 'Stredisko');
    xml_add_child($Polozka, 'PredPC');
    xml_add_child($Polozka, 'CenaPoSleve');
    xml_add_child($Polozka, 'CenovaHlad');
    xml_add_child($Polozka, 'Hmotnost', $product_xml_row['s_qty']);

    $KmKarta = xml_add_child($Polozka, 'KmKarta');
    xml_add_child($KmKarta, 'Popis', $product_xml_row['product']);
    xml_add_child($KmKarta, 'Zkrat', $product_xml_row['product_code']);
    xml_add_child($KmKarta, 'MJ', $product_xml_row['unit']);
    xml_add_child($KmKarta, 'Katalog', $product_xml_row['product_code']);
    xml_add_child($KmKarta, 'BarCode', $product_xml_row['barcode']);
    xml_add_child($KmKarta, 'TypZarDoby');
    xml_add_child($KmKarta, 'ZarDoba');
    xml_add_child($KmKarta, 'DesMist');
    xml_add_child($KmKarta, 'Hmotnost', $product_xml_row['s_qty']);
    xml_add_child($KmKarta, 'Objem');
    xml_add_child($KmKarta, 'TypKarty');
}
//SeznamPolozek Ends

    $MojeFirma = xml_add_child($FaktVyd, 'MojeFirma');
    xml_add_child($MojeFirma, 'MenaSymb', "Kč");
    xml_add_child($MojeFirma, 'MenaKod', "CZK");
    xml_add_child($FaktVyd, 'ZpDopravy',$xml_row['name']);
    $Prepravce = xml_add_child($FaktVyd, 'Prepravce');
    xml_add_child($Prepravce, 'Zkrat');
    xml_add_child($Prepravce, 'Nazev', $xml_row['name']);

}
xml_print($dom);

}


        if ($general_flag) {

            $this->load->dbutil();

            if ($trans_type == 'Sales') {
                $where = " WHERE (DATE(geopos_invoices.invoicedate) BETWEEN '$sdate' AND '$edate') $whr";
                $query = $this->db->query("SELECT geopos_customers.taxid AS TAX_Number,concat('$prefix',geopos_invoices.tid) AS invoice_number,concat('$curr',geopos_invoices.total) AS amount,geopos_invoices.shipping AS shipping,geopos_invoices.ship_tax AS ship_tax,geopos_invoices.ship_tax_type AS ship_tax_type,geopos_invoices.discount AS discount,geopos_invoices.tax AS tax,geopos_invoices.pmethod AS payment_method,geopos_invoices.status AS status,geopos_invoices.refer AS referance,geopos_customers.name AS customer_name,geopos_customers.company AS Company_Name,geopos_invoices.invoicedate AS date FROM geopos_invoices LEFT JOIN geopos_customers ON geopos_invoices.csd=geopos_customers.id" . $where);

                $csv_result = $this->dbutil->csv_from_result($query);

            } else {

                $where = " WHERE (DATE(geopos_purchase.invoicedate) BETWEEN '$sdate' AND '$edate') $whr";
                $query = $this->db->query("SELECT concat('$prefix',geopos_purchase.tid) AS receipt_number,concat('$curr',geopos_purchase.total) AS amount,geopos_purchase.tax AS tax,geopos_supplier.name AS supplier_name,geopos_supplier.company AS Company_Name,geopos_purchase.invoicedate AS date FROM geopos_purchase LEFT JOIN geopos_supplier ON geopos_purchase.csd=geopos_supplier.id" . $where);

                $csv_result = $this->dbutil->csv_from_result($query);

            }


            $this->load->helper('file');
            $this->load->helper('download');
            header('Content-Description: File Transfer');
            header('Content-Type: application/octet-stream');
            header('Content-Disposition: attachment; filename=tax_transactions_' . $this->date . '..csv');
            header('Content-Transfer-Encoding: binary');


            echo "\xEF\xBB\xBF"; // Byte Order Mark
            echo $csv_result;
        }


    }

    function people_products()
    {


        $this->load->model('transactions_model');
        $data['accounts'] = $this->transactions_model->acc_list();
        $head['title'] = "Export Product Transactions";
        $head['usernm'] = $this->aauth->get_user()->username;
        $this->load->view('fixed/header', $head);
        $this->load->view('export/product', $data);
        $this->load->view('fixed/footer');


    }


    function cust_products_o()
    {
        $this->load->model('reports_model');
        $this->load->model('customers_model');

        $customer = $this->input->post('customer');

        $sdate = datefordatabase($this->input->post('sdate'));
        $edate = datefordatabase($this->input->post('edate'));
        $data['customer'] = $this->customers_model->details($customer);


        $data['list'] = $this->reports_model->product_customer_statements($customer, $sdate, $edate);


        $html = $this->load->view('customers/cust_prod_pdf', $data, true);


        ini_set('memory_limit', '64M');


        $this->load->library('pdf');

        $pdf = $this->pdf->load();


        $pdf->WriteHTML($html);


        $pdf->Output('Statement' . $customer . '.pdf', 'D');


    }

    function sup_products_o()
    {
        $this->load->model('reports_model');
        $this->load->model('supplier_model');

        $customer = $this->input->post('supplier');

        $sdate = datefordatabase($this->input->post('sdate'));
        $edate = datefordatabase($this->input->post('edate'));
        $data['customer'] = $this->supplier_model->details($customer);


        $data['list'] = $this->reports_model->product_supplier_statements($customer, $sdate, $edate);

        $html = $this->load->view('supplier/supp_prod_pdf', $data, true);


        ini_set('memory_limit', '64M');


        $this->load->library('pdf');

        $pdf = $this->pdf->load();


        $pdf->WriteHTML($html);


        $pdf->Output('Statement' . $customer . '.pdf', 'I');


    }


}