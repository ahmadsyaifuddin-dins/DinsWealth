<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;
use ZipArchive;

class BackupController extends Controller
{
    public function index()
    {
        return view('backup.index');
    }

    public function download(Request $request)
    {
        $format = $request->input('format');
        $timestamp = now()->format('Ymd_His');

        $tables = DB::connection()->getDoctrineSchemaManager()->listTableNames();

        if ($format === 'json') {
            $data = [];
            foreach ($tables as $table) {
                $data[$table] = DB::table($table)->get();
            }
            $json = json_encode($data, JSON_PRETTY_PRINT);
            $filename = "backup_total_{$timestamp}.json";

            return response($json)
                ->header('Content-Type', 'application/json')
                ->header('Content-Disposition', "attachment; filename={$filename}");
        }

        if ($format === 'csv') {
            $zip = new ZipArchive;
            $zipFilename = "backup_total_csv_{$timestamp}.zip";
            $zipPath = storage_path("app/{$zipFilename}");

            $zip->open($zipPath, ZipArchive::CREATE | ZipArchive::OVERWRITE);

            foreach ($tables as $table) {
                $rows = DB::table($table)->get();
                if ($rows->isEmpty()) continue;

                $csvData = implode(',', array_keys((array)$rows[0])) . "\n";
                foreach ($rows as $row) {
                    $csvData .= implode(',', array_map(function ($val) {
                        return '"' . str_replace('"', '""', $val) . '"';
                    }, (array)$row)) . "\n";
                }

                $zip->addFromString("{$table}.csv", $csvData);
            }

            $zip->close();

            return response()->download($zipPath)->deleteFileAfterSend(true);
        }

        return back()->with('error', 'Format tidak valid.');
    }
}
