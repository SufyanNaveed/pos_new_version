
function selectCustomer(cid, cname, cadd1, cadd2, ph, email, discount = 0) {
    $('#customer_id').val(cid);
    $('#custom_discount').val(discount);
    $('#customer_name').html('<strong>' + cname + '</strong>');
    $('#customer_name').val(cname);
    $('#customer_address1').html('<strong>' + cadd1 + '<br>' + cadd2 + '</strong>');
    $('#customer_phone').html('Phone: <strong>' + ph + '</strong><br>Email: <strong>' + email + '</strong>');
    $("#customer-box").val();
    $("#customer-box-result").hide();
    $(".sbox-result").hide();
    $("#customer").show();
}


function def_timeout(ms) {
            var wait_obj = $.Deferred();
            setTimeout(wait_obj.resolve, ms);
            return wait_obj.promise();
}
///////////////////////////////////////////////////////////////////
function sleep(milliseconds) {
  const date = Date.now();
  let currentDate = null;
  do {
    currentDate = Date.now();
  } while (currentDate - date < milliseconds);
}

//hjghj

const add2SecondsDelay = () => {
  return new Promise(resolve => {
    setTimeout(() => {
      resolve('added 2 seconds delay');
    }, 20000);
  });
}
async function asyncFunctionCall() {

  console.log('abc'); // ------> first step
  const result = await add2SecondsDelay();
  console.log("xyz"); // ------> second step will execute after 2 seconds

}

function PselectCustomer(cid, cname, discount) {
    $('#customer_id').val(cid);
    $('#custom_discount').val(discount);

    $('#customer_name').html('<strong>' + cname + '</strong>');
    $("#customer-box-result").hide();
    $("#customer").show();
}

function selectSupplier(cid, cname, cadd1, cadd2, ph, email) {
    $('#customer_id').val(cid);
    $('#customer_name').html('<strong>' + cname + '</strong>');
    $('#customer_name').val(cname);
    $('#customer_address1').html('<strong>' + cadd1 + '<br>' + cadd2 + '</strong>');
    $('#customer_phone').html('Phone: <strong>' + ph + '</strong><br>Email: <strong>' + email + '</strong>');
    $("#customer-box").val();
    $("#supplier-box-result").hide();
    $("#customer").show();
}


function isNumber(evt) {
    evt = (evt) ? evt : window.event;
    var charCode = (evt.which) ? evt.which : evt.keyCode;
    if (charCode > 31 && (charCode < 44 || charCode > 57)) {
        return false;
    }
    return true;
}


