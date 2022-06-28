<div class="row">
    <div class="col-sm-12">
        <div class="x_panel">
            <div class="x_content">
                <form>
                    <div class="form-group row">
                        <label for="periode" class="col-sm-2 col-form-label">Periode</label>
                        <div class="col-sm-2">
                            <input type="month" class="form-control" id="periode" name="periode">
                        </div>
                        <div class="col-sm-2">
                        <?php 
                        $filterdate = '2022-06-21';
                        $date = date('Y-m-d');
                        if ($date == $filterdate) { ?>
                            <button class="btn btn-primary filter" type="button">Filter</button>
                        <?php } ?>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div class="x_panel" id="myDiv">
            <div class="x_content">
                <div id="notif" class="mb-20">
                    <p>
                        <strong>
                            Note : <br>
                        </strong>
                            <i>
                                Pengajuan jurnal dilakukan setiap akhir bulan (29 Desember). Nominal yang dijurnal merupakan akumulasi dari seluruh pegawai.
                            </i>
                    </p>
                </div>
                <hr>
                <h4>
                    <p id="header">
                        <i></i>
                    </p>
                </h4>
                <br>
                <form action="<?= base_url('Penggajian/saveJurnalGaji')?>" method="post" id="myform">
                    <input type="hidden" name="tgl" id="tgl">
                    <div class="form-group row">
                        <label for="" class="col-sm-2">Kode</label>
                        <div class="col-sm-3">
                            <input type="text" readonly class="form-control" name="kode" value="<?= $kode ?>">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="" class="col-sm-2">Total Gaji Pokok</label>
                        <div class="col-sm-3">
                            <input type="text" readonly class="form-control" name="t_gaji_pokok" id="t_gaji_pokok">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="" class="col-sm-2">Total Tunjangan Kesehatan</label>
                        <div class="col-sm-3">
                            <input type="text" readonly class="form-control" name="t_tunjangan_kesehatan" id="t_tunjangan_kesehatan">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="" class="col-sm-2">Total Tunjangan Jabatan</label>
                        <div class="col-sm-3">
                            <input type="text" readonly class="form-control" name="t_tunjangan_jabatan" id="t_tunjangan_jabatan">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="" class="col-sm-2">Total Bonus</label>
                        <div class="col-sm-3">
                            <input type="text" readonly class="form-control" name="t_bonus" id="t_bonus">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="" class="col-sm-2">Total Utang PPH21</label>
                        <div class="col-sm-3">
                            <input type="text" readonly class="form-control" name="t_ptkp" id="t_ptkp">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="" class="col-sm-2">Total Kas</label>
                        <div class="col-sm-3">
                            <input type="text" readonly class="form-control" name="t_kas" id="t_kas">
                        </div>
                    </div>
                    <hr>
                    <div class="form-group row">
                        <label for="" class="col-sm-2">Total Pendapatan</label>
                        <div class="col-sm-3">
                            <input type="text" readonly class="form-control" name="t_pendapatan" id="t_pendapatan">
                        </div>
                    </div>
                    <br>
                    <div class="form-group row">
                        <label for="" class="col-sm-2"></label>
                        <div class="col-sm-3">
                            <button class="btn btn-primary proses">Proses</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <div class="x_panel" id="myDiv2" style="display: none;">
            <div class="x_content">
                <div id="notif" class="mb-20">
                    <p>
                        <strong>
                            Note : <br>
                        </strong>
                        <i>
                            Pengajuan jurnal penggajian dengan periode yang dipilih masih dalam proses/sudah selesai diproses. Silahkan pilih periode yang lainnya.
                        </i>
                    </p>
                </div>
            </div>
        </div>

        <div id="myDiv3">

        </div>
    </div>
</div>
<script>
    function dateFormat(dateObject) {
        var d = new Date(dateObject);
        var day = d.getDate();
        var month = d.getMonth() + 1;
        var year = d.getFullYear();
        if (day < 10) {
            day = "0" + day;
        }
        if (month < 10) {
            month = "0" + month;
        }
        var date = year + '-' + month;

        return date;
    };
    
    function getList(periode) {
        // var periode = $("#periode").val();
        let html = 'Berikut merupakan akumulasi jurnal penggajian periode ' + periode;
        $("#header").html(html);
        $("#myDiv").show();
        $.ajax({
            url : "<?= base_url('Penggajian/getTotalNominal')?>",
            method : "post",
            type : "json",
            data : {
                periode : periode
            },
            success:function(e) {
                var obj = JSON.parse(e);
                var t_gaji_pokok = (obj.t_gaji_pokok === null) ? 0 : obj.t_gaji_pokok;
                var t_tunjangan_kesehatan = (obj.t_tunjangan_kesehatan === null) ? 0 : obj.t_tunjangan_kesehatan;
                var t_tunjangan_jabatan = (obj.t_tunjangan_jabatan === null) ? 0 : obj.t_tunjangan_jabatan;
                var t_bonus = (obj.t_bonus === null) ? 0 : obj.t_bonus;
                var t_ptkp = (obj.t_ptkp === null) ? 0 : obj.t_ptkp;
                var t_kas = (obj.t_kas === null) ? 0 : obj.t_kas;
                var t_pendapatan = (obj.t_pendapatan === null) ? 0 : obj.t_pendapatan;
                if (
                    t_gaji_pokok 
                    ,t_tunjangan_kesehatan
                    ,t_tunjangan_jabatan
                    ,t_bonus
                    ,t_ptkp
                    ,t_kas 
                    ,t_pendapatan
                    == 0
                ) {
                    $(".proses").prop('disabled', true);
                } else {
                    $(".proses").prop('disabled', false);
                }
                $("#t_gaji_pokok").val(t_gaji_pokok);
                $("#t_tunjangan_kesehatan").val(t_tunjangan_kesehatan);
                $("#t_tunjangan_jabatan").val(t_tunjangan_jabatan);
                $("#t_bonus").val(t_bonus);
                $("#t_ptkp").val(t_ptkp);
                $("#t_kas").val(t_kas);
                $("#t_pendapatan").val(t_pendapatan);
            }
        });
    }

    function cekJurnal(value) {
        var dt = dateFormat(value)
        $.ajax({
            url : "<?= base_url('Penggajian/cekPengajuanJurnal')?>",
            method : "post",
            type : "json",
            data : {
                periode : dt
            },
            success:function(e) {
                var obj = JSON.parse(e);
                console.log(obj)
                if (obj) {
                    var tanggal = dateFormat(obj.tanggal);
                    if (tanggal) {
                        $("#myDiv").hide();
                        $("#myDiv2").show();
                    }
                } else {
                    $("#myDiv").show();
                    $("#myDiv2").hide();
                }
            }
        });
    }

    $(document).ready(function() {
        $("#myDiv").hide();
        $("#myDiv2").hide();

        $(".filter").on("click", function() {
            let value = $("#periode").val();
            $("#tgl").val(value)
            if (value) {
                getList(value);
                cekJurnal(value);
            } else {
                $("#periode").prop('required', true);
            }
        });
    });
</script>