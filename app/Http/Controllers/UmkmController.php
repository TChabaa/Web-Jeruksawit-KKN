<?php

namespace App\Http\Controllers;

use App\Models\Umkm;
use App\Models\User;
use App\Models\GambarUmkm;
use App\Models\ContactUmkm;
use App\Models\OpeningHourUmkm;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use RealRashid\SweetAlert\Facades\Alert;
use Yajra\DataTables\Facades\DataTables;
use App\Http\Requests\UmkmCreateRequest;
use App\Http\Requests\UmkmUpdateRequest;

class UmkmController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (request()->ajax()) {
            $umkm = Umkm::query();
            if (Auth::user()->role === 'owner') {
                $umkm->where('created_by', Auth::user()->id);
            }
            $umkm->get();
            return DataTables::of($umkm)
                ->addColumn('action', function ($item) {
                    $roleName = Auth::user()->role;
                    // Ensure $roleName matches route group names: admin, owner, super_admin
                    if (!in_array($roleName, ['admin', 'owner', 'super_admin'])) {
                        $roleName = 'admin'; // fallback to admin if role is not recognized
                    }
                    $editUrl = route($roleName . '.umkm.edit', $item->id_umkm);
                    $deleteUrl = route($roleName . '.umkm.destroy', $item->id_umkm);
                    return sprintf(
                        '<div class="wrapper-action">
                            <a href="%s">Edit</a>
                            <div>
                                <form action="%s" method="post">
                                    %s %s
                                    <button data-modal-target="deleteModal" data-modal-toggle="deleteModal" type="submit">Hapus</button>
                                </form>
                            </div>
                        </div>',
                        $editUrl,
                        $deleteUrl,
                        method_field('delete'),
                        csrf_field()
                    );
                })
                ->make();
        }

        return view('components.pages.dashboard.admin.umkm.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $owners = [];

        if (Auth::user()->role !== 'owner') {
            $owners = User::where('role', 'owner')->get();
        }

        return view('components.pages.dashboard.admin.umkm.create', compact('owners'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(UmkmCreateRequest $request)
    {
        try {
            DB::beginTransaction();

            // Create UMKM
            $umkm = $this->createUmkm($request);

            // Store opening hours
            $this->storeOpeningHours($request, $umkm);

            // Store contact details
            $this->storeContactDetails($request, $umkm);

            // Store galleries
            $this->storeGalleries($request, $umkm);

            DB::commit();

            Alert::toast('Sukses Menambahkan UMKM', 'success');
            return redirect()->route(Auth::user()->role . '.umkm.index');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => 'Gagal Menambahkan UMKM: ' . $e->getMessage()]);
        }
    }

    private function createUmkm($request)
    {
        return Umkm::create([
            'created_by' => Auth::user()->id,
            'nama' => $request->name_destination,
            'deskripsi' => $request->description,
            'alamat' => $request->location,
            'gmaps_url' => $request->gmaps_url,
            'slug' => Str::slug($request->name_destination . '-' . Str::ulid())
        ]);
    }

    private function storeGalleries($request, $umkm)
    {
        $photos = $request->file('galleries');
        foreach ($photos as $photo) {
            $path = $photo->storePublicly("gambar_umkm", "public");
            GambarUmkm::create([
                'id_umkm' => $umkm->id_umkm,
                'image_url' => $path,
            ]);
        }
    }

    private function storeOpeningHours($request, $umkm)
    {
        $days = [$request->input("opening_hours.first_day"), $request->input("opening_hours.last_day")];
        foreach ($days as $day) {
            OpeningHourUmkm::create([
                'id_umkm' => $umkm->id_umkm,
                'day' => $day,
                'open' => $request->input("opening_hours.open"),
                'close' => $request->input("opening_hours.close"),
            ]);
        }
    }

    private function storeContactDetails($request, $umkm)
    {
        if ($request->has('contact_details')) {
            ContactUmkm::create([
                'id_umkm' => $umkm->id_umkm,
                'nomor' => $request->input('contact_details.phone'),
                'email' => $request->input('contact_details.email'),
                'sosial_media' => $request->input('contact_details.social_media')
            ]);
        }
    }

    public function addGalleries(Request $request, string $umkm)
    {
        try {
            $request->validate([
                'galleries.*' => 'required|image|mimes:jpeg,png,jpg|max:1048|',
            ]);

            DB::beginTransaction();

            $umkm = Umkm::with('gambarUmkm')->where('id_umkm', $umkm)->firstOrFail();
            $this->storeGalleries($request, $umkm);

            DB::commit();

            Alert::toast('Sukses Menambahkan Photo', 'success');
            return redirect()->route(Auth::user()->role . '.umkm.edit', $umkm->id_umkm);
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => 'Gagal Menambahkan Photo: ' . $e->getMessage()]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $slug)
    {
        $umkm = Umkm::with(['contactUmkm', 'openingHours', 'gambarUmkm'])->where('slug', $slug)->firstOrFail();
        $openingHours = $this->formatOpeningHours($umkm->openingHours->toArray());

        // Increment the views count
        $umkm->increment('views');
        return view('components.pages.frontend.detail-umkm', compact('umkm', 'openingHours'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $umkm = Umkm::with(['contactUmkm', 'openingHours', 'gambarUmkm'])->where('id_umkm', $id)->firstOrFail();

        $openingHours = $this->formatOpeningHours($umkm->openingHours->toArray());

        $owners = [];

        if (Auth::user()->role !== 'owner') {
            $owners = User::where('role', 'owner')->get();
        }

        $title = 'Hapus Foto UMKM!';
        $text = "Apakah Anda yakin ingin menghapus?";
        confirmDelete($title, $text);
        return view('components.pages.dashboard.admin.umkm.edit', compact('umkm', 'openingHours', 'owners'));
    }

    private function formatOpeningHours($openingHours)
    {
        // Ambil hari pertama dan kedua
        $days = array_column($openingHours, 'day');

        // Ambil jam buka dan jam tutup dari entry pertama
        $openTime = $openingHours[0]['open'];
        $closeTime = $openingHours[0]['close'];

        // Buat array hasil
        $result = [
            $days[0],       // Nama hari pertama
            $days[1],       // Nama hari kedua
            $openTime,      // Jam buka
            $closeTime      // Jam tutup
        ];

        return $result;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $umkm)
    {
        try {
            DB::beginTransaction();

            $umkm = Umkm::where('id_umkm', $umkm)->firstOrFail();
            $oldName = $umkm->nama;

            $updateData = [
                'nama' => $request->name_destination,
                'deskripsi' => $request->description,
                'alamat' => $request->location,
                'gmaps_url' => $request->gmaps_url,
                'slug' => $request->name_destination != $oldName ? Str::slug($request->name_destination . '-' . Str::ulid()) : $umkm->slug
            ];

            // Only update created_by if user is not owner and owner field is provided
            if (Auth::user()->role !== 'owner' && $request->has('owner')) {
                $updateData['created_by'] = $request->owner;
            }

            $umkm->update($updateData);

            DB::commit();

            Alert::toast('Sukses Mengubah UMKM', 'success');
            return redirect()->route(Auth::user()->role . '.umkm.edit', $umkm->id_umkm);
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => 'Gagal Mengubah UMKM: ' . $e->getMessage()]);
        }
    }

    public function updateOperational(Request $request, string $umkm)
    {
        try {
            $request->validate([
                'opening_hours' => 'array',
                'opening_hours.first_day' => 'required|string|in:senin,selasa,rabu,kamis,jumat,sabtu,minggu',
                'opening_hours.last_day' => 'required|string|in:senin,selasa,rabu,kamis,jumat,sabtu,minggu',
                'opening_hours.open' => 'required|string',
                'opening_hours.close' => 'required|string',
            ]);

            DB::beginTransaction();

            $umkm = Umkm::with('openingHours')->where('id_umkm', $umkm)->firstOrFail();
            $umkm->openingHours()->delete();

            $this->storeOpeningHours($request, $umkm);

            DB::commit();

            Alert::toast('Sukses Mengubah Jam Operasional', 'success');
            return redirect()->route(Auth::user()->role . '.umkm.edit', $umkm->id_umkm);
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => 'Gagal Mengubah Jam Operasional: ' . $e->getMessage()]);
        }
    }

    public function updateContactDetail(Request $request, string $umkm)
    {
        try {
            $request->validate([
                'contact_details' => 'array',
                'contact_details.phone' => 'nullable|string|max:20',
                'contact_details.email' => 'nullable|string|max:50',
                'contact_details.social_media' => 'nullable|string|max:100',
            ]);

            DB::beginTransaction();

            $umkm = Umkm::with('contactUmkm')->where('id_umkm', $umkm)->firstOrFail();
            $umkm->contactUmkm->update([
                "nomor" => $request->input('contact_details.phone'),
                "email" => $request->input('contact_details.email'),
                "sosial_media" => $request->input('contact_details.social_media')
            ]);

            DB::commit();

            Alert::toast('Sukses Mengubah Kontak', 'success');
            return redirect()->route(Auth::user()->role . '.umkm.edit', $umkm->id_umkm);
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => 'Gagal Mengubah Kontak: ' . $e->getMessage()]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $umkm = Umkm::where('id_umkm', $id)->firstOrFail();
        $umkm->delete();

        Alert::toast('Berhasil menghapus data UMKM', 'success');
        return redirect()->route(Auth::user()->role . '.umkm.index');
    }

    public function destroyGallery(string $umkm, string $gallery)
    {
        $umkm = Umkm::with('gambarUmkm')->where('id_umkm', $umkm)->firstOrFail();
        $galleryItem = $umkm->gambarUmkm()->where('id', $gallery)->firstOrFail();

        // Delete the image file
        if ($galleryItem->image_url && Storage::disk('public')->exists($galleryItem->image_url)) {
            Storage::disk('public')->delete($galleryItem->image_url);
        }

        $galleryItem->delete();

        Alert::toast('Berhasil menghapus data photo', 'success');
        return redirect()->route(Auth::user()->role . '.umkm.edit', $umkm->id_umkm);
    }
}
