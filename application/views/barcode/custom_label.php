
<!DOCTYPE html>
<html lang="en">
 <head>
  <meta charset="UTF-8">
  <meta name="Generator" content="EditPlus®">
  <meta name="Author" content="">
  <meta name="Keywords" content="">
  <meta name="Description" content="">
  <title>Labels</title><style>
  body
{
  margin: 0; size: <?= $style['width'] ?>mm <?= $style['height'] ?>mm;
      font-size: <?= $style['font_size'] ?>pt;
}

  @page {
            margin: 0;
            size: <?= $style['width'] ?>mm <?= $style['height']+1 ?>mm;
        }
    </style>

 </head>
 <body onload="print();">
 <div >
  <?php

$generator = new Picqer\Barcode\BarcodeGeneratorPNG();

switch ($style['b_type']){
    case 1:
        $t=$generator::TYPE_EAN_13;
        break;
          case 2:
        $t=$generator::TYPE_CODE_128;
        break;
          case 3:
        $t=$generator::TYPE_CODE_39;
        break;
          case 4:
        $t=$generator::TYPE_EAN_5;
        break;
          case 5:
        $t=$generator::TYPE_EAN_8;
        break;
          case 6:
        $t=$generator::TYPE_UPC_A;
        break;
          case 7:
        $t=$generator::TYPE_UPC_E;
        break;
}


foreach ($products as $lab) {
     for ($i = 0; $i <= $style['total_rows']; $i++) {
         for ($z = 0; $z <= $style['items_per_row']; $z++) {
             echo '<div style=" margin: 0;width:'.$style['label_width'].'mm;height:'.$style['label_height'].'mm;text-align:center;display: inline-block">';
             if ($style['product_name'])  echo substr($lab['product_name'],0,$style['max_char']);
             	if ($style['product_code']) echo  '<br>'.$lab['product_code'] ;
	echo'<br><img src="data:image/png;base64,' . base64_encode($generator->getBarcode($lab['barcode'] , $t)) . '" style=" margin: 0;width:'.$style['bar_width'].'mm;height:'.$style['bar_height'].'mm;"><br>';
 echo  $lab['barcode'].'<br>' ;
 if ($style['product_price']) echo '<strong>'.amountExchange($lab['product_price'], 0, $this->aauth->get_user()->loc) . ' </strong><br>';
   if ($style['store_name']) echo  substr($style['store'],0,$style['max_char']).'<br>' ;
  if ($style['warehouse_name']) echo    substr($style['warehouse'],0,$style['max_char']);
if($lab['expiry']) echo '<br>'.$this->lang->line('Expiry Date') . ' ' . dateformat($lab['expiry']) ;
	echo'</div>';
         }
     }
}
?></div>
 </body>
</html>
