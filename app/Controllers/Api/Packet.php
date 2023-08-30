<?php

namespace App\Controllers\Api;

use App\Controllers\BaseController;
use App\Models\PacketLossModel;
use App\Services\PacketService;

class Packet extends BaseController
{
    private PacketLossModel $packetModel;
    private PacketService $packetService;

    public function __construct()
    {
        $this->packetModel = new PacketLossModel();
        $this->packetService = new PacketService;
    }

    public function weeks()
    {
        return $this->response->setJSON(
            $this->packetService->getWeeks()
        );
    }

    public function regencies()
    {
        $regencies = $this->packetModel->select('kabupaten')->groupBy('kabupaten')->get();
        $regencies = array_map(
            fn($regency) => $regency['kabupaten'],
            $regencies->getResultArray()
        );

        return $this->response->setJSON($regencies);
    }

    public function lossData()
    {
        $spikes = $this->packetService->getTotalSpikes();
        $clears = $this->packetService->getTotalClears();
        $consecutives = $this->packetService->getTotalConsecutives();

        return $this->response->setJSON([
            'spikes' => $this->parsePerWeek($spikes),
            'clears' => $this->parsePerWeek($clears),
            'consecutives' => $this->parsePerWeek($consecutives),
        ]);
    }

    private function parsePerWeek(array $totals)
    {
        return array_map(fn($data) => (int) $data['total'], $totals);
    }
}
