<?php

namespace App\Http\Controllers;

use App\Models\Gallery;
use App\Models\Facility;
use App\Models\Destination;
use App\Models\OpeningHour;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\Accommodation;
use App\Models\ContactDetail;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use RealRashid\SweetAlert\Facades\Alert;
use Yajra\DataTables\Facades\DataTables;
use App\Http\Requests\DestinationCreateRequest;

class DestinationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (request()->ajax()) {
            $destination = Destination::query();
            if (Auth::user()->role === 'owner') {
                $destination->where('owner_id', Auth::user()->id);
            }
            $destination->get();
            return DataTables::of($destination)
                ->addColumn('action', function ($item) {
                    $roleName = Auth::user()->role;
                    // Ensure $roleName matches route group names: admin, owner, super_admin
                    if (!in_array($roleName, ['admin', 'owner', 'super_admin'])) {
                        $roleName = 'admin'; // fallback to admin if role is not recognized
                    }
                    $editUrl = route($roleName . '.destinations.edit', $item->id);
                    $deleteUrl = route($roleName . '.destinations.destroy', $item->id);
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

        return view('components.pages.dashboard.admin.destination.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('components.pages.dashboard.admin.destination.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(DestinationCreateRequest $request)
    {
        try {
            DB::beginTransaction();

            // Create destination
            $destination = $this->createDestination($request);

            // Store opening hours
            $this->storeOpeningHours($request, $destination);

            // Store contact details
            $this->storeContactDetails($request, $destination);

            // Store galleries
            $this->storeGalleries($request, $destination);

            // Store facilities
            $this->storeFacilities($request, $destination);

            // Store accommodation
            $this->storeAccomodation($request, $destination);

            DB::commit();

            Alert::toast('Sukses Menambahkan Destinasi', 'success');
            return redirect()->route(Auth::user()->role . '.destinations.index');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => 'Gagal Menambahkan Destinasi: ' . $e->getMessage()]);
        }
    }

    private function createDestination($request)
    {
        return Destination::create([
            'owner_id' => Auth::user()->id,
            'name' => $request->name_destination,
            'description' => $request->description,
            'location' => $request->location,
            'gmaps_url' => $request->gmaps_url,
            'price_range' => $request->price_range,
            'status' => $request->status,
            'slug' => Str::slug($request->name_destination . '-' . Str::ulid())
        ]);
    }

    private function storeGalleries($request, $destination)
    {
        $photos = $request->file('galleries');
        foreach ($photos as $photo) {
            $path = $photo->storePublicly("gallery", "public");
            Gallery::create([
                'destination_id' => $destination->id,
                'image_url' => $path,
            ]);
        }
    }

    private function storeOpeningHours($request, $destination)
    {
        $days = [$request->input("opening_hours.first_day"), $request->input("opening_hours.last_day")];
        foreach ($days as $day) {
            OpeningHour::create([
                'destination_id' => $destination->id,
                'day' => $day,
                'open' => $request->input("opening_hours.open"),
                'close' => $request->input("opening_hours.close"),
            ]);
        }
    }

    private function storeContactDetails($request, $destination)
    {
        if ($request->has('contact_details')) {
            ContactDetail::create([
                'destination_id' => $destination->id,
                'phone' => $request->input('contact_details.phone'),
                'email' => $request->input('contact_details.email'),
                'social_media' => $request->input('contact_details.social_media')
            ]);
        }
    }

    private function storeFacilities($request, $destination)
    {
        if ($request->has('facilities')) {
            foreach ($request->facilities as $facility) {
                Facility::create([
                    'destination_id' => $destination->id,
                    'name' => $facility,
                ]);
            }
        }
    }

    private function storeAccomodation($request, $destination)
    {
        if ($request->has('accommodations')) {
            foreach ($request->accommodations as $accommodation) {
                Accommodation::create([
                    'destination_id' => $destination->id,
                    'name' => $accommodation
                ]);
            }
        }
    }

    public function addGalleries(Request $request, string $destination)
    {
        try {
            $request->validate([
                'galleries.*' => 'required|image|mimes:jpeg,png,jpg|max:4146|',
            ]);

            DB::beginTransaction();

            $destination = Destination::with('galleries')->findOrFail($destination);
            $this->storeGalleries($request, $destination);

            DB::commit();

            Alert::toast('Sukses Menambahkan Photo', 'success');
            return redirect()->route(Auth::user()->role . '.destinations.edit', $destination);
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => 'Gagal Menambahkan Photo: ' . $e->getMessage()]);
        }
    }

    public function storeAccommodation(Request $request, string $destination)
    {
        try {
            $request->validate([
                'accommodation' => 'required|string',
            ]);

            DB::beginTransaction();

            $destination = Destination::with('accommodations')->findOrFail($destination);
            $destination->accommodations()->create([
                'name' => $request->accommodation
            ]);

            DB::commit();

            Alert::toast('Sukses Menambahkan Akomodasi', 'success');
            return redirect()->route(Auth::user()->role . '.destinations.edit', $destination);
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => 'Gagal Menambahkan Akomodasi: ' . $e->getMessage()]);
        }
    }

    public function storeFacility(Request $request, string $destination)
    {
        try {
            $request->validate([
                'facility' => 'required|string',
            ]);

            DB::beginTransaction();

            $destination = Destination::with('facilities')->findOrFail($destination);
            $destination->facilities()->create([
                'name' => $request->facility
            ]);

            DB::commit();

            Alert::toast('Sukses Menambahkan Fasilitas', 'success');
            return redirect()->route(Auth::user()->role . '.destinations.edit', $destination);
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => 'Gagal Menambahkan Fasilitas: ' . $e->getMessage()]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $slug)
    {
        $destination = Destination::with(['contactDetail', 'accommodations', 'facilities', 'openingHours', 'galleries'])->where('slug', $slug)->firstOrFail();
        $openingHours = $this->formatOpeningHours($destination->openingHours->toArray());

        // Increment the views count
        $destination->increment('views');
        return view('components.pages.frontend.detail-destination', compact('destination', 'openingHours'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $destination = Destination::with(['contactDetail', 'accommodations', 'facilities', 'openingHours', 'galleries'])->findOrFail($id);

        $openingHours = $this->formatOpeningHours($destination->openingHours->toArray());

        $title = 'Hapus Foto Destinasi!';
        $text = "Apakah Anda yakin ingin menghapus?";
        confirmDelete($title, $text);
        return view('components.pages.dashboard.admin.destination.edit', compact('destination', 'openingHours'));
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
    public function update(Request $request, string $destination)
    {
        try {
            DB::beginTransaction();

            $destination = Destination::findOrFail($destination);
            $oldName = $destination->name;

            $destination->update([
                'owner_id' => Auth::user()->id,
                'name' => $request->name_destination,
                'description' => $request->description,
                'location' => $request->location,
                'gmaps_url' => $request->gmaps_url,
                'price_range' => $request->price_range,
                'status' => $request->status,
                'slug' => $request->name_destination != $oldName ? Str::slug($request->name_destination . '-' . Str::ulid()) : $destination->slug
            ]);

            DB::commit();

            Alert::toast('Sukses Mengubah Destinasi', 'success');
            return redirect()->route(Auth::user()->role . '.destinations.edit', $destination);
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => 'Gagal Mengubah Destinasi: ' . $e->getMessage()]);
        }
    }

    public function updateOperational(Request $request, string $destination)
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

            $destination = Destination::with('openingHours')->findOrFail($destination);
            $destination->openingHours()->delete();

            $this->storeOpeningHours($request, $destination);

            DB::commit();

            Alert::toast('Sukses Mengubah Kontak', 'success');
            return redirect()->route(Auth::user()->role . '.destinations.edit', $destination);
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => 'Gagal Mengubah Kontak: ' . $e->getMessage()]);
        }
    }

    public function updateContactDetail(Request $request, string $destination)
    {
        try {
            $request->validate([
                'contact_details' => 'array',
                'contact_details.phone' => 'nullable|string|max:20',
                'contact_details.email' => 'nullable|string|max:50',
                'contact_details.social_media' => 'nullable|string|max:100',
            ]);

            DB::beginTransaction();

            $destination = Destination::with('contactDetail')->findOrFail($destination);
            $destination->contactDetail->update([
                "phone" => $request->input('contact_details.phone'),
                "email" => $request->input('contact_details.email'),
                "social_media" => $request->input('contact_details.social_media')
            ]);

            DB::commit();

            Alert::toast('Sukses Mengubah Kontak', 'success');
            return redirect()->route(Auth::user()->role . '.destinations.edit', $destination);
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => 'Gagal Mengubah Kontak: ' . $e->getMessage()]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Destination $destination)
    {
        // Load galleries relationship to ensure model event can access them
        $destination->load('galleries');
        $destination->delete();

        Alert::toast('Berhasil menghapus data destinasi', 'success');
        return redirect()->route(Auth::user()->role . '.destinations.index');
    }

    public function destroyGallery(string $destination, string $gallery)
    {
        $destination = Destination::with('galleries')->findOrFail($destination);
        $galleryItem = $destination->galleries()->findOrFail($gallery);

        $galleryItem->delete();

        Alert::toast('Berhasil menghapus data photo', 'success');
        return redirect()->route(Auth::user()->role . '.destinations.edit', $destination);
    }

    public function destroyFacility(string $destination, string $facility)
    {
        $destination = Destination::with('facilities')->findOrFail($destination);
        $destination->facilities()->findOrFail($facility)->delete();

        Alert::toast('Berhasil menghapus data fasilitas', 'success');
        return redirect()->route(Auth::user()->role . '.destinations.edit', $destination);
    }

    public function destroyAccommodation(string $destination, string $accommodation)
    {
        $destination = Destination::with('accommodations')->findOrFail($destination);
        $destination->accommodations()->findOrFail($accommodation)->delete();

        Alert::toast('Berhasil menghapus data akomodasi', 'success');
        return redirect()->route(Auth::user()->role . '.destinations.edit', $destination);
    }
}
