<div class="content-body">
    <div class="card">
        <div class="card-header">
            <h5><?php echo $this->lang->line('Products') . ' ' . $this->lang->line('Label'); ?></h5>
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
                <?php
                $attributes = array('class' => 'form-horizontal form-simple', 'id' => 'login_form');
                echo form_open('products/custom_label');
                ?>
                <input type="hidden" name="act" value="add_product">
                <div class="form-group row">


                    <div class="col-sm-4"><label class="col-form-label"
                                                 for="product_cat"><?php echo $this->lang->line('Warehouse') ?></label>
                        <select id="wfrom" name="from_warehouse" class="form-control">
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


                    <div class="col-sm-8"><label class="col-form-label"
                                                 for="pay_cat"><?php echo $this->lang->line('Products') ?></label>
                        <select id="products_l" name="products_l[]" class="form-control required select-box"
                                multiple="multiple">

                        </select>


                    </div>
                </div>
                <hr>
                <?php echo $this->lang->line('Print') ?> <?php echo $this->lang->line('Settings') ?>
                <hr> <div class="form-group row">
                <div class="col-sm-2"><label class="col-form-label"
                                                 for="b_type">Barcode Type</label>
                        <select class="form-control" name="b_type">
                            <option value="1">EAN-13</option>
                             <option value="2">CODE-128</option>
                            <option value="3">CODE-39</option>
                            <option value="4">EAN-5</option>
                            <option value="5">EAN-8</option>
                            <option value="6">UPC-A</option>
                            <option value="7">UPC-E</option>
                        </select>
                    </div> </div>
                <div class="form-group row">


                    <div class="col-sm-2"><label class="col-form-label"
                                                 for="width">Sheet Width</label>
                        <input name="width" class="form-control required" type="number" value="160">
                        <small>in MM</small>

                    </div>
                    <div class="col-sm-2"><label class="col-form-label"
                                                 for="width">Sheet Height</label>
                        <input name="height" class="form-control required" type="number" value="50">
                        <small>in MM</small>

                    </div>

                    <div class="col-sm-2"><label class="col-form-label"
                                                 for="width">Label Width</label>
                        <input name="label_width" class="form-control required" type="number" value="80">
                        <small>in MM</small>

                    </div>
                    <div class="col-sm-2"><label class="col-form-label"
                                                 for="width">Label Height</label>
                        <input name="label_height" class="form-control required" type="number" value="50">
                        <small>in MM</small>

                    </div>

            <!--        <div class="col-sm-2"><label class="col-form-label"
                                                 for="padding">Padding</label>
                        <input name="padding" class="form-control required" type="number" value="10">
                        <small>in PX</small>

                    </div>-->


                    <div class="col-sm-2"><label class="col-form-label"
                                                 for="width">Total Rows</label>
                        <select class="form-control" name="total_rows">
                            <option value="0">1</option>
                            <option value="1">2</option>
                            <option value="2">3</option>
                            <option value="3">4</option>
                            <option value="4">5</option>
                            <option value="5">6</option>
                            <option value="6">7</option>
                            <option value="7">8</option>
                            <option value="8">9</option>
                            <option value="9">10</option>
                            <option value="19">20</option>
                        </select>
                    </div>
                    <div class="col-sm-2"><label class="col-form-label"
                                                 for="width">Total Cols</label>
                        <select class="form-control" name="items_per_row">
                           <option value="0">1</option>
                            <option value="1" selected>2</option>
                            <option value="2">3</option>
                            <option value="3">4</option>
                            <option value="4">5</option>
                            <option value="5">6</option>
                            <option value="6">7</option>
                            <option value="7">8</option>
                            <option value="8">9</option>
                            <option value="9">10</option>
                            <option value="19">20</option>

                        </select>
                    </div>  </div>  <div class="row mb-2">


    <div class="col-sm-2"><label class="col-form-label"
                                                 for="width">BarCode Width</label>
               <input name="bar_width" class="form-control required" type="number" value="50">
                    </div>                     <div class="col-sm-2"><label class="col-form-label"
                                                 for="width">BarCode height</label>

                                              <input name="bar_height" class="form-control required" type="number" value="30">
                    </div>  <div class="col-sm-2"><label class="col-form-label"
                                                 for="font_size">Font Size</label>
                        <select class="form-control" name="font_size">
                            <option value="8">8pt</option>
                            <option value="9">9pt</option>
                            <option value="10">10pt</option>
                           <option value="11" selected>11pt</option>
                            <option value="12" >12pt</option>
                            <option value="13">13pt</option>
                            <option value="14">14pt</option>
                            <option value="15">15pt</option>
                            <option value="16">16pt</option>
                            <option value="17">17pt</option>
                            <option value="18">18pt</option>
                            <option value="19">19pt</option>
                            <option value="20">20pt</option>


                        </select>
                    </div>
                    </div>  <div class="row mb-2">
   <div class="col-sm-2"><label class="col-form-label"
                                                 for="store_name">Product Name</label>
                        <select class="form-control" name="product_name">
                            <option value="1">Yes</option>
                            <option value="0">No</option>
                        </select>
                    </div>
                    <div class="col-sm-2"><label class="col-form-label"
                                                 for="store_name"><?php echo $this->lang->line('Business') . ' ' . $this->lang->line('Location'); ?></label>
                        <select class="form-control" name="store_name">
                            <option value="1">Yes</option>
                            <option value="0">No</option>
                        </select>
                    </div>

                    <div class="col-sm-2"><label class="col-form-label"
                                                 for="store_name"><?php echo $this->lang->line('Warehouse') ?></label>
                        <select class="form-control" name="warehouse_name">
                            <option value="0">No</option>
                            <option value="1">Yes</option>
                        </select>

                    </div>
                    <div class="col-sm-2"><label class="col-form-label"
                                                 for="product_price"><?php echo $this->lang->line('Price') ?></label>
                        <select class="form-control" name="product_price">
                            <option value="1">Yes</option>
                            <option value="0">No</option>
                        </select>
                    </div>
                    <div class="col-sm-2"><label class="col-form-label"
                                                 for="product_code"><?php echo $this->lang->line('Product Code') ?></label>
                        <select class="form-control" name="product_code">
                            <option value="0">No</option>
                            <option value="1">Yes</option>
                        </select>
                    </div>    <div class="col-sm-2"><label class="col-form-label"
                                                 for="max_char">Max Characters (each line)</label>
               <input name="max_char" class="form-control required" type="number" value="50">
                    </div>
                </div>


                <div class="form-group row">


                    <div class="col-sm-4">
                        <input type="submit" class="btn btn-success margin-bottom"
                               value="<?php echo $this->lang->line('Print') ?>"
                               data-loading-text="Adding...">

                    </div>
                </div>
            </div>

            </form>
        </div>
    </div>

    <script type="text/javascript">
        $("#products_l").select2();
        $("#wfrom").on('change', function () {
            var tips = $('#wfrom').val();
            $("#products_l").select2({

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
        });
    </script>

