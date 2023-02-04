<article class="content">


    <div class="offset-md-3 col-md-6">
        <div class="card card-block">
            <div class="card-body">
                <?php echo '<h4>' . $this->config->item('ctitle') . '</h4>
                        <h5>Payable Accounts</h5>     <hr>';
                foreach ($accounts as $account) { ?>
                    <div class="card">
                        <div class="card-block">

                            <div class="row">
                                <div class="col-12">

                                    <div class="stat">
                                        <div class="name"> <?php echo $this->lang->line('Account No') ?>:</div>
                                        <div class="value"> <?php echo $account['acn'] ?></div>
                                        <hr>
                                    </div>

                                </div>
                                <div class="col-12">

                                    <div class="stat">
                                        <div class="name"> <?php echo $this->lang->line('Name') ?>:</div>
                                        <div class="value"> <?php echo $account['name'] ?></div>
                                        <hr>
                                    </div>

                                </div>

                                <div class="col-12">

                                    <div class="stat">
                                        <div class="name"><?php echo $this->lang->line('Code') ?>:</div>
                                        <div class="value"> <?php echo $account['code'] ?></div>
                                        <hr>
                                    </div>

                                </div>

                                <div class="col-12">

                                    <div class="stat">
                                        <div class="name"> Bank:</div>
                                        <div class="value"> <?php echo $account['note'] ?></div>
                                        <hr>
                                    </div>

                                </div>

                                <div class="col-12">

                                    <div class="stat">
                                        <div class="name"> Branch:</div>
                                        <div class="value"> <?php echo $account['branch'] ?></div>
                                        <hr>
                                    </div>

                                </div>

                                <div class="col-12">

                                    <div class="stat">
                                        <div class="name"> <?php echo $this->lang->line('Address') ?>:</div>
                                        <div class="value"> <?php echo $account['address'] ?></div>
                                        <hr>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>

                <?php } ?>
            </div>

        </div>

    </div>

</article>