$(document).ready(function () {


    $("#customer-box").keyup(function () {
        $.ajax({
            type: "GET",
            url: baseurl + 'search_products/csearch',
            data: 'keyword=' + $(this).val() + '&' + crsf_token + '=' + crsf_hash,
            beforeSend: function () {
                $("#customer-box").css("background", "#FFF url(" + baseurl + "assets/custom/load-ring.gif) no-repeat 165px");
            },
            success: function (data) {
                $("#customer-box-result").show();
                $("#customer-box-result").html(data);
                $("#customer-box").css("background", "none");

            }
        });
    });

    $("#pos-customer-box").keyup(function () {
        $.ajax({
            type: "GET",
            url: baseurl + 'search_products/pos_c_search',
            data: 'keyword=' + $(this).val() + '&' + crsf_token + '=' + crsf_hash,
            beforeSend: function () {
                $("#customer-box").css("background", "#FFF url(" + baseurl + "assets/custom/load-ring.gif) no-repeat 165px");
            },
            success: function (data) {
                $("#customer-box-result").show();
                $("#customer-box-result").html(data);
                $("#customer-box").css("background", "none");

            }
        });
    });

    $('#warehouses').change(function () {
        var whr = $('#warehouses option:selected').val();
        var cat = $('#categories option:selected').val();
        $.ajax({
            type: "POST",
            url: baseurl + 'search_products/pos_search',
            data: 'wid=' + whr + '&cid=' + cat + '&' + crsf_token + '=' + crsf_hash,
            beforeSend: function () {
                $("#customer-box").css("background", "#FFF url(" + baseurl + "assets/custom/load-ring.gif) no-repeat 165px");
            },
            success: function (data) {

                $("#pos_item").html(data);

            }
        });
    });


    $('#categories').change(function () {
        var whr = $('#warehouses option:selected').val();
        var cat = $('#categories option:selected').val();
        $.ajax({
            type: "POST",
            url: baseurl + 'search_products/pos_search',
            data: 'wid=' + whr + '&cid=' + cat + '&' + crsf_token + '=' + crsf_hash,
            beforeSend: function () {
                $("#customer-box").css("background", "#FFF url(" + baseurl + "assets/custom/load-ring.gif) no-repeat 165px");
            },
            success: function (data) {

                $("#pos_item").html(data);

            }
        });
    });


    $('#search_bar').keyup(function () {
        var whr = $('#warehouses option:selected').val();
        var cat = $('#categories option:selected').val();
        $.ajax({
            type: "POST",
            url: baseurl + 'search_products/pos_search',
            data: 'name=' + $(this).val() + '&wid=' + whr + '&cid=' + cat + '&' + crsf_token + '=' + crsf_hash,
            beforeSend: function () {
                $("#customer-box").css("background", "#FFF url(" + baseurl + "assets/custom/load-ring.gif) no-repeat 165px");
            },
            success: function (data) {

                $("#pos_item").html(data);

            }
        });
    });
     wait = true;


    $(document).on('click', ".v2_select_pos_item", function (e) {
        var pid = $(this).attr('data-pid');
        var stock = accounting.unformat($(this).attr('data-stock'), accounting.settings.number.decimal);

        var discount = $(this).attr('data-discount');
        var custom_discount = accounting.unformat($('#custom_discount').val(), accounting.settings.number.decimal);
        if (custom_discount > 0) discount = accounting.formatNumber(custom_discount);
        var flag = true;

             $('#v2_search_bar').attr('readonly',false);
         $('#v2_search_bar').val('');
            $('.pdIn').each(function () {

                if (pid == $(this).val()) {

                    var pi = $(this).attr('id');
                    var arr = pi.split('-');
                    pi = arr[1];
                    $('#discount-' + pi).val(discount);
                    var stotal = accounting.unformat($('#amount-' + pi).val(), accounting.settings.number.decimal) + 1;

                    if (stotal <= stock) {
                        $('#amount-' + pi).val(accounting.formatNumber(stotal));
                        $('#search_bar').val('').focus();
                    } else {
                        $('#stock_alert').modal('toggle');
                    }
                    rowTotal(pi);
                    billUpyog();

                    flag = false;
                }
            });
            var t_r = $(this).attr('data-tax');
            if ($("#taxformat option:selected").attr('data-trate')) {

                var t_r = $("#taxformat option:selected").attr('data-trate');
            }
            var sound = document.getElementById("beep");
            sound.play();
            if (flag) {
                var ganak = $('#ganak').val();
                var cvalue = parseInt(ganak);
                var functionNum = "'" + cvalue + "'";
                count = $('#saman-row div').length;
                var data = ' <div class="row  m-0 pt-1 pb-1 border-bottom"  id="ppid-' + cvalue + '"> <div class="col-6 "> <span class="quantity"><input type="text" class="form-control req amnt display-inline mousetrap" name="product_qty[]" inputmode="numeric" id="amount-' + cvalue + '" onkeypress="return isNumber(event)" onkeyup="rowTotal(' + functionNum + '), billUpyog()" autocomplete="off" value="1" ><div class="quantity-nav"><div class="quantity-button quantity-up">+</div><div class="quantity-button quantity-down">-</div></div></span>' + $(this).attr('data-name') + '-' + $(this).attr('data-pcode') + '</div> <div class="col-3"> ' + $(this).attr('data-price') + ' </div> <div class="col-3"><strong><span class="ttlText" id="result-' + cvalue + '">0</span></strong><a data-rowid="' + cvalue + '" class="red removeItem" title="Remove"> <i class="fa fa-trash"></i> </a></div><input type="hidden" class="form-control text-center" name="product_name[]" id="productname-' + cvalue + '" value="' + $(this).attr('data-name') + '-' + $(this).attr('data-pcode') + '"><input type="hidden" id="alert-' + cvalue + '" value="' + $(this).attr('data-stock') + '"  name="alert[]"><input type="hidden" class="form-control req prc" name="product_price[]" id="price-' + cvalue + '" onkeypress="return isNumber(event)" onkeyup="rowTotal(' + functionNum + '), billUpyog()" autocomplete="off"  value="' + $(this).attr('data-price') + '" inputmode="numeric"> <input type="hidden" class="form-control vat" name="product_tax[]" id="vat-' + cvalue + '" onkeypress="return isNumber(event)" onkeyup="rowTotal(' + functionNum + '), billUpyog()" autocomplete="off"  value="' + t_r + '"><input type="hidden" class="form-control discount pos_w" name="product_discount[]" onkeypress="return isNumber(event)" id="discount-' + cvalue + '" onkeyup="rowTotal(' + functionNum + '), billUpyog()" autocomplete="off"  value="' + discount + '"><input type="hidden" name="taxa[]" id="taxa-' + cvalue + '" value="0"><input type="hidden" name="disca[]" id="disca-' + cvalue + '" value="0"><input type="hidden" class="ttInput" name="product_subtotal[]" id="total-' + cvalue + '" value="0"> <input type="hidden" class="pdIn" name="pid[]" id="pid-' + cvalue + '" value="' + $(this).attr('data-pid') + '"> <input type="hidden" name="unit[]" id="unit-' + cvalue + '" value="' + $(this).attr('data-unit') + '"><input type="hidden" name="hsn[]" id="hsn-' + cvalue + '" value="' + $(this).attr('data-pcode') + '"> <input type="hidden" name="serial[]" id="serial-' + cvalue + '" value="' + $(this).attr('data-serial') + '"></div>';
                //ajax request
                // $('#saman-row').append(data);
                $('#pos_items').append(data);
                rowTotal(cvalue);
                billUpyog();
                $('#ganak').val(cvalue + 1);
                $('#amount-' + cvalue).focus();
            }
                 var whr = $('#v2_warehouses option:selected').val();
                            var cat = $('#v2_categories option:selected').val();

                                $.ajax({
                                    type: "POST",
                                    url: baseurl + 'search_products/v2_pos_search',
                                    data: 'name=' + $(this).val() + '&wid=' + whr + '&cid=' + cat + '&' + crsf_token + '=' + crsf_hash+'&bar=' + $('#bar_only').prop('checked')+'&bar=' + $('#bar_only').prop('checked'),
                                    beforeSend: function () {
                                        $("#customer-box").css("background", "#FFF url(" + baseurl + "assets/custom/load-ring.gif) no-repeat 165px");
                                    },
                                    success: function (data) {
                                        $("#pos_item").html(data);

                                    }
                                });



    });



      $(document).on('click', ".v2_select_pos_item_bar", function (e) {
 if (!$('#v2_search_bar').is('[readonly="true"]') ) {

     wait = false;
     var pid = $(this).attr('data-pid');
     var stock = accounting.unformat($(this).attr('data-stock'), accounting.settings.number.decimal);

     var discount = $(this).attr('data-discount');
     var custom_discount = accounting.unformat($('#custom_discount').val(), accounting.settings.number.decimal);
     if (custom_discount > 0) discount = accounting.formatNumber(custom_discount);
     var flag = true;
     var barcode_flag = true;

     var bar = $(this).attr('data-bar');
     var search = $('#v2_search_bar').val();
  $('#v2_search_bar').attr('readonly',false);
         $('#v2_search_bar').val('');
     if (bar && search && bar == search) {

         $('.pdIn').each(function () {

             if (pid == $(this).val()) {


                 var pi = $(this).attr('id');
                 var arr = pi.split('-');
                 pi = arr[1];
                 $('#discount-' + pi).val(discount);
                 var stotal = accounting.unformat($('#amount-' + pi).val(), accounting.settings.number.decimal) + 1;

                 if (stotal <= stock && barcode_flag) {
                     $('#amount-' + pi).val(accounting.formatNumber(stotal));
                     $('#search_bar').val('').focus();
                 } else {
                     $('#stock_alert').modal('toggle');
                 }
                 rowTotal(pi);
                 billUpyog();

                 flag = false;
             }
         });
         var t_r = $(this).attr('data-tax');
         if ($("#taxformat option:selected").attr('data-trate')) {

             var t_r = $("#taxformat option:selected").attr('data-trate');
         }
         var sound = document.getElementById("beep");
         sound.play();
         if (flag && barcode_flag) {
             var ganak = $('#ganak').val();
             var cvalue = parseInt(ganak);
             var functionNum = "'" + cvalue + "'";
             count = $('#saman-row div').length;
             var data = ' <div class="row  m-0 pt-1 pb-1 border-bottom"  id="ppid-' + cvalue + '"> <div class="col-6 "> <span class="quantity"><input type="text" class="form-control req amnt display-inline mousetrap" name="product_qty[]" inputmode="numeric" id="amount-' + cvalue + '" onkeypress="return isNumber(event)" onkeyup="rowTotal(' + functionNum + '), billUpyog()" autocomplete="off" value="1" ><div class="quantity-nav"><div class="quantity-button quantity-up">+</div><div class="quantity-button quantity-down">-</div></div></span>' + $(this).attr('data-name') + '-' + $(this).attr('data-pcode') + '</div> <div class="col-3"> ' + $(this).attr('data-price') + ' </div> <div class="col-3"><strong><span class="ttlText" id="result-' + cvalue + '">0</span></strong><a data-rowid="' + cvalue + '" class="red removeItem" title="Remove"> <i class="fa fa-trash"></i> </a></div><input type="hidden" class="form-control text-center" name="product_name[]" id="productname-' + cvalue + '" value="' + $(this).attr('data-name') + '-' + $(this).attr('data-pcode') + '"><input type="hidden" id="alert-' + cvalue + '" value="' + $(this).attr('data-stock') + '"  name="alert[]"><input type="hidden" class="form-control req prc" name="product_price[]" id="price-' + cvalue + '" onkeypress="return isNumber(event)" onkeyup="rowTotal(' + functionNum + '), billUpyog()" autocomplete="off"  value="' + $(this).attr('data-price') + '" inputmode="numeric"> <input type="hidden" class="form-control vat" name="product_tax[]" id="vat-' + cvalue + '" onkeypress="return isNumber(event)" onkeyup="rowTotal(' + functionNum + '), billUpyog()" autocomplete="off"  value="' + t_r + '"><input type="hidden" class="form-control discount pos_w" name="product_discount[]" onkeypress="return isNumber(event)" id="discount-' + cvalue + '" onkeyup="rowTotal(' + functionNum + '), billUpyog()" autocomplete="off"  value="' + discount + '"><input type="hidden" name="taxa[]" id="taxa-' + cvalue + '" value="0"><input type="hidden" name="disca[]" id="disca-' + cvalue + '" value="0"><input type="hidden" class="ttInput" name="product_subtotal[]" id="total-' + cvalue + '" value="0"> <input type="hidden" class="pdIn" name="pid[]" id="pid-' + cvalue + '" value="' + $(this).attr('data-pid') + '"> <input type="hidden" name="unit[]" id="unit-' + cvalue + '" value="' + $(this).attr('data-unit') + '"><input type="hidden" name="hsn[]" id="hsn-' + cvalue + '" value="' + $(this).attr('data-pcode') + '"> <input type="hidden" name="serial[]" id="serial-' + cvalue + '" value="' + $(this).attr('data-serial') + '"></div>';
             //ajax request
             // $('#saman-row').append(data);
             $('#pos_items').append(data);
             rowTotal(cvalue);
             billUpyog();
             $('#ganak').val(cvalue + 1);

         }
     }
     asyncFunctionCall();

     wait = true;

     return false;

 }



});

    $("#supplier-box").keyup(function () {
        $.ajax({
            type: "GET",
            url: baseurl + 'search_products/supplier',
            data: 'keyword=' + $(this).val() + '&' + crsf_token + '=' + crsf_hash,
            beforeSend: function () {
                $("#supplier-box").css("background", "#FFF url(" + baseurl + "assets/custom/load-ring.gif) no-repeat 165px");
            },
            success: function (data) {
                $("#supplier-box-result").show();
                $("#supplier-box-result").html(data);
                $("#supplier-box").css("background", "none");

            }
        });
    });

    $("#invoice-box").keyup(function () {
        $.ajax({
            type: "GET",
            url: baseurl + 'search/invoice',
            data: 'keyword=' + $(this).val() + '&' + crsf_token + '=' + crsf_hash,
            beforeSend: function () {
                $("#customer-box").css("background", "#FFF url(" + baseurl + "assets/custom/load-ring.gif) no-repeat 165px");
            },
            success: function (data) {
                $("#invoice-box-result").show();
                $("#invoice-box-result").html(data);
                $("#invoice-box").css("background", "none");

            }
        });
    });

    $("#head-customerbox").keyup(function () {
        $.ajax({
            type: "GET",
            url: baseurl + 'search/customer',
            data: 'keyword=' + $(this).val() + '&' + crsf_token + '=' + crsf_hash,
            beforeSend: function () {
                $("#customer-box").css("background", "#FFF url(" + baseurl + "assets/custom/load-ring.gif) no-repeat 165px");
            },
            success: function (data) {
                $("#head-customerbox-result").show();
                $("#head-customerbox-result").html(data);
                //$("#invoice-box").css("background", "none");

            }
        });
    });


});
//make payment

