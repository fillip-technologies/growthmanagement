<?php

namespace App\Http\Controllers\ChatApp;

use App\Http\Controllers\Controller;
use App\Models\Discuss;
use Illuminate\Http\Request;

class ChatManagementController extends Controller
{
    public function sentAdminSms(Request $request)
    {
        $request->validate([
            'employee_id' => 'required',
            'project_id' => 'required',
            'textsms' => 'required|string',
        ]);

        $data = Discuss::create([
            'chatCount' => 1,
            'employee_id' => $request->employee_id,
            'project_id' => $request->project_id,
            'textSMS' => $request->textsms,
        ]);

        if ($data) {
            return response()->json([
                'message' => 'Chat submited successful',
                'success' => true,
                'data' => $data,
            ], 201);
        }

    }

    public function employeeSms(Request $request)
    {

        $request->validate([
            'employee_id' => 'required',
            'project_id' => 'required',
            'textsms' => 'required|string',
        ]);

        $data = Discuss::create([
            'chatCount' => 2,
            'employee_id' => $request->employee_id,
            'project_id' => $request->project_id,
            'textSMS' => $request->textsms,
        ]);

        if ($data) {
            return response()->json([
                'message' => 'Chat submited successful',
                'success' => true,
                'data' => $data,
            ], 201);
        }
    }

    public function getSmsAdmin(Request $request)
    {
        try {

            $chats = Discuss::where('project_id', $request->project_id)->get();

            return response()->json([
                'message' => 'Chat Here',
                'status' => true,
                'data' => $chats,
            ], 200);

        } catch (\Exception $e) {

            return response()->json([
                'message' => 'Something went wrong',
                'status' => false,
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function getSmsEmp(Request $request)
    {
        try {

            $chats = Discuss::where('project_id', $request->project_id)->get();

            return response()->json([
                'message' => 'Chat Here',
                'status' => true,
                'data' => $chats,
            ], 200);

        } catch (\Exception $e) {

            return response()->json([
                'message' => 'Something went wrong',
                'status' => false,
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
