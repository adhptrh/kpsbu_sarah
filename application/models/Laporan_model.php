<?php 
class Laporan_model extends CI_Model
{
    public function getUtang()
    {
        $q = $this->db->query("SELECT 
        SUM(nominal) AS debit, 
        (
            SELECT sum(nominal) 
            FROM jurnal 
            WHERE no_coa = '2111'
            and left(tgl_jurnal, 7) = '2022-06'
            and posisi_dr_cr = 'k' 
        ) AS kredit
        FROM jurnal
        WHERE no_coa = '2111'
        and left(tgl_jurnal, 7) = '2022-06'
        AND posisi_dr_cr = 'd'");
        return $q;
    }
    
    public function neracaSaldo($periode)
    {
        $q = $this->db->query("SELECT 
        a.no_coa, 
        a.nama_coa, 
        a.header, 
        a.saldo_normal,
        j.debit, 
        k.kredit
        FROM coa a
        LEFT JOIN (
           SELECT
            SUM(nominal) AS debit,
            no_coa
            FROM jurnal
            WHERE left(tgl_jurnal, 7) = '$periode'
            AND posisi_dr_cr = 'd'
            GROUP BY no_coa
        ) AS j ON j.no_coa = a.no_coa
        LEFT JOIN (
           SELECT
            SUM(nominal) AS kredit,
            no_coa
            FROM jurnal
            WHERE left(tgl_jurnal, 7) = '$periode'
            AND posisi_dr_cr = 'k'
            GROUP BY no_coa
        ) AS k ON k.no_coa = a.no_coa
        WHERE is_neraca = 1
        GROUP BY no_coa
        ORDER BY no_coa ASC
        ");
        return $q;
    }
}
