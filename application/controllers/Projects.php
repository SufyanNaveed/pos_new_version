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

class Projects extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library("Aauth");
        $this->load->model('projects_model', 'projects');
        $this->load->model('tools_model', 'tools');

        if (!$this->aauth->is_loggedin()) {
            redirect('/user/', 'refresh');
        }
        if (!$this->aauth->premission(4)) {
            exit('<h3>Sorry! You have insufficient permissions to access this section</h3>');
        }
        $this->li_a = 'project';

    }

    //todo section

    public function index()
    {
        $head['usernm'] = $this->aauth->get_user()->username;
        $head['title'] = 'Project List';
        $data['totalt'] = $this->projects->project_count_all();
        $data['eid'] = intval($this->input->get('eid'));
        $this->load->view('fixed/header', $head);
        $this->load->view('projects/index', $data);
        $this->load->view('fixed/footer');

    }

    public function explore()
    {
        $id = $this->input->get('id');
        $head['usernm'] = $this->aauth->get_user()->username;
        $head['title'] = 'Project Overview';
        $data['totalt'] = $this->projects->task_count_all($id);
        $explore = $this->projects->explore($id);
        $data['thread_list'] = $this->projects->task_thread($id);
        $data['milestones'] = $this->projects->milestones_list($id);
        $data['activities'] = $this->projects->activities($id);
        $data['p_files'] = $this->projects->p_files($id);
        $data['comments_list'] = $this->projects->comments_thread($id);
        $data['emp'] = $this->projects->list_project_employee($id);
        $data['emp_time'] = $this->projects->list_project_time($id);
        $this->load->library('session');

        $this->session->set_userdata('pr_id', $id);
        $data['project'] = $explore['project'];
        $data['clock'] = $explore['clock'];
        // $data['customer']=$explore['customer'];
        $data['invoices'] = $explore['invoices'];

        $this->load->view('fixed/header', $head);
        $this->load->view('projects/explore', $data);
        $this->load->view('fixed/footer');

    }

    public function addproject()
    {

        if ($this->input->post()) {

            $name = $this->input->post('name', true);
            $status = $this->input->post('status', true);
            $priority = $this->input->post('priority', true);
            $progress = $this->input->post('progress', true);
            $customer = $this->input->post('customer', true);
            $sdate = $this->input->post('sdate', true);
            $edate = $this->input->post('edate', true);
            $tag = $this->input->post('tags', true);
            $phase = $this->input->post('phase', true);
            $content = $this->input->post('content');
            $budget = numberClean($this->input->post('worth'));
            $customerview = $this->input->post('customerview');
            $customercomment = $this->input->post('customercomment');
            $link_to_cal = $this->input->post('link_to_cal');
            $color = $this->input->post('color');
            $ptype = $this->input->post('ptype');
            $employee = $this->input->post('employee');
            $sdate = datefordatabase($sdate);
            $edate = datefordatabase($edate);

            if ($this->projects->addproject($name, $status, $priority, $progress, $customer, $sdate, $edate, $tag, $phase, $content, $budget, $customerview, $customercomment, $link_to_cal, $color, $ptype, $employee)) {
                echo json_encode(array('status' => 'Success', 'message' => '[Project] ' . $this->lang->line('ADDED') . ' <a href="' . base_url('projects') . '" class="btn btn-blue btn-lg"><span class="fa fa-list-alt" aria-hidden="true"></span> </a>' . ' <a href="' . base_url('projects/addproject') . '" class="btn btn-info btn-lg"><span class="fa fa-plus-circle" aria-hidden="true"></span> </a>'));
            } else {
                echo json_encode(array('status' => 'Error', 'message' => $this->lang->line('ERROR')));
            }

        } else {
            $this->load->model('employee_model', 'employee');
            $head['usernm'] = $this->aauth->get_user()->username;
            $data['emp'] = $this->employee->list_employee();
            $head['title'] = 'Add Project';
            $this->load->view('fixed/header', $head);
            $this->load->view('projects/addproject', $data);
            $this->load->view('fixed/footer');
        }

    }

    //edit project

    public function edit()
    {


        if ($this->input->post()) {
            $pid = $this->input->post('p_id');
            $name = $this->input->post('name', true);
            $status = $this->input->post('status', true);
            $priority = $this->input->post('priority');
            $progress = $this->input->post('progress');
            $customer = $this->input->post('customer');
            $sdate = $this->input->post('sdate');
            $edate = $this->input->post('edate');
            $tag = $this->input->post('tags');
            $phase = $this->input->post('phase');
            $content = $this->input->post('content');
            $budget = numberClean($this->input->post('worth'));
            $customerview = $this->input->post('customerview');
            $customercomment = $this->input->post('customercomment');
            $link_to_cal = $this->input->post('link_to_cal');
            $color = $this->input->post('color');
            $ptype = $this->input->post('ptype');
            $employee = $this->input->post('employee');
            $sdate = datefordatabase($sdate);
            $edate = datefordatabase($edate);
            if ($this->projects->editproject($pid, $name, $status, $priority, $progress, $customer, $sdate, $edate, $tag, $phase, $content, $budget, $customerview, $customercomment, $link_to_cal, $color, $ptype, $employee)) {
                echo json_encode(array('status' => 'Success', 'message' => '[Project] ' . $this->lang->line('UPDATED')));
            } else {
                echo json_encode(array('status' => 'Error', 'message' => $this->lang->line('ERROR')));
            }

        } else {
            $id = $this->input->get('id');
            $this->load->model('employee_model', 'employee');
            $data['project'] = $this->projects->details($id);
            $head['usernm'] = $this->aauth->get_user()->username;
            $data['emp'] = $this->employee->list_employee();
            $data['emp2'] = $this->projects->list_project_employee($id);
            $head['title'] = 'Edit Project';
            $this->load->view('fixed/header', $head);
            $this->load->view('projects/editproject', $data);
            $this->load->view('fixed/footer');
        }

    }


    //tasks section

    public function addtask()
    {
        $this->load->model('employee_model', 'employee');
        $head['usernm'] = $this->aauth->get_user()->username;
        $head['title'] = 'Add Task';
        $data['prid'] = $this->input->get('id');
        $data['milestones'] = $this->projects->milestones($data['prid']);
        $data['emp'] = $this->employee->list_project_employee($data['prid']);

        $this->load->view('fixed/header', $head);
        $this->load->view('projects/addtask', $data);
        $this->load->view('fixed/footer');

    }


    public function addmilestone()
    {

        if ($this->input->post()) {
            $name = $this->input->post('name');
            $stdate = $this->input->post('staskdate');
            $tdate = $this->input->post('taskdate');
            $content = $this->input->post('content');
            $color = $this->input->post('color');
            $prid = $this->input->post('project');
            $stdate = datefordatabase($stdate);
            $tdate = datefordatabase($tdate);

            if ($this->projects->add_milestone($name, $stdate, $tdate, $content, $color, $prid)) {
                echo json_encode(array('status' => 'Success', 'message' => $this->lang->line('ADDED') . '&nbsp; Return to project <a href="' . base_url("projects/explore?id=" . $prid) . '" class="btn btn-primary btn-xs"><i class="icon-eye"></i> ' . $this->lang->line('Yes') . '</a>'));
            } else {
                echo json_encode(array('status' => 'Error', 'message' => $this->lang->line('ERROR')));
            }

        } else {

            $this->load->model('employee_model', 'employee');
            $head['usernm'] = $this->aauth->get_user()->username;
            $data['emp'] = $this->employee->list_employee();
            $head['title'] = 'Add milestone';
            $data['prid'] = $this->input->get('id');

            $this->load->view('fixed/header', $head);
            $this->load->view('projects/addmilestone', $data);
            $this->load->view('fixed/footer');
        }

    }

    public function addactivity()
    {

        if ($this->input->post()) {
            $name = $this->input->post('name');
            $prid = $this->input->post('project');

            if ($this->projects->add_activity($name, $prid)) {
                echo json_encode(array('status' => 'Success', 'message' => $this->lang->line('ADDED') . '&nbsp; Return to project <a href="' . base_url("projects/explore?id=" . $prid) . '" class="btn btn-primary btn-xs"><i class="icon-eye"></i> ' . $this->lang->line('Yes') . '</a>'));
            } else {
                echo json_encode(array('status' => 'Error', 'message' => $this->lang->line('ERROR')));
            }

        } else {

            $this->load->model('employee_model', 'employee');
            $head['usernm'] = $this->aauth->get_user()->username;
            $data['emp'] = $this->employee->list_employee();
            $head['title'] = 'Add activity';
            $data['prid'] = $this->input->get('id');

            $this->load->view('fixed/header', $head);
            $this->load->view('projects/addactivity', $data);
            $this->load->view('fixed/footer');
        }

    }

    public function edittask()
    {
        if ($this->input->post()) {
            $id = $this->input->post('id');
            $name = $this->input->post('name');
            $status = $this->input->post('status');
            $priority = $this->input->post('priority');
            $stdate = $this->input->post('staskdate');
            $tdate = $this->input->post('taskdate');
            $employee = $this->input->post('employee');
            $content = $this->input->post('content');
            $stdate = datefordatabase($stdate);
            $tdate = datefordatabase($tdate);

            if ($this->projects->edittask($id, $name, $status, $priority, $stdate, $tdate, $employee, $content)) {

                $prid = @$this->session->userdata('pr_id');
                echo json_encode(array('status' => 'Success', 'message' => $this->lang->line('UPDATED') . '&nbsp; Return to project <a href="' . base_url("projects/explore?id=" . $prid) . '" class="btn btn-primary btn-xs"><i class="icon-eye"></i> ' . $this->lang->line('Yes') . '</a>'));
            } else {
                echo json_encode(array('status' => 'Error', 'message' => $this->lang->line('ERROR')));
            }
        } else {

            $this->load->model('employee_model', 'employee');

            $head['usernm'] = $this->aauth->get_user()->username;

            $head['title'] = 'Edit Task';

            $id = $this->input->get('id');
            $data['task'] = $this->projects->viewtask($id);
            $data['emp'] = $this->employee->list_project_employee($id);

            if ($data['task'])


                $this->load->view('fixed/header', $head);
            $this->load->view('projects/edittask', $data);
            $this->load->view('fixed/footer');
        }

    }

    public function save_addtask()
    {
        $name = $this->input->post('name');
        $status = $this->input->post('status');
        $priority = $this->input->post('priority');
        $stdate = $this->input->post('staskdate');
        $tdate = $this->input->post('taskdate');
        $employee = $this->input->post('employee');
        $content = $this->input->post('content');
        $prid = $this->input->post('project');
        $milestone = $this->input->post('milestone');
        $assign = $this->aauth->get_user()->id;
        $stdate = datefordatabase($stdate);
        $tdate = datefordatabase($tdate);
        // $out=$this->projects->addtask($name, $status, $priority, $stdate, $tdate, $employee, $assign, $content, $prid, $milestone);
        // print_r($out);
        if ($this->projects->addtask($name, $status, $priority, $stdate, $tdate, $employee, $assign, $content, $prid, $milestone)) {

            echo json_encode(array('status' => 'Success', 'message' => $this->lang->line('New Task Added') . '&nbsp; Return to project <a href="' . base_url("projects/explore?id=" . $prid) . '" class="btn btn-primary btn-xs"><i class="icon-eye"></i> ' . $this->lang->line('Yes') . '</a>'));

        } else {
            echo json_encode(array('status' => 'Error', 'message' => $this->lang->line('ERROR')));
        }

    }

    public function set_task()
    {
        $id = $this->input->post('tid');
        $stat = $this->input->post('stat');
        $this->tools->settask($id, $stat);
        echo json_encode(array('status' => 'Success', 'message' => $this->lang->line('UPDATED'), 'pstatus' => 'Success'));


    }

    public function view_task()
    {
        $id = $this->input->post('tid');

        $task = $this->tools->viewtask($id);

        echo json_encode(array('name' => $task['name'], 'description' => $task['description'], 'employee' => $task['emp'], 'assign' => $task['assign'], 'priority' => $task['priority']));
    }

    public function projects_stats()
    {

        $project = $this->input->get('id');
        //echo $project;
        $this->projects->project_stats($project);


    }

    public function delete_i()
    {
        $id = $this->input->post('deleteid');

        if ($this->projects->deleteproject($id)) {
            echo json_encode(array('status' => 'Success', 'message' => $this->lang->line('DELETED')));
        } else {
            echo json_encode(array('status' => 'Error', 'message' => $this->lang->line('ERROR')));
        }
    }


    public function project_load_list()
    {
        $cday = $this->input->get('cday');
        $eid = 0;
        if ($this->aauth->premission(9)) {
            $eid = $this->input->post('eid');
        }
        $list = $this->projects->project_datatables($cday, $eid);
        $data = array();
        $no = $this->input->post('start');
        foreach ($list as $project) {
            $no++;
            $name = '<a href="' . base_url() . 'projects/explore?id=' . $project->id . '">' . $project->name . '</a>';

            $row = array();
            $row[] = $no;
            $row[] = $name;
            $row[] = dateformat($project->edate);
            $row[] = $project->customer;
            $row[] = '<span class="project_' . $project->status . '">' . $this->lang->line($project->status) . '</span>';

            $row[] = '<a href="' . base_url() . 'projects/explore?id=' . $project->id . '" class="btn btn-primary btn-sm rounded" data-id="' . $project->id . '" data-stat="0"> <i class="fa fa-eye"></i>  ' . $this->lang->line('View') . ' </a> <a class="btn btn-info btn-sm" href="' . base_url() . 'projects/edit?id=' . $project->id . '" data-object-id="' . $project->id . '"> <i class="fa fa-pencil"></i> </a>&nbsp;<a class="btn btn-danger btn-sm delete-object" href="#" data-object-id="' . $project->id . '"> <i class="fa fa-trash"></i> </a>';


            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->projects->project_count_all($cday, $eid),
            "recordsFiltered" => $this->projects->project_count_filtered($cday, $eid),
            "data" => $data,
        );
        echo json_encode($output);
    }


    public function pendingtasks()
    {
        $tasks = $this->projects->pending_tasks();

        $tlist = '';
        $tc = 0;
        foreach ($tasks as $row) {


            $tlist .= '<a href="javascript:void(0)" class="list-group-item">
                      <div class="media">
                        <div class="media-left valign-middle"><i class="icon-bullhorn2 icon-bg-circle bg-cyan"></i></div>
                        <div class="media-body">
                          <h6 class="media-heading">' . $row['name'] . '</h6>
                          <p class="notification-text font-small-2 text-muted">Due date is ' . $row['duedate'] . '.</p><small>
                            Start <time  class="media-meta text-muted">' . $row['start'] . '</time></small>
                        </div>
                      </div></a>';
            $tc++;
        }

        echo json_encode(array('tasks' => $tlist, 'tcount' => $tc));


    }

    //tasks

    public function todo_load_list()
    {
        $pid = $this->input->post('pid');
        $list = $this->projects->task_datatables($pid);
        $data = array();
        $no = $this->input->post('start');

        foreach ($list as $task) {
            $no++;
            $name = '<a class="check text-default" data-id="' . $task->id . '" data-stat="Due"> <i class="icon-check"></i> </a><a href="#" data-id="' . $task->id . '" class="view_task">' . $task->name . '</a>';
            if ($task->status == 'Done') {
                $name = '<a class="check text-success" data-id="' . $task->id . '" data-stat="Done"> <i class="icon-check"></i> </a><a href="#" data-id="' . $task->id . '" class="view_task">' . $task->name . '</a>';
            }
            $row = array();
            $row[] = $no;
            $row[] = '<a href="#" class="btn btn-primary btn-sm rounded set-task" data-id="' . $task->id . '" data-stat="0"> SET </a>' . $name;
            $row[] = dateformat($task->duedate);
            $row[] = dateformat($task->start);
            $row[] = '<span class="task_' . $task->status . '">' . $this->lang->line($task->status) . '</span>';

            $row[] = '<a class="btn-info btn-sm" href="' . base_url('projects') . '/edittask?id=' . $task->id . '" data-object-id="' . $task->id . '"> <i class="icon-pencil"></i> </a>&nbsp;<a class="btn-brown btn-sm delete-custom" data-did="3" href="#"  data-object-id="' . $task->id . '"> <i class="fa fa-trash"></i> </a>';


            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->projects->task_count_all($pid),
            "recordsFiltered" => $this->projects->task_count_filtered($pid),
            "data" => $data,
        );
        echo json_encode($output);
    }


    public function file_handling()
    {
        $id = $this->input->get('id');
        $this->load->library("Uploadhandler_generic", array(
            'accept_file_types' => '/\.(gif|jpe?g|png|docx|docs|txt|pdf|xls)$/i', 'upload_dir' => FCPATH . 'userfiles/project/', 'upload_url' => base_url() . 'userfiles/project/'
        ));
        $files = (string)$this->uploadhandler_generic->filenaam();
        if ($files != '') {
            $fid = rand(100, 9999);
            $this->projects->meta_insert($id, 9, $fid, $files);
        }


    }

    public function set_note()
    {
        $id = $this->input->post('nid');
        $stat = $this->input->post('content');
        $this->projects->setnote($id, $stat);
        echo json_encode(array('status' => 'Success', 'message' => $this->lang->line('UPDATED'), 'pstatus' => 'Success'));


    }

    public function delete_file()
    {
        $fileid = $this->input->post('object_id');
        $pid = $this->input->post('project_id');
        $this->projects->deletefile($pid, $fileid);
        echo json_encode(array('status' => 'Success', 'message' => $this->lang->line('DELETED')));


    }

    public function delete_milestone()
    {
        $mid = $this->input->post('object_id');

        $this->projects->deletemilestone($mid);


        echo json_encode(array('status' => 'Success', 'message' => $this->lang->line('DELETED')));


    }


    //comm section

    public function addcomment()
    {
        $comment = $this->input->post('content');
        $pid = $this->input->post('nid');
        $head['usernm'] = $this->aauth->get_user()->username;
        $head['title'] = 'Add Comment';

        if ($this->projects->add_comment($comment, $pid, $this->aauth->get_user()->id)) {
            echo json_encode(array('status' => 'Success', 'message' => $this->lang->line('ADDED')));
        } else {

            echo json_encode(array('status' => 'Error', 'message' => $this->lang->line('ERROR')));

        }


    }

    public function progress()
    {
        $pid = $this->input->post('pid');
        $val = $this->input->post('val');
        $this->projects->progress($pid, $val);

    }

    public function task_stats()
    {
        $id = $this->input->get('id');
        $this->projects->task_stats(intval($id));
    }


    public function clock_in()
    {
        $id = $this->input->get('id');
        $eid = $this->aauth->get_user()->id;
        $this->projects->clockin($id, $eid);
        redirect('projects/explore?id=' . $id);
    }

    public function clock_out()
    {
        $id = $this->input->get('id');
        $eid = $this->aauth->get_user()->id;
        $this->projects->clockout($id, $eid);
        redirect('projects/explore?id=' . $id);
    }


}