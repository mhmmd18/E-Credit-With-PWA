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
        $totalCicilan = Log::where('date', Carbon::now()->toDateString())->sum('credit');
        return view('logs.index', [
            'logs' => $logs,
            'totalCicilan' => $totalCicilan
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
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
        //
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
        $customer = Customer::where('id', $log->customer_id)->first();
        $current = Log::where('customer_id', $customer->id)->latest()->first();
        $totalCicilan = Log::where('customer_id', $customer->id)->sum('credit');
        return view('logs.edit', [
            'log' => $log,
            'customer' => $customer,
            'totalCicilan' => $totalCicilan,
            'current' => $current
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
        $request->credit = doubleval(str_replace('.', '', $request->credit));

        $totalCredit = Log::where('customer_id', $request->customer_id)->sum('credit');
        $jumlahHutang = Customer::find($request->customer_id)->debt;
        $sisaHutang = $jumlahHutang - ($totalCredit - doubleval($log->credit));

        if (isset($data[1]->id)) {
            if ($request->credit > $sisaHutang) {
                return redirect('/customers/log/' . $log->customer_id . '/edit')->with('failed', 'Jumlah cicilan melebihi hutang!');
            } elseif ($request->credit == $sisaHutang) {
                Customer::find($request->customer_id)->update([
                    'status' => 'Lunas',
                ]);
                Log::find($log->id)->update([
                    'credit' => $request->credit,
                ]);
                return redirect('/customers/' . $log->customer_id)->with('success', 'Hutang Lunas!');
            } elseif ($ambilNasabah->status == 'Lunas') {
                // dd('dd2');
                Customer::find($request->customer_id)->update([
                    'status' => 'Belum Lunas',
                ]);
                Log::find($log->id)->update([
                    'credit' => $request->credit,
                ]);
                return redirect('/customers/' . $log->customer_id)->with('success', 'Cicilan & Status berhasil diubah!');
            } else {
                Log::find($log->id)->update([
                    'credit' => $request->credit,
                ]);
                return redirect('/customers/' . $log->customer_id)->with('success', 'Cicilan berhasil diubah!');
            }
        } else {
            $customer = Customer::find($request->customer_id);
            if ($request->credit > $customer->debt) {
                return redirect('/customers/log/' . $log->customer_id . '/edit')->with('failed', 'Jumlah cicilan melebihi hutang!');
            } else {
                if ($customer->debt == $request->credit) {
                    Customer::find($request->customer_id)->update([
                        'status' => 'Lunas',
                    ]);
                    Log::find($log->id)->update([
                        'credit' => $request->credit,
                    ]);
                    return redirect('/customers/' . $log->customer_id)->with('success', 'Hutang Lunas!');
                } else if ($ambilNasabah->status == 'Lunas') {
                    Customer::find($request->customer_id)->update([
                        'status' => 'Belum Lunas',
                    ]);
                    Log::find($log->id)->update([
                        'credit' => $request->credit,
                    ]);
                    return redirect('/customers/' . $log->customer_id)->with('success', 'Cicilan & Status berhasil diubah!');
                }
                Log::find($log->id)->update([
                    'credit' => $request->credit,
                ]);
                return redirect('/customers/' . $log->customer_id)->with('success', 'Cicilan berhasil diubah!');
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
            return redirect('/customers/' . $log->customer_id)->with('success', 'Cicilan berhasil dihapus!');
        }
        Log::destroy($log->id);
        return redirect('/customers/' . $log->customer_id)->with('success', 'Cicilan berhasil dihapus!');
    }
}
