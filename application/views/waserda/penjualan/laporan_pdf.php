<!-- <link href="<?php echo base_url(); ?>assets/vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet"> -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css">
<style>
    * {
        font-size : 5pt;
    }

    table {
        margin-left:auto;margin-right:auto;
    }

    #img {
        background-image: url('brandlogo.jpg');
    }
</style>
<center>
<div id="img"></div>
<p>Waserda KPSBU</p>
<p>Jl. Kayu Ambon Dalam No. 5, Lembang. Kec. Lembang. Kab. Bandung Barat.</p>
<br>
<p><strong>Invoice </strong> : <?= $detail[0]->invoice?></p>
<p><strong>Date payment </strong> : <?= $penjualan->date_payment?></p>
<p><strong>Pembeli </strong> : <?= $penjualan->nama_pembeli?></p>
<br>
</center>
<table class="table">
    <tr>
        <th>no</th>
        <th>item</th>
        <th>qty</th>
        <th>subtotal</th>
    </tr>
    <?php 
    $no =1;
    $subtotal = 0;
    foreach ($detail as $value) { ?>
    <?php $subtotal = $value->jml * $value->harga ?> 
    <tr>
        <td><?= $no++ ?></td>
        <td><?= $value->nama_produk ?></td>
        <td><?= $value->jml.' '.'@'.$value->harga ?></td>
        <td><?= format_rp($subtotal) ?></td>
    </tr>
    <?php } ?>
</table>
<center>
======================================
<p><strong>Penjualan</strong> : <?= format_rp($penjualan->total_trans) ?></p>
<p><strong>PPN (10%)</strong> : <?= format_rp($penjualan->ppn) ?></p>
======================================
<p><strong>Pembayaran</strong> : <?= format_rp($penjualan->pembayaran) ?></p>
<p><strong>Total</strong> : <?= format_rp($penjualan->total) ?></p>
<p><strong>Kembalian</strong> : <?= format_rp($penjualan->kembalian) ?></p>
<br>
<p>Terimakasih :) </p>
</center>
