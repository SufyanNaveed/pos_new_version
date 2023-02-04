<?php
require 'vendor/autoload.php';

// This will output the barcode as HTML output to display in the browser
$generator = new Picqer\Barcode\BarcodeGeneratorHTML();
?>
<!DOCTYPE html>
<html lang="en">
 <head>
  <meta charset="UTF-8">
  <meta name="Generator" content="EditPlus®">
  <meta name="Author" content="">
  <meta name="Keywords" content="">
  <meta name="Description" content="">
  <title>Document</title><style> 
  body
{
  margin: 0mm; sheet-size: 38px 24mm;size: 38mm 24mm;
}
  
  @page {
            margin: 0;
            size: 38mm 25mm;
			sheet-size: 38mm 24mm;
        }
    </style>
 </head>
 <body>
 <div >
  <?php
//echo $generator->getBarcode('978020137962', $generator::TYPE_EAN_13);
$generator = new Picqer\Barcode\BarcodeGeneratorPNG();
echo '<div id="" style="width:38mm;height:25mm;text-align:center;">This is title<br>
	<img src="data:image/png;base64,' . base64_encode($generator->getBarcode('3443', $generator::TYPE_EAN_13)) . '" style="width:36mm;height:10mm;"><div style="font-size:8pt;">
		This is code<br>This is warehouse<br>This is price
	</div>
</div>';
?></div>
 </body>
</html>
