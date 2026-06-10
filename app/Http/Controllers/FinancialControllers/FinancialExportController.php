<?php

namespace App\Http\Controllers\FinancialControllers;

use App\Exports\FinancialReportExport;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;
use Tymon\JWTAuth\Facades\JWTAuth;

class FinancialExportController extends Controller
{
    public function export(Request $request)
    {
        $clinic = JWTAuth::parseToken()->authenticate();

        $fileName =
            'financial_report_' .
            $clinic->id . '_' .
            now()->format('Ymd_His') .
            '.xlsx';

        $filePath = "reports/{$fileName}";

        $departmentId = $request->filled('department_id') ? (int) $request->department_id : null;

        Excel::store(
            new FinancialReportExport(
                $clinic->id,
                $request->from,
                $request->to,
                $departmentId ),
            $filePath,
            'public'
        );

        return response()->json([
            'success' => true,
            'file_name' => $fileName,
            'file_path' => $filePath,
            'download_url' => asset("storage/{$filePath}"),
            'generated_at' => now()->toDateTimeString()
        ]);
    }
}