<div class="content-body">
    <div class="card">
        <div class="card-header">
            <h4 class="card-title"><?php echo 'Consolidated Location Report' ?></h4>
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

                    <div class="col-md-4">
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
                    </div>

                    <div class="col-md-2">
                        <input type="button" name="search" id="search" value="Search" class="btn btn-info"/>
                    </div>

                </div>
                <hr>
                <table id="invoices" class="table table-striped table-bordered  dataex-res-constructor">
                    <thead>
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
                        <!-- <th class="no-sort"><?php echo $this->lang->line('Settings') ?></th> -->

                    </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
</div>


<div id="delete_model" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">

                <h4 class="modal-title"><?php echo $this->lang->line('Delete Invoice') ?></h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <p><?php echo $this->lang->line('delete this invoice') ?> ?</p>
            </div>
            <div class="modal-footer">
                <input type="hidden" id="object-id" value="">
                <input type="hidden" id="action-url" value="pos_invoices/delete_i">
                <button type="button" data-dismiss="modal" class="btn btn-primary"
                        id="delete-confirm"><?php echo $this->lang->line('Delete') ?></button>
                <button type="button" data-dismiss="modal"
                        class="btn"><?php echo $this->lang->line('Cancel') ?></button>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function () {
        draw_data();

        function draw_data(start_date = '', end_date = '', loc) {
            $('#invoices').DataTable({
                'processing': true,
                'serverSide': true,
                'stateSave': true,
                responsive: true,
                <?php datatable_lang();?>
                'order': [],
                'ajax': {
                    'url': "<?php echo site_url('customers/load_cus_report')?>",
                    'type': 'POST',
                    'data': {
                        '<?=$this->security->get_csrf_token_name()?>': crsf_hash,
                        start_date: start_date,
                        end_date: end_date,
                        locations: loc
                    }
                },
                'columnDefs': [
                    {
                        'targets': [0],
                        'orderable': false,
                    },
                ],
                dom: 'Blfrtip',
                buttons: [
                    {
                        extend: 'excelHtml5',
                        footer: true,
                        exportOptions: { 
                        }
                    }
                ],
            });
        }

        $('#search').click(function () {
            var start_date = $('#start_date').val();
            var end_date = $('#end_date').val();
            var locs = $('#loc').val();
            console.log(locs);
            if (start_date != '' && end_date != '') {
                $('#invoices').DataTable().destroy();
                draw_data(start_date, end_date,locs);
            } else {
                alert("Date range is Required");
            }
        });

        $("#loc").select2({});
    });
</script>