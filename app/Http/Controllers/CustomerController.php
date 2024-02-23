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
    public function pending(Request $request, $type)
    {
        $customers = Customer::latest()->where('type', $type)->where('status', 'Belum Lunas');
        if ($request->address || $request->name) {
            $customers->where('address', 'LIKE', '%' . $request->address . '%')
                ->where('name', 'LIKE', '%' . $request->name . '%');
        }
        return view('customers.index', [
            'customers' => $customers->paginate(5)->withQueryString(),
            'type' => $type,
        ]);
    }
    public function lunas(Request $request, $type)
    {
        $customers = Customer::latest()->where('type', $type)->where('status', 'Lunas');
        if ($request->address || $request->name) {
            $customers->where('address', 'LIKE', '%' . $request->address . '%')
                ->where('name', 'LIKE', '%' . $request->name . '%');
        }
        return view('customers.lunas', [
            'customers' => $customers->paginate(5)->withQueryString(),
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
        $customer = Customer::create($request->all());
        return redirect($request->type == 'Harian' ? '/customers/list/Harian' : ($request->type == 'Mingguan' ? '/customers/list/Mingguan' : '/customers/list/Bulanan'))->with('success', 'Nasabah berhasil ditambah!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function show(Customer $customer)
    {
        $logs = Log::latest()->with('customer')->where('customer_id', $customer->id)->paginate(5)->withQueryString();
        return view('customers.show', [
            'customer' => $customer,
            'logs' => $logs,
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
        ];
        if ($request->name != $customer->name) {
            $rules['name'] = 'required|unique:customers';
        }
        $validatedData = $request->validate($rules, $messages);
        Customer::where('id', $customer->id)
            ->update($validatedData);
        return redirect($request->type == 'Harian' ? '/customers/list/Harian' : ($request->type == 'Mingguan' ? '/customers/list/Mingguan' : '/customers/list/Bulanan'))->with('success', 'Nasabah berhasil diubah!');

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
        return redirect($customer->type == 'Harian' ? '/customers/list/Harian' : ($customer->type == 'Mingguan' ? '/customers/list/Mingguan' : '/customers/list/Bulanan'))->with('success', 'Nasabah berhasil dihapus!');
    }
    public function createLog(Customer $customer)
    {
        // ambil current debt
        $current = Log::where('customer_id', $customer->id)->latest()->first();
        return view('customers.createLog', [
            'customer' => $customer,
            'current' => $current,
        ]);
    }

    public function storeLog(Request $request)
    {
        $validated = $request->validate([
            'customer_id' => 'required',
            'credit' => 'required',
        ]);

        $data = Log::where('customer_id', $request->customer_id)->latest()->first();
        // dd(isset($data));
        if (isset($data)) {
            if ($data->current_debt < $request->credit) {
                // ambil customer_id buat redirect
                // dd($cus->id);
                return redirect('/customers/' . $data->customer_id)->with('failed', 'Catatan gagal ditambah!');
            } else {
                if ($data->current_debt == $request->credit) {
                    Customer::find($request->customer_id)->update([
                        'status' => 'Lunas',
                    ]);
                    $sisa = $data->current_debt - $request->credit;
                    Log::create([
                        'customer_id' => $request->customer_id,
                        'date' => Carbon::now()->toDateString(),
                        'credit' => $request->credit,
                        'current_debt' => $sisa,
                    ]);
                    return redirect('/customers/' . $data->customer_id)->with('success', 'Hutang Lunas!');
                }
                $sisa = $data->current_debt - $request->credit;
                Log::create([
                    'customer_id' => $request->customer_id,
                    'date' => Carbon::now()->toDateString(),
                    'credit' => $request->credit,
                    'current_debt' => $sisa,
                ]);
                return redirect('/customers/' . $data->customer_id)->with('success', 'Catatan berhasil ditambah!');
            }
        } else {
            // mngecek hutang < current
            $customer = Customer::find($request->customer_id);
            if ($request->credit > $customer->debt) {
                return redirect('/customers/' . $customer->id)->with('failed', 'Catatan gagal ditambah!');
            } else {
                if ($customer->debt == $request->credit) {
                    Customer::find($request->customer_id)->update([
                        'status' => 'Lunas',
                    ]);
                    Log::create([
                        'customer_id' => $request->customer_id,
                        'date' => Carbon::now()->toDateString(),
                        'credit' => $request->credit,
                        'current_debt' => $customer->debt - $request->credit,
                    ]);
                    return redirect('/customers/' . $customer->id)->with('success', 'Hutang Lunas!');
                }
                Log::create([
                    'customer_id' => $request->customer_id,
                    'date' => Carbon::now()->toDateString(),
                    'credit' => $request->credit,
                    'current_debt' => $customer->debt - $request->credit,
                ]);
                return redirect('/customers/' . $customer->id)->with('success', 'Catatan berhasil ditambah!');
            }
        }
    }
    // public function soft()
    // {
    //     $customers = Customer::onlyTrashed()->get();
    //     // dd($customers);
    //     return view('customers.delete', [
    //         'customers' => $customers,
    //     ]);
    // }
    // public function restore($id)
    // {
    //     Customer::onlyTrashed()->where('id', $id)->where('type')->restore();
    //     return redirect('/customers');
    // }
    // public function status($id)
    // {
    //     $customer = Customer::where('id', $id)->first();
    //     $status_sekarang = $customer->status;
    //     if ($status_sekarang = 'Belum Lunas') {
    //         Customer::where('id', $id)->update(['status' => 'Lunas']);
    //         return redirect('/customers')->with('success', 'Nasabah berhasil diubah');
    //     }
    // }
}
