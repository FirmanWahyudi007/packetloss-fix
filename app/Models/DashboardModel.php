<?php

namespace App\Models;

use CodeIgniter\Model;

class DashboardModel extends Model
{
    protected $table = 'packetlos';
    protected $primaryKey = 'site_id';

    public function getUniqueRegencies()
    {
        $query = $this->distinct()->select('kabupaten')->findAll();
        $regencies = array_column($query, 'kabupaten');

        return $regencies;
    }

    public function getRegency()
    {
        $query = $this->select('kabupaten, COUNT(*) as count')
                    ->groupBy('kabupaten')
                    ->findAll();

        $regencyCounts = [];
        foreach ($query as $row) {
            $regencyCounts[$row['kabupaten']] = $row['count'];
        }

        return $regencyCounts;
    }
}
