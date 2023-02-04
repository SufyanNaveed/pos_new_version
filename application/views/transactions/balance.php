<div class="content-body">
    <div class="card">
        <div class="card-header">
            <h5><?php echo $this->lang->line('BalanceSheet') ?></h5>
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

                <h5 class="title bg-gradient-x-info p-1 white">
                    <?php echo $this->lang->line('Basic') ?><?php echo $this->lang->line('Accounts') ?>
                </h5>
                <p>&nbsp;</p>
                <table class="table">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th><?php echo $this->lang->line('Name') ?></th>
                        <th><?php echo $this->lang->line('Account') ?></th>
                        <th><?php echo $this->lang->line('Balance') ?></th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php $i = 1;
                    $gross = 0;
                    foreach ($accounts as $row) {
                        if ($row['account_type'] == 'Basic') {
                            $aid = $row['id'];
                            $acn = $row['acn'];
                            $holder = $row['holder'];

                            $balance = $row['lastbal'];
                            $qty = $row['adate'];
                            echo "<tr>
                    <td>$i</td>                    
                    <td>$holder</td>
                    <td>$acn</td>
                   
                    <td>" . amountExchange($balance, 0, $this->aauth->get_user()->loc) . "</td>
                    </tr>";
                            $i++;
                            $gross += $balance;
                        }
                    }
                    ?>
                    </tbody>
                    <tfoot>
                    <tr>
                        <th></th>
                        <th></th>

                        <th></th>

                        <th>
                            <h3 class="text-xl-left"><?php echo amountExchange($gross, 0, $this->aauth->get_user()->loc); ?></h3>
                        </th>
                    </tr>
                    </tfoot>
                </table>
                <h5 class="title bg-gradient-x-purple p-1 white">
                    <?php echo $this->lang->line('Assets') ?><?php echo $this->lang->line('Accounts') ?>
                </h5>
                <p>&nbsp;</p>
                <table class="table">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th><?php echo $this->lang->line('Name') ?></th>
                        <th><?php echo $this->lang->line('Account') ?></th>
                        <th><?php echo $this->lang->line('Balance') ?></th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php $i = 1;
                    $gross1 = 0;
                    foreach ($accounts as $row) {
                        if ($row['account_type'] == 'Assets') {
                            $aid = $row['id'];
                            $acn = $row['acn'];
                            $holder = $row['holder'];

                            $balance = $row['lastbal'];
                            $qty = $row['adate'];
                            echo "<tr>
                    <td>$i</td>                    
                    <td>$holder</td>
                    <td>$acn</td>
                   
                    <td>" . amountExchange($balance, 0, $this->aauth->get_user()->loc) . "</td>
                    </tr>";
                            $i++;
                            $gross1 += $balance;
                        }
                    }
                    ?>
                    </tbody>
                    <tfoot>
                    <tr>
                        <th></th>
                        <th></th>

                        <th></th>

                        <th>
                            <h3 class="text-xl-left"><?php echo amountExchange($gross1, 0, $this->aauth->get_user()->loc); ?></h3>
                        </th>
                    </tr>
                    </tfoot>
                </table>

                <h5 class="title bg-gradient-x-danger p-1 white">
                    <?php echo $this->lang->line('Expenses') ?><?php echo $this->lang->line('Accounts') ?>
                </h5>
                <p>&nbsp;</p>
                <table class="table">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th><?php echo $this->lang->line('Name') ?></th>
                        <th><?php echo $this->lang->line('Account') ?></th>
                        <th><?php echo $this->lang->line('Balance') ?></th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php $i = 1;
                    $gross2 = 0;
                    foreach ($accounts as $row) {
                        if ($row['account_type'] == 'Expenses') {
                            $aid = $row['id'];
                            $acn = $row['acn'];
                            $holder = $row['holder'];

                            $balance = $row['lastbal'];
                            $qty = $row['adate'];
                            echo "<tr>
                    <td>$i</td>                    
                    <td>$holder</td>
                    <td>$acn</td>
                   
                    <td>" . amountExchange($balance, 0, $this->aauth->get_user()->loc) . "</td>
                    </tr>";
                            $i++;
                            $gross2 += $balance;
                        }
                    }
                    ?>
                    </tbody>
                    <tfoot>
                    <tr>
                        <th></th>
                        <th></th>

                        <th></th>

                        <th>
                            <h3 class="text-xl-left"><?php echo amountExchange($gross2, 0, $this->aauth->get_user()->loc); ?></h3>
                        </th>
                    </tr>
                    </tfoot>
                </table>

                <h5 class="title bg-gradient-x-success p-1 white">
                    <?php echo $this->lang->line('Income') ?><?php echo $this->lang->line('Accounts') ?>
                </h5>
                <p>&nbsp;</p>
                <table class="table">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th><?php echo $this->lang->line('Name') ?></th>
                        <th><?php echo $this->lang->line('Account') ?></th>
                        <th><?php echo $this->lang->line('Balance') ?></th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php $i = 1;
                    $gross3 = 0;
                    foreach ($accounts as $row) {
                        if ($row['account_type'] == 'Income') {
                            $aid = $row['id'];
                            $acn = $row['acn'];
                            $holder = $row['holder'];

                            $balance = $row['lastbal'];
                            $qty = $row['adate'];
                            echo "<tr>
                    <td>$i</td>                    
                    <td>$holder</td>
                    <td>$acn</td>
                   
                    <td>" . amountExchange($balance, 0, $this->aauth->get_user()->loc) . "</td>
                    </tr>";
                            $i++;
                            $gross3 += $balance;
                        }
                    }
                    ?>
                    </tbody>
                    <tfoot>
                    <tr>
                        <th></th>
                        <th></th>

                        <th></th>

                        <th>
                            <h3 class="text-xl-left"><?php echo amountExchange($gross3, 0, $this->aauth->get_user()->loc); ?></h3>
                        </th>
                    </tr>
                    </tfoot>
                </table>

                <h5 class="title bg-gradient-x-warning p-1 white">
                    <?php echo $this->lang->line('Liabilities') ?><?php echo $this->lang->line('Accounts') ?>
                </h5>
                <p>&nbsp;</p>
                <table class="table">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th><?php echo $this->lang->line('Name') ?></th>
                        <th><?php echo $this->lang->line('Account') ?></th>
                        <th><?php echo $this->lang->line('Balance') ?></th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php $i = 1;
                    $gross4 = 0;
                    foreach ($accounts as $row) {
                        if ($row['account_type'] == 'Liabilities') {
                            $aid = $row['id'];
                            $acn = $row['acn'];
                            $holder = $row['holder'];

                            $balance = $row['lastbal'];
                            $qty = $row['adate'];
                            echo "<tr>
                    <td>$i</td>                    
                    <td>$holder</td>
                    <td>$acn</td>
                   
                    <td>" . amountExchange($balance, 0, $this->aauth->get_user()->loc) . "</td>
                    </tr>";
                            $i++;
                            $gross4 += $balance;
                        }
                    }
                    ?>
                    </tbody>
                    <tfoot>
                    <tr>
                        <th></th>
                        <th></th>

                        <th></th>

                        <th>
                            <h3 class="text-xl-left"><?php echo amountExchange($gross4, 0, $this->aauth->get_user()->loc); ?></h3>
                        </th>
                    </tr>
                    </tfoot>
                </table>

                <h5 class="title bg-gradient-x-grey-blue p-1 white">
                    <?php echo $this->lang->line('Equity') ?><?php echo $this->lang->line('Accounts') ?>
                </h5>
                <p>&nbsp;</p>
                <table class="table table-striped">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th><?php echo $this->lang->line('Name') ?></th>
                        <th><?php echo $this->lang->line('Account') ?></th>
                        <th><?php echo $this->lang->line('Balance') ?></th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php $i = 1;
                    $gross5 = 0;
                    foreach ($accounts as $row) {
                        if ($row['account_type'] == 'Equity') {
                            $aid = $row['id'];
                            $acn = $row['acn'];
                            $holder = $row['holder'];

                            $balance = $row['lastbal'];
                            $qty = $row['adate'];
                            echo "<tr>
                    <td>$i</td>                    
                    <td>$holder</td>
                    <td>$acn</td>
                   
                    <td>" . amountExchange($balance, 0, $this->aauth->get_user()->loc) . "</td>
                    </tr>";
                            $i++;
                            $gross5 += $balance;
                        }
                    }
                    ?>
                    </tbody>
                    <tfoot>
                    <tr>
                        <th></th>
                        <th></th>

                        <th></th>

                        <th>
                            <h3 class="text-xl-left"><?php echo amountExchange($gross5, 0, $this->aauth->get_user()->loc); ?></h3>
                        </th>
                    </tr>
                    </tfoot>
                </table>


                <table class="table table-striped">
                    <thead>
                    <tr>
                        <th><?php echo $this->lang->line('Type') ?></th>
                        <th><?php echo $this->lang->line('Balance') ?></th>
                    </tr>
                    </thead>
                    <tbody>

                    <tr>
                        <td><?php echo $this->lang->line('Basic') ?></td>
                        <td><?php echo amountExchange($gross, 0, $this->aauth->get_user()->loc) ?></td>

                    </tr>
                    <tr>
                        <td><?php echo $this->lang->line('Assets') ?></td>
                        <td><?php echo amountExchange($gross1, 0, $this->aauth->get_user()->loc) ?></td>

                    </tr>
                    <tr>
                        <td><?php echo $this->lang->line('Expenses') ?></td>
                        <td><?php echo amountExchange($gross2, 0, $this->aauth->get_user()->loc) ?></td>

                    </tr>
                    <tr>
                        <td><?php echo $this->lang->line('Income') ?></td>
                        <td><?php echo amountExchange($gross3, 0, $this->aauth->get_user()->loc) ?></td>

                    </tr>
                    <tr>
                        <td><?php echo $this->lang->line('Liabilities') ?></td>
                        <td><?php echo amountExchange($gross4, 0, $this->aauth->get_user()->loc) ?></td>

                    </tr>
                    <tr>
                        <td><?php echo $this->lang->line('Equity') ?></td>
                        <td><?php echo amountExchange($gross5, 0, $this->aauth->get_user()->loc) ?></td>

                    </tr>
                    </tbody>
                    <tfoot>

                    </tfoot>
                </table>

            </div>
        </div>
    </div>
    <script type="text/javascript">
        $(document).ready(function () {

            //datatables
            $('.dtable').DataTable({responsive: true});

        });
    </script>