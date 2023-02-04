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
require_once APPPATH . 'third_party/qrcode/vendor/autoload.php';

use Endroid\QrCode\QrCode;

defined('BASEPATH') or exit('No direct script access allowed');

// This can be removed if you use __autoload() in config.php OR use Modular Extensions
/** @noinspection PhpIncludeInspection */
require APPPATH . 'libraries/REST_Controller.php';

/**
 * This is an example of a few basic user interaction methods you could use
 * all done with a hardcoded array
 *
 * @package         CodeIgniter
 * @subpackage      Rest Server
 * @category        Controller
 * @author          Phil Sturgeon, Chris Kacerguis
 * @license         MIT
 * @link            https://github.com/chriskacerguis/codeigniter-restserver
 */
class Rest extends REST_Controller
{

    function __construct()
    {
        // Construct the parent class
        parent::__construct();
        // Configure limits on our controller methods
        // Ensure you have created the 'limits' table and enabled 'limits' within application/config/rest.php
        $this->methods['users_get']['limit'] = 500; // 500 requests per hour per user/key
        $this->methods['users_post']['limit'] = 100; // 100 requests per hour per user/key
        $this->methods['users_delete']['limit'] = 50; // 50 requests per hour per user/key
        $this->load->model('restservice_model', 'restservice');
    }

