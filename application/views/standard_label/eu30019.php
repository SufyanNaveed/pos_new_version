<html>

<head>
    <title>EU30019</title>
    <style>


        /* Page Definitions */
        @page WordSection1 {
            size: 595.3pt 841.9pt;
            margin: 30.35pt 13.35pt 0in 13.35pt;
        }

        div.WordSection1 {
            page: WordSection1;
        }

        table {
            width: 568.4pt;
            border-collapse: collapse;
            border: none;
            padding: 0;
        }

        tr {
            height: 60.1pt;
        }

        .label_box {
            width: 1.4in;

            padding: 4mm;

            height: 71.33pt;

         /*   border: 1px solid;*/
            text-align: center;
            font-size: 8pt
        }


        .space_box {
            width: 7.1pt;
            padding: 0;
            height: 60.1pt;
        }
    </style>

</head>

<body>

<div class='WordSection1'>

    <div align='center'>

        <table>

            <?php foreach ($products as $lab) {
                for ($i = 0; $i < 13; $i++) {
                    $style['bar_height'] = 0.3;

                    ?>
                    <tr>
                        <td class='label_box'>
                            <div class="bar">
                                <p><?= $lab['product_name'] ?></p>
                                <barcode code="<?= $lab['barcode'] ?>" type="<?= $lab['code_type'] ?>"
                                         height="<?= $style['bar_height'] ?>"></barcode>
                                <?php if ($style['product_code']) echo '<p>' . $lab['product_code'] . '</p>'; ?>
                                <?php if ($style['product_price']) echo '<p>' . amountExchange($lab['product_price'], 0, $this->aauth->get_user()->loc) . '</p>'; ?>
                            </div>
                        </td>
                        <td class='space_box'>
                            <p>&nbsp;</p>
                        </td>
                        <td class='label_box'>

                            <p><?= $lab['product_name'] ?></p>
                            <barcode code="<?= $lab['barcode'] ?>" type="<?= $lab['code_type'] ?>"
                                     height="<?= $style['bar_height'] ?>"></barcode>
                            <?php if ($style['product_code']) echo '<p>' . $lab['product_code'] . '</p>'; ?>
                            <?php if ($style['product_price']) echo '<p>' . amountExchange($lab['product_price'], 0, $this->aauth->get_user()->loc) . '</p>'; ?>
                        </td>
                        <td class='space_box'>
                            <p>&nbsp;</p>
                        </td>
                        <td class='label_box'>

                            <p><?= $lab['product_name'] ?></p>
                            <barcode code="<?= $lab['barcode'] ?>" type="<?= $lab['code_type'] ?>"
                                     height="<?= $style['bar_height'] ?>"></barcode>
                            <?php if ($style['product_code']) echo '<p>' . $lab['product_code'] . '</p>'; ?>
                            <?php if ($style['product_price']) echo '<p>' . amountExchange($lab['product_price'], 0, $this->aauth->get_user()->loc) . '</p>'; ?>
                        </td>
                        <td class='space_box'>
                            <p>&nbsp;</p>
                        </td>
                        <td class='label_box'>

                            <p><?= $lab['product_name'] ?></p>
                            <barcode code="<?= $lab['barcode'] ?>" type="<?= $lab['code_type'] ?>"
                                     height="<?= $style['bar_height'] ?>"></barcode>
                            <?php if ($style['product_code']) echo '<p>' . $lab['product_code'] . '</p>'; ?>
                            <?php if ($style['product_price']) echo '<p>' . amountExchange($lab['product_price'], 0, $this->aauth->get_user()->loc) . '</p>'; ?>
                        </td>
                        <td class='space_box'>
                            <p>&nbsp;</p>
                        </td>
                        <td class='label_box'>

                            <p><?= $lab['product_name'] ?></p>
                            <barcode code="<?= $lab['barcode'] ?>" type="<?= $lab['code_type'] ?>"
                                     height="<?= $style['bar_height'] ?>"></barcode>
                            <?php if ($style['product_code']) echo '<p>' . $lab['product_code'] . '</p>'; ?>
                            <?php if ($style['product_price']) echo '<p>' . amountExchange($lab['product_price'], 0, $this->aauth->get_user()->loc) . '</p>'; ?>
                        </td>
                    </tr>
                <?php }
            } ?>
        </table>

    </div>

    <p class=MsoNormal style='margin-top:0in;margin-right:4.5pt;margin-bottom:8.0pt;
margin-left:4.5pt'><span lang=EN-GB style='display:none'>&nbsp;</span></p>

</div>

</body>

</html>
