<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Income_money;
use Illuminate\Support\Facades\DB;
use App\Models\Category;
use Khill\Lavacharts\Lavacharts;
use Carbon\Carbon;

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

        // var_dump($now_1);
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
    public function index()
    {
        //
        $income_moneys = Income_money::all();
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
                $m_10 += $income->money;
            } elseif ($month === 11) {
                $m_11 += $income->money;
            } elseif ($month === 12) {
                $m_12 += $income->money;
            }
        }
        $income_money_all = Income_money::all();
        $sum = collect($income_money_all)->sum('money');

        $lava = new Lavacharts;

        $reasons = $lava->DataTable();

        $reasons->addStringColumn("Reasons")
            ->addNumberColumn("￥") //題名
            ->addRow(array("1月", $m_1))
            ->addRow(array("2月", $m_2))
            ->addRow(array("3月", $m_3))
            ->addRow(array("4月", $m_4))
            ->addRow(array("5月", $m_5))
            ->addRow(array("6月", $m_6))
            ->addRow(array("7月", $m_7))
            ->addRow(array("8月", $m_8))
            ->addRow(array("9月", $m_9))
            ->addRow(array("10月", $m_10))
            ->addRow(array("11月", $m_11))
            ->addRow(array("12月", $m_12));


        $columnchart = $lava->ColumnChart("IMDB", $reasons, [
            "title" => "収入" . '合計' . $sum . '円 ',
            'height' => 500,
            'width' => 1000,
            'titleTextStyle' => [
                'color'    => 'gray',
                'fontSize' => 34
            ]
        ]);



        return view('income_moneys.index', ["lava"      => $lava], compact('sum'));
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
