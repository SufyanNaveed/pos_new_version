<div class="content-body">
    <div class="card">
        <div class="card-header pb-0">
            <h5><?php echo $this->lang->line('CreateProductGroup') ?></h5>
            <hr>
            <a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
            <div class="heading-elements">
                <ul class="list-inline mb-0">
                    <li><a data-action="collapse"><i class="ft-minus"></i></a></li>
                    <li><a data-action="expand"><i class="ft-maximize"></i></a></li>
                    <li><a data-action="close"><i class="ft-x"></i></a></li>
                </ul>
            </div>
        </div>

        <div id="notify" class="alert alert-success" style="display:none;">
            <a href="#" class="close" data-dismiss="alert">&times;</a>

            <div class="message"></div>
        </div>
        <div class="card-body">
            <form method="post" id="data_form">


                <input type="hidden" name="act" value="add_product">

                <div class="form-group row">

                    <label class="col-sm-2 col-form-label"
                           for="product_warehouse"><?php echo $this->lang->line('Warehouse') ?>*</label>

                    <div class="col-sm-6">
                        <select id="wfrom" name="product_warehouse" class="form-control">
                            <option value='0'>Select</option>
                            <?php
                            foreach ($warehouse as $row) {
                                $cid = $row['id'];
                                $title = $row['title'];
                                echo "<option value='$cid'>$title</option>";
                            }
                            ?>
                        </select>


                    </div>
                </div>


                  <div class="form-group row">

                    <label class="col-sm-2 control-label"
                           for="group_name"><?php echo $this->lang->line('MasterProductName') ?>*</label>

                    <div class="col-sm-6">
                        <div class="input-group">

                            <input type="text" name="group_name" id="group_name"  class="form-control required"
                                   placeholder="Name" aria-describedby="sizing-addon"
                                 >
                        </div>
                    </div>
                </div>





                <div class="form-group row ">


                    <div class="col-sm-4">
                        <div class="input-group">

                            <input type="text" name="product_tax" class="form-control"
                                   placeholder="<?php echo $this->lang->line('Default TAX Rate') ?>"
                                   aria-describedby="sizing-addon1"
                                   onkeypress="return isNumber(event)"><span
                                    class="input-group-addon">%</span>
                        </div>
                    </div>


                    <div class="col-sm-4">
                        <div class="input-group">

                            <input type="text" name="product_disc" class="form-control"
                                   placeholder="<?php echo $this->lang->line('Default Discount Rate') ?>"
                                   aria-describedby="sizing-addon1"
                                   onkeypress="return isNumber(event)"><span
                                    class="input-group-addon">%</span>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <small><?php echo $this->lang->line('Discount rate during') ?></small>

                        <small><?php echo $this->lang->line('Tax rate during') ?></small>
                    </div>
                </div>




                   <table class="table mt-5" id="v_var">
                                    <tr>
                                        <td><select name="products_l[]"
                                                    class="products_l form-control required select-box col-12"
                                                    multiple="multiple">

                                            </select></td>
                                        <td><input value="" class="form-control col-6" name="v_stock[]"
                                                   placeholder="<?php echo $this->lang->line('Qty') ?>*">
                                        </td>

                                        <td>
                                            <button class="btn btn-red tr_delete">Delete</button>
                                        </td>
                                    </tr>
                                </table> <div class="row p-1">
                            <div class="col">
                                <button class="btn btn-purple tr_clone_add"><?php echo $this->lang->line('add_row') ?></button>


    <hr>
                <div class="form-group row"><label
                            class="col-sm-2 col-form-label"><?php echo $this->lang->line('Image') ?></label>
                    <div class="col-sm-6">
                        <div id="progress" class="progress">
                            <div class="progress-bar progress-bar-success"></div>
                        </div>
                        <!-- The container for the uploaded files -->
                        <table id="files" class="files"></table>
                        <br>
                        <span class="btn btn-success fileinput-button">
        <i class="glyphicon glyphicon-plus"></i>
        <span>Select files...</span>
                            <!-- The file input field used as target for the file upload widget -->
        <input id="fileupload" type="file" name="files[]">
    </span>
                        <br>
                        <pre>Allowed: gif, jpeg, png (Use light small weight images for fast loading - 200x200)</pre>
                        <br>
                        <!-- The global progress bar -->

                    </div>
                </div>

                            </div>
                        </div>


    <div class="form-group row">

                    <label class="col-sm-2 col-form-label"></label>

                    <div class="col-sm-10">
                        <input type="submit" id="submit-data" class="btn btn-lg btn-blue margin-bottom"
                               value="<?php echo $this->lang->line('Add product') ?>" data-loading-text="Adding...">
                        <input type="hidden" value="productgroups/add_group" id="action-url">
                        <p class="mt-3"><?php echo $this->lang->line('EditNotAllowed') ?></p>
                    </div>
                </div>
                <input type="hidden" name="image" id="image" value="default.png">

            </form>
        </div>
    </div>
