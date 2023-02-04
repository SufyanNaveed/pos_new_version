<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=Edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <title>Geo POS Installation</title>
    <link rel='stylesheet' type='text/css' href='assets/css/bootstrap.css'/>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">

    <link rel='stylesheet' type='text/css' href='assets/css/install.css'/>
    <link rel="shortcut icon" href="../assets/images/favicon.ico"/>

    <script type='text/javascript' src='assets/js/jquery.min.js'></script>
    <script type='text/javascript' src='assets/jquery-validation/jquery.validate.min.js'></script>
    <script type='text/javascript' src='assets/jquery-validation/jquery.form.js'></script>

</head>
<body>
<div class="install-box">

    <div class="panel panel-install">
        <div class="panel-heading text-center">
            <h2>Geo POS Billing Installer</h2>
        </div>
        <div class="panel-body no-padding">
            <div class="tab-container clearfix">
                <div id="terms" class="tab-title col-sm-3 active"><i class="fa fa-circle-o"></i><strong>
                        License</strong></span></div>
                <div id="pre-installation" class="tab-title col-sm-3"><i class="fa fa-circle-o"></i><strong>
                        Pre-Installation</strong></span></div>
                <div id="configuration" class="tab-title col-sm-3"><i class="fa fa-circle-o"></i><strong>
                        Configuration</strong></div>
                <div id="finished" class="tab-title col-sm-3"><i class="fa fa-circle-o"></i><strong> Finished</strong>
                </div>
            </div>
            <div class="tab-content">
                <div role="tabpanel" class="tab-pane active" id="terms-tab">
                    <div class="section">
                        <h4 class="text-center">Envato(Codecanyon) License Summary</h4>
                        <hr/>
                        <div>
                            <p>The Regular License grants you, the purchaser, an ongoing, non-exclusive, worldwide
                                license to make
                                use
                                of the digital work (Item) you have selected.</p><br>

                            <p>You are licensed to use the Item to create one single End Product for yourself or for one
                                client (a
                                "single application"), and the End Product can be distributed for Free.</p><br>

                            <p>
                                You can create one End Product for a client, and you can transfer that single End
                                Product to your
                                client
                                for any fee. This license is then transferred to your client.</p><br>

                            <p><strong>You can't Sell the End Product, except to one client. </strong></p><br>


                            <p><strong>You can't re-distribute the Item as stock, in a tool or template, or with source
                                    files. You
                                    can't do this with an Item either on its own or bundled with other items, and even
                                    if you modify
                                    the
                                    Item. You can't re-distribute or make available the Item as-is or with superficial
                                    modifications.
                                    These things are not allowed even if the re-distribution is for Free.</strong></p>
                            <br>

                            <p><strong>Although you can modify the Item and therefore delete unwanted components before
                                    creating
                                    your
                                    single End Product, you can't extract and use a single component of an Item on a
                                    stand-alone
                                    basis.</strong></p>

                            <br>

                            <p>This license can be terminated if you breach it. If that happens, you must stop making
                                copies of or
                                distributing the End Product until you remove the Item from it.</p>
                            <br>

                            <p>The author of the Item retains ownership of the Item but grants you the license on these
                                terms. This
                                license is between the author of the Item and you. Envato Pty Ltd is not a party to this
                                license or
                                the
                                one giving you the license.</p><br>

                            <p>Read The Full License Here- <a href="https://codecanyon.net/licenses/standard">https://codecanyon.net/licenses/standard</a>
                            </p>

                        </div>
                    </div>
                    <div class="section">
                        <div class="text-center">
                            <h4>About</h4>
                            <hr class="star-primary">
                            <p>Application Name: <strong>Geo POS</strong></p>
                            <p>Version: <strong> v <?php echo VER ?></strong></p>

                            <p>Release Date: <strong><?php echo RDATE ?></strong></p>

                            <p>By: <strong>UltimateKode</strong> [ <a href="https://www.ultimatekode.com"
                                                                      target="_blank">www.ultimatekode.com</a>
                                ]</p>
                        </div>
                    </div>
                    <div class="section">
                        <div class="text-center">
                            <h4>Support</h4>
                            <hr class="star-primary">
                            <p><strong><strong class="text-danger">Note</strong>: Please read the troubleshoot_guide before
                                    sending any support request.</strong></p>
                            <p>If you find any bugs or you have any idea for improvement, Please don't hesitate to
                                contact with us using
                                Our support page here<br>
                                <a href="http://helpdesk.ultimatekode.com/"
                                   target="_blank">--Support Section--</a></p>
                        </div>
                    </div>


                    <div class="panel-footer">
                        <button class="btn btn-info form-next1"><i class='fa fa-chevron-right'></i> Next</button>
                    </div>

                </div>


                <div class="tab-content">
                    <div role="tabpanel" class="tab-pane" id="pre-installation-tab">
                        <div class="section">
                            <p><strong>Please configure your PHP settings to match following requirements:</strong></p>
                            <hr/>
                            <div>
                                <table>
                                    <thead>
                                    <tr>
                                        <th width="25%">PHP Settings</th>
                                        <th width="27%">Current Version</th>
                                        <th>Required Version</th>
                                        <th class="text-center">Status</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr>
                                        <td>PHP Version</td>
                                        <td><?php echo $current_php_version; ?></td>
                                        <td><?php echo $php_version_required; ?>+</td>
                                        <td class="text-center">
                                            <?php if ($php_version_success) {
                                                $all_requirement_success = true;
                                                ?>
                                                <i class="status fa fa-check-circle-o"></i>
                                            <?php } else {
                                                $all_requirement_success = false;
                                                ?>
                                                <i class="status fa fa-times-circle-o"></i>
                                            <?php } ?>
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <div class="section">
                            <p><strong>Please make sure the extensions/settings listed below are
                                    installed/enabled:</strong></p>
                            <hr/>
                            <div>
                                <table>
                                    <thead>
                                    <tr>
                                        <th width="25%">Extension</th>
                                        <th width="27%">Current Settings</th>
                                        <th>Required Settings</th>
                                        <th class="text-center">Status</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr>
                                        <td>MySQLi</td>
                                        <td> <?php if ($mysql_success) {
                                                $all_requirement_success = true; ?>
                                                On
                                            <?php } else {
                                                $all_requirement_success = false; ?>
                                                Off
                                            <?php } ?>
                                        </td>
                                        <td>On</td>
                                        <td class="text-center">
                                            <?php if ($mysql_success) {
                                                $all_requirement_success = true; ?>
                                                <i class="status fa fa-check-circle-o"></i>
                                            <?php } else {
                                                $all_requirement_success = false; ?>
                                                <i class="status fa fa-times-circle-o"></i>
                                            <?php } ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>GD</td>
                                        <td> <?php if ($gd_success) {
                                                $all_requirement_success = true; ?>
                                                On
                                            <?php } else { ?>
                                                Off
                                            <?php } ?>
                                        </td>
                                        <td>On</td>
                                        <td class="text-center">
                                            <?php if ($gd_success) {
                                                $all_requirement_success = true; ?>
                                                <i class="status fa fa-check-circle-o"></i>
                                            <?php } else {
                                                $all_requirement_success = false; ?>
                                                <i class="status fa fa-times-circle-o"></i>
                                            <?php } ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>cURL</td>
                                        <td> <?php if ($curl_success) {
                                                $all_requirement_success = true; ?>
                                                On
                                            <?php } else {
                                                $all_requirement_success = false; ?>
                                                Off
                                            <?php } ?>
                                        </td>
                                        <td>On</td>
                                        <td class="text-center">
                                            <?php if ($curl_success) {
                                                $all_requirement_success = true; ?>
                                                <i class="status fa fa-check-circle-o"></i>
                                            <?php } else { ?>
                                                <i class="status fa fa-times-circle-o"></i>
                                            <?php } ?>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td>mbstring</td>
                                        <td> <?php if ($mbstring) { ?>
                                                On
                                            <?php } else {
                                                $all_requirement_success = false; ?>
                                                Off
                                            <?php } ?>
                                        </td>
                                        <td>On</td>
                                        <td class="text-center">
                                            <?php if ($mbstring) {
                                                $all_requirement_success = true; ?>
                                                <i class="status fa fa-check-circle-o"></i>
                                            <?php } else {
                                                $all_requirement_success = false; ?>
                                                <i class="status fa fa-times-circle-o"></i>
                                            <?php } ?>
                                        </td>
                                    </tr>


                                    <tr>
                                        <td>date.timezone</td>
                                        <td> <?php if ($timezone_success) {
                                                echo $timezone_settings;
                                            } else {
                                                echo "Null";
                                            } ?>
                                        </td>
                                        <td>Timezone</td>
                                        <td class="text-center">
                                            <?php if ($timezone_success) { ?>
                                                <i class="status fa fa-check-circle-o"></i>
                                            <?php } else { ?>
                                                <i class="status fa fa-times-circle-o"></i>
                                            <?php } ?>
                                        </td>
                                    </tr>

                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <div class="section">
                            <p><strong>Please make sure you have set the <code>writable</code> permission on the
                                    following files:</strong></p>
                            <hr/>
                            <div>
                                <table>
                                    <tbody>
                                    <?php
                                    $all_files_success = true;
                                    foreach ($writeable_directories as $value) {
                                        ?>
                                        <?php if (!is_writeable('..' . $value)) { ?>
                                            <tr>
                                                <td style="width:87%;"><?php echo $value; ?></td>
                                                <td class="text-center">
                                                    <?php
                                                    $all_files_success = false;
                                                    ?>
                                                    <i class="status fa fa-times-circle-o"></i>
                                                    <?php ?>
                                                </td>
                                            </tr>
                                        <?php }

                                    }

									if (!file_exists('../.htaccess')) {
												echo'<tr>
                                                <td style="width:87%;">';
												echo '<div class="alert alert-warning ">You missed  <strong>the .htaccess file! </strong> Upload from the application_setup folder. On some file managers, it may be hidden. You can find the settings option to show hidden files in File Manager by going to the top right corner and clicking on the gear icon. If you ignore this alert, you may receive  <strong>404 Page Not Found error after the installation </strong>.</div>';
												echo'</td>
                                                <td class="text-center">';
                                         echo'<i class="status fa fa-times-circle-o"></i>                                                    
                                                </td>
                                            </tr>';
									}

                                   echo'</tbody>
                                    </table>';

                                    if ($all_files_success) { ?>
                                    <hr>
                                    <div class="alert alert-success">All required files and folders are writable.</div>
                                    <?php }
                                else {
                                $all_requirement_success = false;

                                ?>

                                    <hr>
                                    <div class="alert alert-danger">Required files and folders are not writable.</div>

                                    <?php
                                    }
                                    ?>
 <hr>
                                    <div class="alert alert-info">Tip: Make sure you are using MySQL 5.6+ OR MariaDB 10.0+ .</div>

                            </div>
                        </div>

                        <div class="panel-footer">
                            <button <?php
                            if (!$all_requirement_success) {
                                echo "disabled=disabled";
                            }
                            ?>  class="btn btn-info form-next"><i class='fa fa-chevron-right'></i> Next
                            </button>
                        </div>

                    </div>
                    <div role="tabpanel" class="tab-pane" id="configuration-tab">
                        <form name="config-form" id="config-form" action="action.php" method="post">

                            <div class="section clearfix">
                                <p><strong>Please enter your database connection details.</strong></p>
                                <hr/>
                                <div>
                                    <div class="form-group clearfix">
                                        <label for="host" class=" col-md-3">Database Host</label>
                                        <div class="col-md-9">
                                            <input type="text" value="" id="host" name="host" class="form-control"
                                                   placeholder="Database Host (usually localhost)"/>
                                        </div>
                                    </div>
                                    <div class="form-group clearfix">
                                        <label for="dbuser" class=" col-md-3">Database User</label>
                                        <div class=" col-md-9">
                                            <input type="text" value="" name="dbuser" class="form-control"
                                                   autocomplete="off" placeholder="Database user name"/>
                                        </div>
                                    </div>
                                    <div class="form-group clearfix">
                                        <label for="dbpassword" class=" col-md-3">Password</label>
                                        <div class=" col-md-9">
                                            <input type="password" value="" name="dbpassword" class="form-control"
                                                   autocomplete="off" placeholder="Database user password"/>
                                        </div>
                                    </div>
                                    <div class="form-group clearfix">
                                        <label for="dbname" class=" col-md-3">Database Name</label>
                                        <div class=" col-md-9">
                                            <input type="text" value="" name="dbname" class="form-control"
                                                   placeholder="Database Name"/>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="section clearfix">
                                <p><strong>Please enter your account details for login to application after
                                        installation.</strong></p>
                                <hr/>
                                <div>

                                    <div class="form-group clearfix">
                                        <label for="email" class=" col-md-3">App URL</label>
                                        <div class=" col-md-9">
                                            <?php
                                            $http = (@$_SERVER["HTTPS"] == "on") ? "https://" : "http://";
                                            $cururl = $http . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
                                            $appurl = str_replace('/install/', '', $cururl);
                                            $appurl = str_replace('index.php', '', $appurl);

                                            echo '<input type="text" value="' . $appurl . '" name="app_url[]" class="form-control" placeholder="app access url" />';

                                            ?>
                                        </div>
                                    </div>


                                    <div class="form-group clearfix">
                                        <label for="host" class=" col-md-3">Login Email</label>
                                        <div class="col-md-9">
                                            <input type="email" name="email" class="form-control" placeholder="Email"/>
                                        </div>
                                    </div>

                                    <div class="form-group clearfix">
                                        <label for="host" class=" col-md-3"> LoginPassword</label>
                                        <div class="col-md-9">
                                            <input type="text" name="password" class="form-control"
                                                   placeholder="Password" value="123456" readonly="">
                                            <small> You can change later your login password.</small>
                                        </div>
                                    </div>



                                </div>


                            </div>

                            <div class="section clearfix">
                                <p><strong>Please enter your purchase code.</strong>
                                    <small> To find your purchase code please check your email or go to CodeCanyon >
                                        downloads.
                                    </small>
                                </p>
                                <hr/>

                                <div class="form-group clearfix">
                                    <label for="host" class=" col-md-3">Purchase Code</label>
                                    <div class="col-md-9">
                                        <input type="text" id="form_control" class="form-control"
                                               placeholder="Purchase Code"/>
                                    </div>
                                </div>
                                 <div class="form-group clearfix">
                                        <label for="number_decimal" class=" col-md-3">Database Decimal Number Format</label>
                                        <div class="col-md-9">
                                            <select name="number_decimal" class="form-control">
                                                <option value="2">0.00 - Default</option>
                                                <option value="3">0.000</option>
                                                <option value="4">0.0000</option>
                                            </select>
                                            <small> Do not change it, if do not know what you are doing. </small>
                                        </div>
                                    </div>
                            </div>

                            <div class="panel-footer">
                                <button type="submit" class="btn btn-info form-next">
                                    <span class="loader hide"> Please wait...It may take 5+ minutes...</span>
                                    <span class="button-text"><i class='fa fa-chevron-right'></i> Finish</span>
                                </button>
                            </div>

                        </form>
                    </div>

                    <div role="tabpanel" class="tab-pane" id="finished-tab">
                        <div class="section">
                            <div class="clearfix">
                                <i class="status fa fa-check-circle-o pull-left" style="font-size: 50px"> </i><span
                                        class="pull-left" style="line-height: 50px;">Congratulation! You have successfully installed.</span>

                            </div>

                            <div style="margin: 15px 0 15px 60px; color: #d73b3b;">
                                Don't forget to delete your install directory!
                            </div>
                            <div style="margin: 15px 0 15px 60px;">
                                <strong><strong class="text-danger">Note</strong>: Please read the help/troubleshoot_guide , public tickets on the helpdesk before
                                    sending any support request.</strong>
                            </div>

                            <div style="margin: 15px 0 15px 60px; font-size: 16px">
                                <p>
                                    Login id and password are same as you have entered.

                                </p>
                            </div>
                            <a class="go-to-login-page" href="<?php echo $appurl; ?>">
                                <div class="text-center">
                                    <div style="font-size: 100px;"><i class="fa fa-desktop"></i></div>
                                    <div>GO TO YOUR LOGIN PAGE</div>
                                </div>
                            </a>
                        </div>

                    </div>
                    <div id="alert-container">

                    </div>
                    <div class="text-center m-b-10">
                        Thank you for purchasing our application, for support, submit a ticket here <a href="http://helpdesk.ultimatekode.com">helpdesk.ultimatekode.com</a> Please read the help/troubleshoot_guide or public tickets on the helpdesk before
                                    sending any support request.
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>