$(document).on('click', "#thermal_p", function (e) {
    var ptid = $(this).attr('data-ptid');
    e.preventDefault();
    $.ajax({
        url: baseurl + 'pos_invoices/thermal_print?id=' + ptid,
        dataType: 'json',
        data: crsf_token + '=' + crsf_hash,
        success: function (data) {
            if (data.status == 'Success') {
                $("#thermal_a").removeClass("alert-warning").addClass("alert alert-info").fadeIn();
                $("#thermal_a .message").html(data.message);
                $("html, body").animate({scrollTop: $('#thermal_a').offset().bottom}, 1000);
            } else {
                $("#thermal_a").removeClass("alert-success").addClass("alert-warning").fadeIn();
                $("#thermal_a .message").html(data.message);
                $("html, body").animate({scrollTop: $('#thermal_a').offset().bottom}, 1000);
            }
        }
    });
});

$(document).on('click', "#thermal_server", function (e) {
    var ptid = $(this).attr('data-ptid');
    var url = $(this).attr('data-url');
    e.preventDefault();
    $.ajax({
        url: url + '?id=' + ptid,
        data: crsf_token + '=' + crsf_hash,
        dataType: 'html',
        success: function (data) {
            $("#thermal_a").removeClass("alert-warning").addClass("alert alert-info").fadeIn();
            $("#thermal_a .message").html('Success');
            $("html, body").animate({scrollTop: $('#thermal_a').offset().bottom}, 1000);
        }
    });

});

