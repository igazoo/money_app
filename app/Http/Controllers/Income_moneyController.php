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

class Income_moneyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function month()
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
        $user_id = Auth::id();
        $all_income = Income_money::where('user_id', $user_id)->get();


        return view('income_moneys.month', ["lava"      => $lava], compact('sum', 'user_id', 'all_income'));
    }
    public function index()
    {
        //
        $user_id = Auth::id();
        $income_moneys = Income_money::where('user_id', $user_id)->get();

        $m_1 = 0;
        $m_2 = 0;
        $m_3 = 0;
        $m_4 = 0;
        $m_5 = 0;
        $m_6 = 0;
        $m_7 = 0;
        $m_8 = 0;
        $m_9 = 0;
        $m_10 = 0;
        $m_11 = 0;
        $m_12 = 0;

        foreach ($income_moneys as $income) {
            $d = $income->date;
            $m = strtotime($d);
            $month = idate('m', $m);
            if ($month === 1) {
                $m_1 += $income->money;
            } elseif ($month === 2) {
                $m_2 += $income->money;
            } elseif ($month === 3) {
                $m_3 += $income->money;
            } elseif ($month === 4) {
                $m_4 += $income->money;
            } elseif ($month === 5) {
                $m_5 += $income->money;
            } elseif ($month === 6) {
                $m_6 += $income->money;
            } elseif ($month === 7) {
                $m_7 += $income->money;
            } elseif ($month === 8) {
                $m_8 += $income->money;
            } elseif ($month === 9) {
                $m_9 += $income->money;
            } elseif ($month === 10) {
                $m_10 += $income->money;;
            } elseif ($month === 11) {
                $m_11 += $income->money;;
            } elseif ($month === 12) {
                $m_12 += $income->money;;
            }
        }
        $income_money_all = Income_money::where('user_id', $user_id)->get();
        $sum = collect($income_money_all)->sum('money');


        $pay_moneys = Pay_money::where('user_id', $user_id)->get();

        $p_1 = 0;
        $p_2 = 0;
        $p_3 = 0;
        $p_4 = 0;
        $p_5 = 0;
        $p_6 = 0;
        $p_7 = 0;
        $p_8 = 0;
        $p_9 = 0;
        $p_10 = 0;
        $p_11 = 0;
        $p_12 = 0;

        foreach ($pay_moneys as $pay) {
            $d = $pay->date;
            $m = strtotime($d);
            $month = idate('m', $m);
            if ($month === 1) {
                $p_1 += $pay->money;
            } elseif ($month === 2) {
                $p_2 += $pay->money;
            } elseif ($month === 3) {
                $p_3 += $pay->money;
            } elseif ($month === 4) {
                $p_4 += $pay->money;
            } elseif ($month === 5) {
                $p_5 += $pay->money;
            } elseif ($month === 6) {
                $p_6 += $pay->money;
            } elseif ($month === 7) {
                $p_7 += $pay->money;
            } elseif ($month === 8) {
                $p_8 += $pay->money;
            } elseif ($month === 9) {
                $p_9 += $pay->money;
            } elseif ($month === 10) {
                $p_10 += $pay->money;;
            } elseif ($month === 11) {
                $p_11 += $pay->money;;
            } elseif ($month === 12) {
                $p_12 += $pay->money;;
            }
        }
        $pay_money_all = Pay_money::where('user_id', $user_id)->get();
        $pay_sum = collect($pay_money_all)->sum('money');

        $lava = new Lavacharts;

        $reasons = $lava->DataTable();

        $reasons->addStringColumn("Reasons")
            ->addNumberColumn('収入')
            ->addNumberColumn('支出')
            ->addRow(array("1月", $m_1, $p_1))
            ->addRow(array("2月", $m_2, $p_2))
            ->addRow(array("3月", $m_3, $p_3))
            ->addRow(array("4月", $m_4, $p_4))
            ->addRow(array("5月", $m_5, $p_5))
            ->addRow(array("6月", $m_6, $p_6))
            ->addRow(array("7月", $m_7, $p_7))
            ->addRow(array("8月", $m_8, $p_8))
            ->addRow(array("9月", $m_9, $p_9))
            ->addRow(array("10月", $m_10, $p_10))
            ->addRow(array("11月", $m_11, $p_11))
            ->addRow(array("12月", $m_12, $p_12));
        $all_sum =  $sum - $pay_sum;

        $columnchart = $lava->ColumnChart("IMDB", $reasons, [
            "title" =>   '集計' . $all_sum . '円 ',
            'height' => 500,
            'width' => 1000,
            'titleTextStyle' => [
                'color'    => 'gray',
                'fontSize' => 34
            ]
        ]);
        $user_id = Auth::id();



        return view('income_moneys.index', ["lava"      => $lava], compact('user_id', 'income_money_all'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $categories  = Category::all();
        return view('income_moneys.create', compact(('categories')));
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
        $income_money = new Income_money;
        $income_money->money = $request->input('money');
        $income_money->date = $request->input('date');
        $income_money->category_id = $request->input('category_id');
        $income_money->user_id = Auth::id();
        $income_money->save();
        return redirect('income_moneys');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
