<x-layouts.dashboard>
    <x-slot:title>Layanan Surat Menyurat</x-slot:title>

    <div class="px-4 py-6 mx-auto max-w-7xl sm:px-6 lg:px-8">
        <!-- Header Section -->
        <div class="mb-8">
            <div class="sm:flex sm:items-center sm:justify-between">
                <div>
                    <h1 class="text-2xl font-bold text-gray-900">Layanan Surat Menyurat</h1>
                    <p class="mt-2 text-sm text-gray-700">Kelola permohonan surat dari masyarakat</p>
                </div>
                <div class="mt-4 sm:mt-0">
                    <a href="{{ route(auth()->user()->role . '.layanan-surat.create') }}"
                        class="inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-green-600 border border-transparent rounded-md shadow-sm hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2">
                        <svg class="-ml-1 mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4">
                            </path>
                        </svg>
                        Buat Surat Baru
                    </a>
                </div>
            </div>
        </div>

        <!-- Statistics Cards -->
        <div class="grid grid-cols-1 gap-5 mb-8 sm:grid-cols-2 lg:grid-cols-4">
            <div class="bg-white overflow-hidden shadow rounded-lg">
                <div class="p-5">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <div class="w-8 h-8 bg-yellow-500 rounded-md flex items-center justify-center">
                                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                        </div>
                        <div class="ml-5 w-0 flex-1">
                            <dl>
                                <dt class="text-sm font-medium text-gray-500 truncate">Menunggu Verifikasi</dt>
                                <dd class="text-lg font-medium text-gray-900">{{ $statistics['pending'] ?? 0 }}</dd>
                            </dl>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow rounded-lg">
                <div class="p-5">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <div class="w-8 h-8 bg-green-500 rounded-md flex items-center justify-center">
                                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5 13l4 4L19 7"></path>
                                </svg>
                            </div>
                        </div>
                        <div class="ml-5 w-0 flex-1">
                            <dl>
                                <dt class="text-sm font-medium text-gray-500 truncate">Disetujui</dt>
                                <dd class="text-lg font-medium text-gray-900">{{ $statistics['approved'] ?? 0 }}</dd>
                            </dl>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow rounded-lg">
                <div class="p-5">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <div class="w-8 h-8 bg-red-500 rounded-md flex items-center justify-center">
                                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M6 18L18 6M6 6l12 12"></path>
                                </svg>
                            </div>
                        </div>
                        <div class="ml-5 w-0 flex-1">
                            <dl>
                                <dt class="text-sm font-medium text-gray-500 truncate">Ditolak</dt>
                                <dd class="text-lg font-medium text-gray-900">{{ $statistics['rejected'] ?? 0 }}</dd>
                            </dl>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow rounded-lg">
                <div class="p-5">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <div class="w-8 h-8 bg-blue-500 rounded-md flex items-center justify-center">
                                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                                    </path>
                                </svg>
                            </div>
                        </div>
                        <div class="ml-5 w-0 flex-1">
                            <dl>
                                <dt class="text-sm font-medium text-gray-500 truncate">Total Surat</dt>
                                <dd class="text-lg font-medium text-gray-900">{{ $statistics['total'] ?? 0 }}</dd>
                            </dl>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Data Table -->
        <div class="bg-white shadow rounded-lg">
            <div class="px-4 py-5 sm:p-6">
                <div class="sm:flex sm:items-center sm:justify-between mb-6">
                    <h3 class="text-lg leading-6 font-medium text-gray-900">Daftar Permohonan Surat</h3>

                    <!-- Filters Section -->
                    <div class="mt-4 sm:mt-0">
                        <div class="flex flex-col sm:flex-row gap-4">
                            <!-- Status Filter Buttons -->
                            <div class="flex flex-wrap gap-2">
                                <button id="filter-all"
                                    class="filter-btn active px-3 py-1 text-sm font-medium rounded-md bg-blue-100 text-blue-800 hover:bg-blue-200">
                                    Semua
                                </button>
                                <button id="filter-pending"
                                    class="filter-btn px-3 py-1 text-sm font-medium rounded-md bg-gray-100 text-gray-800 hover:bg-yellow-100 hover:text-yellow-800">
                                    Menunggu Verifikasi
                                </button>
                                <button id="filter-approved"
                                    class="filter-btn px-3 py-1 text-sm font-medium rounded-md bg-gray-100 text-gray-800 hover:bg-green-100 hover:text-green-800">
                                    Disetujui
                                </button>
                                <button id="filter-rejected"
                                    class="filter-btn px-3 py-1 text-sm font-medium rounded-md bg-gray-100 text-gray-800 hover:bg-red-100 hover:text-red-800">
                                    Ditolak
                                </button>
                            </div>

                            <!-- Jenis Surat Filter Dropdown -->
                            <div class="flex items-center gap-2">
                                <label for="jenis-surat-filter" class="text-sm font-medium text-gray-700">Jenis
                                    Surat:</label>
                                <select id="jenis-surat-filter"
                                    class="px-3 py-1 text-sm border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                    <option value="all">Semua Jenis</option>
                                    @foreach ($jenisSurat as $jenis)
                                        <option value="{{ $jenis->id_jenis }}">{{ $jenis->nama_jenis }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="overflow-hidden shadow ring-1 ring-black ring-opacity-5 md:rounded-lg">
                    <table id="surat-table" class="min-w-full divide-y divide-gray-300">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    No. Surat
                                </th>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Nama Pemohon
                                </th>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Jenis Surat
                                </th>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Status
                                </th>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Tanggal
                                </th>
                                <th scope="col" class="relative px-6 py-3">
                                    <span class="sr-only">Actions</span>
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            <!-- Data will be populated by DataTables -->
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    @push('script')
        <script>
            $(document).ready(function() {
                // Initialize DataTable
                var table = $('#surat-table').DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: {
                        url: "{{ route(auth()->user()->role . '.layanan-surat') }}",
                        type: 'GET',
                        data: function(d) {
                            // Get status filter value
                            var statusFilter = $('.filter-btn.active').attr('id').replace('filter-', '');

                            // Only add status parameter if it's not 'all'
                            if (statusFilter !== 'all') {
                                if (statusFilter === 'pending') {
                                    d.status = 'belum_diverifikasi';
                                } else if (statusFilter === 'approved') {
                                    d.status = 'disetujui';
                                } else if (statusFilter === 'rejected') {
                                    d.status = 'ditolak';
                                }
                            }

                            // Add jenis surat filter - only if not 'all'
                            var jenisSurat = $('#jenis-surat-filter').val();
                            if (jenisSurat && jenisSurat !== 'all') {
                                d.jenis_surat = jenisSurat;
                            }
                        }
                    },
                    columns: [{
                            data: 'no_surat',
                            name: 'nomor_surat'
                        },
                        {
                            data: 'nama_pemohon',
                            name: 'pemohon.nama_lengkap'
                        },
                        {
                            data: 'jenis_surat',
                            name: 'jenisSurat.nama_jenis',
                            orderable: false
                        },
                        {
                            data: 'status',
                            name: 'status',
                            orderable: false,
                            searchable: false
                        },
                        {
                            data: 'created_at',
                            name: 'created_at'
                        },
                        {
                            data: 'action',
                            name: 'action',
                            orderable: false,
                            searchable: false
                        }
                    ],
                    order: [
                        [4, 'desc']
                    ],
                    language: {
                        url: '//cdn.datatables.net/plug-ins/1.13.7/i18n/id.json'
                    },
                    responsive: true,
                    pageLength: 25,
                    lengthMenu: [
                        [10, 25, 50, 100, -1],
                        [10, 25, 50, 100, "Semua"]
                    ]
                });

                // Filter button click events
                $('.filter-btn').on('click', function() {
                    // Update active state
                    $('.filter-btn').removeClass(
                            'active bg-blue-100 text-blue-800 bg-yellow-100 text-yellow-800 bg-green-100 text-green-800 bg-red-100 text-red-800'
                            )
                        .addClass('bg-gray-100 text-gray-800');

                    $(this).removeClass('bg-gray-100 text-gray-800').addClass(
                        'active bg-blue-100 text-blue-800');

                    // Reload DataTable with new filter
                    table.ajax.reload();
                });

                // Jenis Surat filter change event
                $('#jenis-surat-filter').on('change', function() {
                    // Reload DataTable with new filter
                    table.ajax.reload();
                });
            });
        </script>
    @endpush
</x-layouts.dashboard>
