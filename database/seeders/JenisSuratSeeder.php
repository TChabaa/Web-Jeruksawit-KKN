<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\JenisSurat;

class JenisSuratSeeder extends Seeder
{
    public function run(): void
    {
        $surat = new JenisSurat();
        $surat->nama_jenis = 'SKCK';
        $surat->deskripsi = 'Surat Keterangan Catatan Kepolisian diperluakan untuk keperluan melamar pekerjaan, mengurus visa, atau keperluan lainnya yang memerlukan bukti catatan kepolisian.';
        $surat->save();

        $surat = new JenisSurat();
        $surat->nama_jenis = 'Izin Keramaian';
        $surat->deskripsi = 'Surat izin untuk mengadakan acara/keramaian seperti hajatan, konser, atau acara lainnya yang melibatkan banyak orang.';
        $surat->save();

        $surat = new JenisSurat();
        $surat->nama_jenis = 'Keterangan Usaha';
        $surat->deskripsi = 'Surat keterangan untuk keperluan usaha yang biasanya digunakan untuk keperluan pengajuan kredit atau legalitas usaha.';
        $surat->save();

        $surat = new JenisSurat();
        $surat->nama_jenis = 'SKTM';
        $surat->deskripsi = 'Surat Keterangan Tidak Mampu diperluakan untuk berbagai keperluan administratif, seperti bantuan sosial, pembebasan biaya sekolah, atau keperluan lainnya.';
        $surat->save();

        $surat = new JenisSurat();
        $surat->nama_jenis = 'Belum Menikah';
        $surat->deskripsi = 'Surat keterangan belum menikah yang biasanya digunakan untuk keperluan administrasi, pendaftaran pernikahan, atau keperluan lainnya.';
        $surat->save();

        $surat = new JenisSurat();
        $surat->nama_jenis = 'Keterangan Kematian';
        $surat->deskripsi = 'Surat keterangan kematian yang digunakan untuk keperluan administrasi, klaim asuransi, atau keperluan lainnya terkait dengan kematian seseorang.';
        $surat->save();

        $surat = new JenisSurat();
        $surat->nama_jenis = 'Keterangan Kelahiran';
        $surat->deskripsi = 'Surat keterangan kelahiran yang digunakan untuk keperluan administrasi, pembuatan akta kelahiran, atau keperluan lainnya terkait dengan kelahiran.';
        $surat->save();

        $surat = new JenisSurat();
        $surat->nama_jenis = 'Orang yang Sama';
        $surat->deskripsi = 'Surat keterangan orang yang sama yang digunakan untuk menyatakan bahwa dua identitas yang berbeda merujuk pada orang yang sama.';
        $surat->save();

        $surat = new JenisSurat();
        $surat->nama_jenis = 'Pindah Keluar';
        $surat->deskripsi = 'Surat keterangan pindah keluar yang digunakan untuk keperluan administrasi kependudukan ketika seseorang pindah dari satu daerah ke daerah lain.';
        $surat->save();

        $surat = new JenisSurat();
        $surat->nama_jenis = 'Domisili Instansi';
        $surat->deskripsi = 'Surat keterangan domisili instansi yang digunakan untuk menyatakan alamat resmi dari suatu instansi, lembaga, atau organisasi.';
        $surat->save();

        $surat = new JenisSurat();
        $surat->nama_jenis = 'Domisili Kelompok';
        $surat->deskripsi = 'Surat keterangan domisili kelompok yang digunakan untuk menyatakan alamat resmi dari suatu kelompok, komunitas, atau perkumpulan.';
        $surat->save();
    }
}
