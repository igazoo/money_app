<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Income_money;
use Illuminate\Support\Facades\DB;
use App\Models\Category;
use Khill\Lavacharts\Lavacharts;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use App\Models\Pay_money;

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
        $income = new Income_money;
        $sum = $income->now_month_sum();
        $sum_1 = $income->last_month_sum();
        $sum_2 = $income->last_month_2_sum();

        $pay = new Pay_money();
        $pay_sum = $pay->now_month_sum();
        $pay_sum_1 = $pay->last_month_sum();
        $pay_sum_2 = $pay->last_month_2_sum();
        $lava = new Lavacharts;

        $reasons = $lava->DataTable();

        $reasons->addStringColumn("Reasons")
            ->addNumberColumn("収入")
            ->addNumberColumn("支出")
            ->addRow(array($now_month - 2 . '月', $sum_2, $pay_sum_2))
            ->addRow(array($now_month - 1 . '月', $sum_1, $pay_sum_1))
            ->addRow(array('今月', $sum, $pay_sum));

        $all_sum = $sum - $pay_sum;

        $columnchart = $lava->ColumnChart("IMDB", $reasons, [
            "title" => "集計" . "\n" . $now_month . '月'  . $all_sum . '円 ',
            'height' => 500,
            'width' => 1000,
            'titleTextStyle' => [
                'color'    => 'gray',
                'fontSize' => 34
            ]
        ]);
        $all_income = Income_money::all();
        $user_id = Auth::id();

        return view('income_moneys.month', ["lava"      => $lava], compact('sum', 'user_id', 'all_income'));
    }
}