//part
$(document).on('click', "#submitpayment", function (e) {
    e.preventDefault();

    var pyurl = baseurl + 'transactions/payinvoice';
    payInvoice(pyurl);

});
$(document).on('click', "#purchasepayment", function (e) {
    e.preventDefault();

    var pyurl = baseurl + 'transactions/paypurchase';

    payInvoice(pyurl);


});
$(document).on('click', "#recpayment", function (e) {
    e.preventDefault();

    var pyurl = baseurl + 'transactions/pay_recinvoice';

    payInvoice(pyurl);


});

function payInvoice(pyurl) {

    var errorNum = farmCheck();
    $("#part_payment").modal('hide');
    if (errorNum > 0) {
        $("#notify").removeClass("alert-success").addClass("alert-danger").fadeIn();
        $("#notify .message").html("<strong>Error</strong>: It appears you have forgotten to enter partial amount!");
        $("html, body").animate({scrollTop: $('#notify').offset().bottom}, 1000);
    } else {
        jQuery.ajax({

            url: pyurl,
            type: 'POST',
            data: $('form.payment').serialize() + '&' + crsf_token + '=' + crsf_hash,
            dataType: 'json',
            success: function (data) {
                if (data.status == "Success") {
                    $("#notify .message").html("<strong>" + data.status + "</strong>: " + data.message);
                    $("#notify").removeClass("alert-danger").addClass("alert-success").fadeIn();
                    $("html, body").scrollTop($("body").offset().top);
                    $('#pstatus').html(data.pstatus);
                    $('#activity').append(data.activity);
                    $('#rmpay').val(data.amt);
                    $('#paymade').text(data.ttlpaid);
                    $('#paydue').text(data.amt);

                } else {
                    $("#notify .message").html("<strong>" + data.status + "</strong>: " + data.message);
                    $("#notify").removeClass("alert-success").addClass("alert-danger").fadeIn();
                    $("html, body").scrollTop($("body").offset().top);

                }

            },
            error: function (data) {
                $("#notify .message").html("<strong>" + data.status + "</strong>: " + data.message);
                $("#notify").removeClass("alert-success").addClass("alert-danger").fadeIn();
                $("html, body").scrollTop($("body").offset().top);
            }
        });
    }

}

//////////////send

function loadEmailTem(action) {

    jQuery.ajax({

        url: baseurl + 'emailinvoice/template',
        type: 'POST',
        data: action + '&' + crsf_token + '=' + crsf_hash,
        dataType: 'json',
        beforeSend: function () {
            setTimeout(
                console.log('loading')
                , 5000);
        },
        success: function (data) {
            $('#request').hide();
            $('#emailbody').show();
            $('#subject').val(data.subject);
            $('.note-editable').html(data.message);


        },
        error: function (data) {
            $("#notify .message").html("<strong>" + data.status + "</strong>: " + data.message);
            $("#notify").removeClass("alert-success").addClass("alert-danger").fadeIn();
            $("html, body").scrollTop($("body").offset().top);
        }
    });

}

$('.sendbill').click(function (e) {
    e.preventDefault();
    $('#emailtype').val($(this).attr('data-type'));
    $('#itype').val($(this).attr('data-itype'));

});
$('.sendsms').click(function (e) {
    e.preventDefault();
    $('#smstype').val($(this).attr('data-type'));

});
$("#sendEmail").on("show.bs.modal", function (e) {
    var action = 'ttype=' + $('#emailtype').val() + '&invoiceid=' + $('#invoiceid').val() + '&itype=' + $('#itype').val();
    loadEmailTem(action);
});

$("#sendSMS").on("show.bs.modal", function (e) {
    var action = 'ttype=' + $('#smstype').val() + '&invoiceid=' + $('#invoiceid').val();
    loadSmsTem(action);
});

function loadSmsTem(action) {

    jQuery.ajax({

        url: baseurl + 'sms/template',
        type: 'POST',
        data: action + '&' + crsf_token + '=' + crsf_hash,
        dataType: 'json',
        beforeSend: function () {
            setTimeout(
                console.log('loading')
                , 5000);
        },
        success: function (data) {
            $('#request_sms').hide();
            $('#smsbody').show();
            $('#sms_tem').html(data.message);
        },
        error: function (data) {
            $("#notify .message").html("<strong>" + data.status + "</strong>: " + data.message);
            $("#notify").removeClass("alert-success").addClass("alert-danger").fadeIn();
            $("html, body").scrollTop($("body").offset().top);
        }
    });

}

$('#submitSMS').on('click', function (e) {
    e.preventDefault();
    $("#sendSMS").modal('hide');

    var action = 'mobile=' + $('#smstype').val() + '&message=' + $('#invoiceid').val();

    sendSms(action);

});

function sendSms(message) {
    var errorNum = farmCheck();
    $("#sendEmail").modal('hide');
    if (errorNum > 0) {
        $("#notify").removeClass("alert-success").addClass("alert-warning").fadeIn();
        $("#notify .message").html("<strong>Error</strong>: It appears you have forgotten to enter mobile number!");
        $("html, body").animate({scrollTop: $('#notify').offset().bottom}, 1000);
    } else {
        jQuery.ajax({
            url: baseurl + 'sms/send_sms',
            type: 'POST',
            data: $('#sendsms').serialize() + '&' + crsf_token + '=' + crsf_hash,
            dataType: 'json',
            success: function (data) {
                if (data.status == "Success") {
                    $("#notify .message").html("<strong>" + data.status + "</strong>: " + data.message);
                    $("#notify").removeClass("alert-danger").addClass("alert-success").fadeIn();
                    $("html, body").scrollTop($("body").offset().top);
                } else {
                    $("#notify .message").html("<strong>" + data.status + "</strong>: " + data.message);
                    $("#notify").removeClass("alert-success").addClass("alert-danger").fadeIn();
                    $("html, body").scrollTop($("body").offset().top);
                }
            },
            error: function (data) {
                $("#notify .message").html("<strong>" + data.status + "</strong>: " + data.message);
                $("#notify").removeClass("alert-success").addClass("alert-danger").fadeIn();
                $("html, body").scrollTop($("body").offset().top);
            }
        });
    }
}

