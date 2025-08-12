<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\GambarArticle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;
use App\Http\Requests\ArticleCreateRequest;
use Illuminate\Support\Facades\Auth;

class ArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function index()
    {
        // Mengecek apakah permintaan yang diterima adalah permintaan AJAX
        if (request()->ajax()) {
            // Membuat query untuk model article
            $article = Article::with('user');

            // Jika pengguna memiliki peran 'writer', filter data berdasarkan author_id pengguna saat ini
            if (Auth::user()->role === 'writer') {
                $article->where('author_id', Auth::user()->id);
            }

            // Mengurutkan data berdasarkan yang terbaru
            $article->get();

            // Mengembalikan data dalam format DataTables
            return DataTables::of($article)
                ->addColumn('writer', function ($item) {
                    return $item->user ? $item->user->name : 'Tidak ada penulis'; // Ganti 'name' dengan atribut penulis yang sesuai
                })
                // Menambahkan kolom aksi untuk setiap item
                ->addColumn('action', function ($item) {
                    $roleName = Auth::user()->role;
                    $editUrl = route($roleName . '.articles.edit', $item->id);
                    $deleteUrl = route($roleName . '.articles.destroy', $item->id);


                    // Membuat tombol edit dan hapus untuk setiap item
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

        // Jika bukan permintaan AJAX, mengembalikan view untuk halaman dashboard
        return view('components.pages.dashboard.admin.article.index');
    }



    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('components.pages.dashboard.admin.article.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ArticleCreateRequest $request)
    {
        try {
            DB::beginTransaction();

            $article = $this->createArticle($request);
            $this->storeGambars($request, $article);

            DB::commit();

            Alert::toast('Sukses Menambahkan Artikel', 'success');
            return redirect()->route(Auth::user()->role . '.articles.index');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => 'Gagal Menambahkan Artikel: ' . $e->getMessage()]);
        }
    }


    private function createArticle($request)
    {
        return Article::create([
            'author_id' => Auth::user()->id,
            'title' => $request->title,
            'content' => $request->content,
            'slug' => Str::slug($request->title . '-' . Str::ulid())
        ]);
    }

    private function storeGambars($request, $article)
    {
        $photos = $request->file('gambar_articles');
        foreach ($photos as $photo) {
            $path = $photo->storePublicly("gambar_article", "public");
            GambarArticle::create([
                'article_id' => $article->id,
                'image_url' => $path,
            ]);
        }
    }

    public function addGambar(Request $request, string $article)
    {
        try {
            $request->validate([
                'gambar_articles.*' => 'required|image|mimes:jpeg,png,jpg|max:4146|',
            ]);

            DB::beginTransaction();

            $article = Article::with('gambar_articles')->findOrFail($article);
            $this->storeGambars($request, $article);

            DB::commit();

            Alert::toast('Sukses Menambahkan Photo', 'success');
            return redirect()->route(Auth::user()->role . '.articles.edit', $article);
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
        $article = Article::with(['user', "gambar_articles"])->where('slug', $slug)->firstOrFail();
        // Increment the views count
        $article->increment('views');
        return view('components.pages.frontend.detail-article', compact('article'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $article =  Article::with(["gambar_articles"])->findOrFail($id);

        $title = 'Hapus Foto Artikel!';
        $text = "Apakah Anda yakin ingin menghapus?";
        confirmDelete($title, $text);
        return view('components.pages.dashboard.admin.article.edit', compact('article'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            DB::beginTransaction();

            $article = Article::findOrFail($id);
            $oldTitle = $article->title;

            $article->update([
                'author_id' => Auth::user()->id,
                'title' => $request->title,
                'content' => $request->content,
                'slug' => $request->title != $oldTitle ? Str::slug($request->title . '-' . Str::ulid()) : $article->slug
            ]);

            DB::commit();

            Alert::toast('Sukses Mengubah Artikel', 'success');
            return redirect()->route(Auth::user()->role . '.articles.index');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => 'Gagal Mengubah Artikel: ' . $e->getMessage()]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Article $article)
    {
        // Load gambar_articles relationship to ensure model event can access them
        $article->load('gambar_articles');
        $article->delete();
        Alert::toast('Sukses Menghapus Artikel', 'success');
        return redirect()->route(Auth::user()->role . '.articles.index');
    }

    public function destroyGambar(string $article, string $gambar_article)
    {
        try {
            DB::beginTransaction();

            $article = Article::with('gambar_articles')->findOrFail($article);
            $gambarItem = $article->gambar_articles()->findOrFail($gambar_article);

            // Check if this is the last image (optional - you can remove this if you want to allow deleting all images)
            if ($article->gambar_articles->count() <= 1) {
                Alert::toast('Tidak dapat menghapus foto. Setidaknya harus ada 1 foto untuk artikel.', 'error');
                return redirect()->route(Auth::user()->role . '.articles.edit', $article);
            }

            $gambarItem->delete();

            DB::commit();

            Alert::toast('Berhasil menghapus foto artikel', 'success');
            return redirect()->route(Auth::user()->role . '.articles.edit', $article);
        } catch (\Exception $e) {
            DB::rollBack();
            Alert::toast('Gagal menghapus foto: ' . $e->getMessage(), 'error');
            return redirect()->route(Auth::user()->role . '.articles.edit', $article);
        }
    }
}
