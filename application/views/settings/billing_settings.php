<article class="content-body">
    <div class="card card-block">
        <div id="notify" class="alert alert-success" style="display:none;">
            <a href="#" class="close" data-dismiss="alert">&times;</a>

            <div class="message"></div>
        </div>
        <form method="post" id="product_action" class="form-horizontal">
            <div class="card-body">
       <hr>
  <h5><?php echo $this->lang->line('product_search_settings') ?> </h5>
                  <p>Allow Sales Person to bill with 0 stock, helpful to use products as a service.</p>

                <div class="form-group row">

                    <label class="col-sm-2 col-form-label"
                           for="product_name"><?php echo $this->lang->line('product_search_settings') ?></label>

                    <div class="col-sm-6"><select name="serial" class="form-control">

                            <?php switch ($billing_settings['key1']) {
                                case '0' :
                                    echo '<option value="0">** ' . $this->lang->line('search_default') . ' **</option>';
                                    break;
                                case '1' :
                                    echo '<option value="1">**' . $this->lang->line('search_serial_with') . '**</option>';
                                    break;
                                    case '2' :
                                    echo '<option value="2">**' . $this->lang->line('search_serial_only') . '**</option>';
                                    break;

                            } ?>
                            <option value="0"><?php echo $this->lang->line('search_default') ?></option>
                            <option value="1"><?php echo $this->lang->line('search_serial_with') ?></option>
                             <option value="2"><?php echo $this->lang->line('search_serial_only') ?></option>


                        </select>

                    </div>

                </div><p><?php echo $this->lang->line('search_serial_with_not_available') ?></p>
                <hr>

                <h5><?php echo $this->lang->line('Billing Settings') ?> Service / Product
                    As A Service</h5>
                <hr>
                <p>Allow Sales Person to bill with 0 stock, helpful to use products as a service.</p>

                <div class="form-group row">

                    <label class="col-sm-2 col-form-label"
                           for="product_name"><?php echo $this->lang->line('Zero Stock') ?></label>

                    <div class="col-sm-6"><select name="stock" class="form-control">

                            <?php switch ($zero_stock['key1']) {
                                case '0' :
                                    echo '<option value="0">** ' . $this->lang->line('Yes') . ' **</option>';
                                    break;
                                case '1' :
                                    echo '<option value="1">**' . $this->lang->line('No') . '**</option>';
                                    break;

                            } ?>
                            <option value="0"><?php echo $this->lang->line('Yes') ?></option>
                            <option value="1"><?php echo $this->lang->line('No') ?></option>


                        </select>

                    </div>
                </div>       <hr>
                     <h5><?php echo $this->lang->line('disable_expired_products') ?> </h5>
                <hr>


                <div class="form-group row">

                    <label class="col-sm-2 col-form-label"
                           for="product_name">   <h5><?php echo $this->lang->line('disable_expired_products') ?> </h5></label>

                    <div class="col-sm-6"><select name="expired" class="form-control">

                            <?php switch ($billing_settings['key2']) {
                                case '0' :
                                    echo '<option value="0">** ' . $this->lang->line('No') . ' **</option>';
                                    break;
                                case '1' :
                                    echo '<option value="1">**' . $this->lang->line('Yes') . '**</option>';
                                    break;

                            } ?>
                            <option value="0"><?php echo $this->lang->line('No') ?></option>
                            <option value="1"><?php echo $this->lang->line('Yes') ?></option>


                        </select>

                    </div>
                </div>



                <div class="form-group row">

                    <label class="col-sm-2 col-form-label"></label>

                    <div class="col-sm-4">
                        <input type="submit" id="billing_update" class="btn btn-success margin-bottom"
                               value="<?php echo $this->lang->line('Update') ?>" data-loading-text="Updating...">
                    </div>
                </div>

            </div>
        </form>
    </div>

</article>
<script type="text/javascript">
    $("#billing_update").click(function (e) {
        e.preventDefault();
        var actionurl = baseurl + 'settings/billing_settings';
        actionProduct(actionurl);
    });
</script>
