<?php

namespace App\Http\Controllers;

use App\Models\Managers;
use App\Models\Reports;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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

    public function sendReport(Request $request)
    {
        // 1. Validate the incoming request data
        $request->validate([
            'commentId' => 'required|integer|exists:comments,id', // Validate that commentId exists
            'reason'    => 'required|string|in:Tin rác,Quấy rối,Nội dung không phù hợp,Khác', // Your Vietnamese reasons
            'content'   => 'nullable|string|max:500',
        ]);

        if(!Auth::check()){
            return response()->json([
                'success' => false,
                'message' => 'Bạn vui lòng đăng nhập để bình luận.',
            ]);
        }
        // 2. Get the reporter's ID from authentication, or use anonymous ID
        $client = Auth::user();

        try {
            // 3. Create the report record
            Reports::create([
                'reason'    => $request->input('reason'),
                'content'   => $request->input('content'),
                'clientId'  => $client->getAuthIdentifier(),
                'commentId' => $request->commentId, // Use commentId directly from the request
                'date'      => now(),               // Manually set the 'date' field
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Báo cáo bình luận đã được gửi thành công. Cảm ơn phản hồi của bạn!',
            ], 200);

        } catch (\Exception $e) {
            Log::error('Lỗi khi gửi báo cáo bình luận: ' . $e->getMessage(), ['exception' => $e, 'request' => $request->all()]);
            return response()->json([
                'success' => false,
                'message' => 'Có lỗi xảy ra khi gửi báo cáo. Vui lòng thử lại.',
                'error' => $e->getMessage()
            ], 500);
        }
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
                    $client->isMute = $client->isMute - 1 ;
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

