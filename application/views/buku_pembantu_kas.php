<html>

<body>
    <div class="x_panel">
        <div class="x_content">
            <form action="<?= base_url('Laporan/buku_pembantu_kas')?>" method="post">
                <div class="form-group row">
                    <label for="periode" class="col-sm-2 col-form-label">Periode</label>
                    <div class="col-sm-2">
                        <input type="month" class="form-control" id="periode" name="periode">
                    </div>
                    <div class="col-sm-2">
                       <button class="btn btn-primary" type="submit">Filter</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <div class="x_panel">
        <div class="x_title">
            <h3 class="panel-title"><b>Buku Pembantu Kas</b></h3>
        </div>

        <div class="x_content">
            <div class="row">
                <div class="col-sm-7">

                </div>
            </div>
            <center>
            <h3>KPSBU - Buku Pembantu Kas</h3>
            <h4>Periode - <?= $periode ?></h4>

            <center>
            <hr>
            <table class="table table-striped table-bordered table-hover jambo_table">
                <thead>
                    <tr>
                        <th rowspan="2" class="text-center">#</th>
                        <th rowspan="2" class="text-center">Tanggal</th>
                        <th rowspan="2" class="text-center">ID Ref</th>
                        <th rowspan="2" class="text-center">Keterangan</th>
                        <th colspan="2" class="text-center">Mutasi</th>
                        <th rowspan="2" class="text-center">Saldo</th>
                    </tr>
                    <tr>
                        <th class="text-center">Debit</th>
                        <th class="text-center">Kredit</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    $saldo = 0;
                    $no = 1;
                    foreach ($list as $key => $value) { ?>
                    <tr>
                        <td><?= $no++ ?></td>
                        <td><?= $value->tanggal ?></td>
                        <td><?= $value->id_ref ?></td>
                        <td><?= $value->keterangan ?></td>

                        <?php if ($value->posisi_dr_cr == 'd') { ?>
                            <?php $saldo += $value->nominal ?>
                            <td class="text-right"><?= format_rp($value->nominal)?></td>
                            <td></td>
                        <?php } else { ?>
                            <?php $saldo -= $value->nominal ?>
                            <td></td>
                            <td class="text-right"><?= format_rp($value->nominal)?></td>
                        <?php } ?>
                        
                        <!-- saldo -->
                        <td class="text-right"><?= format_rp($saldo) ?></td>
                    </tr>
                    
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</body>

</html>