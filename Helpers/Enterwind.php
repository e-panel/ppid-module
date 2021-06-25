<?php 

if(!function_exists('segmen_ppid')) {
    function segmen_ppid($slug) {
        switch ($slug) {
            case 1:
                return 'List Induk (PPID Pembantu)';
            break;
            case 2:
                return 'Audit Laporan Keuangan';
            break;
            default:
                return '-';
                break;
        }
    }
}

if(!function_exists('jenis_pengadaan')) {
    function jenis_pengadaan() {
        return [
            1 => 'Barang',
            'Jasa Konsultansi',
            'Jasa Lainnya',
            'Pekerjaan Konstruksi'
        ];
    }
}

if(!function_exists('select_jenis_pengadaan')) {
    function select_jenis_pengadaan($i) {
        foreach(jenis_pengadaan() as $ii => $temp):
            if($i == $ii):
                return $temp;
            endif;
        endforeach;
    }
}

if(!function_exists('tahun_anggaran')) {
    function tahun_anggaran() {
        return [
            '2016' => '2016',
            '2017' => '2017',
            '2018' => '2018',
            '2019' => '2019',
            '2020' => '2020', 
            '2021' => '2021', 
            '2022' => '2022', 
        ];
    }
}