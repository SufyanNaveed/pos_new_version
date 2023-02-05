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
<table cellpadding="20">

    <tr>
        <td>
            <h1><?= $name ?><br><br></h1>
            <barcode type="<?= $ctype ?>" code="<?= $code ?>" text="1" class="barcode" height=".4" size="5">
            </barcode><br></td>


    </tr>
</table>
</body>
</html>