<?php

namespace App\Http\Controllers;

use App\Models\ChatMessage;
use App\Models\Student;
use App\Models\SystemUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChatController extends Controller
{
    /**
     * =========================================
     * STUDENT CHAT
     * =========================================
     */
    public function studentChat(Request $request)
{
    // Student aliye-login
    $student = Auth::guard('student')->user();

    // Pata admins wote active
    $admins = SystemUser::where('role', 'admin')
        ->where('status', 'active')
        ->orderBy('firstname', 'asc')
        ->get();

    // Kama hakuna admin
    if ($admins->isEmpty()) {
        return back()->with(
            'error',
            'Administrator is not available at the moment.'
        );
    }

    /*
    |--------------------------------------------------------------------------
    | Admin aliyechaguliwa
    |--------------------------------------------------------------------------
    */

    $selectedAdminId = $request->get('admin_id');

    // Kama hakuna admin aliyechaguliwa,
    // tumia admin wa kwanza
    if (!$selectedAdminId) {
        $selectedAdminId = $admins->first()->id;
    }

    // Hakikisha admin anayechaguliwa ni admin active
    $admin = $admins->where('id', $selectedAdminId)->first();

    // Kama admin huyo hayupo
    if (!$admin) {
        $admin = $admins->first();
        $selectedAdminId = $admin->id;
    }

    /*
    |--------------------------------------------------------------------------
    | Pata messages za student huyu na admin huyu tu
    |--------------------------------------------------------------------------
    */

    $messages = ChatMessage::where('student_id', $student->id)
        ->where('admin_id', $admin->id)
        ->orderBy('created_at', 'asc')
        ->get();

    /*
    |--------------------------------------------------------------------------
    | Mark messages za admin kuwa READ
    |--------------------------------------------------------------------------
    */

    ChatMessage::where('student_id', $student->id)
        ->where('admin_id', $admin->id)
        ->where('sender_type', 'admin')
        ->where('is_read', false)
        ->update([
            'is_read' => true
        ]);

    return view('chat', compact(
        'student',
        'admins',
        'admin',
        'messages',
        'selectedAdminId'
    ));
}


    /**
     * =========================================
     * STUDENT SEND MESSAGE
     * =========================================
     */
    public function sendMessage(Request $request)
{
    // Student aliye-login
    $student = Auth::guard('student')->user();

    /*
    |--------------------------------------------------------------------------
    | Validate
    |--------------------------------------------------------------------------
    */

    $validated = $request->validate([
        'admin_id' => [
            'required',
            'integer',
            'exists:system_users,id',
        ],

        'message' => [
            'required',
            'string',
            'max:5000',
        ],
    ]);

    /*
    |--------------------------------------------------------------------------
    | Hakikisha admin ni active na role yake ni admin
    |--------------------------------------------------------------------------
    */

    $admin = SystemUser::where('id', $validated['admin_id'])
        ->where('role', 'admin')
        ->where('status', 'active')
        ->first();

    if (!$admin) {
        return back()->with(
            'error',
            'The selected administrator is not available.'
        );
    }

    /*
    |--------------------------------------------------------------------------
    | Save message
    |--------------------------------------------------------------------------
    */

    ChatMessage::create([
        'student_id' => $student->id,
        'admin_id' => $admin->id,
        'sender_type' => 'student',
        'message' => $validated['message'],
        'is_read' => false,
    ]);

    /*
    |--------------------------------------------------------------------------
    | Return kwenye conversation ya admin huyo
    |--------------------------------------------------------------------------
    */

    return redirect()
        ->route('student.chat', [
            'admin_id' => $admin->id
        ])
        ->with('success', 'Message sent successfully.');
}


  
    public function adminChat($studentId)
    {
        /*
        |--------------------------------------------------------------------------
        | Admin aliye-login
        |--------------------------------------------------------------------------
        */

        $admin = Auth::guard('web')->user();


        /*
        |--------------------------------------------------------------------------
        | Tafuta Student
        |--------------------------------------------------------------------------
        */

        $student = \App\Models\Student::findOrFail(
            $studentId
        );


        /*
        |--------------------------------------------------------------------------
        | Pata messages
        |--------------------------------------------------------------------------
        */

        $messages = ChatMessage::where(
                'student_id',
                $student->id
            )
            ->where(
                'admin_id',
                $admin->id
            )
            ->orderBy(
                'created_at',
                'asc'
            )
            ->get();


        /*
        |--------------------------------------------------------------------------
        | Mark Student messages as READ
        |--------------------------------------------------------------------------
        */

        ChatMessage::where(
                'student_id',
                $student->id
            )
            ->where(
                'admin_id',
                $admin->id
            )
            ->where(
                'sender_type',
                'student'
            )
            ->where(
                'is_read',
                false
            )
            ->update([
                'is_read' => true
            ]);


        return view(
            'adminrepond',
            compact(
                'admin',
                'student',
                'messages'
            )
        );
    }


    /**
     * =========================================
     * ADMIN SEND MESSAGE
     * =========================================
     */
    public function adminSendMessage(
        Request $request,
        $studentId
    ) {

        /*
        |--------------------------------------------------------------------------
        | Validate
        |--------------------------------------------------------------------------
        */

        $request->validate([
            'message' => [
                'required',
                'string',
                'max:5000'
            ],
        ], [
            'message.required' => 'Please enter a message.',
            'message.max' => 'Message cannot exceed 5000 characters.',
        ]);


        /*
        |--------------------------------------------------------------------------
        | Admin aliye-login
        |--------------------------------------------------------------------------
        */

        $admin = Auth::guard('web')->user();


        /*
        |--------------------------------------------------------------------------
        | Student
        |--------------------------------------------------------------------------
        */

        $student = \App\Models\Student::findOrFail(
            $studentId
        );


        /*
        |--------------------------------------------------------------------------
        | Save Admin Message
        |--------------------------------------------------------------------------
        */

        ChatMessage::create([

            'student_id' => $student->id,

            'admin_id' => $admin->id,

            'sender_type' => 'admin',

            'message' => trim($request->message),

            'is_read' => true,

        ]);


        /*
        |--------------------------------------------------------------------------
        | Back to conversation
        |--------------------------------------------------------------------------
        */

        return redirect()
            ->route(
                'admin.chat',
                $student->id
            )
            ->with(
                'success',
                'Message sent successfully.'
            );
    }
    public function adminChats() { 
        $admin = Auth::guard('web')->user(); 
        /* |-------------------------------------------------------------------------- | Get students who have messages with this admin |-------------------------------------------------------------------------- | | Tunatumia latest message ya kila student. | */ 
        $studentIds = ChatMessage::where( 'admin_id', $admin->id ) 
        ->select('student_id') ->distinct() ->pluck('student_id');
         $students = Student::whereIn( 'id', $studentIds ) ->get(); 
        $chatStudents = []; foreach ($students as $student) { 
$latestMessage = ChatMessage::where( 'student_id', $student->id )
             ->where( 'admin_id', $admin->id ) ->latest('created_at') ->first(); 
            $unreadCount = ChatMessage::where( 'student_id', $student->id ) ->where( 'admin_id', $admin->id ) ->where( 'sender_type', 'student' ) 
            ->where( 'is_read', false ) ->count(); $chatStudents[] = [ 'student' => $student, 'latest_message' => $latestMessage, 'unread_count' => $unreadCount, ]; } 
          usort( $chatStudents, function ($a, $b) { $dateA = $a['latest_message'] ? $a['latest_message']->created_at : null; $dateB = $b['latest_message'] ? $b['latest_message']->created_at : null; if (!$dateA) 
          { return 1; } if (!$dateB) { return -1; } return $dateB->timestamp - $dateA->timestamp; } ); 
          return view( 'adminchats', compact( 'admin', 'chatStudents' ) ); }


          
}

