<?php 
class Laporan extends CI_Controller
{

    public function __construct() {
        parent::__construct();
        $this->load->model('Produk_model', 'produk');
    }

    /** laporan salma */
    public function buku_pembantu_kas()
    {
        $periode = $this->input->post('periode');
        if (isset($periode)) {
            $list = $this->db->query("select * from buku_pembantu_kas where left(tanggal, 7) = '$periode'")->result();
            $data = [
                'list' => $list,
                'periode' => date('F Y', strtotime($periode)),
            ];
            $this->template->load('template', 'buku_pembantu_kas', $data);
        } else {
            $list = $this->db->query("select * from buku_pembantu_kas where left(tanggal, 7) = ''")->result();
            $data = [
                'list' => $list,
                'periode' => '',
            ];
            $this->template->load('template', 'buku_pembantu_kas', $data);
        }
    }

    public function buku_kas_kecil()
    {
        $periode = $this->input->post('periode');
        if (isset($periode)) {
            $list = $this->db->query("select * from buku_kas_kecil where left(tgl_transaksi, 7) = '$periode' order by tgl_transaksi desc")->result();
            $data = [
                'list' => $list,
                'periode' => date('F Y', strtotime($periode))
            ];
            $this->template->load('template', 'laporan/buku_kas_kecil', $data);
        } else {
            $list = $this->db->query("select * from buku_kas_kecil where tgl_transaksi = sysdate() order by tgl_transaksi desc")->result();
            $data = [
                'list' => $list,
                'periode' => '',
            ];
            $this->template->load('template', 'laporan/buku_kas_kecil', $data);
        }
        
    }

