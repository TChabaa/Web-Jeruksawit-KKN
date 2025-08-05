@extends('components.layouts.admin')

@section('title', 'Form Keterangan Kematian')

@section('content')
    <div class="container-fluid">
        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Form Keterangan Kematian</h1>
            <a href="{{ route('admin.layanan-surat.index') }}" class="btn btn-secondary btn-sm">
                <i class="fas fa-arrow-left"></i> Kembali
            </a>
        </div>

        <div class="row">
            <div class="col-lg-12">
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Detail Permohonan Keterangan Kematian</h6>
                    </div>
                    <div class="card-body">
                        @if (isset($surat))
                            <!-- Informasi Surat -->
                            <div class="row mb-4">
                                <div class="col-md-6">
                                    <h6 class="font-weight-bold">Informasi Surat</h6>
                                    <table class="table table-borderless">
                                        <tr>
                                            <td width="150">Nomor Surat</td>
                                            <td>: {{ $surat->nomor_surat ?? 'Belum ditetapkan' }}</td>
                                        </tr>
                                        <tr>
                                            <td>Tanggal Pengajuan</td>
                                            <td>: {{ $surat->created_at->format('d F Y') }}</td>
                                        </tr>
                                        <tr>
                                            <td>Status</td>
                                            <td>:
                                                @if ($surat->status == 'pending')
                                                    <span class="badge badge-warning">Menunggu</span>
                                                @elseif($surat->status == 'approved')
                                                    <span class="badge badge-success">Disetujui</span>
                                                @else
                                                    <span class="badge badge-danger">Ditolak</span>
                                                @endif
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                            </div>

                            <!-- Data Pemohon -->
                            <div class="row mb-4">
                                <div class="col-md-12">
                                    <h6 class="font-weight-bold">Data Pemohon</h6>
                                    <table class="table table-borderless">
                                        <tr>
                                            <td width="150">Nama Lengkap</td>
                                            <td>: {{ $surat->pemohon->nama }}</td>
                                        </tr>
                                        <tr>
                                            <td>NIK</td>
                                            <td>: {{ $surat->pemohon->nik }}</td>
                                        </tr>
                                        <tr>
                                            <td>Tempat Lahir</td>
                                            <td>: {{ $surat->pemohon->tempat_lahir }}</td>
                                        </tr>
                                        <tr>
                                            <td>Tanggal Lahir</td>
                                            <td>:
                                                {{ \Carbon\Carbon::parse($surat->pemohon->tanggal_lahir)->format('d F Y') }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Alamat</td>
                                            <td>: {{ $surat->pemohon->alamat }}</td>
                                        </tr>
                                    </table>
                                </div>
                            </div>

                            <!-- Detail Kematian -->
                            @if ($surat->detailKematian)
                                <div class="row mb-4">
                                    <div class="col-md-12">
                                        <h6 class="font-weight-bold">Detail Kematian</h6>
                                        <table class="table table-borderless">
                                            <tr>
                                                <td width="150">Nama Almarhum</td>
                                                <td>: {{ $surat->detailKematian->nama_almarhum }}</td>
                                            </tr>
                                            <tr>
                                                <td>NIK Almarhum</td>
                                                <td>: {{ $surat->detailKematian->nik_almarhum }}</td>
                                            </tr>
                                            <tr>
                                                <td>Tanggal Kematian</td>
                                                <td>:
                                                    {{ \Carbon\Carbon::parse($surat->detailKematian->tanggal_kematian)->format('d F Y') }}
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Tempat Kematian</td>
                                                <td>: {{ $surat->detailKematian->tempat_kematian }}</td>
                                            </tr>
                                            <tr>
                                                <td>Sebab Kematian</td>
                                                <td>: {{ $surat->detailKematian->sebab_kematian }}</td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                            @endif

                            <!-- Lampiran -->
                            @if ($surat->lampiran)
                                <div class="row mb-4">
                                    <div class="col-md-12">
                                        <h6 class="font-weight-bold">Lampiran</h6>
                                        <a href="{{ Storage::url($surat->lampiran) }}" target="_blank"
                                            class="btn btn-outline-primary btn-sm">
                                            <i class="fas fa-file"></i> Lihat Lampiran
                                        </a>
                                    </div>
                                </div>
                            @endif

                            <!-- Action Buttons -->
                            <div class="row">
                                <div class="col-md-12">
                                    <form action="{{ route('admin.layanan-surat.updateStatus', $surat->id_surat) }}"
                                        method="POST" class="d-inline">
                                        @csrf
                                        @method('PATCH')
                                        @if ($surat->status == 'pending')
                                            <button type="submit" name="status" value="approved"
                                                class="btn btn-success mr-2">
                                                <i class="fas fa-check"></i> Setujui
                                            </button>
                                            <button type="submit" name="status" value="rejected"
                                                class="btn btn-danger mr-2">
                                                <i class="fas fa-times"></i> Tolak
                                            </button>
                                        @endif
                                    </form>

                                    @if ($surat->status == 'approved')
                                        <a href="{{ route('admin.layanan-surat.print', $surat->id_surat) }}"
                                            target="_blank" class="btn btn-primary">
                                            <i class="fas fa-print"></i> Cetak Surat
                                        </a>
                                    @endif
                                </div>
                            </div>
                        @else
                            <p class="text-muted">Data surat tidak ditemukan.</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
