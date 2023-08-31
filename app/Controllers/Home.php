<?php

namespace App\Controllers;

use App\Models\DashboardModel;

class Home extends BaseController
{
    protected $dashboardModel;
    public function __construct()
    {
        $this->dashboardModel = new DashboardModel();
    }
    public function index(): string
    {
        $model = new DashboardModel();

        $data['uniqueRegencies'] = $model->getUniqueRegencies();
        $data['regencyCounts'] = $model->getRegency();
        //get week ini gais
        $data['week'] = $model->select('week as week')->orderBy('week', 'desc')->groupBy('week')->findAll();
        $weekval = $this->request->getPost('week');
        $data['pl_clear'] = $model->where('week', ['week' => $weekval])->where('pl_status', 'CLEAR')->countAllResults();
        $data['pl_spike'] = $model->where('week', ['week' => $weekval])->where('pl_status', 'SPIKE')->countAllResults();
        $data['pl_consecutive'] = $model->where('week', ['week' => $weekval])->where('pl_status', 'CONSECUTIVE')->countAllResults();

        $data['packetloss'] = $model->findAll();
        // dd($data['regencyCounts']);
        return view('index', $data);
    }

    public function getDatabyWeek($weekval = null)
    {
        $model = new DashboardModel();

        $data['pl_clear'] = $model->where('week', ['week' => $weekval])->where('pl_status', 'CLEAR')->countAllResults();
        $data['pl_spike'] = $model->where('week', ['week' => $weekval])->where('pl_status', 'SPIKE')->countAllResults();
        $data['pl_consecutive'] = $model->where('week', ['week' => $weekval])->where('pl_status', 'CONSECUTIVE')->countAllResults();

        return response()->setJson($data);
    }

    public function getDatabyWeekGroup($weekval = null)
    {
        $model = new DashboardModel();
        $week = $model->select('week as week')->orderBy('week', 'desc')->groupBy('week')->find();
        $weekval = $weekval ?? $week[0]['week'];
        $data['weeksData'] = $model->getChartData($weekval);
        return response()->setJson($data);
    }
}
