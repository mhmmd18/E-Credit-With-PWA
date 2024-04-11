<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Log;
use App\Models\Smoke;
use App\Models\Buyer;
use App\Models\User;
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
        $user = User::where('role_id', 2)->count();
        $rokok = Smoke::count();
        $eceranBelumLunas = Buyer::where('type', 'Eceran')->where('status', 'Belum Lunas')->count();
        $eceranLunas = Buyer::where('type', 'Eceran')->where('status', 'Lunas')->count();
        $bungkusanBelumLunas = Buyer::where('type', 'Bungkusan')->where('status', 'Belum Lunas')->count();
        $bungkusanLunas = Buyer::where('type', 'Bungkusan')->where('status', 'Lunas')->count();
        $totalHutang = Buyer::where('status', 'Belum Lunas')->sum('total');

        return view('dashboard', [
            'harianLunas' => $harianLunas,
            'harianBelumLunas' => $harianBelumLunas,
            'mingguanLunas' => $mingguanLunas,
            'mingguanBelumLunas' => $mingguanBelumLunas,
            'bulananLunas' => $bulananLunas,
            'bulananBelumLunas' => $bulananBelumLunas,
            'penghasilan' => $penghasilan,
            'user' => $user,
            'rokok' => $rokok,
            'eceranBelumLunas' => $eceranBelumLunas,
            'eceranLunas' => $eceranLunas,
            'bungkusanBelumLunas' => $bungkusanBelumLunas,
            'bungkusanLunas' => $bungkusanLunas,
            'totalHutang' => $totalHutang
        ]);
    }
}