</div>
<script src="<?php echo assets_url('assets/myjs/jquery.ui.widget.js'); ?>"></script>
<script src="<?php echo assets_url('assets/myjs/jquery.fileupload.js') ?>"></script>
<script>
    /*jslint unparam: true */
    /*global window, $ */
    $(function () {
        'use strict';
        // Change this to the location of your server-side upload handler:
        var url = '<?php echo base_url() ?>productgroups/file_handling';
        $('#fileupload').fileupload({
            url: url,
            dataType: 'json',
            formData: {'<?=$this->security->get_csrf_token_name()?>': crsf_hash},
            done: function (e, data) {
                var img = 'default.png';
                $.each(data.result.files, function (index, file) {
                    $('#files').html('<tr><td><a data-url="<?php echo base_url() ?>productgroups/file_handling?op=delete&name=' + file.name + '" class="aj_delete"><i class="btn-danger btn-sm icon-trash-a"></i> ' + file.name + ' </a><img style="max-height:200px;" src="<?php echo base_url() ?>userfiles/groups/' + file.name + '"></td></tr>');
                    img = file.name;
                });

                $('#image').val(img);
            },
            progressall: function (e, data) {
                var progress = parseInt(data.loaded / data.total * 100, 10);
                $('#progress .progress-bar').css(
                    'width',
                    progress + '%'
                );
            }
        }).prop('disabled', !$.support.fileInput)
            .parent().addClass($.support.fileInput ? undefined : 'disabled');


        $("#products_l").select2();
        $(".products_l").select2({ placeholder: "Please select a product"});
        $("#wfrom").on('change', function () {

            int_search();


        });


    });

    $(document).on('click', ".aj_delete", function (e) {
        e.preventDefault();

        var aurl = $(this).attr('data-url');
        var obj = $(this);

        jQuery.ajax({

            url: aurl,
            type: 'GET',
            dataType: 'json',
            success: function (data) {
                obj.closest('tr').remove();
                obj.remove();
            }
        });

    });


    $(document).on('click', ".tr_clone_add", function (e) {
        e.preventDefault();
        var n_row = '  <tr> <td> <select name="products_l[]" class="products_l form-control required select-box col-12" multiple="multiple"></select></td>     <td><input value="" class="form-control col-6" name="v_stock[]"  placeholder="<?php echo $this->lang->line('Qty') ?>*">   </td>   <td> <button class="btn btn-red tr_delete">Delete</button> </td></tr>';

        $('#v_var').find('tbody').find("tr:last").after(n_row);
        int_search();

    });


    $(document).on('click', ".tr_delete", function (e) {
        e.preventDefault();
        $(this).closest('tr').remove();
    });




    function int_search() {
        var tips = $('#wfrom').val();
        $(".products_l").select2({placeholder: "Please select a product",

            tags: [],
            ajax: {
                url: baseurl + 'products/stock_transfer_products?wid=' + tips,
                dataType: 'json',
                type: 'POST',
                quietMillis: 50,
                data: function (product) {

                    return {
                        product: product,
                        '<?=$this->security->get_csrf_token_name()?>': crsf_hash

                    };
                },
                processResults: function (data) {
                    return {
                        results: $.map(data, function (item) {
                            return {
                                text: item.product_name,
                                id: item.pid
                            }
                        })
                    };
                },
            }
        });

    }
</script>
