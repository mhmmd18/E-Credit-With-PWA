<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Log;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $harianLunas = Customer::where('type', 'Harian')->where('status', 'Lunas')->count();
        $harianBelumLunas = Customer::where('type', 'Harian')->where('status', 'Belum Lunas')->count();
        $mingguanLunas = Customer::where('type', 'Mingguan')->where('status', 'Lunas')->count();
        $mingguanBelumLunas = Customer::where('type', 'Mingguan')->where('status', 'Belum Lunas')->count();
        $bulananLunas = Customer::where('type', 'Bulanan')->where('status', 'Lunas')->count();
        $bulananBelumLunas = Customer::where('type', 'Bulanan')->where('status', 'Belum Lunas')->count();
        $penghasilan = Log::where('date', Carbon::now()->toDateString())->sum('credit');

        return view('dashboard', [
            'harianLunas' => $harianLunas,
            'harianBelumLunas' => $harianBelumLunas,
            'mingguanLunas' => $mingguanLunas,
            'mingguanBelumLunas' => $mingguanBelumLunas,
            'bulananLunas' => $bulananLunas,
            'bulananBelumLunas' => $bulananBelumLunas,
            'penghasilan' => $penghasilan,
        ]);
    }
}
