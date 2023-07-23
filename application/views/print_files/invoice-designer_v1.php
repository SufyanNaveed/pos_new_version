<style>
    table {
  border-collapse: collapse;
}
/* .panel-body{
    border: 1px solid #000;
 } */
#printableArea{
    padding: 15px !important;
}
.panel-body {
    padding: 0px;
}
hr{
    border: 1px solid #909194;
    margin: 0px !important;
}
th, td {
  padding: 15px; 
}
.top_class{
    /* border: 1px solid #8e8e8e; */
    margin-right: 9px;

}
.padding_class{
    padding:0px;
}
.heading_area{
    background: #d8f3d8;
    padding: 10px 0px 10px 9px;
    font-size: 15px;
    font-weight: 700;
    color: #2b2b97;
    width:50%;
    border-right: 1px solid #8e8e8e;
    border-bottom: 1px solid #cac5c5;
}

.heading_area_right{
    background: #d8f3d8;
    padding: 6px 0px 6px 9px;
    font-size: 14px;
    font-weight: 700;
    color: #2b2b97;
    /* border-right: 1px solid #8e8e8e; */
    border-bottom: 1px solid #cac5c5;
}

.content_area{ 
    padding: 10px 0px 10px 9px;
    font-size: 15px;
    font-weight: 700;
    color: #3d3b3b;
    border-bottom: 1px solid #cac5c5;
}

.content_area_right{ 
    padding: 6px 0px 6px 9px;
    font-size: 14px;
    font-weight: 700;
    color: #3d3b3b;
    border-bottom: 1px solid #cac5c5;
}

.col-sm-6 {
    width: 49.6%;
}

.div_contact{
    font-size: 42px !important;
    /* color: #2b2b97; */
    /* transform: scale(1.5, 1); */
    /* margin-left: 80px; */
    /* display: inline-block; */
}

.div_contact_right{
    font-size: 100% !important;
    color: #2b2b97;
    /* transform: scale(1.5, 1); */
    /* margin-left: -42px; */
    /* display: inline-block; */
    text-align: right;
}
.logo_img{ 
    /* width:100%;  */
    /* height:100%; */
}
 
