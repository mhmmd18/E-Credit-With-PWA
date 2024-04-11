<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Smoke;

class SmokeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $perPage = 5; // Jumlah data per halaman
        $smokes = Smoke::latest();
        // search
        if ($request->name) {
            $smokes->where('name', 'LIKE', '%' . $request->name . '%');
        }

        // Ambil query string 'page' dari request
        $currentPage = $request->query('page', 1);

        // Hitung nomor awal untuk data pada halaman saat ini
        $startNumber = ($currentPage - 1) * $perPage + 1;

        // Ambil data Smoke yang diurutkan berdasarkan tanggal pembuatan terbaru
        $smokes = $smokes->paginate($perPage)->withQueryString();

        // Jika halaman saat ini bukan halaman pertama, atur nomor awal berdasarkan halaman dan jumlah data per halaman
        if ($currentPage > 1) {
            $startNumber = ($currentPage - 1) * $perPage + 1;
        }

        return view('smokes.index', [
            'smokes' => $smokes,
            'startNumber' => $startNumber // Kirimkan startNumber ke view
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('smokes.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|unique:smokes',
            // 'unit_price' => 'max:255',
            'price' => 'required',
        ]);
        $request['price'] = str_replace('.', '', $request->price);

        if ($request->unit_price != null) {
            $request['unit_price'] = str_replace('.', '', $request->unit_price);
        }else{
            $request['unit_price'] = 0;
        }

        Smoke::create($request->all());
        return redirect('/smokes')->with('success', 'Data rokok berhasil ditambah!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Log  $log
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Log  $log
     * @return \Illuminate\Http\Response
     */
    public function edit(Smoke $smoke)
    {
        return view('smokes.edit', [
            'smoke' => $smoke,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Log  $log
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Smoke $smoke)
    {
        $rules = [
            // 'unit_price' => 'max:255',
            'price' => 'required',
        ];
        $request['price'] = str_replace('.', '', $request->price);

        if ($request->unit_price != null) {
            $request['unit_price'] = str_replace('.', '', $request->unit_price);
        }else{
            $request['unit_price'] = 0;
        }

        if ($request->name != $smoke->name) {
            $rules['name'] = 'required|unique:smokes';
        }
        $validatedData = $request->validate($rules);
        Smoke::where('id', $smoke->id)
            ->update($validatedData);
        return redirect('/smokes')->with('success', 'Data rokok berhasil diubah!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Log  $log
     * @return \Illuminate\Http\Response
     */
    public function destroy(Smoke $smoke)
    {
        Smoke::destroy($smoke->id);
        return redirect('/smokes')->with('success', 'Data rokok berhasil dihapus!');
    }
}
