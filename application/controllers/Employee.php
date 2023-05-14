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

class Employee extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('employee_model', 'employee');
        $this->load->library("Aauth");
        if (!$this->aauth->is_loggedin()) {
            redirect('/user/', 'refresh');
        }
        if (!$this->aauth->premission(9)) {

            exit('<h3>Sorry! You have insufficient permissions to access this section</h3>');

        }
        $this->li_a = 'emp';

    }

    public function index()
    {
        $head['usernm'] = $this->aauth->get_user()->username;
        $head['title'] = 'Employees List';
        $data['employee'] = $this->employee->list_employee();
        $this->load->view('fixed/header', $head);
        $this->load->view('employee/list', $data);
        $this->load->view('fixed/footer');
    }

    public function import(){
        $this->load->library('form_validation');
        $this->load->helper('file');
        if($this->input->post('importSubmit')){
            $this->form_validation->set_rules('file', 'CSV file', 'callback_file_check');
            if($this->form_validation->run() == true){
                if(is_uploaded_file($_FILES['file']['tmp_name'])){
                    $this->load->library('CSVReader');
                    $csvData = $this->csvreader->parse_csv($_FILES['file']['tmp_name']);
                    if(!empty($csvData)){
                        // echo '<pre>'; print_r($csvData); exit;

                        foreach($csvData as $row){ 
                            
                            $name =  explode("(",$row['Staff']);
                            $email =  strtolower($name[0]).'@gmail.com';
                            //echo '<pre>'; print_r($email); exit;
                            $invoiceno = str_replace("Inv","",$row['Invoice Number']);

                            $id = $this->aauth->create_user($email, '123456', $name[0]);
                            if(!$id){
                                $this->db->select('*');
                                $this->db->from('geopos_users');
                                $this->db->where('username', $name[0]);
                                $id = $this->db->get()->row()->id; 
                            }else{
                                $data = array(
                                    'id' => $id,
                                    'username' => $name[0],
                                    'name' => $name[0],
                                    'address' => '',
                                    'city' => '',
                                    'region' => '',
                                    'country' => '',
                                    'postbox' => '',
                                    'phone' => '',
                                    'dept' => '',
                                    'salary' => '',
                                    'target' => '',
                                    'month_target' => '',
                                    'c_rate' => '',
                                );
                                if ($this->db->insert('geopos_employees', $data)) {
                                    
                                    $target_data = array(
                                        'emp_id' => $id,
                                        'target' => 0,
                                        'month_target' => 0,
                                        'year' => date('Y')
                                    );
                                    $this->db->insert('geopos_employees_month_target', $target_data);
                        
                                    $data1 = array(
                                        'roleid' => 2,
                                        'loc' => 3
                                    );
                        
                                    $this->db->set($data1);
                                    $this->db->where('id', $id);
                        
                                    $this->db->update('geopos_users');
                                }
                            }
                            $sale_date = date("Y-m-d", strtotime($row['Sale Date']));
                            
                            $data1 = array('tid' => $invoiceno, 'invoicedate' => $sale_date, 'invoiceduedate' => $sale_date, 
                            'subtotal' => $row['Grand Total.'], 'shipping' => '0.00', 'ship_tax' => $row['Total VAT'], 
                            'ship_tax_type' => 'incl', 'discount_rate' => '0.00', 'total' => $row['Grand Total.'], 
                            'pmethod' => 'Cash', 'notes' => '', 'status' => 'paid', 'csd' => 1, 
                            'eid' => $id, 'pamnt' => 0, 'taxstatus' => 'yes', 'discstatus' => 1, 
                            'format_discount' => '%', 'refer' => $refer, 'term' => 1, 
                            'multi' => NULL, 'i_class' => 1, 'loc' => 3,
                            'wholesale' => 0);
                            $this->db->insert('geopos_invoices', $data1);
                            $invoice_id = $this->db->insert_id();

                            
                            $this->db->select('*');
                            $this->db->from('geopos_products');
                            $this->db->where('product_code', $row['Article Number']);
                            $this->db->or_where('product_name', $row['Product Name']);
                            $res = $this->db->get()->row_array();
                            //decho '<pre>'; print_r($res); exit;
                            if($res){
                                $data2 = array(
                                    'tid' => $invoice_id,
                                    'pid' => $res['pid'],
                                    'product' => $row['Product Name'],
                                    'code' => $row['Article Number'],
                                    'qty' => $row['Total Qnty'],
                                    'price' => $row['Unit Price'],
                                    'tax' => $row['Total VAT'],
                                    'discount' => 0,
                                    'subtotal' => $row['Grand Total.'],
                                    'totaltax' => $row['Total VAT'],
                                    'totaldiscount' => 0,
                                    'product_des' => '',
                                    'i_class' => 1,
                                    'unit' => '',
                                    'serial' => ''
                                );
                                $this->db->insert('geopos_invoice_items', $data2);
                                // $invoice_id = $this->db->insert_id();
                            }


                            $data = array(
                                'payerid' => 1,
                                'payer' => 'Walk-in Client',
                                'acid' => 1,
                                'account' => 'Sales Account',
                                'date' => $sale_date,
                                'debit' => 0,
                                'credit' => $row['Grand Total.'],
                                'type' => 'Income',
                                'cat' => '',
                                'method' => 'Transfer',
                                'tid' => $invoice_id,
                                'eid' => $id,
                                'note' => '#'.$invoiceno.'-Cash',
                                'loc' => 3
                            );
                            $amount = $row['Grand Total.'];
                            $this->db->set('lastbal', "lastbal+$amount", FALSE);
                            $this->db->where('id', 5);
                            $this->db->update('geopos_accounts');
                            $this->db->insert('geopos_transactions', $data);


                            //profit calculation
                            $t_profit = 0;
                            $this->db->select('geopos_invoice_items.pid, geopos_invoice_items.price, geopos_invoice_items.qty, geopos_products.fproduct_price');
                            $this->db->from('geopos_invoice_items');
                            $this->db->join('geopos_products', 'geopos_products.pid = geopos_invoice_items.pid', 'left');
                            $this->db->where('geopos_invoice_items.tid', $invoice_id);
                            $query = $this->db->get();
                            $pids = $query->result_array();
                            foreach ($pids as $profit) {
                                $t_cost = $profit['fproduct_price'] * $profit['qty'];
                                $s_cost = $profit['price'] * $profit['qty'];

                                $t_profit += $s_cost - $t_cost;
                            }
                            $data = array('type' => 9, 'rid' => $invoice_id, 'col1' => $t_profit, 'd_date' => $sale_date);

                            $this->db->insert('geopos_metadata', $data);
                             
                        } 
                    }
                }else{
                    $this->session->set_userdata('error_msg', 'Error on file upload, please try again.');
                }
            }else{
                $this->session->set_userdata('error_msg', 'Invalid file, please select only CSV file.');
            }
        }
        redirect('employee');
    }
    
    /*
     * Callback function to check file value and type during validation
     */
    public function file_check($str){
        $allowed_mime_types = array('text/x-comma-separated-values', 'text/comma-separated-values', 'application/octet-stream', 'application/vnd.ms-excel', 'application/x-csv', 'text/x-csv', 'text/csv', 'application/csv', 'application/excel', 'application/vnd.msexcel', 'text/plain');
        if(isset($_FILES['file']['name']) && $_FILES['file']['name'] != ""){
            $mime = get_mime_by_extension($_FILES['file']['name']);
            $fileAr = explode('.', $_FILES['file']['name']);
            $ext = end($fileAr);
            if(($ext == 'csv') && in_array($mime, $allowed_mime_types)){
                return true;
            }else{
                $this->form_validation->set_message('file_check', 'Please select only CSV file to upload.');
                return false;
            }
        }else{
            $this->form_validation->set_message('file_check', 'Please select a CSV file to upload.');
            return false;
        }
    }

    
    
    
    public function salaries()
    {
        $head['usernm'] = $this->aauth->get_user()->username;
        $head['title'] = 'Employees List';
        $data['employee'] = $this->employee->list_employee();
        $this->load->view('fixed/header', $head);
        $this->load->view('employee/salaries', $data);
        $this->load->view('fixed/footer');
    }


    public function view()
    {
        $id = $this->input->get('id');
        $head['usernm'] = $this->aauth->get_user()->username;
        $head['title'] = 'Employee Details';
        $data['employee'] = $this->employee->employee_details($id);
        $data['eid'] = intval($id);
        $this->load->view('fixed/header', $head);
        $this->load->view('employee/view', $data);
        $this->load->view('fixed/footer');

    }

    public function view_employee_target()
    {
        $id = $this->input->get('id');
        $head['usernm'] = $this->aauth->get_user()->username;
        $head['title'] = 'Employee Details';
        $data['employee_target'] = $this->employee->employee_target_details($id);
        $data['eid'] = intval($id);
        $this->load->view('fixed/header', $head);
        $this->load->view('employee/view_employee_target', $data);
        $this->load->view('fixed/footer');

    }

    public function history()
    {
        $id = $this->input->get('id');
        $head['usernm'] = $this->aauth->get_user()->username;
        $head['title'] = 'Employee Details';
        $data['employee'] = $this->employee->employee_details($id);
        $data['history'] = $this->employee->salary_history($data['employee']['id']);
        $data['eid'] = intval($id);
        $this->load->view('fixed/header', $head);
        $this->load->view('employee/history', $data);
        $this->load->view('fixed/footer');

    }


    public function add()
    {

        $head['usernm'] = $this->aauth->get_user()->username;
        $head['title'] = 'Add Employee';
        $data['dept'] = $this->employee->department_list(0);

        $this->load->view('fixed/header', $head);
        $this->load->view('employee/add', $data);
        $this->load->view('fixed/footer');


    }

    public function submit_user()
    {
        if ($this->aauth->get_user()->roleid < 4) {
            redirect('/dashboard/', 'refresh');
        }

        $username = $this->input->post('username', true);

        $password = $this->input->post('password', true);
        $roleid = 3;
        if ($this->input->post('roleid')) {
            $roleid = $this->input->post('roleid');

        }

        if ($roleid > 3) {
            if ($this->aauth->get_user()->roleid < 5) {
                die('No! Permission');
            }
        }

        $location = $this->input->post('location', true);
        $name = $this->input->post('name', true);
        $phone = $this->input->post('phone', true);
        $email = $this->input->post('email', true);
        $address = $this->input->post('address', true);
        $city = $this->input->post('city', true);
        $region = $this->input->post('region', true);
        $country = $this->input->post('country', true);
        $postbox = $this->input->post('postbox', true);
        $salary = numberClean($this->input->post('salary', true));
        $target = numberClean($this->input->post('target', true));
        $month_target = $this->input->post('month_target', true);
        $commission = $this->input->post('commission', true);
        $department = $this->input->post('department', true);

        $a = $this->aauth->create_user($email, $password, $username);

        if ((string)$this->aauth->get_user($a)->id != $this->aauth->get_user()->id) {
            $nuid = (string)$this->aauth->get_user($a)->id;

            if ($nuid > 0) {


                $this->employee->add_employee($nuid, (string)$this->aauth->get_user($a)->username, $name, $roleid, $phone, $address, $city, $region, $country, $postbox, $location, $salary, $target, $month_target, $commission, $department);

            }

        } else {
            echo json_encode(array('status' => 'Error', 'message' =>
                'There has been an error, please try again.'));
        }
    }

    public function invoices()
    {
        $id = $this->input->get('id');
        $head['usernm'] = $this->aauth->get_user()->username;
        $head['title'] = 'Employee Invoices';
        $data['employee'] = $this->employee->employee_details($id);
        $data['eid'] = intval($id);
        $this->load->view('fixed/header', $head);
        $this->load->view('employee/invoices', $data);
        $this->load->view('fixed/footer');
    }

    public function invoices_list()
    {

        $eid = $this->input->post('eid');
        $list = $this->employee->invoice_datatables($eid);
        $data = array();

        $no = $this->input->post('start');


        foreach ($list as $invoices) {
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $invoices->tid;
            $row[] = $invoices->name;
            $row[] = $invoices->invoicedate;
            $row[] = amountExchange($invoices->total, 0, $this->aauth->get_user()->loc);
            switch ($invoices->status) {
                case "paid" :
                    $out = '<span class="label label-success">Paid</span> ';
                    break;
                case "due" :
                    $out = '<span class="label label-danger">Due</span> ';
                    break;
                case "canceled" :
                    $out = '<span class="label label-warning">Canceled</span> ';
                    break;
                case "partial" :
                    $out = '<span class="label label-primary">Partial</span> ';
                    break;
                default :
                    $out = '<span class="label label-info">Pending</span> ';
                    break;
            }
            $row[] = $out;
            $row[] = '<a href="' . base_url("invoices/view?id=$invoices->id") . '" class="btn btn-success btn-xs"><i class="fa fa-eye"></i> View</a> &nbsp; <a href="' . base_url("invoices/printinvoice?id=$invoices->id") . '&d=1" class="btn btn-info btn-xs"  title="Download"><span class="fa fa-download"></span></a>';

            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->employee->invoicecount_all($eid),
            "recordsFiltered" => $this->employee->invoicecount_filtered($eid),
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);

    }

    public function transactions()
    {
        $id = $this->input->get('id');
        $head['usernm'] = $this->aauth->get_user()->username;
        $head['title'] = 'Employee Transactions';
        $data['employee'] = $this->employee->employee_details($id);
        $data['eid'] = intval($id);
        $this->load->view('fixed/header', $head);
        $this->load->view('employee/transactions', $data);
        $this->load->view('fixed/footer');
    }

    public function translist()
    {
        $eid = $this->input->post('eid');
        $list = $this->employee->get_datatables($eid);
        $data = array();
        $no = $this->input->post('start');
        foreach ($list as $prd) {
            $no++;
            $row = array();
            $pid = $prd->id;
            $row[] = $prd->date;
            $row[] = $prd->account;
            $row[] = amountExchange($prd->debit, 0, $this->aauth->get_user()->loc);
            $row[] = amountExchange($prd->credit, 0, $this->aauth->get_user()->loc);

            $row[] = $prd->payer;
            $row[] = $prd->method;
            $row[] = '<a href="' . base_url() . 'transactions/view?id=' . $pid . '" class="btn btn-primary btn-xs"><span class="icon-eye"></span> View</a> <a data-object-id="' . $pid . '" class="btn btn-danger btn-xs delete-object"><span class="icon-bin"></span>Delete</a>';
            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->employee->count_all(),
            "recordsFiltered" => $this->employee->count_filtered(),
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);
    }


    function disable_user()
    {
        if (!$this->aauth->get_user()->roleid == 5) {
            redirect('/dashboard/', 'refresh');
        }
        $uid = intval($this->input->post('deleteid'));

        $nuid = intval($this->aauth->get_user()->id);

        if ($nuid == $uid) {
            echo json_encode(array('status' => 'Error', 'message' =>
                'You can not disable yourself!'));
        } else {

            $this->db->select('banned');
            $this->db->from('geopos_users');
            $this->db->where('id', $uid);
            $query = $this->db->get();
            $result = $query->row_array();
            if ($result['banned'] == 0) {
                $this->aauth->ban_user($uid);
            } else {
                $this->aauth->unban_user($uid);
            }

            echo json_encode(array('status' => 'Success', 'message' =>
                'User Profile updated successfully!'));


        }
    }

    function enable_user()
    {
        if (!$this->aauth->get_user()->roleid == 5) {
            redirect('/dashboard/', 'refresh');
        }
        $uid = intval($this->input->post('deleteid'));

        $nuid = intval($this->aauth->get_user()->id);

        if ($nuid == $uid) {
            echo json_encode(array('status' => 'Error', 'message' =>
                'You can not disable yourself!'));
        } else {


            $a = $this->aauth->unban_user($uid);

            echo json_encode(array('status' => 'Success', 'message' =>
                'User Profile disabled successfully!'));


        }
    }

    function delete_user()
    {
        if (!$this->aauth->get_user()->roleid == 5) {
            redirect('/dashboard/', 'refresh');
        }
        $uid = intval($this->input->post('empid'));

        $nuid = intval($this->aauth->get_user()->id);

        if ($nuid == $uid) {
            echo json_encode(array('status' => 'Error', 'message' =>
                'You can not delete yourself!'));
        } else {

            $this->db->delete('geopos_employees', array('id' => $uid));

            $this->db->delete('geopos_users', array('id' => $uid));

            echo json_encode(array('status' => 'Success', 'message' =>
                'User Profile deleted successfully! Please refresh the page!'));


        }
    }


    public function calc_income()
    {
        $eid = $this->input->post('eid');

        if ($this->employee->money_details($eid)) {
            $details = $this->employee->money_details($eid);

            echo json_encode(array('status' => 'Success', 'message' =>
                '<br> Total Income: ' . amountExchange($details['credit'], 0, $this->aauth->get_user()->loc) . '<br> Total Expenses: ' . amountExchange($details['debit'], 0, $this->aauth->get_user()->loc)));

        }


    }

    public function calc_sales()
    {
        $eid = $this->input->post('eid');

        if ($this->employee->sales_details($eid)) {
            $details = $this->employee->sales_details($eid);

            echo json_encode(array('status' => 'Success', 'message' =>
                'Total Sales (Paid Payment):  ' . amountExchange($details['total'], 0, $this->aauth->get_user()->loc)));

        }


    }

    public function update()
    {
        if (!$this->aauth->is_loggedin()) {
            redirect('/user/', 'refresh');
        }


        $id = $this->input->get('id');
        $this->load->model('employee_model', 'employee');
        if ($this->input->post()) {
            $eid = $this->input->post('eid', true);
            $name = $this->input->post('name', true);
            $phone = $this->input->post('phone', true);
            $phonealt = $this->input->post('phonealt', true);
            $address = $this->input->post('address', true);
            $city = $this->input->post('city', true);
            $region = $this->input->post('region', true);
            $country = $this->input->post('country', true);
            $postbox = $this->input->post('postbox', true);
            $location = $this->input->post('location', true);
            $salary = numberClean($this->input->post('salary', true));
            $target = numberClean($this->input->post('target', true));
            $month_target = $this->input->post('month_target', true);
            $department = $this->input->post('department', true);
            $commission = $this->input->post('commission', true);
            $roleid = $this->input->post('roleid', true);
            $this->employee->update_employee($eid, $name, $phone, $phonealt, $address, $city, $region, $country, $postbox, $location, $salary,$target,$month_target, $department, $commission, $roleid);

        } else {
            $head['usernm'] = $this->aauth->get_user($id)->username;
            $head['title'] = $head['usernm'] . ' Profile';


            $data['user'] = $this->employee->employee_details($id);
            $data['dept'] = $this->employee->department_list($id, $this->aauth->get_user()->loc);
            $data['eid'] = intval($id);
            $this->load->view('fixed/header', $head);
            $this->load->view('employee/edit', $data);
            $this->load->view('fixed/footer');
        }


    }


    public function displaypic()
    {

        if (!$this->aauth->is_loggedin()) {
            redirect('/user/', 'refresh');
        }

        $this->load->model('employee_model', 'employee');
        $id = $this->input->get('id');
        $this->load->library("uploadhandler", array(
            'accept_file_types' => '/\.(gif|jpe?g|png)$/i', 'upload_dir' => FCPATH . 'userfiles/employee/'
        ));
        $img = (string)$this->uploadhandler->filenaam();
        if ($img != '') {
            $this->employee->editpicture($id, $img);
        }


    }


    public function user_sign()
    {
        if (!$this->aauth->is_loggedin()) {
            redirect('/user/', 'refresh');
        }


        $this->load->model('employee_model', 'employee');
        $id = $this->input->get('id');
        $this->load->library("uploadhandler", array(
            'accept_file_types' => '/\.(gif|jpe?g|png)$/i', 'upload_dir' => FCPATH . 'userfiles/employee_sign/'
        ));
        $img = (string)$this->uploadhandler->filenaam();
        if ($img != '') {
            $this->employee->editsign($id, $img);
        }


    }


    public function updatepassword()
    {

        if (!$this->aauth->is_loggedin()) {
            redirect('/user/', 'refresh');
        }
        $this->load->library("form_validation");

        $id = $this->input->get('id');
        $this->load->model('employee_model', 'employee');


        if ($this->input->post()) {
            $eid = $this->input->post('eid');
            $this->form_validation->set_rules('newpassword', 'Password', 'required');
            $this->form_validation->set_rules('renewpassword', 'Confirm Password', 'required|matches[newpassword]');
            if ($this->form_validation->run() == FALSE) {
                echo json_encode(array('status' => 'Error', 'message' => '<br>Rules<br> Password length should  be at least 6 [a-z-0-9] allowed!<br>New Password & Re New Password should be same!'));
            } else {

                $newpassword = $this->input->post('newpassword');
                echo json_encode(array('status' => 'Success', 'message' => 'Password Updated Successfully!'));
                $this->aauth->update_user($eid, false, $newpassword, false);
            }


        } else {
            $head['usernm'] = $this->aauth->get_user()->username;
            $head['title'] = $head['usernm'] . ' Profile';
            $data['user'] = $this->employee->employee_details($id);
            $data['eid'] = intval($id);
            $this->load->view('fixed/header', $head);
            $this->load->view('employee/password', $data);
            $this->load->view('fixed/footer');
        }


    }

    public function permissions()
    {

        $head['usernm'] = $this->aauth->get_user()->username;
        $head['title'] = 'Employee Permissions';
        $data['permission'] = $this->employee->employee_permissions();
        $this->load->view('fixed/header', $head);
        $this->load->view('employee/permissions', $data);
        $this->load->view('fixed/footer');


    }

    public function permissions_update()
    {

        $head['usernm'] = $this->aauth->get_user()->username;
        $head['title'] = 'Employee Permissions';
        $permission = $this->employee->employee_permissions();

        foreach ($permission as $row) {
            $i = $row['id'];
            $name1 = 'r_' . $i . '_1';
            $name2 = 'r_' . $i . '_2';
            $name3 = 'r_' . $i . '_3';
            $name4 = 'r_' . $i . '_4';
            $name5 = 'r_' . $i . '_5';
            $name6 = 'r_' . $i . '_6';
            $name7 = 'r_' . $i . '_7';
            $name8 = 'r_' . $i . '_8';
            $val1 = 0;
            $val2 = 0;
            $val3 = 0;
            $val4 = 0;
            $val5 = 0;
            $val6 = 0;
            $val7 = 0;
            $val8 = 0;
            if ($this->input->post($name1)) $val1 = 1;
            if ($this->input->post($name2)) $val2 = 1;
            if ($this->input->post($name3)) $val3 = 1;
            if ($this->input->post($name4)) $val4 = 1;
            if ($this->input->post($name5)) $val5 = 1;
            if ($this->input->post($name6)) $val6 = 1;
            if ($this->input->post($name7)) $val7 = 1;
            if ($this->aauth->get_user()->roleid == 5 && $i == 9) $val5 = 1;
            $data = array('r_1' => $val1, 'r_2' => $val2, 'r_3' => $val3, 'r_4' => $val4, 'r_5' => $val5, 'r_6' => $val6, 'r_7' => $val7);
            $this->db->set($data);
            $this->db->where('id', $i);
            $this->db->update('geopos_premissions');
        }

        echo json_encode(array('status' => 'Success', 'message' =>
            $this->lang->line('UPDATED')));
    }


    public function holidays()
    {

        $head['usernm'] = $this->aauth->get_user()->username;
        $head['title'] = 'Holidays';
        $this->load->view('fixed/header', $head);
        $this->load->view('employee/holidays');
        $this->load->view('fixed/footer');

    }


    public function hday_list()
    {
        $list = $this->employee->holidays_datatables();
        $data = array();
        $no = $this->input->post('start');
        foreach ($list as $obj) {
            $datetime1 = date_create($obj->val1);
            $datetime2 = date_create($obj->val2);
            $interval = date_diff($datetime1, $datetime2);
            $day = $interval->format('%a days');
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $obj->val1;
            $row[] = $obj->val2;
            $row[] = $day;
            $row[] = $obj->val3;
            $row[] = "<a href='" . base_url("employee/editholiday?id=$obj->id") . "' class='btn btn-blue'><i class='fa fa-pencil'></i> " . $this->lang->line('Edit') . "</a> " . '<a href="#" data-object-id="' . $obj->id . '" class="btn btn-danger delete-object"><span class="fa fa-trash"></span></a>';


            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->employee->holidays_count_all(),
            "recordsFiltered" => $this->employee->holidays_count_filtered(),
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);
    }

    public function delete_hday()
    {
        $id = $this->input->post('deleteid');


        if ($this->employee->deleteholidays($id)) {
            echo json_encode(array('status' => 'Success', 'message' => $this->lang->line('DELETED')));
        } else {
            echo json_encode(array('status' => 'Error', 'message' => $this->lang->line('ERROR')));
        }
    }

    public function addhday()
    {

        if ($this->input->post()) {

            $from = datefordatabase($this->input->post('from'));
            $todate = datefordatabase($this->input->post('todate'));
            $note = $this->input->post('note', true);

            $date1 = new DateTime($from);
            $date2 = new DateTime($todate);
            if ($date1 <= $date2) {


                if ($this->employee->addholidays($this->aauth->get_user()->loc, $from, $todate, $note)) {
                    echo json_encode(array('status' => 'Success', 'message' => $this->lang->line('ADDED') . "   <a href='addhday' class='btn btn-indigo btn-lg'><span class='icon-plus-circle' aria-hidden='true'></span>  </a> <a href='holidays' class='btn btn-grey btn-lg'><span class='icon-eye' aria-hidden='true'></span>  </a>"));
                }
            } else {
                echo json_encode(array('status' => 'Error', 'message' => $this->lang->line('ERROR') . '- Invalid'));
            }
        } else {
            $data['id'] = $this->input->get('id');
            $head['usernm'] = $this->aauth->get_user()->username;
            $head['title'] = 'Add Holiday';
            $this->load->view('fixed/header', $head);
            $this->load->view('employee/addholyday', $data);
            $this->load->view('fixed/footer');
        }

    }


    public function editholiday()
    {

        if ($this->input->post()) {


            $id = $this->input->post('did');
            $from = datefordatabase($this->input->post('from'));
            $todate = datefordatabase($this->input->post('todate'));
            $note = $this->input->post('note', true);

            if ($this->employee->edithday($id, $this->aauth->get_user()->loc, $from, $todate, $note)) {
                echo json_encode(array('status' => 'Success', 'message' => $this->lang->line('ADDED') . "  <a href='addhday' class='btn btn-indigo btn-lg'><span class='icon-plus-circle' aria-hidden='true'></span>  </a> <a href='holidays' class='btn btn-grey btn-lg'><span class='icon-eye' aria-hidden='true'></span>  </a>"));
            } else {
                echo json_encode(array('status' => 'Error', 'message' => $this->lang->line('ERROR')));
            }
        } else {
            $data['id'] = $this->input->get('id');
            $data['hday'] = $this->employee->hday_view($data['id'], $this->aauth->get_user()->loc);
            $head['usernm'] = $this->aauth->get_user()->username;
            $head['title'] = 'Edit Holiday';
            $this->load->view('fixed/header', $head);
            $this->load->view('employee/edithday', $data);
            $this->load->view('fixed/footer');
        }

    }


    public function departments()
    {

        $head['usernm'] = $this->aauth->get_user()->username;
        $data['department_list'] = $this->employee->department_list($this->aauth->get_user()->loc);
        $head['title'] = 'Departments';
        $this->load->view('fixed/header', $head);
        $this->load->view('employee/departments', $data);
        $this->load->view('fixed/footer');

    }

    public function department()
    {

        $data['id'] = $this->input->get('id');
        $head['usernm'] = $this->aauth->get_user()->username;
        $data['department'] = $this->employee->department_view($data['id'], $this->aauth->get_user()->loc);
        $data['department_list'] = $this->employee->department_elist($data['id']);
        $head['title'] = 'Departments';
        $this->load->view('fixed/header', $head);
        $this->load->view('employee/department', $data);
        $this->load->view('fixed/footer');

    }

    public function delete_dep()
    {

        $id = $this->input->post('deleteid');


        if ($this->employee->deletedepartment($id)) {
            echo json_encode(array('status' => 'Success', 'message' => $this->lang->line('DELETED')));
        } else {
            echo json_encode(array('status' => 'Error', 'message' => $this->lang->line('ERROR')));
        }
    }

    public function adddep()
    {

        if ($this->input->post()) {

            $name = $this->input->post('name', true);


            if ($this->employee->adddepartment($this->aauth->get_user()->loc, $name)) {
                echo json_encode(array('status' => 'Success', 'message' => $this->lang->line('ADDED') . "  <a href='adddep' class='btn btn-indigo btn-lg'><span class='icon-plus-circle' aria-hidden='true'></span>  </a> <a href='departments' class='btn btn-grey btn-lg'><span class='icon-eye' aria-hidden='true'></span>  </a>"));
            } else {
                echo json_encode(array('status' => 'Error', 'message' => $this->lang->line('ERROR')));
            }
        } else {

            $head['usernm'] = $this->aauth->get_user()->username;
            $head['title'] = 'Add Department';
            $this->load->view('fixed/header', $head);
            $this->load->view('employee/adddep');
            $this->load->view('fixed/footer');
        }

    }

    public function editdep()
    {

        if ($this->input->post()) {

            $name = $this->input->post('name', true);
            $id = $this->input->post('did');

            if ($this->employee->editdepartment($id, $this->aauth->get_user()->loc, $name)) {
                echo json_encode(array('status' => 'Success', 'message' => $this->lang->line('ADDED') . "  <a href='adddep' class='btn btn-indigo btn-lg'><span class='icon-plus-circle' aria-hidden='true'></span>  </a> <a href='departments' class='btn btn-grey btn-lg'><span class='icon-eye' aria-hidden='true'></span>  </a>"));
            } else {
                echo json_encode(array('status' => 'Error', 'message' => $this->lang->line('ERROR')));
            }
        } else {
            $data['id'] = $this->input->get('id');
            $data['department'] = $this->employee->department_view($data['id'], $this->aauth->get_user()->loc);
            $head['usernm'] = $this->aauth->get_user()->username;
            $head['title'] = 'Edit Department';
            $this->load->view('fixed/header', $head);
            $this->load->view('employee/editdep', $data);
            $this->load->view('fixed/footer');
        }

    }

    public function payroll_create()
    {
        $this->load->library("Custom");
        $data['dual'] = $this->custom->api_config(65);
        $this->load->model('transactions_model', 'transactions');
        $data['cat'] = $this->transactions->categories();
        $data['accounts'] = $this->transactions->acc_list();
        $head['title'] = "Add Transaction";
        $head['usernm'] = $this->aauth->get_user()->username;
        $this->load->view('fixed/header', $head);
        $this->load->view('employee/payroll_create', $data);
        $this->load->view('fixed/footer');

    }

    public function emp_search()
    {

        $name = $this->input->get('keyword', true);


        $whr = '';
        if ($this->aauth->get_user()->loc) {
            $whr = ' (geopos_users.loc=' . $this->aauth->get_user()->loc . ') AND ';
        }
        if ($name) {
            $query = $this->db->query("SELECT geopos_employees.* ,geopos_users.email FROM geopos_employees  LEFT JOIN geopos_users ON geopos_users.id=geopos_employees.id  WHERE $whr (UPPER(geopos_employees.name)  LIKE '%" . strtoupper($name) . "%' OR UPPER(geopos_employees.phone)  LIKE '" . strtoupper($name) . "%') LIMIT 6");
            $result = $query->result_array();
            echo '<ol>';
            $i = 1;
            foreach ($result as $row) {

                echo "<li onClick=\"selectPay('" . $row['id'] . "','" . $row['name'] . " ','" . amountFormat_general($row['salary']) . "')\"><span>$i</span><p>" . $row['name'] . " &nbsp; &nbsp  " . $row['phone'] . "</p></li>";
                $i++;
            }
            echo '</ol>';
        }

    }

    public function payroll()
    {

        $head['usernm'] = $this->aauth->get_user()->username;
        $head['title'] = 'Employee Payroll Transactions';


        $this->load->view('fixed/header', $head);
        $this->load->view('employee/payroll');
        $this->load->view('fixed/footer');
    }

    public function payroll_emp()
    {

        $id = $this->input->get('id');
        $head['usernm'] = $this->aauth->get_user()->username;
        $head['title'] = 'Employee Payroll Transactions';
        $data['employee'] = $this->employee->employee_details($id);
        $data['eid'] = intval($id);
        $this->load->view('fixed/header', $head);
        $this->load->view('employee/payroll_employee', $data);
        $this->load->view('fixed/footer');
    }


    public function payrolllist()
    {

        $eid = $this->input->post('eid');
        $list = $this->employee->pay_get_datatables($eid);
        $data = array();
        $no = $this->input->post('start');
        foreach ($list as $prd) {
            $no++;
            $row = array();
            $pid = $prd->id;
            $row[] = $prd->date;

            $row[] = amountExchange($prd->debit, 0, $this->aauth->get_user()->loc);
            $row[] = amountExchange($prd->credit, 0, $this->aauth->get_user()->loc);
            $row[] = $prd->account;
            $row[] = $prd->payer;
            $row[] = $prd->method;
            $row[] = '<a href="' . base_url() . 'transactions/view?id=' . $pid . '" class="btn btn-primary btn-xs"><span class="fa fa-eye"></span> View</a> <a  href="#" data-object-id="' . $pid . '" class="btn btn-danger btn-xs delete-object"><span class="fa fa-trash"></span></a> ';
            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->employee->pay_count_all($eid),
            "recordsFiltered" => $this->employee->pay_count_filtered($eid),
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);
    }

    public function attendances()
    {

        $head['usernm'] = $this->aauth->get_user()->username;
        $head['title'] = 'Attendance';
        $this->load->view('fixed/header', $head);
        $this->load->view('employee/attendance_list');
        $this->load->view('fixed/footer');

    }

    public function attendance()
    {
        if ($this->input->post()) {
            $emp = $this->input->post('employee');
            $adate = datefordatabase($this->input->post('adate'));
            $from = timefordatabase($this->input->post('from'));
            $todate = timefordatabase($this->input->post('to'));
            $note = $this->input->post('note');

            if ($this->employee->addattendance($emp, $adate, $from, $todate, $note)) {
                echo json_encode(array('status' => 'Success', 'message' => $this->lang->line('ADDED') . "  <a href='attendance' class='btn btn-blue btn-lg'><span class='fa fa-plus-circle' aria-hidden='true'></span>  </a> <a href='attendances' class='btn btn-grey btn-lg'><span class='fa fa-eye' aria-hidden='true'></span>  </a>"));
            } else {
                echo json_encode(array('status' => 'Error', 'message' => $this->lang->line('ERROR')));
            }
        } else {
            $data['emp'] = $this->employee->list_employee();
            $head['usernm'] = $this->aauth->get_user()->username;
            $head['title'] = 'New Attendance';
            $this->load->view('fixed/header', $head);
            $this->load->view('employee/attendance', $data);
            $this->load->view('fixed/footer');
        }

    }

    public function auto_attendance()
    {
        if ($this->input->post()) {
            $auto_attand = $this->input->post('attend');

            if ($this->employee->autoattend($auto_attand)) {
                echo json_encode(array('status' => 'Success', 'message' => $this->lang->line('UPDATED')));
            } else {
                echo json_encode(array('status' => 'Error', 'message' => $this->lang->line('ERROR')));
            }
        } else {
            $this->load->model('plugins_model', 'plugins');

            $data['auto'] = $this->plugins->universal_api(62);


            $head['usernm'] = $this->aauth->get_user()->username;
            $head['title'] = 'Auto Attendance';
            $this->load->view('fixed/header', $head);
            $this->load->view('employee/autoattend', $data);
            $this->load->view('fixed/footer');
        }

    }


    public function att_list()
    {
        $cid = $this->input->post('cid');
        $list = $this->employee->attendance_datatables($cid);
        $data = array();
        $no = $this->input->post('start');

        foreach ($list as $obj) {

            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $obj->name;
            $row[] = dateformat($obj->adate) . ' &nbsp; ' . $obj->tfrom . ' - ' . $obj->tto;
            $row[] = round((strtotime($obj->tto) - strtotime($obj->tfrom)) / 3600, 2);
            $row[] = round($obj->actual_hours / 3600, 2);
            $row[] = $obj->note;

            $row[] = '<a href="#" data-object-id="' . $obj->id . '" class="btn btn-danger btn-sm delete-object"><span class="fa fa-trash"></span></a>';


            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->employee->attendance_count_all($cid),
            "recordsFiltered" => $this->employee->attendance_count_filtered($cid),
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);
    }

    public function delete_attendance()
    {
        $id = $this->input->post('deleteid');


        if ($this->employee->deleteattendance($id)) {
            echo json_encode(array('status' => 'Success', 'message' => $this->lang->line('DELETED')));
        } else {
            echo json_encode(array('status' => 'Error', 'message' => $this->lang->line('ERROR')));
        }
    }


}