//mail
function sendBill(message) {
    var errorNum = farmCheck();
    $("#sendEmail").modal('hide');
    if (errorNum > 0) {
        $("#notify").removeClass("alert-success").addClass("alert-warning").fadeIn();
        $("#notify .message").html("<strong>Error</strong>: It appears you have forgotten to enter email!");
        $("html, body").animate({scrollTop: $('#notify').offset().bottom}, 1000);
    } else {
        jQuery.ajax({
            url: baseurl + 'communication/send_invoice',
            type: 'POST',
            data: $('#sendbill').serialize() + '&message=' + encodeURIComponent(message) + '&' + crsf_token + '=' + crsf_hash,
            dataType: 'json',
            success: function (data) {
                if (data.status == "Success") {
                    $("#notify .message").html("<strong>" + data.status + "</strong>: " + data.message);
                    $("#notify").removeClass("alert-danger").addClass("alert-success").fadeIn();
                    $("html, body").scrollTop($("body").offset().top);
                } else {
                    $("#notify .message").html("<strong>" + data.status + "</strong>: " + data.message);
                    $("#notify").removeClass("alert-success").addClass("alert-danger").fadeIn();
                    $("html, body").scrollTop($("body").offset().top);
                }
            },
            error: function (data) {
                $("#notify .message").html("<strong>" + data.status + "</strong>: " + data.message);
                $("#notify").removeClass("alert-success").addClass("alert-danger").fadeIn();
                $("html, body").scrollTop($("body").offset().top);
            }
        });
    }
}

////////////////////////////////////////////////////////////
//////////////cancel
$(document).on('click', "#cancel-bill", function (e) {
    e.preventDefault();
    $('#cancel_bill').modal({backdrop: 'static', keyboard: false}).one('click', '#send', function () {
        var acturl = 'transactions/cancelinvoice';
        cancelBill(acturl);
    });
});

function cancelBill(acturl) {
    var $btn;
    var errorNum = farmCheck();
    $("#cancel_bill").modal('hide');
    if (errorNum > 0) {
        $("#notify").removeClass("alert-success").addClass("alert-warning").fadeIn();
        $("#notify .message").html("<strong>Error</strong>");
        $("html, body").animate({scrollTop: $('#notify').offset().bottom}, 1000);
    } else {
        jQuery.ajax({
            url: baseurl + acturl,
            type: 'POST',
            data: $('form.cancelbill').serialize() + '&' + crsf_token + '=' + crsf_hash,
            dataType: 'json',
            success: function (data) {
                if (data.status == "Success") {
                    $("#notify .message").html("<strong>" + data.status + "</strong>: " + data.message);
                    $("#notify").removeClass("alert-danger").addClass("alert-success").fadeIn();
                    $("html, body").scrollTop($("body").offset().top);
                } else {
                    $("#notify .message").html("<strong>" + data.status + "</strong>: " + data.message);
                    $("#notify").removeClass("alert-success").addClass("alert-danger").fadeIn();
                    $("html, body").scrollTop($("body").offset().top);
                }
                setTimeout(function () {// wait for 5 secs(2)
                    location.reload(); // then reload the page.(3)
                }, 2000);
            },
            error: function (data) {
                $("#notify .message").html("<strong>" + data.status + "</strong>: " + data.message);
                $("#notify").removeClass("alert-success").addClass("alert-danger").fadeIn();
                $("html, body").scrollTop($("body").offset().top);
            }
        });
    }
}

/////// product add edit actions
//calcualtions
$("#calculate_income").click(function (e) {
    e.preventDefault();
    var actionurl = baseurl + 'reports/customincome';
    actionCaculate(actionurl);
});
$("#calculate_expense").click(function (e) {
    e.preventDefault();
    var actionurl = baseurl + 'reports/customexpense';
    actionCaculate(actionurl);
});

function actionCaculate(actionurl, f_name = '#product_action') {
    var errorNum = farmCheck();
    if (errorNum > 0) {
        $("#notify").removeClass("alert-success").addClass("alert-warning").fadeIn();
        $("#notify .message").html("<strong>Error</strong>: It appears you have forgotten to complete something!");
        $("html, body").animate({scrollTop: $('#notify').offset().top}, 1000);
    } else {
        $(".required").parent().removeClass("has-error");
        $.ajax({
            url: actionurl,
            type: 'POST',
            data: $(f_name).serialize() + '&' + crsf_token + '=' + crsf_hash,
            dataType: 'json',
            success: function (data) {
                $("#notify .message").html("<strong>" + data.status + "</strong>: " + data.message);
                $("#notify").removeClass("alert-warning").addClass("alert-success").fadeIn();
                $("html, body").animate({scrollTop: $('html, body').offset().top}, 200);
                //  $("#product_action").remove();
                $("#param1").html(data.param1);
            },
            error: function (data) {
                $("#notify .message").html("<strong>" + data.status + "</strong>: " + data.message);
                $("#notify").removeClass("alert-success").addClass("alert-warning").fadeIn();
                $("html, body").animate({scrollTop: $('#notify').offset().top}, 1000);
            }
        });
    }
}

$("#mclient_add").click(function (e) {
    e.preventDefault();
    var actionurl = baseurl + 'invoices/addcustomer';
    searchCS(actionurl);
});
$("#msupplier_add").click(function (e) {
    e.preventDefault();
    var actionurl = baseurl + 'supplier/addsupplier';
    searchCS(actionurl);
});

