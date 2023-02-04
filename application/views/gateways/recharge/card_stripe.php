<link rel="stylesheet" type="text/css"
      href="<?= assets_url() ?>assets/css/global.css<?= APPVER ?>">
<link rel="stylesheet" type="text/css"
      href="<?= assets_url() ?>assets/css/normalize.css<?= APPVER ?>">

<?php
$rming = $amount;

$surcharge_t = false;

$row = $gateway;

$cid = $row['id'];
$title = $row['name'];
if ($row['surcharge'] > 0) {
    $surcharge_t = true;
    $fee = '( ' . amountExchange($rming, $invoice['multi'], $invoice['loc']) . '+' . amountFormat_s($row['surcharge']) . ' %)';
} else {
    $fee = '';


}
?>

<script type="text/javascript" src="https://js.stripe.com/v3/"></script>
<div class="app-content content container-fluid">
    <div class="content-wrapper">
        <div id="notify" class="alert alert-success" style="display:none;">
            <a href="#" class="close" data-dismiss="alert">&times;</a>

            <div class="message"></div>
        </div>
        <section class="card">
            <div class="card-header">
                <h4 class="card-title"><?php echo $this->lang->line('Secure Checkout Page') ?></h4>
            </div>
            <div class="card-body m-2">
                <div class="row">

                    <div class="col-md-6"><span class="display-block text-xs-center"><img class="bg-white round "
                                                                                          style="max-width:30rem;max-height:10rem"
                                                                                          src="<?= base_url('assets/gateway_logo/' . $gid . '.png') ?>"></span>
                        <div class="form-group">
                            <label for="cardNumber"> <?php echo $this->lang->line('Total Amount') ?>
                                <input name="total_amount"
                                       value="<?php echo amountExchange($amount) ?>"
                                       type="text"
                                       class="form-control"


                                       readonly/></label>

                        </div>
                    </div>

                    <div id="p_form" class="col-md-6 ">

                              <div class="sr-root">
            <div class="sr-main">
                <form id="payment-form" class="sr-payment-form">
                    <div class="sr-combo-inputs-row">
                        <div class="sr-input sr-card-element" id="card-element"></div>
                    </div>
                    <div class="sr-field-error" id="card-errors" role="alert"></div>
                    <button id="submit">
                        <div class="spinner hidden" id="spinner"></div>
                        <span id="button-text">Pay With
                        Stripe Secure</span><span id="order-amount"></span>
                    </button><p class="mt-1 font-medium-2"><?=$fee?></p>
                </form>
                <div class="sr-result hidden">
                    <p>Payment completed<br/>
                        <?php

                        echo '<a class="btn btn-info btn-block"
                                                    href = "' . base_url('crm/payments/recharge/?') . 'token=t" role = "button" ><i
                                                        class="fa fa-backward" ></i > </a >';
                        ?>
                    </p>
                    <pre>
            <code></code>
          </pre>
                </div>
            </div>
        </div>
                    </div>


                </div>
            </div>
        </section>
        <section class="card">

            <div class="card-body bg-white"><img class="img-responsive pull-right"
                                                 src="<?php echo base_url('assets/images/ssl-seal.png') ?>"></div>
        </section>

    </div>

    <!-- Vendor libraries -->
    <script type="text/javascript">
    // A reference to Stripe.js
    var stripe;

    var orderData = {
        items: [{id: "invoice-payment"}],
        currency: "<?=$row['currency']?>",
        <?=$this->security->get_csrf_token_name(); ?>: '<?=$this->security->get_csrf_hash(); ?>',
        id: '<?=$id?>',
        itype: 'inv',
        gateway: 1,
        amount: '<?php if ($rming > 0) echo numberClean(amountExchange_s($rming, 0, 0)) * 100; else echo '0.00'; ?>',
        token: '<?=$token ?>'
    };

    // Disable the button until we have Stripe set up on the page
    document.querySelector("button").disabled = true;

    fetch("<?=base_url('billing/stripe_api_response') ?>")
        .then(function (result) {
            return result.json();
        })
        .then(function (data) {
            return setupElements(data);
        })
        .then(function ({stripe, card, clientSecret}) {
            document.querySelector("button").disabled = false;

            var form = document.getElementById("payment-form");
            form.addEventListener("submit", function (event) {
                event.preventDefault();
                pay(stripe, card, clientSecret);
            });
        });

    var setupElements = function (data) {
        stripe = Stripe(data.publishableKey);
        /* ------- Set up Stripe Elements to use in checkout form ------- */
        var elements = stripe.elements();
        var style = {
            base: {
                color: "#32325d",
                fontFamily: '"Helvetica Neue", Helvetica, sans-serif',
                fontSmoothing: "antialiased",
                fontSize: "16px",
                "::placeholder": {
                    color: "#aab7c4"
                }
            },
            invalid: {
                color: "#fa755a",
                iconColor: "#fa755a"
            }
        };

        var card = elements.create("card", {style: style});
        card.mount("#card-element");

        return {
            stripe: stripe,
            card: card,
            clientSecret: data.clientSecret
        };
    };

    var handleAction = function (clientSecret) {
        stripe.handleCardAction(clientSecret).then(function (data) {
            if (data.error) {
                showError("Your card was not authenticated, please try again");
            } else if (data.paymentIntent.status === "requires_confirmation") {

                var verifyData = {
                    items: [{id: "invoice-payment"}],
                    currency: "<?=$row['currency']?>",
                    <?=$this->security->get_csrf_token_name(); ?>: '<?=$this->security->get_csrf_hash(); ?>',
                    id: '<?=$id?>',
                    itype: 'inv',
                    gateway: 1,
                    amount: '<?php if ($rming > 0) echo numberClean(amountExchange_s($rming,0, 0)) * 100; else echo '0.00'; ?>',
                    token: '<?=$token ?>',
                    paymentIntentId: data.paymentIntent.id
                };

                jQuery.ajax({
                    url: '<?php echo base_url('billing/process_recharge') ?>',
                    type: 'POST',
                    dataType: 'json',
                    data: verifyData,
                    success: function (data) {
                        if (data.error) {
                            showError(data.error);
                        } else {
                            orderComplete(clientSecret);
                        }
                    },
                    error: function (data) {

                    }

                });



            }
        });
    };

    /*
     * Collect card details and pay for the order
     */
    var pay = function (stripe, card) {
        changeLoadingState(true);

        // Collects card details and creates a PaymentMethod
        stripe
            .createPaymentMethod("card", card)
            .then(function (result) {
                if (result.error) {
                    showError(result.error.message);
                } else {
                    orderData.paymentMethodId = result.paymentMethod.id;
                    return jQuery.ajax({
                        url: '<?php echo base_url('billing/process_recharge') ?>',
                        type: 'POST',
                        dataType: 'json',
                        data: orderData,
                        success: function (data) {
                            if (data.error) {
                                showError(data.error);
                            } else if (data.requiresAction) {
                                // Request authentication
                                handleAction(data.clientSecret);
                            } else {
                                orderComplete(data.clientSecret);
                            }
                        },
                        error: function (data) {
                            showError(data.error);
                        }

                    });

                }
            });
    };

    /* ------- Post-payment helpers ------- */

    /* Shows a success / error message when the payment is complete */
    var orderComplete = function (clientSecret) {
        if(clientSecret) {
            stripe.retrievePaymentIntent(clientSecret).then(function (result) {
                var paymentIntent = result.paymentIntent;
                var paymentIntentJson = JSON.stringify(paymentIntent, null, 2);

                document.querySelector(".sr-payment-form").classList.add("hidden");
                // document.querySelector("pre").textContent = paymentIntentJson;

                document.querySelector(".sr-result").classList.remove("hidden");
                setTimeout(function () {
                    document.querySelector(".sr-result").classList.add("expand");
                }, 200);

                changeLoadingState(false);
            });
        } else {
              document.querySelector(".sr-payment-form").classList.add("hidden");
                // document.querySelector("pre").textContent = paymentIntentJson;

                document.querySelector(".sr-result").classList.remove("hidden");
                setTimeout(function () {
                    document.querySelector(".sr-result").classList.add("expand");
                }, 200);
        }
    };

    var showError = function (errorMsgText) {
        changeLoadingState(false);
        var errorMsg = document.querySelector(".sr-field-error");
        errorMsg.textContent = errorMsgText;
        setTimeout(function () {
            errorMsg.textContent = "";
        }, 4000);
    };

    // Show a spinner on payment submission
    var changeLoadingState = function (isLoading) {
        if (isLoading) {
            document.querySelector("button").disabled = true;
            document.querySelector("#spinner").classList.remove("hidden");
            document.querySelector("#button-text").classList.add("hidden");
        } else {
            document.querySelector("button").disabled = false;
            document.querySelector("#spinner").classList.add("hidden");
            document.querySelector("#button-text").classList.remove("hidden");
        }
    };

</script>
