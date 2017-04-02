<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use DB;

class ReportsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }


    public function index()
    {
        return view('reports.index');
    }


    public function show($id)
    {
        switch ($id) {

            case 1:
                $description = 'Onnistuneiden tehtävien lukumäärä sessioittain';
                $report = $this->getReport1();
                $columns = ['sessio', 'käyttäjä', 'onnistuneet tehtävät'];
                break;

            case 2:
                $description = 'Session nopein, hitain ja keskimääräinen suoritusaika tehtävälistakohtaisesti';
                $report = $this->getReport2();
                $columns = ['', 'yhteensä', 'nopein', 'hitain', 'keskimääräinen suoritusaika'];
                break;

            #case 3:

            #case 4:

            #case 5:

            default:
                $description = 'Raportti ei saatavilla';
                $report = [[]];
                $columns = [];
                break;
        }
        return view('reports.show', compact('report', 'description', 'columns', 'id'));
    }


    private function getReport1()
    {
        return DB::select(
            "SELECT s.id, u.name, COUNT(nullif(ta.result, false))
            FROM sessions s 
                JOIN users u ON s.user_id = u.id
                JOIN task_attempts ta ON s.id = ta.session_id
            GROUP BY (s.id, u.name)
            ORDER BY (s.id);"
        );
    }

    private function getReport2()
    {
        return DB::select(
            "SELECT tl.name, 
                COUNT(s.id) AS yht, 
                MIN(s.end_time - s.start_time) AS nopein, 
                MAX(s.end_time - s.start_time) AS hitain, 
                AVG(s.end_time - s.start_time) AS keskiarvo
            FROM sessions s 
                JOIN tasklists tl ON s.tasklist_id = tl.id
            GROUP BY (tl.name, tl.id)
            ORDER BY (tl.id);"
        );
    }


}
