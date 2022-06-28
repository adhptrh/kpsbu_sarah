<!-- <link href="<?php echo base_url(); ?>assets/vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet"> -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css">
<style>
    * {
        font-size : 5pt;
    }
</style>
<center>
<p>Waserda KPSBU</p>
<p>Jl. Kayu Ambon Dalam No. 5, Lembang. Kec. Lembang. Kab. Bandung Barat.</p>
<br>
<p><strong>Invoice </strong> : <?= $detail[0]->invoice?></p>
<p><strong>Date payment </strong> : <?= $detail[0]->tanggal?></p>
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
    $no = 1;
    foreach ($detail as $value) { ?>
    <?php $subtotal = $value->jml * $value->harga_satuan ?>
    <tr>
        <td><?= $no++ ?></td>
        <td><?= $value->nama_produk?></td>
        <td><?= $value->jml.' '.'@'.$value->harga_satuan ?></td>
        <td><?= format_rp($subtotal)?></td>
    </tr>
    <?php } ?>
</table>
<center>
======================================
<p><strong>Pembelian</strong> : <?= format_rp($detail[0]->total) ?></p>
<p><strong>PPN (10%)</strong> : <?= format_rp($detail[0]->ppn) ?></p>
<p><strong>Grand Total</strong> : <?= format_rp($detail[0]->grandtotal) ?></p>
======================================
<br>
<p>Terimakasih :) </p>
</center>