<script type="text/javascript">
    var configurationIab = $('#form_control');
    var onFormSubmit = function ($form) {
        configurationIab.attr('name', 'app_url[]');
        $form.find('[type="submit"]').attr('disabled', 'disabled').find(".loader").removeClass("hide");
        $form.find('[type="submit"]').find(".button-text").addClass("hide");
        $("#alert-container").html("");
    };
    var onSubmitSussess = function ($form) {
        $form.find('[type="submit"]').removeAttr('disabled').find(".loader").addClass("hide");
        $form.find('[type="submit"]').find(".button-text").removeClass("hide");
    };


    $(document).ready(function () {
        var $preInstallationTab = $("#pre-installation-tab"),
            $termTab = $("#terms-tab"),
            $configurationTab = $("#configuration-tab");


        $(".form-next1").click(function () {

            $termTab.removeClass("active");
            $("#terms").removeClass("active");
            $preInstallationTab.addClass("active");
            $("#pre-installation").addClass("active");
            $("#terms").find("i").removeClass("fa-circle-o").addClass("fa-check-circle");

        });
        $(".form-next").click(function () {

            if ($preInstallationTab.hasClass("active")) {
                $("#pre-installation").removeClass("active");
                $preInstallationTab.removeClass("active");

                $termTab.removeClass("active");
                $configurationTab.addClass("active");
                $("#pre-installation").find("i").removeClass("fa-circle-o").addClass("fa-check-circle");
                $("#configuration").addClass("active");
                $("#host").focus();
            }
        });

        $("#config-form").submit(function () {
            var $form = $(this);
            onFormSubmit($form);
            $form.ajaxSubmit({
                dataType: "json",
                success: function (result) {
                    onSubmitSussess($form, result);
                    if (result.success) {
                        $configurationTab.removeClass("active");
                        $("#configuration").find("i").removeClass("fa-circle-o").addClass("fa-check-circle");
                        $("#finished").find("i").removeClass("fa-circle-o").addClass("fa-check-circle");
                        $("#finished").addClass("active");
                        $("#finished-tab").addClass("active");
                    } else {
                        $("#alert-container").html('<div class="alert alert-danger" role="alert">' + result.message + '</div>');
                    }
                }
            });
            return false;
        });

    });
</script>