function searchCS(actionurl) {
    var errorNum = farmCheck2();
    if (errorNum > 0) {
        $("#statusMsg").removeClass("alert-success").addClass("alert-warning").fadeIn();
        $("#statusMsg").html("<strong>Error</strong>: It appears you have forgotten to complete something!");
        $("html, body").animate({scrollTop: $('#statusMsg').offset().top}, 1000);
    } else {
        $(".crequired").parent().removeClass("has-error");
        $.ajax({
            url: actionurl,
            type: 'POST',
            data: $("#product_action").serialize() + '&' + crsf_token + '=' + crsf_hash,
            dataType: 'json',
            success: function (data) {
                if (data.status == 'Success') {


                    $("#statusMsg").html("<strong>" + data.status + "</strong>: " + data.message);
                    $("#statusMsg").removeClass("alert-warning").addClass("alert-success").fadeIn();
                    $("html, body").animate({scrollTop: $('html, body').offset().top}, 200);
                    $('#customer_id').val(data.cid);
                    $('#customer_name').html('<strong>' + $('#mcustomer_name').val() + '</strong>');
                    $('#customer_address1').html('<strong>' + $('#mcustomer_address1').val() + '<br>' + $('#mcustomer_city').val() + ',' + $('#mcustomer_country').val() + '</strong>');
                    $('#customer_phone').html('Phone: <strong>' + $('#mcustomer_phone').val() + '</strong><br>Email: <strong>' + $('#mcustomer_email').val() + '</strong>');
                    $('#customer_pass').html('Login Password ' + data.pass);
                     $('#custom_discount').val(data.discount);
                    $("#customer-box").val();
                    $("#customer-box-result").hide();
                    $("#customer").show();
                    $('#addCustomer').find('input:text,input:hidden').val('');
                    $("#addCustomer").modal('toggle');
                    $("#Pos_addCustomer").modal('toggle');
                } else {
                    $("#statusMsg").html("<strong>" + data.status + "</strong>: " + data.message);
                    $("#statusMsg").removeClass("alert-success").addClass("alert-warning").fadeIn();
                    $("html, body").animate({scrollTop: $('#statusMsg').offset().top}, 1000);
                }
            },
            error: function (data) {
                $("#statusMsg").html("<strong>" + data.status + "</strong>: " + data.message);
                $("#statusMsg").removeClass("alert-success").addClass("alert-warning").fadeIn();
                $("html, body").animate({scrollTop: $('#statusMsg').offset().top}, 1000);
            }
        });
    }
}


//task manager
$('.icheck-activity').click(function (e) {
    var actionurl = 'tools/set_task';
    var id = $(this)[0].value;
    var stat = '';
    var hid = $(this).attr('id');
    if ($(this)[0].checked) {
        stat = 'Done';
        $('#s' + hid).removeClass("task_Due").addClass('task_Done');
    } else {
        stat = 'Due';
        $('#s' + hid).removeClass("task_Done").addClass('task_Due');
    }
    $('#s' + hid).text(stat);
    $.ajax({
        url: baseurl + actionurl,
        type: 'POST',
        data: 'tid=' + id + '&stat=' + stat + '&' + crsf_token + '=' + crsf_hash,
        dataType: 'json',
        success: function (data) {

        }
    });

});

$(document).on('click', ".check", function (e) {
    e.preventDefault();
    var actionurl = 'tools/set_task';
    var rval = 'Due';
    var id = $(this).attr('data-id');
    var stat = $(this).attr('data-stat');
    if (stat == 'Done') {
        $(this).attr('data-stat', 'Due');
        $(this).toggleClass('text-success text-default');
    } else {
        $(this).toggleClass('text-default text-success');
        $(this).attr('data-stat', 'Done');
        rval = 'Done';
    }
    $.ajax({
        url: baseurl + actionurl,
        type: 'POST',
        data: 'tid=' + id + '&stat=' + rval + '&' + crsf_token + '=' + crsf_hash,
        dataType: 'json',
        success: function (data) {
        }
    });
});
//universal list item delete from table
$(document).on('click', ".delete-object", function (e) {
    e.preventDefault();
    $('#object-id').val($(this).attr('data-object-id'));

    $(this).closest('tr').attr('id', $(this).attr('data-object-id'));
    $('#delete_model').modal({backdrop: 'static', keyboard: false});

});
$(document).on('click', ".delete-object2", function (e) {
    e.preventDefault();
    $('#object-id2').val($(this).attr('data-object-id'));
    $(this).closest('tr').attr('id', $(this).attr('data-object-id'));
    $('#delete_model2').modal({backdrop: 'static', keyboard: false});

});
$("#delete-confirm").on("click", function () {
    var o_data = 'deleteid=' + $('#object-id').val();
    var action_url = $('#delete_model #action-url').val();
    $('#' + $('#object-id').val()).remove();
    removeObject(o_data, action_url);
});
$("#delete-confirm2").on("click", function () {
    var o_data = 'deleteid=' + $('#object-id2').val();
    var action_url = $('#delete_model2 #action-url2').val();
    $('#' + $('#object-id2').val()).remove();
    removeObject(o_data, action_url);
});



function removeObject(action, action_url) {
    if ($("#notify").length == 0) {
        $("#c_body").html('<div id="notify" class="alert" style="display:none;"><a href="#" class="close" data-dismiss="alert">&times;</a><div class="message"></div></div>');
    }
    jQuery.ajax({
        url: baseurl + action_url,
        type: 'POST',
        data: action + '&' + crsf_token + '=' + crsf_hash,
        dataType: 'json',
        success: function (data) {
            if (data.status == "Success") {
                $("#notify .message").html("<strong>" + data.status + "</strong>: " + data.message);
                $("#notify").removeClass("alert-danger").addClass("alert-success").fadeIn();
                $("html, body").scrollTop($("body").offset().top);
            } else {
                $("#notify .message").html("<strong>" + data.status + "</strong>: " + data.message);
                $("#notify").removeClass("alert-success").addClass("alert-danger").fadeIn();
                $("html, body").scrollTop($("body").offset().top);
            }
        },
        error: function (data) {
            $("#notify .message").html("<strong>" + data.status + "</strong>: " + data.message);
            $("#notify").removeClass("alert-success").addClass("alert-warning").fadeIn();
            $("html, body").scrollTop($("body").offset().top);
        }
    });
}

//universal create
$("#submit-data").on("click", function (e) {
    e.preventDefault();
    $(this).hide();
    var o_data = $("#data_form").serialize();
    var action_url = $('#action-url').val();
    addObject(o_data, action_url);
    setTimeout(function(){  $("#submit-data").show(); }, 1000);
});
$("#submit-data2").on("click", function (e) {
    e.preventDefault();

    var o_data = $("#data_form2").serialize();
    var action_url = $('#action-url2').val();
    addObject(o_data, action_url);
});