    public function laporan_arus_kas()
    {
        $total_d = $this->db->query("select sum(nominal) as total from buku_pembantu_kas where posisi_dr_cr = 'd' ")->row()->total;
        $total_k = $this->db->query("select sum(nominal) as total from buku_pembantu_kas where posisi_dr_cr = 'k' ")->row()->total;
        $kas_diterima = $total_d - $total_k;

        $pmb = $this->db->query("SELECT
        SUM(nominal) as total
        FROM jurnal a
        JOIN coa b ON a.no_coa = b.no_coa
        WHERE b.header = 5
        AND nama_coa LIKE '%pembelian%'")->row()->total;

        $beban = $this->db->query("SELECT
        SUM(nominal) as total, 
        nama_coa
        FROM jurnal a
        JOIN coa b ON a.no_coa = b.no_coa
        WHERE b.header = 5
        AND is_arus_kas = 1
        GROUP BY a.no_coa")->result();
        // print_r($kas_diterima);exit;
        $data = [
            'kas_diterima' => $kas_diterima,
            'pmb' => $pmb,
            'beban' => $beban,
        ];
        $this->template->load('template', 'arus_kas', $data);
    }

    // sarah
    public function laporan_penjualan_shu()
    {
        $susu_murni = $this->db->query("SELECT * FROM pnj_susu WHERE jenis_pnj_susu = 'susu_murni'")->result();
        $pakan_konsentrat = $this->db->query("SELECT * FROM pnj_susu WHERE jenis_pnj_susu = 'pakan_konsentrat'")->result();
        $susu_olahan = $this->db->query("SELECT * FROM pnj_susu WHERE jenis_pnj_susu = 'susu_olahan'")->result();
        $total_pbj = $this->db->query("SELECT SUM(total) AS total_penjualan FROM pnj_susu")->row()->total_penjualan;
        $data = [
            'susu_murni' => $susu_murni,
            'susu_olahan' => $susu_olahan,
            'pakan_konsentrat' => $pakan_konsentrat,
            'total' => $total_pbj
        ];

        $this->template->load('template', 'shu/laporan_penjualan_shu/index', $data);
    }

   /*  public function neraca_saldo()
    {
        $bulan = $this->input->post('bulan');
        $tahun = $this->input->post('tahun');
        $periode = $tahun.'-'.$bulan;
        $saldo_awal = $this->db->query("SELECT * FROM coa WHERE no_coa = '1111'")->result()[0]->saldo_awal;

        if (isset($periode)) {
            $list = $this->Laporan_model->neracaSaldo($periode)->result();
            echo "<pre>";
            var_dump($list);
            echo "</pre>";
            $data = [
                'list' => $list,
                'periode' => $periode,
                'saldo_awal' => $saldo_awal,
            ];
            $this->template->load('template', 'laporan/neraca_saldo', $data);
        } 
    } */

    public function neraca_saldo()
    {
        $bulan = $this->input->post('bulan');
        $tahun = $this->input->post('tahun');
        $periode = $tahun.'-'.$bulan;
        $saldo_awal = $this->db->query("SELECT * FROM coa WHERE no_coa = '1111'")->result()[0]->saldo_awal;

        if (isset($periode)) {
            $list = [];
            $qgetcoa = "SELECT * FROM coa WHERE is_neraca = 1";
            $coas = $this->db->query($qgetcoa)->result();
            foreach ($coas as $coa) {
                $data = [
                    "no_coa"=>$coa->no_coa,
                    "nama_coa"=>$coa->nama_coa,
                    "header"=>$coa->header,
                    "saldo_normal"=>$coa->saldo_normal,
                    "nominal"=>0,
                ];
                $qgetjurnalitem = "SELECT a.no_coa, b.nama_coa, a.posisi_dr_cr, b.header, a.nominal FROM jurnal a LEFT JOIN coa b ON b.no_coa = a.no_coa WHERE b.is_neraca = 1 AND a.no_coa = '".$coa->no_coa."' ORDER BY a.nominal DESC";
                $jurnalItems = $this->db->query($qgetjurnalitem)->result();
                foreach ($jurnalItems as $k=>$jurnal) {
                    if ($jurnal->posisi_dr_cr == "k") {
                        $data["nominal"] -= $jurnal->nominal;
                    } else {
                        $data["nominal"] += $jurnal->nominal;
                    }
                }
                if ($coa->saldo_normal == "k") {
                    $data["nominal"] = 0 - $data["nominal"];
                }
                /* if ($coa->no_coa == '1312') {
                    echo $coa->no_coa;
                    $data["nominal"] = 0-$data["nominal"];
                } */
                array_push($list, (object)$data);
            }
            $q = "SELECT a.no_coa, b.nama_coa, a.posisi_dr_cr, b.header, a.nominal FROM jurnal a LEFT JOIN coa b ON b.no_coa = a.no_coa WHERE b.is_neraca = 1 AND a.no_coa = '1312'";
            $data = [
                'list' => $list,
                'periode' => $periode,
                'saldo_awal' => $saldo_awal,
            ];
            $this->template->load('template', 'laporan/neraca_saldo', $data);
        } 
    }

    public function laporan_neraca()
    {
        $saldo_awal = $this->db->query("SELECT * FROM coa WHERE no_coa = '1111'")->result()[0]->saldo_awal;
        $query = $this->db->query("SELECT 
        SUM(nominal) AS debit, 
        (
            SELECT sum(nominal) 
            FROM jurnal 
            WHERE no_coa = '1111'
            and left(tgl_jurnal, 7) = '".date("Y-m")."'
            and posisi_dr_cr = 'k' 
        ) AS kredit
        FROM jurnal
        WHERE no_coa = '1111'
        and left(tgl_jurnal, 7) = '".date("Y-m")."'
        AND posisi_dr_cr = 'd'")->row();
        $total_kas = $query->debit - $query->kredit + $saldo_awal;

        $query = $this->db->query("SELECT 
        SUM(nominal) AS debit, 
        (
            SELECT sum(nominal) 
            FROM jurnal 
            WHERE no_coa = '1112'
            and left(tgl_jurnal, 7) = '".date("Y-m")."'
            and posisi_dr_cr = 'k' 
        ) AS kredit
        FROM jurnal
        WHERE no_coa = '1112'
        and left(tgl_jurnal, 7) = '".date("Y-m")."'
        AND posisi_dr_cr = 'd'")->row();
        $persediaanbahanbaku = $query->debit - $query->kredit + $saldo_awal;

        $query = $this->db->query("SELECT 
        SUM(nominal) AS debit, 
        (
            SELECT sum(nominal) 
            FROM jurnal 
            WHERE no_coa = '2111'
            and left(tgl_jurnal, 7) = '".date("Y-m")."'
            and posisi_dr_cr = 'k' 
        ) AS kredit
        FROM jurnal
        WHERE no_coa = '2111'
        and left(tgl_jurnal, 7) = '".date("Y-m")."'
        AND posisi_dr_cr = 'd'")->row();
        $utang = $query->debit - $query->kredit + $saldo_awal;

        $query = $this->db->query("SELECT 
        SUM(nominal) AS debit, 
        (
            SELECT sum(nominal) 
            FROM jurnal 
            WHERE no_coa = '1125'
            and left(tgl_jurnal, 7) = '".date("Y-m")."'
            and posisi_dr_cr = 'k' 
        ) AS kredit
        FROM jurnal
        WHERE no_coa = '1125'
        and left(tgl_jurnal, 7) = '".date("Y-m")."'
        AND posisi_dr_cr = 'd'")->row();
        $akumulasipenyusutankendaraan = $query->kredit + $saldo_awal;

        $query = $this->db->query("SELECT 
        SUM(nominal) AS debit, 
        (
            SELECT sum(nominal) 
            FROM jurnal 
            WHERE no_coa = '3111'
            and left(tgl_jurnal, 7) = '".date("Y-m")."'
            and posisi_dr_cr = 'k' 
        ) AS kredit
        FROM jurnal
        WHERE no_coa = '3111'
        and left(tgl_jurnal, 7) = '".date("Y-m")."'
        AND posisi_dr_cr = 'd'")->row();
        $simpananpokok = $query->kredit + $saldo_awal;

        $query = $this->db->query("SELECT 
        SUM(nominal) AS debit, 
        (
            SELECT sum(nominal) 
            FROM jurnal 
            WHERE no_coa = '3112'
            and left(tgl_jurnal, 7) = '".date("Y-m")."'
            and posisi_dr_cr = 'k' 
        ) AS kredit
        FROM jurnal
        WHERE no_coa = '3112'
        and left(tgl_jurnal, 7) = '".date("Y-m")."'
        AND posisi_dr_cr = 'd'")->row();
        $simpananwajib = $query->kredit + $saldo_awal;

        $query = $this->db->query("SELECT 
        SUM(nominal) AS debit, 
        (
            SELECT sum(nominal) 
            FROM jurnal 
            WHERE no_coa = '3113'
            and left(tgl_jurnal, 7) = '".date("Y-m")."'
            and posisi_dr_cr = 'k' 
        ) AS kredit
        FROM jurnal
        WHERE no_coa = '3112'
        and left(tgl_jurnal, 7) = '".date("Y-m")."'
        AND posisi_dr_cr = 'd'")->row();
        $simpananmasuka = $query->kredit + $saldo_awal;

        $query = $this->db->query("SELECT 
        SUM(nominal) AS debit, 
        (
            SELECT sum(nominal) 
            FROM jurnal 
            WHERE no_coa = '3200'
            and left(tgl_jurnal, 7) = '".date("Y-m")."'
            and posisi_dr_cr = 'k' 
        ) AS kredit
        FROM jurnal
        WHERE no_coa = '3200'
        and left(tgl_jurnal, 7) = '".date("Y-m")."'
        AND posisi_dr_cr = 'd'")->row();
        $shuditahan = $query->debit - $query->kredit + $saldo_awal;
        
        $total_aktifa = $total_kas + $persediaanbahanbaku + $akumulasipenyusutankendaraan;
        $modal = $total_aktifa - ($utang+$simpananpokok+$simpananwajib+$simpananmasuka);
        $total_pasiva = $modal+$utang+$simpananpokok+$simpananwajib+$simpananmasuka;

        $data = [
            'kas' => $total_kas,
            'persediaanbahanbaku' => $persediaanbahanbaku,
            'utang' => $utang,
            "akumulasipenyusutankendaraan"=>$akumulasipenyusutankendaraan,
            "simpananpokok"=>$simpananpokok,
            "simpananwajib"=>$simpananwajib,
            "simpananmasuka"=>$simpananmasuka,
            "shuditahan"=>$shuditahan,
            "total_aktifa"=>$total_aktifa,
            "total_pasiva"=>$total_pasiva,
            "modal"=>$modal,
        ];
        
        $this->template->load('template', 'laporan/laporan_neraca', $data);
    }

    public function laporan_simpanan()
    {
        // $list = $this->db->query("SELECT 
        // z.nama_peternak, 
        // z.no_peternak, 
        // z.deposit, 
        // x.total_liter, 
        // x.total_harga, 
        // x.total_masuka, 
        // x.total_simpanan_wajib
        // FROM peternak z
        // LEFT JOIN (
        //     SELECT a.no_peternak, 
        //     a.nama_peternak, 
        //     a.deposit, 
        //     sum(b.jumlah_liter_susu) AS total_liter, 
        //     sum(b.jumlah_harga_susu) AS total_harga, 
        //     sum(b.simpanan_masuka) AS total_masuka, 
        //     sum(b.simpanan_wajib) AS total_simpanan_wajib, 
        //     c.total_bayar, 
        //     c.tgl_transaksi
        //     FROM peternak a 
        //     LEFT JOIN log_pembayaran_susu b ON a.no_peternak = b.id_anggota
        //     LEFT JOIN pembayaran_susu c ON b.id_pembayaran = c.kode_pembayaran
        //     WHERE left(tgl_transaksi, 4) = '$year'
        //     GROUP BY nama_peternak
        // ) AS x ON z.no_peternak = x.no_peternak
        // WHERE z.is_deactive = 0")->result();
        $list = $this->M_transaksi->data_laporan_shu()->result();
        // print_r($list);exit;
        $data = [
            'list' => $list,
        ];
        $this->template->load('template', 'laporan_simpanan', $data);
    }

    // siti 
    public function laporan_penjualan_waserda()
    {
        $bulan = $this->input->post('bulan');
        $tahun = $this->input->post('tahun');

        $periode = $tahun.'-'.$bulan;

        $show_all = $this->input->post('show_all');
        // print_r($show_all);exit;

        if (isset($periode)) {
            $list = $this->db->query("SELECT * FROM pos_penjualan 
            WHERE LEFT(tanggal, 7) = '$periode'")->result();
            $data = [
                'list' => $list, 
            ];
            $this->template->load('template', 'laporan/laporan_penjualan_waserda', $data);
        }
    }

    public function laporan_pmb_waserda()
    {
        $bulan = $this->input->post('bulan');
        $tahun = $this->input->post('tahun');

        $periode = $tahun.'-'.$bulan;

        $show_all = $this->input->post('show_all');
        // print_r($show_all);exit;

        if (isset($periode)) {
            $list = $this->db->query("SELECT * FROM pos_pembelian 
            WHERE LEFT(tanggal, 7) = '$periode'")->result();
            $data = [
                'list' => $list, 
            ];
            $this->template->load('template', 'laporan/laporan_pmb_waserda', $data);
        }
    }

    public function laba_rugi()
    {
        $listPendapatan = $this->db->query('SELECT SUM(nominal) AS nominal, b.nama_coa, a.posisi_dr_cr
        from jurnal a
        JOIN coa b ON a.no_coa = b.no_coa
        WHERE header = 4
        AND is_waserda = 1')->result();
        $listHPP = $this->db->query('SELECT SUM(nominal) AS nominal, b.nama_coa, a.posisi_dr_cr
        from jurnal a
        JOIN coa b ON a.no_coa = b.no_coa
        WHERE header = 6
        AND is_waserda = 1')->result();
        $listBeban = $this->db->query('SELECT b.nama_coa, a.posisi_dr_cr, SUM(nominal) AS nominal
        from jurnal a
        JOIN coa b ON a.no_coa = b.no_coa
        WHERE header = 5
        AND is_waserda = 1 
        AND posisi_dr_cr = "d"
        GROUP BY nama_coa')->result();
        $data = [
            'pendapatan' => $listPendapatan,
            'beban' => $listBeban,
            'hpp' => $listHPP,
        ];
        // print_r($data);exit;
        $this->template->load('template', 'laporan/laba_rugi', $data);
    }

    public function kartu_stok()
    {
        $kode = $this->input->post('nama_brg');
        $periode = $this->input->post('periode');
        if (isset($kode, $periode)) {
            $this->db->where('status', 1);
            $getProduk = $this->db->get('waserda_produk')->result();

            $getKartuStok = $this->db->query("select * from waserda_kartu_stok where kode = '$kode' and left(tgl_transaksi, 7) = '$periode'")->result();
            $data = [
                'produk' => $getProduk, 
                'kartu_stok' => $getKartuStok,
            ];
            $this->template->load('template', 'laporan/kartu_stok', $data);
        } else {
            $this->db->where('status', 1);
            $getProduk = $this->db->get('waserda_produk')->result();

            $getKartuStok = $this->db->query("select * from waserda_kartu_stok where kode = '$kode' and left(tgl_transaksi, 7) = '$periode'")->result();
            $data = [
                'produk' => $getProduk, 
                'kartu_stok' => $getKartuStok,
            ];
            $this->template->load('template', 'laporan/kartu_stok', $data);
        }
        
    }
}
?>