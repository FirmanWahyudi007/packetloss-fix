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

    public function getChartData($selectedWeek)
    {
        // SQL query to count "SPIKE" and "CLEAR" statuses grouped by "nop"
        $query = $this->select('nop, SUM(CASE WHEN pl_status = "SPIKE" THEN 1 ELSE 0 END) AS spike_count, SUM(CASE WHEN pl_status = "CLEAR" THEN 1 ELSE 0 END) AS clear_count')
            ->where('week', $selectedWeek) // Replace 'week' with your actual column name
            ->groupBy('nop')
            ->orderBy('nop', 'asc')
            ->get();

        return $query->getResult('array'); // Return the query result as an array
    }
}
