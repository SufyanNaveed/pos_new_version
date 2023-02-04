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

class Communication extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('communication_model');
        $this->load->library("Aauth");
        if (!$this->aauth->is_loggedin()) {
            redirect('/user/', 'refresh');
        }
    }

    public function send_invoice()
    {
        if (!$this->aauth->premission(1)) {
            exit('<h3>Sorry! You have insufficient permissions to access this section</h3>');
        }
        $mailtoc = $this->input->post('mailtoc');
        $mailtotilte = $this->input->post('customername');
        $subject = $this->input->post('subject');

        $message = $this->input->post('message');
        $att = $this->input->post('attach');
        $attachmenttrue = false;
        $attachment = '';
        if ($att) {
            $tid = $this->input->post('tid');
            $attachmenttrue = true;
            $attach = $this->mail_attach($tid);
            $attachment = FCPATH . DIRECTORY_SEPARATOR . 'userfiles' . DIRECTORY_SEPARATOR . 'temp' . DIRECTORY_SEPARATOR . 'Invoice_' . $tid . '.pdf';
        }

        $this->communication_model->send_email($mailtoc, $mailtotilte, $subject, $message, $attachmenttrue, $attachment);
        if ($att) {
            unlink(FCPATH . DIRECTORY_SEPARATOR . 'userfiles' . DIRECTORY_SEPARATOR . 'temp' . DIRECTORY_SEPARATOR . 'Invoice_' . $tid . '.pdf');
        }
    }

    public function send_general()
    {
        $mailtoc = $this->input->post('mailtoc');
        $mailtotilte = $this->input->post('customername');
        $subject = $this->input->post('subject');
        $message = $this->input->post('text');
        $attachmenttrue = false;
        $attachment = '';
        $this->communication_model->send_email($mailtoc, $mailtotilte, $subject, $message, $attachmenttrue, $attachment);
    }


    private function mail_attach($tid)
    {
        $this->load->model('invoices_model', 'invocies');
        $this->load->library("Custom");
        $data['id'] = $tid;
        $data['invoice'] = $this->invocies->invoice_details($tid);
        $data['title'] = "Invoice " . $data['invoice']['tid'];
        $data['products'] = $this->invocies->invoice_products($tid);
        $data['employee'] = $this->invocies->employee($data['invoice']['eid']);
        if (CUSTOM) $data['c_custom_fields'] = $this->custom->view_fields_data($data['invoice']['cid'], 1, 1);

        $data['round_off'] = $this->custom->api_config(4);
        if ($data['invoice']['i_class'] == 1) {
            $pref = prefix(7);
        } elseif ($data['invoice']['i_class'] > 1) {
            $pref = prefix(3);
        } else {
            $pref = $this->config->item('prefix');
        }
        $data['general'] = array('title' => $this->lang->line('Invoice'), 'person' => $this->lang->line('Customer'), 'prefix' => $pref, 't_type' => 0);
        ini_set('memory_limit', '64M');
        if ($data['invoice']['taxstatus'] == 'cgst' || $data['invoice']['taxstatus'] == 'igst') {
            $html = $this->load->view('print_files/invoice-a4-gst_v' . INVV, $data, true);
        } else {
            $html = $this->load->view('print_files/invoice-a4_v' . INVV, $data, true);
        }
        //PDF Rendering
        $this->load->library('pdf');
        if (INVV == 1) {
            $header = $this->load->view('print_files/invoice-header_v' . INVV, $data, true);
            $pdf = $this->pdf->load_split(array('margin_top' => 40));
            $pdf->SetHTMLHeader($header);
        }
        if (INVV == 2) {
            $pdf = $this->pdf->load_split(array('margin_top' => 5));
        }
        $pdf->SetHTMLFooter('<div style="text-align: right;font-family: serif; font-size: 8pt; color: #5C5C5C; font-style: italic;margin-top:-6pt;">{PAGENO}/{nbpg} #' . $data['invoice']['tid'] . '</div>');
        $pdf->WriteHTML($html);

        return $pdf->Output(FCPATH . DIRECTORY_SEPARATOR . 'userfiles' . DIRECTORY_SEPARATOR . 'temp' . DIRECTORY_SEPARATOR . 'Invoice_' . $tid . '.pdf', 'F');
        //   return $pdf->Output('Invoice_' . $data['invoice']['tid'] . '.pdf', 'S');


    }


}