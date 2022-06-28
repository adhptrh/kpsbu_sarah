<div class="row">
    <div class="col-sm-12">
        <div class="x_panel">
            <div class="x_title">
                <div class="row">
                    <div class="col-sm-10 col-12">
                        <h4 id="quote">Pengajuan Jurnal</h4>
                    </div>
                    <div class="col-sm-2 col-12">
                        <h3 id="quote">
                            <!-- <a href="#add" data-toggle="modal" class="btn pull-right btn-primary">Tambah</a> -->
                        </h3>
                    </div>
                </div>
            </div>
            <div class="x_content">
                <div id="notif">
                    <?php echo $this->session->flashdata('notif_ubah'); ?>
                </div>
                <div class="table-responsive">
                    <table class="table table-bordered jambo_table" id="datatable">
                        <thead>
                            <tr>
                                <th style="width: 5%;">#</th>
                                <th>Kode</th>
                                <th>Tanggal</th>
                                <th>Nominal</th>
                                <th>Tgl. Approve</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                            $no = 1;
                            foreach ($list as $key => $value) { ?>
                            <tr>
                                <td><?= $no++ ?></td>
                                <td><?= $value->kode ?></td>
                                <td><?= $value->tanggal ?></td>
                                <td><?= format_rp($value->nominal) ?></td>
                                <td><?= ($value->tgl_approve == '') ? '-' : $value->tgl_approve  ?></td>
                                <td>
                                    <?php if ($value->status == 'pending') { ?>
                                        <a href="<?= base_url('c_transaksi/status_pengajuan/'.$value->kode.'/'.$value->tanggal.'/'.$value->nominal)?>" onclick="return confirm('Anda yakin?')" class="btn btn-xs btn-warning"><?= $value->status?></a>
                                    <?php } else { ?>
                                        <a href="#" class="btn btn-xs btn-success"><?= $value->status?></a>
                                    <?php } ?>
                                </td>
                            </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