@media print {
    .padding_class{
        padding:0px;
    }
    .col-sm-6 {
        width: 45%;
    }

    .logo_img{ 
        width:unset; 
        height:1%;"
        margin-left:0px;
    }

    .div_contact{
        font-size: 8px;
        color: #2b2b97; 
        margin-left: 35px; 
    }
    .div_contact_right{
        font-size: 8px;
        color: #2b2b97; 
        margin-right: 40px; 
    }
}
</style>
<!-- Printable area end -->
<!-- <div class="row">
            <div class="col-sm-12">
                <div class="panel panel-bd">
                    <div id="printableArea" onload="printDiv('printableArea')">
                        <div class="panel-body">
                            <div class="row" > -->
                                <!-- <div class="table-responsive">
                                    <table class="table" style="border-collapse: collapse;">
                                        <tr>
                                            <td width = "35%" class="div_contact">
                                                     <img id="image" src="<?php $loc = location($invoice['loc']);  echo base_url().'userfiles/company/' . $loc['logo'] ?>" alt="logo" class="img img-responsive"/> 
                                                        Tel: 02-5526604, 02-5526603 <br>
                                                        P.O.BOX. 132623, Abu Dhabi - U.A.E. <br>
                                                        E-mail: nooraltmaman@gmail.com <br>
                                                        Website: www.nooraltmamantrading.com  
                                            </td>
                                            <td width = "30%"></td>
                                            <td width = "35%"  class="div_contact_right">
                                                     <img id="image" src="<?php $loc = location($invoice['loc']);  echo base_url().'userfiles/company/' . $loc['logo'] ?>" alt="logo" class="img img-responsive"/> 
                                                         ٹیلیفون                       ۰۲-٥٥۲٦٦۰۳, ۰۲-٤۰٦٦۲٥٥       <br>
                                                        صندوق بريد. 132623 ، أبو ظبي - الإمارات العربية المتحدة. <br>
                                                        E-mail: nooraltmaman@gmail.com <br>
                                                        Website: www.nooraltmamantrading.com <br>
                                                     
                                            </td> 
                                        </tr>  
                                    </table>
                                </div> -->

                                <div class="table-responsive">
                                    <table class="table" style="margin-bottom:10px;"> 
                                        <tr>
                                            <td width="75%" style="border: 1px solid black; padding: 0">
                                                <table class="table" style="margin-bottom:10px;"> 
                                                    <tr>
                                                        <td class="heading_area"> 
                                                            Customer Code:   
                                                        </td>
                                                        <td class="content_area"> 
                                                            <span class=""><?php echo $invoice['cid'];?> </span> 
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="heading_area"> 
                                                            Customer Name:   
                                                        </td>
                                                        <td class="content_area"> 
                                                            <span class=""><?php echo $invoice['name'];?> </span> 
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="heading_area"> 
                                                            Place/Emirates:   
                                                        </td>
                                                        <td class="content_area"> 
                                                            <span class=""><?php echo $invoice['address'];?> </span> 
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="heading_area_right"> 
                                                             Customer phone:   
                                                        </td>
                                                        <td class="content_area"> 
                                                            <span class=""><?php echo $invoice['phone'];?> </span> 
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="heading_area_right"> 
                                                             Customer TRN:   
                                                        </td>
                                                        <td class="content_area"> 
                                                            <span class=""><?php echo '-';?> </span> 
                                                        </td>
                                                    </tr> 
                                                </table> 
                                            </td>
                                            <td width="75%" style="border: 1px solid black; padding: 0">
                                                <table class="table" style="margin-bottom:10px;"> 
                                                    <tr>
                                                        <td class="heading_area"> 
                                                            Invoice No
                                                        </td>
                                                        <td class="content_area"> 
                                                            <span class=""><?php echo $invoice['iid'];?> </span> 
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="heading_area"> 
                                                            Invoice Date    
                                                        </td>
                                                        <td class="content_area"> 
                                                            <span class=""><?php echo $invoice['invoicedate'];?> </span> 
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="heading_area"> 
                                                            LPO No.   
                                                        </td>
                                                        <td class="content_area"> 
                                                            <span class=""><?php echo 'COUNTER - 025526';?></span> 
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="heading_area_right"> 
                                                            Payment Terms    
                                                        </td>
                                                        <td class="content_area"> 
                                                            <span class=""><?php echo $invoice['pmethod'] ?> </span> 
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="heading_area_right"> 
                                                            Sales Person   
                                                        </td>
                                                        <td class="content_area"> 
                                                            <span class=""><?php echo $employee ? $employee['name'] : '--' ?> </span> 
                                                        </td>
                                                    </tr> 
                                                </table> 
                                            </td> 
                                        </tr>
                                         
                                    </table>
                                </div>
                                <div class="table-responsive">
                                    <table class="table">
                                        <thead>
                                            <tr style="background: #d8f3d8;color: #2b2b97;">
                                                <th class="text-center" style="border: 1px solid black;">Sr.</th>
                                                <th class="text-center" style="border: 1px solid black;">Item Code.</th>
                                                <th width="35%" class="text-center" style="border: 1px solid black;">Description</th> 
                                                <th class="text-center" style="border: 1px solid black;">Qty.</th>
                                                <th class="text-center" style="border: 1px solid black;">Unit.</th> 
                                                <th class="text-center" style="border: 1px solid black;">Unit Price</th>
                                                <th class="text-center" style="border: 1px solid black;">Amount Excl. VAT (AED)</th>
                                                <th class="text-center" style="border: 1px solid black;">VAT%</th>
                                                <th class="text-center" style="border: 1px solid black;">VAT Amount VAT (AED)</th>
                                                <th class="text-center" style="border: 1px solid black;">Amount Incl. VAT (AED)</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $subtotal= $discount = 0;  
                                            if($products) { foreach($products as $key=>$row) {?>
                                            <tr>
                                                <td class="text-center" style="border: 1px solid black;"><?php echo $key+1;?></td>
                                                <td class="text-center" style="border: 1px solid black;"><?php echo $row['code'];?></td>
                                                <td class="text-center" style="border: 1px solid black;"><?php echo $row['product'];?></td>
                                                <td class="text-center" style="border: 1px solid black;"><?php echo $row['qty'];?></td>
                                                <td class="text-center" style="border: 1px solid black;"><?php echo $row['unit'];?></td>
                                                <td class="text-center" style="border: 1px solid black;"><?php echo $row['price'];?></td>
                                                <td class="text-center" style="border: 1px solid black;"><?php echo $row['subtotal'];?></td>
                                                <td class="text-center" style="border: 1px solid black;"><?php echo $row['tax'];?></td>
                                                <td class="text-center" style="border: 1px solid black;"><?php echo $row['totaltax'];?></td>
                                                <td class="text-center" style="border: 1px solid black;"><?php echo $row['subtotal'] + $row['totaltax'];?></td>
                                            </tr>
                                            <?php 
                                                $subtotal += ($row['subtotal'] + $row['totaltax']); 
                                                $discount += $row['totaldiscount']; 

                                                $vattotal= $subtotal * 5/100;
                                        
                                            } } ?>
                                            <tr>
                                                <td style="border: 1px solid black;" height="5px">&nbsp;</td>
                                                <td style="border: 1px solid black;" height="5px"></td>
                                                <td style="border: 1px solid black;" height="5px"></td> 
                                                <td style="border: 1px solid black;" height="5px"></td>
                                                <td style="border: 1px solid black;" height="5px"></td>
                                                <td style="border: 1px solid black;" height="5px"></td>
                                                <td style="border: 1px solid black;" height="5px"></td>
                                                <td style="border: 1px solid black;" height="5px"></td>
                                                <td style="border: 1px solid black;" height="5px"></td>
                                                <td style="border: 1px solid black;" height="5px"></td>
                                            </tr>
                                            <tr>
                                                <td style="border: 1px solid black;" height="5px">&nbsp;</td>
                                                <td style="border: 1px solid black;" height="5px"></td>
                                                <td style="border: 1px solid black;" height="5px"></td> 
                                                <td style="border: 1px solid black;" height="5px"></td>
                                                <td style="border: 1px solid black;" height="5px"></td>
                                                <td style="border: 1px solid black;" height="5px"></td>
                                                <td style="border: 1px solid black;" height="5px"></td>
                                                <td style="border: 1px solid black;" height="5px"></td>
                                                <td style="border: 1px solid black;" height="5px"></td>
                                                <td style="border: 1px solid black;" height="5px"></td>
                                            </tr> 

                                            <tr>
                                                <td class="text-left" colspan="6" style="border: 1px solid black; background: #d8f3d8;color: #2b2b97;"><b>Amount in Words: (AED):(Dhs): <?php echo AmountInWords($subtotal); ?></b></td>
                                                <td class="text-left" colspan="3" style="border: 1px solid black;"><b>Gross Amount (AED)</b></td>
                                                <td class="text-right" style="border: 1px solid black;"><b><?php echo number_format($subtotal,2); ?></b></td>
                                            </tr>

                                            <tr>
                                                <td class="text-left" colspan="6" style="border: 1px solid black;"> <b>Previous Balance: 0.00</b> </td>
                                                <td class="text-left" colspan="3" style="border: 1px solid black; background: #d8f3d8;color: #2b2b97;"><b>Discount</b></td>
                                                <td class="text-right" style="border: 1px solid black;"><b><?php echo $discount; ?></b></td>
                                            </tr>

                                            <tr>
                                                <td class="text-left" colspan="6" rowspan="3" style="border: 1px solid black;">
                                                    <span><b><i>Terms & Conditions:</i></b></span><br>
                                                    <span>1- Goods as above have been received in good condition..</span><br>
                                                    <span>2- Goods return is accepted only if it is in good condition and within seven days from the invoice date.</span><br>
                                                    <span>3- Incase of anycheque return AED 100 will be charged to your account. </span><br>
                                                    <span>4- This is electronic invoice from company pos system, no need stamp and Receiver sign </span><br>
                                                </td>
                                                <td class="text-left" colspan="3" style="border: 1px solid black; background: #d8f3d8;color: #2b2b97;"><b>VAT 5% (AED)</b></td>
                                                <td class="text-right" style="border: 1px solid black;"><b><?php echo number_format($vattotal,2); ?></b></td>
                                            </tr>

                                            <tr>
                                                 <td class="text-left" colspan="3" style="border: 1px solid black; background: #d8f3d8;color: #2b2b97;"><b>Round Off (AED)</b></td>
                                                <td class="text-right" style="border: 1px solid black;"><b><?php echo number_format(round($subtotal + $discount + $vattotal),2); ?></b></td>
                                            </tr>

                                            <tr>
                                                 <td class="text-left" colspan="3" style="border: 1px solid black; background: #d8f3d8;color: #2b2b97;"><b>NET Amount (AED)</b></td>
                                                <td class="text-right" style="border: 1px solid black;"><b><?php echo number_format(round($subtotal + $discount + $vattotal),2); ?></b></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="row" style="margin-right: 0px !important; margin-left:0px !important;">
                                <div class="col-xs-8 invoicefooter-content">
                                    <p></p>
                                    <p><strong>Thank you for shopping with us</strong></p> 
                                </div>
                                </div>
                                 
                    <!-- <div class="panel-footer text-left hidden-print">
                       
                        <button class="btn btn-info" onclick="printDiv('printableArea')"><span class="fa fa-print"></span></button>

                    </div>
                </div>
            </div>                
        </div> -->

