<?php foreach ($list as $value) { ?>
    <div class="modal fade" id="detail_<?= $value->kode_shu ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h5 class="modal-title" id="exampleModalLabel">Detail SHU - <b><?= $value->kode_shu?></b></h5>
            </div>
            <form action="<?= base_url('shu/save_transaksi_shu')?>" method="POST">
                <div class="modal-body">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Uraian</th>
                                <th>Persentase</th>
                                <th>Nominal SHU</th>
                                <th>Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                            $no = 1;
                            $y = 0;
                            foreach ($detail_shu as $k=>$item) { 
                                if ($value->kode_shu != $item->kode_shu) continue;
                                if ($y > 3) $y = 0;
                                ?>
                            <tr>
                                <td><?= $no++ ?></td>
                                <td><?= $item->uraian?></td>
                                <td><?= $shu[$y]->persentase ?>%</td>
                                <td><?= format_rp($value->nominal) ?></td>
                                <td><?= format_rp($item->nominal) ?></td>
                            </tr>
                            <?php 
                            $y++;
                        } ?>
                        </tbody>
                    </table> 
                </div>
            </form>
            </div>
        </div>
    </div>
<?php } ?>