<div class="content-body">
    <div class="card">
        <div class="card-header">
            <h4 class="card-title"><?php echo $this->lang->line('Products').' '.$this->lang->line('Report') ?> 
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
                <table id="po" class="table table-striped table-bordered zero-configuration">
                    <thead>
                    <tr>
                        <th><?php echo $this->lang->line('serialNO') ?></th> 
                        <th><?php echo 'Article No' ?></th>
                        <th><?php echo $this->lang->line('product').' '.$this->lang->line('Category') ?></th>
                        <th><?php echo $this->lang->line('product').' '.$this->lang->line('Name') ?></th>
                        <th><?php echo 'Total Stock' ?></th>
                        <th><?php echo 'Net Purchase Amount' ?></th>
                        <th><?php echo 'Total Purchase Amount' ?></th>
                        <th><?php echo 'Net Sale Amount' ?></th>
                        <th><?php echo 'Total Sale Amount' ?></th>
                        <th><?php echo 'Aging Days' ?></th>
                        <th><?php echo 'Status' ?></th>
                    </tr>
                    </thead>
                    <tbody>
                    </tbody>

                    <tfoot>
                    <tr>
                        <th><?php echo $this->lang->line('serialNO') ?></th> 
                        <th><?php echo 'Article No' ?></th>
                        <th><?php echo $this->lang->line('product').' '.$this->lang->line('Category') ?></th>
                        <th><?php echo $this->lang->line('product').' '.$this->lang->line('Name') ?></th>
                        <th><?php echo 'Total Stock' ?></th>
                        <th><?php echo 'Net Purchase Amount' ?></th>
                        <th><?php echo 'Total Purchase Amount' ?></th>
                        <th><?php echo 'Net Sale Amount' ?></th>
                        <th><?php echo 'Total Sale Amount' ?></th>
                        <th><?php echo 'Aging Days' ?></th>
                        <th><?php echo 'Status' ?></th>
                    </tr>
                    </tfoot>
                </table>
            </div>
        </div>


    </div>
    <div id="delete_model" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">

                    <h4 class="modal-title"><?php echo $this->lang->line('Delete Order') ?></h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    <p><?php echo $this->lang->line('delete this order') ?></p>
                </div>
                <div class="modal-footer">
                    <input type="hidden" id="object-id" value="">
                    <input type="hidden" id="action-url" value="purchase/delete_i">
                    <button type="button" data-dismiss="modal" class="btn btn-primary" id="delete-confirm">Delete
                    </button>
                    <button type="button" data-dismiss="modal" class="btn">Cancel</button>
                </div>
            </div>
        </div>
    </div>


    <script type="text/javascript">
        $(document).ready(function () {
            draw_data();

            function draw_data(start_date = '', end_date = '') {
                $('#po').DataTable({
                    'processing': true,
                    'serverSide': true,
                    'stateSave': true,
                    // responsive: true,
                    scrollX: true,
                    <?php datatable_lang();?>
                    'order': [],
                    'ajax': {
                        'url': "<?php echo site_url('products/load_pro_report')?>",
                        'type': 'POST',
                        'data': {
                            '<?=$this->security->get_csrf_token_name()?>': crsf_hash,
                            start_date: start_date,
                            end_date: end_date
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
                                columns: [1, 2, 3, 4, 5]
                            }
                        }
                    ],
                });
            };

            $('#search').click(function () {
                var start_date = $('#start_date').val();
                var end_date = $('#end_date').val();
                if (start_date != '' && end_date != '') {
                    $('#po').DataTable().destroy();
                    draw_data(start_date, end_date);
                } else {
                    alert("Date range is Required");
                }
            });
        });
    </script>