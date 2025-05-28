<?php

namespace App\Http\Controllers;

use App\Models\Managers;
use App\Models\Reports;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
class ReportController extends Controller
{

    public function index(Request $request)
    {
        $managerId = $request->session()->get('logged_in_manager_id');
        $manager  = Managers::find($managerId);
        if($manager == null){
            return redirect()->route('managerLogin');
        }
        $reports = Reports::with(['client', 'comment'])
        ->orderBy('id', 'asc')
        ->get();


        return view('managers.manageReports', compact('manager','reports'));
    }


    public function processReport(Request $request, $id)
    {
        $managerId = $request->session()->get('logged_in_manager_id');
        $manager  = Managers::find($managerId);
        if($manager == null){
            return redirect()->route('managerLogin');
        }
        $report = Reports::find($id);
        if (!$report) {
            return redirect()->back()->with('error', 'Báo cáo không tồn tại.');
        }
        $action = $request->input('action');
        try {
            if ($action === 'resolve') {
                if ($report->comment) {
                    $client =  $report->comment->client;
                    $client = $client->isMute - 1 ;
                    $client->save();
                    $report->comment->delete();
                    Log::info("Comment ID: {$report->comment->id} deleted due to report resolution.");
                }
                $report->delete();
                Log::info("Report ID: {$report->id} resolved and deleted.");
                return redirect()->route('managerManageReports')->with('success', 'Đã xóa bình luận thành công');
            } elseif ($action === 'ignore') {
                $report->delete();
                Log::info("Report ID: {$report->id} ignored and deleted.");
                return redirect()->route('managerManageReports')->with('success', 'Báo cáo đã được bỏ qua thành công.');
            } else {
                return redirect()->back()->with('error', 'Hành động không hợp lệ.');
            }
        } catch (\Exception $e) {
            Log::error("Error processing report ID: {$report->id} with action '{$action}'. Error: " . $e->getMessage());
            return redirect()->back()->with('error', 'Đã xảy ra lỗi khi xử lý báo cáo.');
        }
    }
}

