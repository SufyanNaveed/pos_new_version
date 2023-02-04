<div class="content-body">
    <div class="card">
        <div class="card-header">
            <h5><?php echo $this->lang->line('Edit Account') ?></h5>
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
                $attributes = array('class' => 'form-horizontal', 'id' => 'data_form');
                echo form_open('', $attributes);
                ?>


                <input type="hidden" name="acid" value="<?php echo $account['id'] ?>">


                <div class="form-group row">

                    <label class="col-sm-2 col-form-label"
                           for="accno"><?php echo $this->lang->line('Account No') ?></label>

                    <div class="col-sm-8">
                        <input type="text"
                               class="form-control margin-bottom required" name="accno"
                               value="<?php echo $account['acn'] ?>">
                    </div>
                </div>


                <div class="form-group row">

                    <label class="col-sm-2 col-form-label" for="holder"><?php echo $this->lang->line('Name') ?></label>

                    <div class="col-sm-8">


                        <input type="text" name="holder" class="form-control required"
                               aria-describedby="sizing-addon1" value="<?php echo $account['holder'] ?>">

                    </div>

                </div>


                <div class="form-group row">

                    <label class="col-sm-2 col-form-label" for="acode"><?php echo $this->lang->line('Note') ?></label>

                    <div class="col-sm-8">


                        <input type="text" name="acode" class="form-control"
                               aria-describedby="sizing-addon1" value="<?php echo $account['code'] ?>">

                    </div>

                </div>
                <div class="form-group row">

                    <label class="col-sm-2 col-form-label"
                           for="lid"><?php echo $this->lang->line('Business Locations') ?></label>

                    <div class="col-sm-6">
                        <select name="lid" class="form-control">
                            <option value='<?php echo $account['loc'] ?>'><?php echo $this->lang->line('Do not change') ?></option>

                            <?php
                            if (!$this->aauth->get_user()->loc) echo "<option value='0'>" . $this->lang->line('All') . "</option>";
                            foreach ($locations as $row) {
                                $cid = $row['id'];
                                $acn = $row['cname'];
                                $holder = $row['address'];
                                echo "<option value='$cid'>$acn - $holder</option>";
                            }
                            ?>
                        </select>


                    </div>
                </div>
                <?php if ($account['account_type'] == 'Equity') {
                    ?>

                    <div class="form-group row ">

                        <label class="col-sm-2 col-form-label"
                               for="balance"><?php echo $this->lang->line('AccountBalance') ?></label>

                        <div class="col-sm-6">
                            <input type="text" name="balance" class="form-control"
                                   value="<?php echo amountFormat_general($account['lastbal']) ?>"
                                   onkeypress="return isNumber(event)">
                        </div>
                    </div>

                <?php } ?>
                <div class="form-group row">

                    <label class="col-sm-2 col-form-label"></label>

                    <div class="col-sm-4">
                        <input type="submit" id="submit-data" class="btn btn-success margin-bottom"
                               value="<?php echo $this->lang->line('Update') ?>" data-loading-text="Updating...">
                        <input type="hidden" value="accounts/editacc" id="action-url">
                    </div>
                </div>

            </div>
            </form>
        </div>

    </div>
</div>

