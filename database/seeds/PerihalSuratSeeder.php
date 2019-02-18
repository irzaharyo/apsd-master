<?php

use App\Models\PerihalSurat;
use Illuminate\Database\Seeder;

class PerihalSuratSeeder extends Seeder
{
    const PERIHALS = [
        ['000', 'Umum'],
        ['010', 'Urusan Dalam'],
        ['020', 'Peralatan'],
        ['030', 'Kekayaan Daerah'],
        ['040', 'Perpustakaan / Dokumen / Kearsipan / Sandi'],
        ['050', 'Perancanaan'],
        ['060', 'Organisasi / Ketatalaksanaan'],
        ['070', 'Penelitian'],
        ['080', 'Konperensi'],
        ['090', 'Perjalananan Dinas'],
        ['100', 'Pemerintahan'],
        ['110', 'Pemerintahan Pusat'],
        ['120', 'Pemda Tk.I'],
        ['130', 'Pemda Tk.II'],
        ['140', 'Pemerintahan Desa'],
        ['150', 'Dpr-Mpr'],
        ['160', 'Dprd Tk.I'],
        ['170', 'Dprd Tk.II'],
        ['180', 'Hukum'],
        ['190', 'Hubungan Luar Negeri'],
        ['200', 'Politik'],
        ['210', 'Kepartaian'],
        ['220', 'Organisasi Kemasyarakatan'],
        ['230', 'Organisasi Profesi & Fungsional'],
        ['240', 'Organisasi Pemuda'],
        ['250', 'Organisasi Burah, Tani, Kelayam'],
        ['260', 'Organisasi Wanita'],
        ['270', 'Pemilihan Umum'],
        ['300', 'Keamanan / Ketertiban'],
        ['310', 'Pertahanan'],
        ['320', 'Kemiliteran'],
        ['330', 'Keamanan'],
        ['340', 'Pertahanan Sipil'],
        ['350', 'Kejahatan'],
        ['360', 'Bencana'],
        ['370', 'Kecelakaan'],
        ['400', 'Kesejahteraan Rakyat'],
        ['410', 'Pembangunan Desa'],
        ['420', 'Pendidikan'],
        ['430', 'Kebudayaan'],
        ['440', 'Kesehatan'],
        ['450', 'Agama'],
        ['460', 'Sosial'],
        ['470', 'Kependudukan'],
        ['480', 'Media Massa'],
        ['500', 'Perekonomian'],
        ['510', 'Perdagangan'],
        ['520', 'Pertanian'],
        ['530', 'Perindustiran'],
        ['540', 'Petambangan Kesamudraan'],
        ['550', 'Perhubungan'],
        ['560', 'Tenaga Kerja'],
        ['570', 'Permodelan'],
        ['580', 'Perbangkan / Moneter'],
        ['590', 'Agraria'],
        ['600', 'Pekerjaan Umum & Ketenagaan'],
        ['610', 'Pengairan'],
        ['620', 'Jalan'],
        ['630', 'Jembatan'],
        ['640', 'Bangunan'],
        ['650', 'Tetap Ruang Kota'],
        ['660', 'Tata Lingkungan'],
        ['670', 'Ketenagaan'],
        ['680', 'Peralatan Bangunan'],
        ['690', 'Air Minum'],
        ['700', 'Pengawasan'],
        ['710', 'Bidang Pemerintahan'],
        ['720', 'Bidang Politik'],
        ['730', 'Bidang Keamanan / Ketertiban'],
        ['740', 'Bidang Kesra'],
        ['750', 'Bidang Perekonomian'],
        ['760', 'Bidang Pekerjaan Umum'],
        ['780', 'Bidang Kepegawaian'],
        ['790', 'Bidang Keuangan'],
        ['800', 'Kepegawaian'],
        ['810', 'Pengadaan'],
        ['820', 'Pengangkatan & Mutasi'],
        ['830', 'Kedudukan'],
        ['840', 'Kesejahteraan'],
        ['850', 'Cuti'],
        ['860', 'Penilaian'],
        ['870', 'Tata Usaha'],
        ['880', 'Pemberhentian'],
        ['890', 'Pendidikan'],
        ['900', 'Keuangan'],
        ['910', 'Anggaran'],
        ['920', 'Otorisasi'],
        ['930', 'Verivikasi'],
        ['940', 'Pembukuan'],
        ['950', 'Pembendaharaan'],
        ['960', 'Pembinaan Kebendaharaan'],
        ['970', 'Pendapatan'],
        ['990', 'Bendaharawan'],
    ];

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach (static::PERIHALS as $PERIHAL) {
            PerihalSurat::create([
                'kode' => $PERIHAL[0],
                'perihal' => $PERIHAL[1],
            ]);
        }
    }
}
