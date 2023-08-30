<?php

namespace App\Services;

use App\Models\PacketLossModel;
use CodeIgniter\Database\BaseResult;

class PacketService
{
    private PacketLossModel $packetModel;
    private array $weeks;

    public function __construct()
    {
        $this->packetModel = new PacketLossModel();
        $weeks = $this->packetModel->select('week')
            ->groupBy('week')
            ->orderBy('week', 'ASC')
            ->get()
            ->getResultArray();

        $this->weeks = array_map(fn($week) => $week['week'], $weeks);
    }

    public function getWeeks(): array
    {
        return $this->weeks;
    }

    public function getTotalSpikes()
    {
        return $this->fillEmptyWeeks(
            $this->getTotalData('SPIKE')->getResultArray()
        );
    }

    public function getTotalClears()
    {
        return $this->fillEmptyWeeks(
            $this->getTotalData('CLEAR')->getResultArray()
        );
    }

    public function getTotalConsecutives()
    {
        return $this->fillEmptyWeeks(
            $this->getTotalData('CONSECUTIVE')->getResultArray()
        );
    }

    private function getTotalData(string $status): BaseResult
    {
        return $this->packetModel->select('week, COUNT(*) as total')
            ->groupBy('week')
            ->where('pl_status', $status)
            ->get();
    }

    private function fillEmptyWeeks(array $data)
    {
        $availWeeks = array_map(fn($week) => $week['week'], $data);
        $diffs = array_diff($this->weeks, $availWeeks);

        if(empty($diffs)) return $data;

        foreach($diffs as $week) {
            array_push($data, [
                'week' => $week,
                'total' => "0",
            ]);
        }

        usort($data, fn($week1, $week2) => $week1 <=> $week2);
        return $data;
    }
}
