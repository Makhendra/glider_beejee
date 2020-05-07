<?php


namespace App\Http\Controllers;


use App\Http\Requests\ReportRequest;
use App\Models\Report;

class ReportsController extends Controller
{
    public function create(ReportRequest $request)
    {
        $data = $request->all();
        Report::create($data);
        telegram_log($data);
        return back();
    }
}