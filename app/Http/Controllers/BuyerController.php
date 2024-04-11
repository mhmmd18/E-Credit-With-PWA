<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Buyer;
use App\Models\Smoke;

class BuyerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function pending(Request $request, $type, Buyer $buyer)
    {
        $perPage = 5;
        $buyers = Buyer::latest()->with('smoke')->where('type', $type)->where('status', 'Belum Lunas');

        if ($request->created_at || $request->name) {
            $buyers->where('created_at', 'LIKE', '%' . $request->created_at . '%')
                    ->where('name', 'LIKE', '%' . $request->name . '%');
        }

        // Menambahkan nomor halaman saat ini ke dalam query string jika belum ada
        $currentPage = $request->has('page') ? $request->page : 1;
        $page = ($currentPage - 1) * $perPage + 1;

        $buyers = $buyers->paginate($perPage)->withQueryString()->withPath("/buyers/list/" . $type)->setPageName('page')->appends(request()->query());  
        // Jika halaman saat ini tidak kosong, atur jalur paginasi ke halaman berikutnya
        if ($page > 1) {
            $buyers->setPath("/buyers/list/" . $type . "?page=$page");
        }
        return view('buyers.index', [
            'buyers' => $buyers,
            'type' => $type,
        ]);
    }

    public function lunas(Request $request, $type)
    {
        $perPage = 5;
        $buyers = Buyer::latest()->with('smoke')->where('type', $type)->where('status', 'Lunas');

        if ($request->created_at || $request->name) {
            $buyers->where('created_at', 'LIKE', '%' . $request->created_at . '%')
                    ->where('name', 'LIKE', '%' . $request->name . '%');
        }
        // Menambahkan nomor halaman saat ini ke dalam query string jika belum ada
        $currentPage = $request->has('page') ? $request->page : 1;
        $page = ($currentPage - 1) * $perPage + 1;

        $buyers = $buyers->paginate($perPage)->withQueryString()->withPath("/buyers/list/" . $type . '/lunas')->setPageName('page')->appends(request()->query());
        // Jika halaman saat ini tidak kosong, atur jalur paginasi ke halaman berikutnya
        if ($page > 1) {
            $buyers->setPath("/buyers/list/" . $type . "/lunas?page=$page");
        }
        return view('buyers.lunas', [
            'buyers' => $buyers,
            'type' => $type,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $smokes = Smoke::all();
        return view('buyers.create',[
            'smokes' => $smokes
        ]);
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
            'smoke_id' => 'required',
            'name' => 'required|unique:buyers',
            'type' => 'required',
            'qty' => 'required',
            'total' => 'required',
        ]);
        $request['total'] = str_replace('.', '', $request->total);
        Buyer::create($request->all());
        return redirect($request->type == 'Eceran' ? '/buyers/list/Eceran'  : '/buyers/list/Bungkusan')->with('success', 'Data pembeli berhasil ditambah!');
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\Buyer  $buyer
     * @return \Illuminate\Http\Response
     */
    public function show(Buyer $buyer)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\Buyer  $buyer
     * @return \Illuminate\Http\Response
     */
    public function edit(Buyer $buyer)
    {
        $smokes = Smoke::all();
        return view('buyers.edit', [
            'buyer' => $buyer,
            'smokes' => $smokes
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param \App\Models\Buyer  $buyer
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Buyer $buyer)
    {
        $rules = [
            'smoke_id' => 'required',
            'type' => 'required',
            'qty' => 'required',
        ];
        $request['total'] = str_replace('.', '', $request->total);
        if ($request->name != $buyer->name) {
            $rules['name'] = 'required|unique:buyers';
        }
        $validatedData = $request->validate($rules);
        Buyer::where('id', $buyer->id)
            ->update($validatedData);
        return redirect($request->type == 'Eceran' ? '/buyers/list/Eceran'  : '/buyers/list/Bungkusan')->with('success', 'Data pembeli berhasil diubah!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Buyer  $buyer
     * @return \Illuminate\Http\Response
     */
    public function destroy(Buyer $buyer)
    {
        Buyer::destroy($buyer->id);
        return redirect($buyer->type == 'Eceran' ? '/buyers/list/Eceran'  : '/buyers/list/Bungkusan')->with('success', 'Data pembeli berhasil dihapus!');
    }

    public function confirm(Buyer $buyer)
    {
        Buyer::where('id', $buyer->id)
            ->update(['status' => 'Lunas']);
        return redirect($buyer->type == 'Eceran' ? '/buyers/list/Eceran/lunas'  : '/buyers/list/Bungkusan/lunas')->with('success', 'Status pembeli berhasil diubah!');
    }

    public function reports(Request $request, Buyer $buyer)
    {
        $perPage = 5;
        $query = Buyer::latest()->with('smoke')->where('status', 'Belum Lunas');
        $totalHutang = $query->sum('total');

        if ($request->created_at || $request->name) {
            $query->where('created_at', 'LIKE', '%' . $request->created_at . '%')
                ->where('name', 'LIKE', '%' . $request->name . '%');
        }

        $buyers = $query->paginate($perPage)->withQueryString()->withPath("/reports")->setPageName('page')->appends(request()->query());

        // Jika halaman saat ini tidak kosong, atur jalur paginasi ke halaman berikutnya
        $currentPage = $request->has('page') ? $request->page : 1;
        $page = ($currentPage - 1) * $perPage + 1;

        if ($page > 1) {
            $buyers->setPath("/reports?page=$page");
        }

        return view('buyers.reports', [
            'buyers' => $buyers,
            'totalHutang' => $totalHutang
        ]);                                             

    }
}
