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

            case 3:
                $description = 'Tehtävälistan yhteenvetotiedot tehtäväkohtaisesti (tehtäväkuvaukset, onnistumisprosentit, keskimääräinen aika)';
                $report = $this->getReport3();
                $columns = ['', '', 'kuvaus', 'keskiarvo', 'onnistumis-%'];
                break;

            case 4:
                $description = 'Kaikki tehtävät vaikeusjärjestyksessä. Keskimääräisten yritysten määrä (onnistuneet), sekä epäonnistuneiden prosenttiosuus.';
                $report = $this->getReport4();
                $columns = ['', 'aika', 'yritykset', 'epäonnistumis-%'];
                break;

            case 5:
                $description = 'Kyselyt tyypeittäin (Select, Insert jne.), yritysten keskimääräinen lukumäärä sekä keskimäärin käytetty aika.';
                $report = $this->getReport5();
                $columns = ['tyyppi', 'yrityksiä', 'aika (k/a)'];
                break;

            #case 6:

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

    private function getReport3()
    {
        return DB::select(
            "SELECT tl.name AS sarja,
                    t.name AS tehtava, 
                    t.description AS kuvaus, 
                    to_char(AVG(st.end_time - st.start_time), 'MI:SS') AS keskiarvo, 
                    to_char(
                        (100.0 / COUNT(st.id) *     -- |   100.0 / TEHDYT TEHTÄVÄT *
                        (SELECT COUNT(ta2.id)       -- |   ONNISTUNEET TEHTÄVÄT = ONNISTUMISPROSENTTI
                        FROM tasks t2 
                            JOIN task_tasklist ttl2 ON t2.id = ttl2.task_id
                            JOIN sessions s2 ON ttl2.tasklist_id = s2.tasklist_id
                            JOIN session_tasks st2 ON t2.id = st2.task_id AND s2.id = st2.session_id
                            JOIN task_attempts ta2 ON ta2.session_id = st2.session_id AND ta2.task_id = st2.task_id
                        WHERE ttl2.tasklist_id = tl.id AND result = true AND t.name = t2.name)), 'FM999.99'
                    ) AS onnistumisprosentti
            FROM tasks t 
                JOIN task_tasklist ttl ON t.id = ttl.task_id
                JOIN tasklists tl ON ttl.tasklist_id = tl.id
                JOIN sessions s ON ttl.tasklist_id = s.tasklist_id
                JOIN session_tasks st ON t.id = st.task_id AND s.id = st.session_id
            GROUP BY (tl.name, tl.id, t.name, t.description)
            ORDER BY (tl.name, t.name);"
        );
    }

    private function getReport4()
    {
        return DB::select(
            "SELECT t.name AS tehtava, 
                    to_char(AVG(st.end_time - st.start_time), 'MI:SS') AS aika,

                    to_char((SELECT AVG(ta2.count)      -- Onnistuneiden tehtävien yrityksiä keskimäärin
                        FROM tasks t2
                            JOIN session_tasks st2 ON t2.id = st2.task_id
                            JOIN task_attempts ta2 ON t2.id = ta2.task_id AND st2.session_id = ta2.session_id AND result = true
                        WHERE t.name = t2.name), 'FM999.99'
                    ) AS yritykset,

                    to_char(100.0*(SELECT COUNT(ta3.task_id)        -- 100 * Epäonnistuneet tehtävät
                        FROM task_attempts ta3
                        WHERE ta3.task_id = t.id AND count = 3 AND result = false
                    ) /                                             -- Jaettuna
                    (SELECT COUNT(st3.task_id)                      -- Tehtävät yhteensä
                        FROM session_tasks st3
                        WHERE st3.task_id = t.id
                    ), 'FM999.99') AS Epäonnistuneet                -- = Epäonnistumis-%

            FROM tasks t 
                JOIN session_tasks st ON t.id = st.task_id
                JOIN task_attempts ta ON t.id = ta.task_id AND st.session_id = ta.session_id
            GROUP BY (t.name, t.id)
            ORDER BY (aika) DESC;"
        );
    }

    private function getReport5()
    {
        return DB::select(
            "SELECT t.type AS tyyppi, 
                    to_char(1.0*(
                        SELECT COUNT(ta2.task_id)           -- Yritykset yhteensä
                            FROM tasks t2 
                                JOIN session_tasks st2 ON t2.id = st2.task_id
                                JOIN task_attempts ta2 ON t2.id = ta2.task_id AND ta2.session_id = st2.session_id
                            WHERE t2.type = t.type) /       -- JAETTUNA
                        (SELECT COUNT(st2.task_id)          -- Tehtävät yhteensä
                            FROM tasks t2 
                                JOIN session_tasks st2 ON t2.id = st2.task_id
                            WHERE t2.type = t.type
                        ), 'FM999.99'
                    ) AS yrityksiä,                         -- = Yrityksiä keskimäärin

                    to_char(AVG(st.end_time - st.start_time), 'MI:SS') AS aika
            FROM tasks t
                JOIN session_tasks st ON t.id = st.task_id
            GROUP BY (t.type);"
        );
    }


}
