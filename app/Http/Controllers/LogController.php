<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Log;
use Carbon\Carbon;
use Illuminate\Http\Request;

class LogController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $logs = Log::latest()->with('customer')->where('date', Carbon::now()->toDateString())->paginate(5)->withQueryString();
        return view('logs.index', [
            'logs' => $logs,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // $data = Log::where('customer_id', $request->customer_id)->latest()->first();
        // dd($data->current_debt);
        $customers = Customer::where('status', 'Belum Lunas')->get();
        return view('logs.create', [
            'customers' => $customers,
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
            'customer_id' => 'required',
            'credit' => 'required',
        ]);

        $data = Log::where('customer_id', $request->customer_id)->latest()->first();
        // dd(isset($data));
        if (isset($data)) {
            if ($data->current_debt < $request->credit) {
                return redirect('/logs')->with('failed', 'Catatan gagal ditambah!');
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
                    return redirect('/logs')->with('success', 'Hutang Lunas!');
                }
                $sisa = $data->current_debt - $request->credit;
                Log::create([
                    'customer_id' => $request->customer_id,
                    'date' => Carbon::now()->toDateString(),
                    'credit' => $request->credit,
                    'current_debt' => $sisa,
                ]);
                return redirect('/logs')->with('success', 'Catatan berhasil ditambah!');
            }
        } else {
            // mngecek hutang < current
            $customer = Customer::find($request->customer_id);
            if ($request->credit > $customer->debt) {
                return redirect('/logs')->with('failed', 'Catatan gagal ditambah!');
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
                    return redirect('/logs')->with('success', 'Hutang Lunas!');
                }
                Log::create([
                    'customer_id' => $request->customer_id,
                    'date' => Carbon::now()->toDateString(),
                    'credit' => $request->credit,
                    'current_debt' => $customer->debt - $request->credit,
                ]);
                return redirect('/logs')->with('success', 'Catatan berhasil ditambah!');
            }
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Log  $log
     * @return \Illuminate\Http\Response
     */
    public function show(Log $log)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Log  $log
     * @return \Illuminate\Http\Response
     */
    public function edit(Log $log)
    {
        return view('logs.edit', [
            'log' => $log,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Log  $log
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Log $log)
    {
        $validated = $request->validate([
            'credit' => 'required',
        ]);
        $data = Log::where('customer_id', $request->customer_id)->latest()->get();
        $ambilNasabah = Customer::where('id', $request->customer_id)->first();
        // Jika bayar lebih besar dari sebelumnya
        if (isset($data[1]->id)) {
            if ($data[1]->current_debt < $request->credit) {
                return redirect('/customers/' . $log->customer_id)->with('failed', 'Catatan gagal diubah!');
            } else {
                if ($data[1]->current_debt == $request->credit) {
                    Customer::find($request->customer_id)->update([
                        'status' => 'Lunas',
                    ]);
                    Log::find($log->id)->update([
                        'credit' => $request->credit,
                        'current_debt' => $data[1]->current_debt - $request->credit,
                    ]);
                    return redirect('/customers/' . $log->customer_id)->with('success', 'Hutang Lunas!');
                } else if ($ambilNasabah->status == 'Lunas') {
                    Customer::find($request->customer_id)->update([
                        'status' => 'Belum Lunas',
                    ]);
                    Log::find($log->id)->update([
                        'credit' => $request->credit,
                        'current_debt' => $data[1]->current_debt - $request->credit,
                    ]);
                    return redirect('/customers/' . $log->customer_id)->with('success', 'Catatan berhasil diubahh!');
                }
                Log::find($log->id)->update([
                    'credit' => $request->credit,
                    'current_debt' => $data[1]->current_debt - $request->credit,
                ]);
                return redirect('/customers/' . $log->customer_id)->with('success', 'Catatan berhasil diubah!');
            }
        } else {
            // mngecek hutang < current
            $customer = Customer::find($request->customer_id);
            if ($request->credit > $customer->debt) {
                return redirect('/customers/' . $log->customer_id)->with('failed', 'Catatan gagal diubah!');
            } else {
                if ($customer->debt == $request->credit) {
                    Customer::find($request->customer_id)->update([
                        'status' => 'Lunas',
                    ]);
                    Log::find($log->id)->update([
                        'credit' => $request->credit,
                        'current_debt' => $customer->debt - $request->credit,
                    ]);
                    return redirect('/customers/' . $log->customer_id)->with('success', 'Hutang Lunas!');
                } else if ($ambilNasabah->status == 'Lunas') {
                    Customer::find($request->customer_id)->update([
                        'status' => 'Belum Lunas',
                    ]);
                    Log::find($log->id)->update([
                        'credit' => $request->credit,
                        'current_debt' => $customer->debt - $request->credit,
                    ]);
                    return redirect('/customers/' . $log->customer_id)->with('success', 'Catatan berhasil diubahh!');
                }
                Log::find($log->id)->update([
                    'credit' => $request->credit,
                    'current_debt' => $customer->debt - $request->credit,
                ]);
                return redirect('/customers/' . $log->customer_id)->with('success', 'Catatan berhasil diubah!');
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Log  $log
     * @return \Illuminate\Http\Response
     */
    public function destroy(Log $log)
    {
        if ($log->customer->status == 'Lunas') {
            Customer::where('id', $log->customer_id)->update(['status' => 'Belum Lunas']);
            Log::destroy($log->id);
            return redirect('/customers/' . $log->customer_id)->with('success', 'Catatan berhasil di hapus!');
        }
        Log::destroy($log->id);
        return redirect('/customers/' . $log->customer_id)->with('success', 'Catatan berhasil di hapus!');
    }
    // public function soft()
    // {
    //     $logs = Log::onlyTrashed()->get();
    //     // dd($logs);
    //     return view('logs.delete', [
    //         'logs' => $logs,
    //     ]);
    // }
    // public function restore($id)
    // {
    //     $logs = Log::onlyTrashed()->where('id', $id)->restore();
    //     return redirect('/logs')->with('success', 'Catatan berhasil dikembalikan!');
    // }
}
