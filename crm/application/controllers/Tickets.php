<?php
/**
 * Geo POS -  Accounting,  Invoicing  and CRM Software
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
        if (!is_login()) {
            redirect(base_url() . 'user/profile', 'refresh');
        }
        $this->load->model('general_model', 'general');
        $this->captcha = $this->general->public_key()->captcha;
        $this->user_id = isset($this->session->get_userdata()['user_details'][0]->id) ? $this->session->get_userdata()['user_details'][0]->users_id : '1';

    }


    //documents


    public function index()
    {

        $head['usernm'] = '';
        $head['title'] = 'Support Tickets';
        $this->load->view('includes/header', $head);
        if ($this->ticket->ticket()->key1) {
            $this->load->view('support/tickets');
        } else {
            $this->load->view('support/general');
        }
        $this->load->view('includes/footer');


    }

    public function tickets_load_list()
    {
        if (!$this->ticket->ticket()->key1) {
            exit();
        }
        $list = $this->ticket->ticket_datatables();
        $data = array();
        $no = $this->input->post('start');
        foreach ($list as $ticket) {
            $row = array();
            $no++;
            $row[] = $no;
            $row[] = $ticket->subject;
            $row[] = $ticket->created;
            $row[] = '<span class="st-' . $ticket->status . '">' . $this->lang->line($ticket->status) . '</span>';

            $row[] = '<a href="' . base_url('tickets/thread/?id=' . $ticket->id) . '" class="btn btn-success btn-xs"><i class="icon-file-text"></i> ' . $this->lang->line('View') . '</a>';


            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->ticket->ticket_count_all(),
            "recordsFiltered" => $this->ticket->ticket_count_filtered(),
            "data" => $data,
        );
        echo json_encode($output);
    }


    public function thread()
    {
        if (!$this->ticket->ticket()->key1) {
            exit();
        }
        $flag = true;
        $data['captcha_on'] = $this->captcha;
        $data['captcha'] = $this->general->public_key()->recaptcha_p;

        $this->load->helper(array('form'));
        $thread_id = $this->input->get('id');

        $data['response'] = 3;
        $head['usernm'] = '';
        $head['title'] = 'Add Support Reply';

        $this->load->view('includes/header', $head);

        if ($this->input->post('content')) {

            if ($this->captcha) {
                $this->load->helper('recaptchalib_helper');
                $reCaptcha = new ReCaptcha($this->general->public_key()->recaptcha_s);
                $resp = $reCaptcha->verifyResponse($this->input->server("REMOTE_ADDR"),
                    $this->input->post("g-recaptcha-response"));

                if (!$resp->success) {
                    $flag = false;

                }
            }

           if ($flag) {

                $title = $this->input->post('title');
                $message = $this->input->post('content');
                $attach = $_FILES['userfile'];

                if ($attach['name'][0]) {


                    $data = array();

                    $countfiles = count($_FILES['userfile']['name']);


                    for ($i = 0; $i < $countfiles; $i++) {

                        if (!empty($_FILES['userfile']['name'][$i])) {


                            $_FILES['file']['name'] =  $_FILES['userfile']['name'][$i];
                            $_FILES['file']['type'] = $_FILES['userfile']['type'][$i];
                            $_FILES['file']['tmp_name'] = $_FILES['userfile']['tmp_name'][$i];
                            $_FILES['file']['error'] = $_FILES['userfile']['error'][$i];
                            $_FILES['file']['size'] = $_FILES['userfile']['size'][$i];


                            $config['upload_path'] = '../userfiles/support';
                            $config['allowed_types'] = 'docx|docs|txt|pdf|xls|png|jpg|gif';
                            $config['max_size'] = 3000;
                            $config['file_name'] =  rand(9,999).time().$_FILES['userfile']['name'][$i];


                            //Load upload library
                            $this->load->library('upload', $config);

                            // File upload
                            if ($this->upload->do_upload('file')) {
                                // Get data about the file
                                $uploadData = $this->upload->data();
                                $filename = $uploadData['file_name'];
                                // Initialize array
                                $data['filenames'][] = $filename;
                            } else {
                                $data['response'] = 0;
                                $data['responsetext'] = 'File Upload Error';
                            }
                        }
                    }
                      $this->ticket->addreply($thread_id, $message,$data['filenames']);
                    $data['response'] = 1;
                    $data['responsetext'] = 'Reply Submitted Successfully.';
                }
 else {
                    $this->ticket->addreply($thread_id, $message, '');
                    $data['response'] = 1;
                    $data['responsetext'] = 'Reply Submitted Successfully.';
                }
            }

         else {

                $data['response'] = 0;
                $data['responsetext'] = 'Captcha Error!';

            }
            $data['thread_info'] = $this->ticket->thread_info($thread_id);
            $data['thread_list'] = $this->ticket->thread_list($thread_id);

            $this->load->view('support/thread', $data);
        } else {

            $data['thread_info'] = $this->ticket->thread_info($thread_id);
            $data['thread_list'] = $this->ticket->thread_list($thread_id);


            $this->load->view('support/thread', $data);


        }
        $this->load->view('includes/footer');


    }

    public function addticket()
    {
        if (!$this->ticket->ticket()->key1) {
            exit();
        }
        $flag = true;
        $data['captcha_on'] = $this->captcha;
        $data['captcha'] = $this->general->public_key()->recaptcha_p;
        $this->load->helper(array('form'));

        $data['response'] = 3;
        $head['usernm'] = '';
        $head['title'] = 'Add Support Ticket';

        $this->load->view('includes/header', $head);

        if ($this->input->post('content')) {
            if ($this->captcha) {
                $this->load->helper('recaptchalib_helper');
                $reCaptcha = new ReCaptcha($this->general->public_key()->recaptcha_s);
                $resp = $reCaptcha->verifyResponse($this->input->server("REMOTE_ADDR"),
                    $this->input->post("g-recaptcha-response"));

                if (!$resp->success) {
                    $flag = false;

                }
            }

            if ($flag) {

                $title = $this->input->post('title');
                $message = $this->input->post('content');
                $attach = $_FILES['userfile'];


                if ($attach) {

                    $data = array();

                    $countfiles = count($_FILES['userfile']['name']);


                    for ($i = 0; $i < $countfiles; $i++) {

                        if (!empty($_FILES['userfile']['name'][$i])) {


                            $_FILES['file']['name'] =  $_FILES['userfile']['name'][$i];
                            $_FILES['file']['type'] = $_FILES['userfile']['type'][$i];
                            $_FILES['file']['tmp_name'] = $_FILES['userfile']['tmp_name'][$i];
                            $_FILES['file']['error'] = $_FILES['userfile']['error'][$i];
                            $_FILES['file']['size'] = $_FILES['userfile']['size'][$i];


                            $config['upload_path'] = '../userfiles/support';
                            $config['allowed_types'] = 'docx|docs|txt|pdf|xls|png|jpg|gif';
                            $config['max_size'] = 3000;
                            $config['file_name'] =  rand(9,999).time().$_FILES['userfile']['name'][$i];


                            //Load upload library
                            $this->load->library('upload', $config);

                            // File upload
                            if ($this->upload->do_upload('file')) {
                                // Get data about the file
                                $uploadData = $this->upload->data();
                                $filename = $uploadData['file_name'];
                                // Initialize array
                                $data['filenames'][] = $filename;
                            } else {
                                $data['response'] = 0;
                                $data['responsetext'] = 'File Upload Error';
                            }
                        }
                    }
                      $this->ticket->addticket($title, $message,$data['filenames']);
                    $data['response'] = 1;
                    $data['responsetext'] = 'Ticket Submitted Successfully.';
                }
 else {
                    $this->ticket->addticket($title, $message, '');
                    $data['response'] = 1;
                    $data['responsetext'] = 'Ticket Submitted Successfully.';
                }
            } else {

                $data['response'] = 0;
                $data['responsetext'] = 'Captcha Error!.';

            }
            $this->load->view('support/addticket', $data);

        } else {


            $this->load->view('support/addticket', $data);


        }
        $this->load->view('includes/footer');


    }


}