<?php 

function AmountInWords(float $amount)
  {
     $amount_after_decimal = round($amount - ($num = floor($amount)), 2) * 100;
     // Check if there is any number after decimal
     $amt_hundred = null;
     $count_length = strlen($num);
     $x = 0;
     $string = array();
     $change_words = array(0 => '', 1 => 'One', 2 => 'Two',
       3 => 'Three', 4 => 'Four', 5 => 'Five', 6 => 'Six',
       7 => 'Seven', 8 => 'Eight', 9 => 'Nine',
       10 => 'Ten', 11 => 'Eleven', 12 => 'Twelve',
       13 => 'Thirteen', 14 => 'Fourteen', 15 => 'Fifteen',
       16 => 'Sixteen', 17 => 'Seventeen', 18 => 'Eighteen',
       19 => 'Nineteen', 20 => 'Twenty', 30 => 'Thirty',
       40 => 'Forty', 50 => 'Fifty', 60 => 'Sixty',
       70 => 'Seventy', 80 => 'Eighty', 90 => 'Ninety');
      $here_digits = array('', 'Hundred','Thousand','Lakh', 'Crore');
      while( $x < $count_length ) {
        $get_divider = ($x == 2) ? 10 : 100;
        $amount = floor($num % $get_divider);
        $num = floor($num / $get_divider);
        $x += $get_divider == 10 ? 1 : 2;
        if ($amount) {
         $add_plural = (($counter = count($string)) && $amount > 9) ? 's' : null;
         $amt_hundred = ($counter == 1 && $string[0]) ? ' and ' : null;
         $string [] = ($amount < 21) ? $change_words[$amount].' '. $here_digits[$counter]. $add_plural.' 
         '.$amt_hundred:$change_words[floor($amount / 10) * 10].' '.$change_words[$amount % 10]. ' 
         '.$here_digits[$counter].$add_plural.' '.$amt_hundred;
          }
     else $string[] = null;
     }
     $implode_to_Rupees = implode('', array_reverse($string));
     $get_paise = ($amount_after_decimal > 0) ? "And " . ($change_words[$amount_after_decimal / 10] . " 
     " . $change_words[$amount_after_decimal % 10]) : '';
     return ($implode_to_Rupees ? $implode_to_Rupees : '') . $get_paise;
  }


?>


