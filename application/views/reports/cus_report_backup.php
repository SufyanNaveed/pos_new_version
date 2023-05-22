<?php
$due = false;
if ($this->input->get('due')) {
    $due = true;
} ?>
<div class="content-body">
    <div class="card">
        <div class="card-header">
            <h4 class="card-title"> <?php echo $this->lang->line('Customers').' '.$this->lang->line('Report') ?></h4>
            <a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
            <div class="heading-elements">
                <ul class="list-inline mb-0">
                    <li><a data-action="collapse"><i class="ft-minus"></i></a></li>
                    <li><a data-action="expand"><i class="ft-maximize"></i></a></li>
                    <li><a data-action="close"><i class="ft-x"></i></a></li>
                </ul>
            </div>
        </div>
        <div class="card-content">
            <div id="notify" class="alert alert-success" style="display:none;">
                <a href="#" class="close" data-dismiss="alert">&times;</a>

                <div class="message"></div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-2"><?php echo $this->lang->line('Invoice Date') ?></div>
                    <div class="col-md-2">
                        <input type="text" name="start_date" id="start_date"
                            class="date30 form-control" autocomplete="off"/>
                    </div>
                    <div class="col-md-2">
                        <input type="text" name="end_date" id="end_date" class="form-control"
                            data-toggle="datepicker" autocomplete="off"/>
                    </div>

                    <!-- <div class="col-md-4">
                        <select id="loc" class="form-control select-box" multiple="multiple">
                            <?php $loc = location($this->aauth->get_user()->loc);
                                $current_loc =  $loc['id'];
                                //echo ' <option value="' . $loc['id'] . '" selected > *' . $loc['cname'] . '*</option>';
                            $loc = locations();
                            foreach ($loc as $row) { 
                                // if($row['id'] != $current_loc){
                                    echo ' <option value="' . $row['id'] . '"> ' . $row['cname'] . '</option>';
                                // }
                            }
                            echo ' <option value="0">Master/Default</option>';
                            ?>
                        </select>
                    </div> -->

                    <div class="col-md-2">
                        <input type="button" name="search" id="search" value="Search" class="btn btn-info"/>
                    </div>

                    </div>
                <table id="clientstable" class="table table-striped table-bordered zero-configuration" cellspacing="0"
                       width="100%">
                    <thead>
                        <tr>
                            <!-- <th><?php echo $this->lang->line('serialNO') ?></th>
                            <th>#</th>
                            <th><?php echo $this->lang->line('Date') ?></th>
                            <th><?php echo $this->lang->line('Name') ?></th>
                            <th><?php echo $this->lang->line('Address') ?></th>
                            <th><?php echo $this->lang->line('Phone') ?></th>
                            <th><?php echo $this->lang->line('Email') ?></th> 
                            <th><?php echo $this->lang->line('Qty') ?></th>
                            <th><?php echo $this->lang->line('Net_amount') ?></th>
                            <th><?php echo $this->lang->line('total_Vat') ?></th>
                            <th><?php echo $this->lang->line('Grand Total') ?></th>
                            <th><?php echo $this->lang->line('Cash') ?></th>
                            <th><?php echo $this->lang->line('Card') ?></th>
                            <th><?php echo $this->lang->line('Credit Note') ?></th> -->
                            
                            <th><?php echo $this->lang->line('No') ?></th>
                            <th> #</th>
                            <th> Staff</th>
                            <th><?php echo $this->lang->line('Date') ?></th>
                            <th><?php echo $this->lang->line('Customer') ?></th>
                            <th><?php echo $this->lang->line('Phone') ?></th>
                            <th><?php echo $this->lang->line('Address') ?></th>
                            <th><?php echo $this->lang->line('Product Code') ?></th>
                            <th><?php echo $this->lang->line('Product Name') ?></th>
                            <th><?php echo $this->lang->line('Category') ?></th>
                            <th><?php echo $this->lang->line('Quantity') ?></th>
                            <th><?php echo 'Net amount' ?></th>
                            <th><?php echo 'VAT' ?></th>
                            <th><?php echo 'Grand Total' ?></th>
                            <th><?php echo 'Payment Method' ?></th>
                            <th><?php echo $this->lang->line('Location') ?></th>
                            <th><?php echo $this->lang->line('Status') ?></th>
                        <!-- <th class="no-sort"><?php echo $this->lang->line('Settings') ?></th> -->
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>

                    <tfoot>
                        <tr>
                        <th><?php echo $this->lang->line('No') ?></th>
                            <th> #</th>
                            <th> Staff</th>
                            <th><?php echo $this->lang->line('Date') ?></th>
                            <th><?php echo $this->lang->line('Customer') ?></th>
                            <th><?php echo $this->lang->line('Phone') ?></th>
                            <th><?php echo $this->lang->line('Address') ?></th>
                            <th><?php echo $this->lang->line('Product Code') ?></th>
                            <th><?php echo $this->lang->line('Product Name') ?></th>
                            <th><?php echo $this->lang->line('Category') ?></th>
                            <th><?php echo $this->lang->line('Quantity') ?></th>
                            <th><?php echo 'Net amount' ?></th>
                            <th><?php echo 'VAT' ?></th>
                            <th><?php echo 'Grand Total' ?></th>
                            <th><?php echo 'Payment Method' ?></th>
                            <th><?php echo $this->lang->line('Location') ?></th>
                            <th><?php echo $this->lang->line('Status') ?></th>
                        </tr>
                    </tfoot>
                </table>

            </div>
        </div>
    </div>
</div>


    <script type="text/javascript">
    $(document).ready(function () {
        $('.summernote').summernote({
            height: 100,
            toolbar: [
                // [groupName, [list of button]]
                ['style', ['bold', 'italic', 'underline', 'clear']],
                ['font', ['strikethrough', 'superscript', 'subscript']],
                ['fontsize', ['fontsize']],
                ['color', ['color']],
                ['para', ['ul', 'ol', 'paragraph']],
                ['height', ['height']],
                ['fullscreen', ['fullscreen']],
                ['codeview', ['codeview']]
            ]
        });



        $('#clientstable').DataTable({
            'processing': true,
            'serverSide': true,
            'stateSave': true,
            scrollX: true,
            //responsive: true,
            <?php datatable_lang();?>
            'order': [],
            'ajax': {
                'url': "<?php echo site_url('customers/load_cus_report')?>",
                'type': 'POST',
                'data': {'<?=$this->security->get_csrf_token_name()?>': crsf_hash },
                start_date: start_date,
                end_date: end_date,
                locations: loc
            },
            'columnDefs': [
                {
                    'targets': [0],
                    'orderable': false, 
                },
            ], dom: 'Blfrtip',
            buttons: [
                {
                    extend: 'excelHtml5',
                    footer: true,
                    exportOptions: {
                        //columns: [0, 1, 2, 3, 4]
                    }
                }
            ],
        });


    });


</script>
