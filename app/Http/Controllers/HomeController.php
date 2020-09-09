<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Income_money;
use Illuminate\Support\Facades\DB;
use App\Models\Category;
use Khill\Lavacharts\Lavacharts;
use Carbon\Carbon;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $now_date = Carbon::now();
        $now_month = $now_date->month;
        $all = Income_money::all();
        $now = [];
        $now_1 = []; //先月
        $now_2 = []; //先々月
        foreach ($all as $income) {
            $d = $income->date;
            $m = strtotime($d);
            $month = idate('m', $m);
            //var_dump($month);
            if ($month === $now_month) {
                $now[] = $income->money;
            }
        }
        $back_date = $now_date->month - 1;
        foreach ($all as $income) {
            $d = $income->date;
            $m = strtotime($d);
            $month = idate('m', $m);
            //var_dump($month);
            if ($month === $back_date) {
                $now_1[] = $income->money;
            }
        }
        $back_date_2 = $now_date->month - 2;
        foreach ($all as $income) {
            $d = $income->date;
            $m = strtotime($d);
            $month = idate('m', $m);
            //var_dump($month);
            if ($month === $back_date_2) {
                $now_2[] = $income->money;
            }
        }
        $sum = array_sum($now); //今月
        $sum_1 = array_sum($now_1); //先月
        $sum_2 = array_sum($now_2); //先々月

        var_dump($now_1);
        $lava = new Lavacharts;

        $reasons = $lava->DataTable();

        $reasons->addStringColumn("Reasons")
            ->addNumberColumn("￥") //題名
            ->addRow(array($now_month - 2 . '月', $sum_2))
            ->addRow(array($now_month - 1 . '月', $sum_1))
            ->addRow(array('今月', $sum));




        $columnchart = $lava->ColumnChart("IMDB", $reasons, [
            "title" => "収入" . "\n" . $now_month . '月' . '合計' . $sum . '円 ',
            'height' => 500,
            'width' => 1000,
            'titleTextStyle' => [
                'color'    => 'gray',
                'fontSize' => 34
            ]
        ]);



        return view('income_moneys.month', ["lava"      => $lava], compact('sum'));
    }
}
