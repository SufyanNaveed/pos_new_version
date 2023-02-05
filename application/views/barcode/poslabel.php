<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title>Print BarCode</title>
    <style>  @page {
            margin: 0 auto;
            sheet-size: 250px 48mm;
        }
        h1{
            font-size:50px !important; 
        }
    </style>
</head>
<body>
<table cellpadding="20" style="width: 100%">

    <tr>
        <td style="border: 1px solid;"><strong>
            <h1><?= $lab['product_name'] ?></strong><br><?= $lab['product_code'] ?></h1>
            <br><br>
            <barcode code="<?= $lab['barcode'] ?>" text="1" class="barcode" height=".4" size="5">
            </barcode><br><br>

            <?php
            if ($lab['expiry']) echo $this->lang->line('Expiry Date') . ' ' . dateformat($lab['expiry']) . '<br><br>';
            ?>
            <h1> 
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                <?= amountExchange($lab['product_price'], 0, $this->aauth->get_user()->loc) ?></h1>
        </td>


    </tr>
</table>
</body>
</html>