<?php
/**
 * @var \App\Model\Entity\Order $orderEntity
 * @var \App\Model\Entity\Transaction $transactionEntity
 */
?>
<div style="padding: 5px 20px; border-top: 1px solid rgba(0,0,0,0.05);">
    <div style="color: #636363; font-size: 12px;">
        <p><strong>Pesanan anda telah <?= $status;?></strong> </p>
        <table  border="0" cellspacing="0" cellpadding="0" style="width:70%;">
            <tr style="margin-top:15px;">
                <td>Invoice</td>
                <td>:<?= $orderEntity->invoice;?></td>
            </tr>
            <tr style="margin-top:15px;">
                <td>Jasa Pengiriman</td>
                <td>:<?= strtoupper($courier);?></td>
            </tr>
            <tr style="margin-top:15px;">
                <td>Nomor AWB</td>
                <td>:<?= strtoupper($awb);?></td>
            </tr>
            <tr style="margin-top:15px;">
                <td>Tanggal Pengiriman</td>
                <td>:<?= $send_date;?></td>
            </tr>
        </table>

        <a href="<?= Cake\Core\Configure::read('frontsite');?>user/history/detail/<?= $orderEntity->invoice;?>" style="padding:8px 20px;background-color:#DF0101;color:#fff;font-weight:bolder;font-size:16px;display:inline-block;margin:20px 0px;text-decoration:none"><?= 'Pantau Pesanan Anda'; ?></a>

        <?php if ($orderEntity->order_type == 1) : ?>
        <?php echo $this->element('Email/Partials/product_detail', ['orderEntity' => $orderEntity, 'transactionEntity' => $transactionEntity]); ?>
        <?php elseif ($orderEntity->order_type == 2) : ?>
        <?php echo $this->element('Email/Partials/digital_detail', ['orderEntity' => $orderEntity, 'transactionEntity' => $transactionEntity]); ?>
        <?php endif; ?>
        <p></p>
    </div>
</div>