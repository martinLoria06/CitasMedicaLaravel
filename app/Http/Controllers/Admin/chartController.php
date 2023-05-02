<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Appoinment;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class chartController extends Controller
{
    public function appointments()
    {

        $monthCounts =  Appoinment::select(
            DB::raw('MONTH(created_at) as month'),
            DB::raw('COUNT(1) as count')
        )
            ->groupBy('month')
            ->get()
            ->toArray();
        $counts = array_fill(0, 12, 0);
        foreach ($monthCounts as $monthCount) {
            $index = $monthCount['month'] - 1;
            $counts[$index] = $monthCount['count'];
        }

        // dd($counts);

        return view('charts.appointments', compact('counts'));
    }

    public function doctors()
    {
        return view('charts.doctors');
    }

    public function doctorsJson()
    {
        $doctors = User::doctors()
            ->select('name')
            ->withCount(['attendedAppoinments','cancellAppoinments'])
            ->orderBy('attended_appoinments_count','desc')
            ->take(5)
            ->get();
            // ->toArray();

            $data = [];
            $data['categories'] = $doctors->pluck('name');

            $series = [];
            $series1['name'] = 'Citas atendidas';
            $series1['data'] = $doctors->pluck('attended_appoinments_count');
            $series2['name'] = 'Citas canceladas';
            $series2['data'] =  $doctors->pluck('cancell_appoinments_count');

            $series[] = $series1;
            $series[] = $series2;
            $data['series'] = $series;

            return $data;
    }
}