function addObject(action, action_url) {
    var errorNum = farmCheck();
    var $btn;
    if ($("#notify").length == 0) {
        $("#c_body").html('<div id="notify" class="alert" style="display:none;"><a href="#" class="close" data-dismiss="alert">&times;</a><div class="message"></div></div>');
    }
    if (errorNum > 0) {
        $("#notify").removeClass("alert-success").addClass("alert-warning").fadeIn();
        $("#notify .message").html("<strong>Error</strong>: It appears you have forgotten to complete something!");
        $("html, body").scrollTop($("body").offset().top);
    } else {
        jQuery.ajax({
            url: baseurl + action_url,
            type: 'POST',
            data: action + '&' + crsf_token + '=' + crsf_hash,
            dataType: 'json',
            success: function (data) {

                if (data.status == "Success") {
                    $("#notify .message").html("<strong>" + data.status + "</strong>: " + data.message);
                    $("#notify").removeClass("alert-danger").addClass("alert-success").fadeIn();
                    $("html, body").scrollTop($("body").offset().top);
                    $("#data_form").remove();
                } else {
                    $("#notify .message").html("<strong>" + data.status + "</strong>: " + data.message);
                    $("#notify").removeClass("alert-success").addClass("alert-danger").fadeIn();
                    $("html, body").scrollTop($("body").offset().top);
                }
            },
            error: function (data) {
                $("#notify .message").html("<strong>" + data.status + "</strong>: " + data.message);
                $("#notify").removeClass("alert-success").addClass("alert-warning").fadeIn();
                $("html, body").scrollTop($("body").offset().top);
            }
        });
    }
}

//
function actionProduct(actionurl) {
    var errorNum = farmCheck();

    if (errorNum > 0) {
        $("#notify").removeClass("alert-success").addClass("alert-warning").fadeIn();
        $("#notify .message").html("<strong>Error</strong>: It appears you have forgotten to complete something!");
        $("html, body").animate({scrollTop: $('#notify').offset().top}, 1000);
    } else {
        $(".required").parent().removeClass("has-error");
        $.ajax({
            url: actionurl,
            type: 'POST',
            data: $("#product_action").serialize() + '&' + crsf_token + '=' + crsf_hash,
            dataType: 'json',
            success: function (data) {
                $("#notify .message").html("<strong>" + data.status + "</strong>: " + data.message);
                $("#notify").removeClass("alert-warning").addClass("alert-success").fadeIn();
                $("html, body").animate({scrollTop: $('html, body').offset().top}, 200);
                //   $("#product_action").remove();
            },
            error: function (data) {
                $("#notify .message").html("<strong>" + data.status + "</strong>: " + data.message);
                $("#notify").removeClass("alert-success").addClass("alert-warning").fadeIn();
                $("html, body").animate({scrollTop: $('#notify').offset().top}, 1000);
            }
        });
    }
}

//uni sender
$('#sendMail').on('click', '#sendNow', function (e) {
    e.preventDefault();
    var o_data = $("#sendmail_form").serialize();
    var action_url = $('#sendMail #action-url').val();
    sendMail_g(o_data, action_url);
});

$(document).on('click', "#upda", function (e) {
    e.preventDefault();
    var errorNum = farmCheck();
    if (errorNum > 0) {
        $("#notify").removeClass("alert-success").addClass("alert-warning").fadeIn();
        $("#notify .message").html("<strong>Error</strong>: It appears you have forgotten to details!");
        $("html, body").animate({scrollTop: $('body').offset().top}, 1000);
    } else {
        var action_url = $("#core").val();
        $.ajax({
            url: baseurl + action_url,
            type: 'POST',
            data: $("#activ").serialize() + '&' + crsf_token + '=' + crsf_hash,
            dataType: 'json',
            success: function (data) {

                if (data.status == 'Success') {
                    $("#notify .message").html("<strong>Success</strong>: Thank You! License updated, please refresh the page.");
                    $("#notify").removeClass("alert-danger").addClass("alert-success").fadeIn();
                    $("html, body").animate({scrollTop: $('#notify').offset().top}, 1000);
                    setTimeout(function () {
                        window.location.href = baseurl;
                    }, 1000);
                } else if (data.status == 'WError') {
                    $("#notify .message").html("<strong>Error</strong>: " + data.message);
                    $("#notify").removeClass("alert-success").addClass("alert-danger").fadeIn();
                    $("html, body").animate({scrollTop: $('#notify').offset().top}, 1000);
                } else if (data.status == 'Error') {
                    $("#notify .message").html("<strong>Error</strong>: " + data.message + " <a class='blue' href='http://bit.ly/georegular' target='_blank'>Purchase another copy</a> OR <a href='http://bit.ly/2IsOoFa' target='_blank'> Read the license terms!</a>");
                    $("#notify").removeClass("alert-success").addClass("alert-danger").fadeIn();
                    $("html, body").animate({scrollTop: $('#notify').offset().top}, 1000);
                } else {
                    setTimeout(function () {
                        window.location.href = baseurl;
                    }, 100);
                }
            }
        });

    }
});


function sendMail_g(o_data, action_url) {
    var errorNum = farmCheck();
    $("#sendMail").modal('hide');
    if ($("#notify").length == 0) {
        $("#c_body").html('<div id="notify" class="alert" style="display:none;"><a href="#" class="close" data-dismiss="alert">&times;</a><div class="message"></div></div>');
    }

    if (errorNum > 0) {
        $("#notify").removeClass("alert-success").addClass("alert-warning").fadeIn();
        $("#notify .message").html("<strong>Error</strong>");
        $("html, body").animate({scrollTop: $('body').offset().top}, 1000);
    } else {
        jQuery.ajax({
            url: baseurl + action_url,
            type: 'POST',
            data: o_data + '&' + crsf_token + '=' + crsf_hash,
            dataType: 'json',
            success: function (data) {
                if (data.status == "Success") {
                    $("#notify .message").html("<strong>" + data.status + "</strong>: " + data.message);
                    $("#notify").removeClass("alert-danger").addClass("alert-success").fadeIn();
                    $("html, body").animate({scrollTop: $('#notify').offset().top}, 1000);
                } else {
                    $("#notify .message").html("<strong>" + data.status + "</strong>: " + data.message);
                    $("#notify").removeClass("alert-success").addClass("alert-danger").fadeIn();
                    $("html, body").animate({scrollTop: $('body').offset().top}, 1000);
                }
            },
            error: function (data) {
                $("#notify .message").html("<strong>" + data.status + "</strong>: " + data.message);
                $("#notify").removeClass("alert-success").addClass("alert-danger").fadeIn();
                $("html, body").animate({scrollTop: $('body').offset().top}, 1000);
            }
        });
    }
}

