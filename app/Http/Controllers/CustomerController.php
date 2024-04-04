<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Log;
use Carbon\Carbon;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    // public function index(Request $request)
    // {
    //     $customers = Customer::latest();
    //     if ($request->address || $request->type || $request->name) {
    //         $customers->where('address', 'LIKE', '%' . $request->address . '%')
    //             ->where('type', 'LIKE', '%' . $request->type . '%')
    //             ->where('name', 'LIKE', '%' . $request->name . '%');
    //     }
    //     return view('customers.index', [
    //         'customers' => $customers->paginate(5)->withQueryString(),
    //     ]);
    // }
    // public function pending(Request $request, $type)
    // {
    //     $paymentInfo = [];
    //     $customers = Customer::latest()->where('type', $type)->where('status', 'Belum Lunas');
        
    //     if ($request->address || $request->name) {
    //         $customers->where('address', 'LIKE', '%' . $request->address . '%')
    //         ->where('name', 'LIKE', '%' . $request->name . '%');
    //     }
    //     // $customers = $customers->paginate(5)->withQueryString()->appends(request()->query());
    //     $page = ($customers->currentPage() - 1) * $customers->perPage() + 1;
    //     $customers = $customers->paginate(5)->withQueryString()->withPath('/customers')->setPageName('page')->appends(request()->query());
    //     $customers->setPath('/customers?page=' . $page);
    //     // Memeriksa apakah pembayaran telah dilakukan untuk setiap pelanggan
    //     foreach ($customers as $customer) {
    //         $isPay = Log::where('date', Carbon::now()->toDateString())
    //                 ->where('customer_id', $customer->id)
    //                 ->exists();
    //         $paymentInfo[$customer->id] = $isPay;
    //     }   
    //     return view('customers.index', [
    //         'customers' => $customers,
    //         'type' => $type,
    //         'paymentInfo' => $paymentInfo
    //     ]);
    // }
    public function pending(Request $request, $type)
    {
        $paymentInfo = [];
        $perPage = 5;
        $customers = Customer::latest()->where('type', $type)->where('status', 'Belum Lunas');

        if ($request->address || $request->name) {
            $customers->where('address', 'LIKE', '%' . $request->address . '%')
                    ->where('name', 'LIKE', '%' . $request->name . '%');
        }

        // Menambahkan nomor halaman saat ini ke dalam query string jika belum ada
        $currentPage = $request->has('page') ? $request->page : 1;
        $page = ($currentPage - 1) * $perPage + 1;

        $customers = $customers->paginate($perPage)->withQueryString()->withPath("/customers/list/" . $type)->setPageName('page')->appends(request()->query());
        // Memeriksa apakah pembayaran telah dilakukan untuk setiap pelanggan
        foreach ($customers as $customer) {
            $isPay = Log::where('date', Carbon::now()->toDateString())
                        ->where('customer_id', $customer->id)
                        ->exists();
            $paymentInfo[$customer->id] = $isPay;
        }   
        // Jika halaman saat ini tidak kosong, atur jalur paginasi ke halaman berikutnya
        if ($page > 1) {
            $customers->setPath("/customers/list/" . $type . "?page=$page");
        }
        return view('customers.index', [
            'customers' => $customers,
            'type' => $type,
            'paymentInfo' => $paymentInfo
        ]);
    }


    public function lunas(Request $request, $type)
    {
        $perPage = 5;
        $customers = Customer::latest()->where('type', $type)->where('status', 'Lunas');

        if ($request->address || $request->name) {
            $customers->where('address', 'LIKE', '%' . $request->address . '%')
                ->where('name', 'LIKE', '%' . $request->name . '%');
        }
        // Menambahkan nomor halaman saat ini ke dalam query string jika belum ada
        $currentPage = $request->has('page') ? $request->page : 1;
        $page = ($currentPage - 1) * $perPage + 1;

        $customers = $customers->paginate($perPage)->withQueryString()->withPath("/customers/list/" . $type . '/lunas')->setPageName('page')->appends(request()->query());
        // Jika halaman saat ini tidak kosong, atur jalur paginasi ke halaman berikutnya
        if ($page > 1) {
            $customers->setPath("/customers/list/" . $type . "/lunas?page=$page");
        }
        return view('customers.lunas', [
            'customers' => $customers,
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
        return view('customers.create');
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
            'name' => 'required|unique:customers',
            'gender' => 'required',
            'address' => 'required',
            'type' => 'required',
            'debt' => 'required',
        ]);
        $request['debt'] = str_replace('.', '', $request->debt);
        $customer = Customer::create($request->all());

        return redirect($request->type == 'Harian' ? '/customers/list/Harian' : ($request->type == 'Mingguan' ? '/customers/list/Mingguan' : '/customers/list/Bulanan'))->with('success', 'Data nasabah berhasil ditambah!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    // public function show(Customer $customer)
    // {
    //     $logs = Log::latest()->with('customer')->where('customer_id', $customer->id)->paginate(5)->withQueryString();
    //     $totalCicilan = Log::where('customer_id', $customer->id)->sum('credit');
    //     $isPath = '/customers/' . $customer->id;
    //     return view('customers.show', [
    //         'customer' => $customer,
    //         'logs' => $logs,
    //         'totalCicilan' => $totalCicilan,
    //         'isPath' => $isPath
    //     ]);
    // }
    public function show(Customer $customer)
    {
        $perPage = 5; // Jumlah item per halaman
        $logs = Log::latest()->with('customer')->where('customer_id', $customer->id)->paginate($perPage)->withQueryString();

        // Menghitung nomor urut pertama pada halaman saat ini
        $startIndex = ($logs->firstItem() - 1);
        // Menghitung nomor urut terakhir pada halaman saat ini
        $endIndex = min($startIndex + $perPage - 1, $logs->total());
        // Menentukan jalur paginasi
        $isPath = '/customers/' . $customer->id . '?page=' . ceil($endIndex / $perPage);
        $totalCicilan = Log::where('customer_id', $customer->id)->sum('credit');
        return view('customers.show', [
            'customer' => $customer,
            'logs' => $logs,
            'totalCicilan' => $totalCicilan,
            'isPath' => $isPath
        ]);
    }                                       
    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function edit(Customer $customer)
    {
        return view('customers.edit', [
            'customer' => $customer,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Customer $customer)
    {
        $rules = [
            'gender' => 'required',
            'address' => 'required',
            'phone' => 'max:12',
            'type' => 'required',
            'debt' => 'required',
            'items' => 'max:255',
        ];
        $request['debt'] = str_replace('.', '', $request->debt);
        $totalCicilan = Log::where('customer_id', $customer->id)->sum('credit');
        if ($request->name != $customer->name) {
            $rules['name'] = 'required|unique:customers';
        } elseif (doubleval($request->debt) < $totalCicilan) {
            return redirect('/customers/' . $customer->id . '/edit')->with('failed', 'Hutang kurang dari total cicilan!');
        } elseif (doubleval($request->debt) == $totalCicilan) {
            $validatedData = $request->validate($rules);
            Customer::where('id', $customer->id)
                ->update([
                    'status' => 'Lunas',
                ] + $validatedData);
            return redirect($request->type == 'Harian' ? '/customers/list/Harian' : ($request->type == 'Mingguan' ? '/customers/list/Mingguan' : '/customers/list/Bulanan'))->with('success', 'Status nasabah menjadi lunas!');
        } elseif (doubleval($request->debt) > $totalCicilan && $customer->status == 'Lunas') {
            $validatedData = $request->validate($rules);
            Customer::where('id', $customer->id)
                ->update([
                    'status' => 'Belum Lunas',
                ] + $validatedData);
            return redirect($request->type == 'Harian' ? '/customers/list/Harian' : ($request->type == 'Mingguan' ? '/customers/list/Mingguan' : '/customers/list/Bulanan'))->with('success', 'Status nasabah menjadi belum lunas!');
        }
        $validatedData = $request->validate($rules);
        Customer::where('id', $customer->id)
            ->update($validatedData);
        return redirect($request->type == 'Harian' ? '/customers/list/Harian' : ($request->type == 'Mingguan' ? '/customers/list/Mingguan' : '/customers/list/Bulanan'))->with('success', 'Data nasabah berhasil diubah!');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function destroy(Customer $customer)
    {
        Customer::destroy($customer->id);
        Log::where('customer_id', $customer->id)->delete();
        return redirect($customer->type == 'Harian' ? '/customers/list/Harian' : ($customer->type == 'Mingguan' ? '/customers/list/Mingguan' : '/customers/list/Bulanan'))->with('success', 'Data nasabah berhasil dihapus!');
    }
    public function createLog(Customer $customer)
    {
        // ambil current debt
        $current = Log::where('customer_id', $customer->id)->latest()->first();
        $totalCicilan = Log::where('customer_id', $customer->id)->sum('credit');
        return view('customers.createLog', [
            'customer' => $customer,
            'current' => $current,
            'totalCicilan' => $totalCicilan
        ]);
    }

    public function storeLog(Request $request)
    {
        $validated = $request->validate([
            'customer_id' => 'required',
            'credit' => 'required',
        ]);
        $data = Log::where('customer_id', $request->customer_id)->latest()->first();
        $request->credit = doubleval(str_replace('.', '', $request->credit));
        // Menghitung total kredit dari log
        $totalCicilan = Log::where('customer_id', $request->customer_id)->sum('credit');
        $jumlahHutang = Customer::find($request->customer_id)->debt;
        $sisaHutang = $jumlahHutang - $totalCicilan;

        if (isset($data)) {
            // Mengecek apakah total kredit lebih besar dari kredit yang diminta
            if ($sisaHutang < $request->credit) {
                return redirect('/customers/log/' . $data->customer_id)->with('failed', 'Jumlah cicilan melebihi hutang!');
            } else {
                // Melunasi hutang jika total kredit sama dengan kredit yang diminta
                if ($sisaHutang == $request->credit) {
                    Customer::find($request->customer_id)->update([
                        'status' => 'Lunas',
                    ]);
                    Log::create([
                        'customer_id' => $request->customer_id,
                        'date' => Carbon::now()->toDateString(),
                        'credit' => $request->credit,
                    ]);
                    return redirect('/customers/' . $data->customer_id)->with('success', 'Hutang Lunas!');
                }
                // Membuat catatan log baru dengan jumlah kredit yang diminta
                Log::create([
                    'customer_id' => $request->customer_id,
                    'date' => Carbon::now()->toDateString(),
                    'credit' => $request->credit,
                ]);
                return redirect('/customers/' . $data->customer_id)->with('success', 'Cicilan berhasil ditambah!');
            }
        } else {
            // Mngecek apakah hutang kurang dari total kredit
            $customer = Customer::find($request->customer_id);

            if ($request->credit > $customer->debt) {
                return redirect('/customers/log/' . $customer->id)->with('failed', 'Jumlah cicilan melebihi hutang!');
            } else {
                // Melunasi hutang jika total kredit sama dengan hutang pelanggan
                if ($customer->debt == $request->credit) {
                    Customer::find($request->customer_id)->update([
                        'status' => 'Lunas',
                    ]);
                    Log::create([
                        'customer_id' => $request->customer_id,
                        'date' => Carbon::now()->toDateString(),
                        'credit' => $request->credit,
                    ]);
                    return redirect('/customers/' . $customer->id)->with('success', 'Hutang Lunas!');
                }
                // Membuat catatan log baru dengan jumlah kredit yang diminta
                Log::create([
                    'customer_id' => $request->customer_id,
                    'date' => Carbon::now()->toDateString(),
                    'credit' => $request->credit,
                ]);
                return redirect('/customers/' . $customer->id)->with('success', 'Cicilan berhasil ditambah!');
            }
        }
    }
}
