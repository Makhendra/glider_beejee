<?php


namespace App\Http\Controllers;


use App\Http\Requests\ReportRequest;
use App\Models\Questionnary;
use App\Models\Report;
use Illuminate\Http\Request;

class ReportsController extends Controller
{
    public function create(ReportRequest $request)
    {
        $data = $request->all();
        Report::create($data);
        telegram_log($data);
        return back();
    }

    public function questionnaire(Request $request) {
        $data = $request->all();
        Questionnary::create(['data' => $data]);
        telegram_log($data);
        return back();
    }
}