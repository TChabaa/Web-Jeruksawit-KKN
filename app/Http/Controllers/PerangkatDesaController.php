<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use App\Models\PerangkatDesa;
use App\Models\User;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;
use App\Http\Requests\PerangkatDesaCreateRequest;
use App\Http\Requests\PerangkatDesaUpdateRequest;
use Illuminate\Support\Facades\Auth;

class PerangkatDesaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Check if the request is AJAX
        if (request()->ajax()) {
            // Create query for PerangkatDesa model
            $perangkat_desa = PerangkatDesa::with('user');

            // If user has 'writer' role, filter data based on current user's created_by
            if (Auth::user()->role === 'writer') {
                $perangkat_desa->where('created_by', Auth::user()->id);
            }

            // Order data by newest
            $perangkat_desa = $perangkat_desa->latest()->get();

            // Return data in DataTables format
            return DataTables::of($perangkat_desa)
                ->addColumn('creator', function ($item) {
                    return $item->user ? $item->user->name : 'Tidak ada pembuat';
                })
                // Add action column for each item
                ->addColumn('action', function ($item) {
                    $roleName = Auth::user()->role;
                    // Ensure $roleName matches route group names: admin, owner, super_admin
                    if (!in_array($roleName, ['admin', 'owner', 'super_admin'])) {
                        $roleName = 'admin'; // fallback to admin if role is not recognized
                    }
                    $editUrl = route($roleName . '.perangkat-desa.edit', $item->id_perangkat);
                    $deleteUrl = route($roleName . '.perangkat-desa.destroy', $item->id_perangkat);

                    // Create edit and delete buttons for each item
                    return sprintf(
                        '
                    <div class="wrapper-action">
                        <a href="%s">Edit</a>
                        <div>
                            <form action="%s" method="post">
                                %s %s
                                <button data-modal-target="deleteModal" data-modal-toggle="deleteModal" type="submit">Hapus</button>
                            </form>
                        </div>
                    </div>
                    ',
                        $editUrl,
                        $deleteUrl,
                        method_field('delete'),
                        csrf_field(),
                    );
                })
                ->make();
        }

        // If not AJAX request, return view for dashboard page
        return view('components.pages.dashboard.admin.perangkat-desa.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('components.pages.dashboard.admin.perangkat-desa.create');
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\PerangkatDesaCreateRequest  $request
     */
    public function store(PerangkatDesaCreateRequest $request): \Illuminate\Http\RedirectResponse
    {
        try {
            DB::beginTransaction();

            $path = null;
            if ($request->hasFile('gambar')) {
                $photo = $request->file('gambar');
                $path = $photo->storePublicly("perangkat_desa", "public");
            }

            PerangkatDesa::create([
                'created_by' => Auth::user()->id,
                'nama' => $request->nama,
                'jabatan' => $request->jabatan,
                'gambar' => $path,
                'slug' => Str::slug($request->nama . '-' . Str::ulid())
            ]);

            DB::commit();

            Alert::toast('Sukses Menambahkan Perangkat Desa', 'success');
            return redirect()->route(Auth::user()->role . '.perangkat-desa.index');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => 'Gagal Menambahkan Perangkat Desa: ' . $e->getMessage()]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $slug)
    {
        $perangkat_desa = PerangkatDesa::with('user')->where('slug', $slug)->firstOrFail();
        return view('components.pages.frontend.detail-perangkat-desa', compact('perangkat_desa'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $perangkat_desa = PerangkatDesa::findOrFail($id);

        return view('components.pages.dashboard.admin.perangkat-desa.edit', compact('perangkat_desa'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param PerangkatDesaUpdateRequest $request
     * @param string $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(PerangkatDesaUpdateRequest $request, string $id)
    {
        try {
            DB::beginTransaction();

            $perangkat_desa = PerangkatDesa::findOrFail($id);
            $oldName = $perangkat_desa->nama;

            // Check if there's a new image uploaded
            if ($request->hasFile('gambar')) {
                // Delete old image if exists
                if ($perangkat_desa->gambar && Storage::disk('public')->exists($perangkat_desa->gambar)) {
                    Storage::disk('public')->delete($perangkat_desa->gambar);
                }

                $photo = $request->file('gambar');
                $path = $photo->storePublicly("perangkat_desa", "public");
            } else {
                $path = $perangkat_desa->gambar;
            }

            $perangkat_desa->update([
                'nama' => $request->nama,
                'jabatan' => $request->jabatan,
                'gambar' => $path,
                'slug' => $request->nama != $oldName ? Str::slug($request->nama . '-' . Str::ulid()) : $perangkat_desa->slug
            ]);

            DB::commit();

            Alert::toast('Sukses Mengubah Perangkat Desa', 'success');
            return redirect()->route(Auth::user()->role . '.perangkat-desa.index');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => 'Gagal Mengubah Perangkat Desa: ' . $e->getMessage()]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $perangkat_desa = PerangkatDesa::findOrFail($id);
            $perangkat_desa->delete();

            Alert::toast('Sukses Menghapus Perangkat Desa', 'success');
            return redirect()->route(Auth::user()->role . '.perangkat-desa.index');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Gagal Menghapus Perangkat Desa: ' . $e->getMessage()]);
        }
    }
}