//generic model

//part
$(document).on('click', "#submit_model", function (e) {
    e.preventDefault();
    var o_data = $("#form_model").serialize();
    var action_url = $('#form_model #action-url').val();
    $("#pop_model").modal('hide');
    saveMData(o_data, action_url);
});

$(document).on('click', "#submit_model2", function (e) {
    e.preventDefault();
    var o_data = $("#form_model2").serialize();
    var action_url = $('#form_model2 #action-url').val();
    $("#pop_model2").modal('hide');
    saveMData(o_data, action_url);
});

$(document).on('click', "#submit_model3", function (e) {
    e.preventDefault();
    var o_data = $("#form_model3").serialize();
    var action_url = $('#form_model3 #action-url').val();
    $("#pop_model3").modal('hide');
    saveMData(o_data, action_url);
});

function saveMData(o_data, action_url) {
    var errorNum = farmCheck();
    if (errorNum > 0) {
        $("#notify").removeClass("alert-success").addClass("alert-danger").fadeIn();
        $("#notify .message").html("<strong>Error</strong>");
        $("html, body").animate({scrollTop: $('#notify').offset().top}, 1000);
    } else {
        jQuery.ajax({
            url: baseurl + action_url,
            type: 'POST',
            data: o_data + '&' + crsf_token + '=' + crsf_hash,
            dataType: 'json',
            success: function (data) {
                if (data.status == "Success") {
                    $("#notify .message").html("<strong>" + data.status + "</strong>: " + data.message);
                    $("#notify").removeClass("alert-danger").addClass("alert-success").fadeIn();
                    $("html, body").scrollTop($("body").offset().top);
                    $('#pstatus').html(data.pstatus);
                } else {
                    $("#notify .message").html("<strong>" + data.status + "</strong>: " + data.message);
                    $("#notify").removeClass("alert-success").addClass("alert-danger").fadeIn();
                    $("html, body").scrollTop($("body").offset().top);
                }
            },
            error: function (data) {
                $("#notify .message").html("<strong>" + data.status + "</strong>: " + data.message);
                $("#notify").removeClass("alert-success").addClass("alert-danger").fadeIn();
                $("html, body").scrollTop($("body").offset().top);
            }
        });
    }
}

function miniDash() {
    var actionurl = $('#dashurl').val();
    var d_csrf = crsf_token + '=' + crsf_hash;
    $.ajax({
        url: baseurl + actionurl,
        type: 'POST',
        dataType: 'json',
        data: d_csrf,
        success: function (data) {
            var i = 0;
            //  var obj = jQuery.parseJSON(data);
            $.each(data, function (key, value) {
                for (ind in value) {
                    $('#dash_' + i).text(value[ind]);
                    i++;
                }
            });
        }
    });
}

//universal list item delete from table

$(document).on('click', ".delete-custom", function (e) {
    e.preventDefault();
    var did = $(this).attr('data-did');
    $('#object-id_' + did).val($(this).attr('data-object-id'));
    // $(this).closest('section').attr('id','d_'+$(this).attr('data-object-id'));
    $(this).closest("*[data-block]").attr('id', 'd_' + $(this).attr('data-object-id'));

    $('#delete_model_' + did).modal({backdrop: 'static', keyboard: false});
    // $("#notify .message")
    $('#delete_model_' + did + ' .delete-confirm').attr('data-mid', did);
});

$(".delete-confirm").on("click", function () {
    var did = $(this).attr('data-mid');
    var o_data = $('#mform_' + did).serialize();
    var action_url = $('#action-url_' + did).val();
    $('#d_' + $('#object-id_' + did).val()).remove();
    removeObject_c(o_data, action_url);
});

function removeObject_c(action, action_url) {

    jQuery.ajax({
        url: baseurl + action_url,
        type: 'POST',
        data: action + '&' + crsf_token + '=' + crsf_hash,
        dataType: 'json',
        success: function (data) {
            if (data.status == "Success") {
                $("#notify .message").html("<strong>" + data.status + "</strong>: " + data.message);
                $("#notify").removeClass("alert-danger").addClass("alert-success").fadeIn();
                $("html, body").scrollTop($("body").offset().top);
            } else {
                $("#notify .message").html("<strong>" + data.status + "</strong>: " + data.message);
                $("#notify").removeClass("alert-success").addClass("alert-danger").fadeIn();
                $("html, body").scrollTop($("body").offset().top);
            }
        },
        error: function (data) {
            $("#notify .message").html("<strong>" + data.status + "</strong>: " + data.message);
            $("#notify").removeClass("alert-success").addClass("alert-warning").fadeIn();
            $("html, body").scrollTop($("body").offset().top);
        }
    });

}

$("#copy_address").change(function () {
    if ($(this).prop("checked") == true) {
        // alert("Checkbox is checked." );
        $('#mcustomer_name_s').val($('#mcustomer_name').val());
        $('#mcustomer_phone_s').val($('#mcustomer_phone').val());
        $('#mcustomer_email_s').val($('#mcustomer_email').val());
        $('#mcustomer_address1_s').val($('#mcustomer_address1').val());
        $('#mcustomer_city_s').val($('#mcustomer_city').val());
        $('#region_s').val($('#region').val());
        $('#mcustomer_country_s').val($('#mcustomer_country').val());
        $('#postbox_s').val($('#postbox').val());
    } else {
        $('#mcustomer_name_s').val('');
        $('#mcustomer_phone_s').val('');
        $('#mcustomer_email_s').val('');
        $('#mcustomer_address1_s').val('');
        $('#mcustomer_city_s').val('');
        $('#region_s').val('');
        $('#mcustomer_country_s').val('');
        $('#postbox_s').val('');
    }
});

$(document).on('click', ".apply_coupon", function (e) {
    e.preventDefault();
    var actionurl = 'pos_invoices/set_coupon';
    var coupon = $('#coupon').val();

    $.ajax({

        url: baseurl + actionurl,
        type: 'POST',
        data: 'coupon=' + coupon + '&' + crsf_token + '=' + crsf_hash,
        dataType: 'json',
        success: function (data) {
            $('#r_coupon').html(data.message);
            if (data.status == 'Success') $('#i_coupon').val(data.message);
            $('#coupon_amount').val(accounting.unformat(data.amount, accounting.settings.number.decimal));
            billUpyog();
        }

    });

});
