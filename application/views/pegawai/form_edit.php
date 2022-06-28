<div class="row">
    <div class="col-sm-12">
        <div class="x_panel">
            <div class="x_title">
                <div class="row">
                    <div class="col-sm-10 col-12">
                        <h4 id="quote">Form Edit Pegawai</h4>
                    </div>
                    <div class="col-sm-2 col-12">
                        <h3 id="quote">
                            <!-- <a href="#add" data-toggle="modal" class="btn pull-right btn-primary">Tambah Data</a> -->
                        </h3>
                    </div>
                </div>
            </div>
            <div class="x_content">
                <form action="<?= base_url('c_masterdata/edit_peg')?>" method="post">
                    <div class="body">
                        <div class="row">
                            <div class="col-sm-6">
                                <input type="hidden" value="<?= $pegawai->id?>" name="id" id="id">
                                <input type="hidden" value="<?= $pegawai->nip?>" name="nip" id="nip">
                                <div class="form-group row">
                                    <label for="nama" class="col-sm-3 col-form-label">Nama Pegawai</label>
                                    <div class="col-sm-7">
                                        <input type="text" name="nama" class="form-control" id="nama" placeholder="Nama Pegawai" value="<?= $pegawai->nama?>" required>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="alamat" class="col-sm-3 col-form-label">Alamat</label>
                                    <div class="col-sm-7">
                                        <textarea name="alamat" id="alamat" cols="10" rows="5" class="form-control" placeholder="Alamat" required><?= htmlspecialchars($pegawai->alamat)?></textarea>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="no_telp" class="col-sm-3 col-form-label">No Telp</label>
                                    <div class="col-sm-7">
                                        <input type="text" name="no_telp" class="form-control" id="no_telp" placeholder="No Telp" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');" value="<?= $pegawai->no_telp?>" required>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="tempat_lahir" class="col-sm-3 col-form-label">Tempat Lahir</label>
                                    <div class="col-sm-7">
                                        <input type="text" name="tempat_lahir" class="form-control" id="tempat_lahir" placeholder="Tempat Lahir" value="<?= $pegawai->tempat_lahir?>" required>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="ttl" class="col-sm-3 col-form-label">Tanggal Lahir</label>
                                    <div class="col-sm-7">
                                        <input type="date" name="ttl" class="form-control" id="ttl" value="<?= $pegawai->tgl_lahir?>" required>
                                    </div>
                                </div>
                            </div>

                            <!-- kanan -->
                            <div class="col-sm-6">
                                <div class="form-group row">
                                <label for="jabatan" class="col-sm-3 col-form-label">Jabatan</label>
                                <div class="col-sm-9">
                                    <select name="jabatan" id="jabatan" class="form-control">
                                        <?php foreach ($jabatan as $key => $value) { ?>
                                        <option value="<?= $value->desc?>"<?= ($pegawai->id_jabatan == $value->desc) ? 'selected' : ''?>><?= $value->desc?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="jp" class="col-sm-3 col-form-label">Jenis Pegawai</label>
                                <div class="col-sm-9">
                                    <select name="jp" id="jp" class="form-control">
                                        <?php foreach ($jp as $key => $value) { ?>
                                        <option value="<?= $value->desc?>"<?= ($pegawai->id_jenis_pegawai == $value->desc) ? 'selected' : '' ?>><?= $value->desc?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="pendidikan" class="col-sm-3 col-form-label">Pendidikan</label>
                                <div class="col-sm-9">
                                    <select name="pendidikan" id="pendidikan" class="form-control">
                                    </select>
                                </div>
                            </div>
                            <div id="hide_ptkp">
                                <div class="form-group row">
                                    <label for="ptkp" class="col-sm-3 col-form-label">PTKP</label>
                                    <div class="col-sm-9">
                                        <select name="ptkp" id="ptkp" class="form-control">
                                            <?php foreach ($ptkp as $key => $value) { ?>
                                            <option value="<?= $value->desc?>"<?= ($pegawai->id_ptkp == $value->desc) ? 'selected' : ''?>><?= $value->desc?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="nama_bank" class="col-sm-3 col-form-label">Bank</label>
                                <div class="col-sm-9">
                                    <select name="nama_bank" id="nama_bank" class="form-control" required>
                                        <option value="">-</option>
                                        <option value="BCA"<?= ($pegawai->nama_bank == 'BCA') ? 'selected' : '' ?>>BCA</option>
                                        <option value="Mandiri"<?= ($pegawai->nama_bank == 'Mandiri') ? 'selected' : '' ?>>Mandiri</option>
                                        <option value="BRI"<?= ($pegawai->nama_bank == 'BRI') ? 'selected' : '' ?>>BRI</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="no_rek" class="col-sm-3 col-form-label">No Rek</label>
                                <div class="col-sm-9">
                                    <input type="text" name="no_rek" class="form-control" id="no_rek" placeholder="No Rekening" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');" value="<?= $pegawai->no_rek?>" required>
                                </div>
                            </div>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <div class="footer" style="margin-top:20px">
                        <a href="<?= base_url('c_masterdata/pegawai')?>" class="btn btn-default">Kembali</a>
                        <button class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script>
    function getPendidikan() {
        var nip = $("#nip").val();
        $.ajax({
            url : "<?= base_url('c_masterdata/getList')?>",
            method : "post",
            data : {
                nip : nip
            },
            success:function(response) {
                var obj = JSON.parse(response);
                console.log(obj.pendidikan)
                $("#pendidikan").val(obj.pendidikan).attr("selected", "selected");
            }
        })
    }
    $(document).ready(function() {
        
        $("#jp").on("change", function() {
            var value = $(this).val();
            if (value == 'Tetap') {
                $("#hide_ptkp").show();
            } else if (value == 'Kontrak') {
                $("#hide_ptkp").hide();
            }
            if (value) {
                $.ajax({
                    url : "<?= base_url('c_masterdata/pendidikan_list')?>", 
                    method : "post",
                    data : {
                        val : value
                    },
                    success : function (e) {
                        var obj = JSON.parse(e)
                        // console.log(value)
                        let row = '';
                        obj.forEach(element => {
                            row += `<option value="${element.pendidikan}">${element.pendidikan}</option>`
                        });
                        $("#pendidikan").html(row)
                    }
                })
            } else {
                var html = '<option value="">-</option>';
                $("#pendidikan").html(html)
            }
        });

        if ($("#jp").val() == 'Kontrak') {
            $("#hide_ptkp").hide();
            $.ajax({
                url : "<?= base_url('c_masterdata/pendidikan_list')?>", 
                method : "post",
                data : {
                    val : $("#jp").val()
                },
                success : function (e) {
                    var obj = JSON.parse(e)
                    // console.log(value)
                    let row = '';
                    obj.forEach(element => {
                        row += `<option value="${element.pendidikan}" selected>${element.pendidikan}</option>`
                    });
                    $("#pendidikan").html(row);
                    getPendidikan();
                }
            });
        } else {
            $("#hide_ptkp").show();
            $.ajax({
                url : "<?= base_url('c_masterdata/pendidikan_list')?>", 
                method : "post",
                data : {
                    val : $("#jp").val()
                },
                success : function (e) {
                    var obj = JSON.parse(e)
                    // console.log(value)
                    let row = '';
                    obj.forEach(element => {
                        row += `<option value="${element.pendidikan}" selected>${element.pendidikan}</option>`
                    });
                    $("#pendidikan").html(row);
                    getPendidikan();
                }
            });
        }
    });
</script>