    public function clients_get()
    {
        $id = $this->get('id');
        if ($id === NULL) {
            $list = $this->restservice->customers();
            if ($list) {
                // Set the response and exit
                $this->response($list, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
            } else {
                // Set the response and exit
                $this->response([
                    'status' => FALSE,
                    'message' => 'No Client were found'
                ], REST_Controller::HTTP_NOT_FOUND); // NOT_FOUND (404) being the HTTP response code
            }
        }
        // Find and return a single record for a particular user.
        $id = (int)$id;
        // Validate the id.
        if ($id <= 0) {
            // Invalid id, set the response and exit.
            $this->response(NULL, REST_Controller::HTTP_BAD_REQUEST); // BAD_REQUEST (400) being the HTTP response code
        }
        // Get the user from the array, using the id as key for retrieval.
        // Usually a model is to be used for this.
        $list = $this->restservice->customers($id);
        if (!empty($list)) {
            $this->set_response($list[0], REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
        } else {
            $this->set_response([
                'status' => FALSE,
                'message' => 'Client could not be found'
            ], REST_Controller::HTTP_NOT_FOUND); // NOT_FOUND (404) being the HTTP response code
        }
    }

    public function clients_post()
    {
        $id = $this->post('id');
        if ($id === NULL) {
            $list = $this->restservice->customers();
            // Check if the users data store contains users (in case the database result returns NULL)
            if ($list) {
                // Set the response and exit
                $this->response($list, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
            } else {
                // Set the response and exit
                $this->response([
                    'status' => FALSE,
                    'message' => 'No Client were found'
                ], REST_Controller::HTTP_NOT_FOUND); // NOT_FOUND (404) being the HTTP response code
            }
        }
        // Find and return a single record for a particular user.
        $id = (int)$id;
        // Validate the id.
        if ($id <= 0) {
            // Invalid id, set the response and exit.
            $this->response(NULL, REST_Controller::HTTP_BAD_REQUEST); // BAD_REQUEST (400) being the HTTP response code
        }
        // Get the user from the array, using the id as key for retrieval.
        // Usually a model is to be used for this.
        $list = $this->restservice->customers($id);
        if (!empty($list)) {
            $this->set_response($list[0], REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
        } else {
            $this->set_response([
                'status' => FALSE,
                'message' => 'Client could not be found'
            ], REST_Controller::HTTP_NOT_FOUND); // NOT_FOUND (404) being the HTTP response code
        }
    }


    public function clients_delete()
    {
        $id = (int)$this->get('id');
        // Validate the id.
        if ($id <= 0) {
            // Set the response and exit
            $this->response(NULL, REST_Controller::HTTP_BAD_REQUEST); // BAD_REQUEST (400) being the HTTP response code
        }

        if ($this->restservice->delete_customers($id)) {
            $message = [
                'id' => $id,
                'message' => 'Deleted the resource'
            ];

            $this->set_response($message, REST_Controller::HTTP_NO_CONTENT); // NO_CONTENT (204) being the HTTP response code
        }
    }

    public function products_post()
    {
        $id = $this->post('id');
        if ($id === NULL) {
            $list = $this->restservice->products();
            // Check if the users data store contains users (in case the database result returns NULL)
            if ($list) {
                // Set the response and exit
                $this->response($list, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
            } else {
                // Set the response and exit
                $this->response([
                    'status' => FALSE,
                    'message' => 'No Products were found'
                ], REST_Controller::HTTP_NOT_FOUND); // NOT_FOUND (404) being the HTTP response code
            }
        }
        // Find and return a single record for a particular user.
        $id = (int)$id;
        // Validate the id.
        if ($id <= 0) {
            // Invalid id, set the response and exit.
            $this->response(NULL, REST_Controller::HTTP_BAD_REQUEST); // BAD_REQUEST (400) being the HTTP response code
        }
        // Get the user from the array, using the id as key for retrieval.
        // Usually a model is to be used for this.
        $list = $this->restservice->products($id);
        if (!empty($list)) {
            $this->set_response($list[0], REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
        } else {
            $this->set_response([
                'status' => FALSE,
                'message' => 'Products could not be found'
            ], REST_Controller::HTTP_NOT_FOUND); // NOT_FOUND (404) being the HTTP response code
        }
    }

    public function invoice_get()
    {
        $id = $this->get('id');

        if ($id === NULL) {
            $list = $this->restservice->invoice($id);
            // Check if the users data store contains users (in case the database result returns NULL)
            if ($list) {
                // Set the response and exit
                $this->response($list, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
            } else {
                // Set the response and exit
                $this->response([
                    'status' => FALSE,
                    'message' => 'No Products were found'
                ], REST_Controller::HTTP_NOT_FOUND); // NOT_FOUND (404) being the HTTP response code
            }
        }
        // Find and return a single record for a particular user.
        $id = (int)$id;
        // Validate the id.
        if ($id <= 0) {
            // Invalid id, set the response and exit.
            $this->response(NULL, REST_Controller::HTTP_BAD_REQUEST); // BAD_REQUEST (400) being the HTTP response code
        }
        // Get the user from the array, using the id as key for retrieval.
        // Usually a model is to be used for this.
        $list = $this->restservice->invoice($id);
        if (!empty($list)) {
            $this->set_response($list[0], REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
        } else {
            $this->set_response([
                'status' => FALSE,
                'message' => 'Invoice could not be found'
            ], REST_Controller::HTTP_NOT_FOUND); // NOT_FOUND (404) being the HTTP response code
        }
    }

    public function invoicepdf_get()
    {
        $run = false;
        $this->load->model('pos_invoices_model', 'invocies');
        $id = $this->get('id');
        $key = $this->get('key');
        $this->db->select('key');
        $this->db->from('geopos_restkeys');
        $this->db->limit(1);
        $this->db->where('key', $key);
        $query_r = $this->db->get();
        if ($query_r->num_rows() > 0) {
            $run = true;
        }


        if (!$run) {
            $this->set_response([
                'status' => FALSE,
                'message' => 'Invoice could not be found'
            ], REST_Controller::HTTP_NOT_FOUND);
        }


        // Get the user from the array, using the id as key for retrieval.
        // Usually a model is to be used for this.
        $this->load->library('Aauth');
        $this->load->library('Custom');
        $tid = $id;
        $data['qrc'] = 'pos_' . date('Y_m_d_H_i_s') . '_.png';
        $data['id'] = $tid;
        $data['title'] = "Invoice $tid";
        $data['invoice'] = $this->invocies->invoice_details($tid);
        if ($data['invoice']) $data['products'] = $this->invocies->invoice_products($tid);
        if ($data['invoice']) $data['employee'] = $this->invocies->employee($data['invoice']['eid']);


        $this->load->model('billing_model', 'billing');
        $online_pay = $this->billing->online_pay_settings();
        if ($online_pay['enable'] == 1) {
            $token = hash_hmac('ripemd160', $tid, $this->config->item('encryption_key'));
            $data['qrc'] = 'pos_' . date('Y_m_d_H_i_s') . '_.png';

            $qrCode = QrCode::create(base_url('billing/card?id=' . $tid . '&itype=inv&token=' . $token))
                ->setEncoding(new Encoding('UTF-8'))
                ->setSize(300)
                ->setRoundBlockSizeMode(new RoundBlockSizeModeMargin())
                ->setForegroundColor(new Color(0, 0, 0))
                ->setBackgroundColor(new Color(255, 255, 255));

            $writer = new \Endroid\QrCode\Writer\PngWriter();
            $result = $writer->write($qrCode);
            $result->saveToFile(FCPATH . 'userfiles/pos_temp/' . $data['qrc']);

           // $qrCode = new QrCode(base_url('billing/card?id=' . $tid . '&itype=inv&token=' . $token));

//header('Content-Type: '.$qrCode->getContentType());
//echo $qrCode->writeString();
          //  $qrCode->writeFile(FCPATH . 'userfiles/pos_temp/' . $data['qrc']);
        }

        $this->pheight = 0;
        $this->load->library('pdf');
        $pdf = $this->pdf->load_thermal();
        // retrieve data from model or just static date
        $data['title'] = "items";
        $pdf->allow_charset_conversion = true;  // Set by default to TRUE
        $pdf->charset_in = 'UTF-8';
        //   $pdf->SetDirectionality('rtl'); // Set lang direction for rtl lang
        $pdf->autoLangToFont = true;
        $data['round_off'] = $this->custom->api_config(4);
        $html = $this->load->view('print_files/pos_pdf_compact', $data, true);
        // render the view into HTML

        $h = 160 + $this->pheight;
        $pdf->_setPageSize(array(70, $h), $pdf->DefOrientation);
        $pdf->WriteHTML($html);
        $file_name = substr($key, 0, 6) . $id;
        $pdf->Output('userfiles/pos_temp/' . $file_name . '.pdf', 'F');
        if (!extension_loaded('imagick')) {
            $this->set_response([
                'status' => FALSE,
                'message' => 'Imagick extension not installed!'
            ], REST_Controller::HTTP_OK);
        }
        $im = new Imagick();
        $im->setResolution(300, 300);
        $im->readimage(FCPATH . 'userfiles/pos_temp/' . $file_name . '.pdf');
        $im->setImageType(imagick::IMGTYPE_TRUECOLOR);
        $im->setImageFormat('png');
        //$im->transparentPaintImage(      'white', 0, 100, false    );
        $im->writeImage(FCPATH . 'userfiles/pos_temp/rest-' . $file_name . '.png');
        $im->clear();
        $im->destroy();
        unlink('userfiles/pos_temp/' . $data['qrc']);
        unlink(FCPATH . 'userfiles/pos_temp/' . $file_name . '.pdf');
        $this->set_response(array('w' => 1), REST_Controller::HTTP_OK);

    }


}
