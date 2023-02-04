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

class Tickets extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('ticket_model', 'ticket');
        $this->load->library("Aauth");
        if (!$this->aauth->is_loggedin()) {
            redirect('/user/', 'refresh');
        }
        if (!$this->aauth->premission(3)) {

            exit('<h3>Sorry! You have insufficient permissions to access this section</h3>');

        }
        $this->li_a = 'crm';

    }


    //documents


    public function index()
    {

        $head['usernm'] = $this->aauth->get_user()->username;
        $head['title'] = 'Support Tickets';
        $data['totalt'] = $this->ticket->ticket_count_all('');
        $this->load->view('fixed/header', $head);
        $this->load->view('support/tickets', $data);
        $this->load->view('fixed/footer');


    }

    public function tickets_load_list()
    {
        $filt = $this->input->get('stat');
        $list = $this->ticket->ticket_datatables($filt);
        $data = array();
        $no = $this->input->post('start');

        foreach ($list as $ticket) {
            $row = array();
            $no++;
            $row[] = $no;
            $row[] = $ticket->subject;
            $row[] = dateformat_time($ticket->created);
            $row[] = '<span class="st-' . $ticket->status . '">' . $ticket->status . '</span>';

            $row[] = '<a href="' . base_url('tickets/thread/?id=' . $ticket->id) . '" class="btn btn-success btn-xs"><i class="fa fa-eye"></i> ' . $this->lang->line('View') . '</a> <a class="btn btn-danger btn-xs delete-object" href="#" data-object-id="' . $ticket->id . '"> <i class="fa fa-trash "></i> </a>';


            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->ticket->ticket_count_all($filt),
            "recordsFiltered" => $this->ticket->ticket_count_filtered($filt),
            "data" => $data,
        );
        echo json_encode($output);
    }

    public function ticket_stats()
    {

        $this->ticket->ticket_stats();


    }


    public function thread()
    {

        $this->load->helper(array('form'));
        $thread_id = $this->input->get('id');

        $data['response'] = 3;
        $head['usernm'] = $this->aauth->get_user()->username;
        $head['title'] = 'Add Support Reply';

        $this->load->view('fixed/header', $head);

        if ($this->input->post('content')) {

            $message = $this->input->post('content');
            $attach = $_FILES['userfile']['name'];
            if ($attach) {
                $config['upload_path'] = './userfiles/support';
                $config['allowed_types'] = 'docx|docs|txt|pdf|xls|png|jpg|gif';
                $config['max_size'] = 3000;
                $config['file_name'] = time() . $attach;
                $this->load->library('upload', $config);

                if (!$this->upload->do_upload('userfile')) {
                    $data['response'] = 0;
                    $data['responsetext'] = 'File Upload Error';

                } else {
                    $data['response'] = 1;
                    $data['responsetext'] = 'Reply Added Successfully.';
                    $filename = $this->upload->data()['file_name'];
                    $this->ticket->addreply($thread_id, $message, $filename);
                }
            } else {
                $this->ticket->addreply($thread_id, $message, '');
                $data['response'] = 1;
                $data['responsetext'] = 'Reply Added Successfully.';
            }

            $data['thread_info'] = $this->ticket->thread_info($thread_id);
            $data['thread_list'] = $this->ticket->thread_list($thread_id);

            $this->load->view('support/thread', $data);
        } else {

            $data['thread_info'] = $this->ticket->thread_info($thread_id);
            $data['thread_list'] = $this->ticket->thread_list($thread_id);


            $this->load->view('support/thread', $data);


        }
        $this->load->view('fixed/footer');


    }


    public function delete_ticket()
    {
        $id = $this->input->post('deleteid');

        if ($this->ticket->deleteticket($id)) {
            echo json_encode(array('status' => 'Success', 'message' => $this->lang->line('DELETED')));
        } else {
            echo json_encode(array('status' => 'Error', 'message' => $this->lang->line('ERROR')));
        }
    }

    public function update_status()
    {
        $tid = $this->input->post('tid');
        $status = $this->input->post('status');


        $this->db->set('status', $status);
        $this->db->where('id', $tid);
        $this->db->update('geopos_tickets');

        echo json_encode(array('status' => 'Success', 'message' =>
            $this->lang->line('UPDATED'), 'pstatus' => $status));
    }


}