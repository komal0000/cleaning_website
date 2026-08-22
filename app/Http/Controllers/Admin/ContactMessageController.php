<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContactMessage;
use Illuminate\Http\Request;

class ContactMessageController extends Controller
{
    public function index()
    {
        return view('admin.contact-messages.index');
    }

    public function getData(Request $request)
    {
        $query = ContactMessage::query();

        // Apply status filter
        if ($request->has('status') && $request->status !== '') {
            $query->where('status', $request->status);
        }

        // Apply search filter
        if ($request->has('search') && $request->search['value'] !== '') {
            $searchValue = $request->search['value'];
            $query->where(function($q) use ($searchValue) {
                $q->where('name', 'like', "%{$searchValue}%")
                  ->orWhere('email', 'like', "%{$searchValue}%")
                  ->orWhere('phone', 'like', "%{$searchValue}%")
                  ->orWhere('service', 'like', "%{$searchValue}%")
                  ->orWhere('message', 'like', "%{$searchValue}%");
            });
        }

        // Get total count before pagination
        $totalRecords = ContactMessage::count();
        $filteredRecords = $query->count();

        // Apply ordering
        if ($request->has('order')) {
            $columns = ['id', 'name', 'email', 'phone', 'service', 'status', 'created_at'];
            $columnIndex = $request->order[0]['column'];
            $columnName = $columns[$columnIndex] ?? 'created_at';
            $direction = $request->order[0]['dir'] ?? 'desc';
            $query->orderBy($columnName, $direction);
        } else {
            $query->latest();
        }

        // Apply pagination
        if ($request->has('start') && $request->has('length')) {
            $query->skip($request->start)->take($request->length);
        }

        $messages = $query->get();

        return response()->json([
            'draw' => intval($request->draw),
            'recordsTotal' => $totalRecords,
            'recordsFiltered' => $filteredRecords,
            'data' => $messages->map(function($message) {
                return [
                    'id' => $message->id,
                    'name' => $message->name,
                    'email' => $message->email,
                    'phone' => $message->phone ?? 'N/A',
                    'service' => $message->service,
                    'status' => $message->status,
                    'status_badge' => $message->status_badge,
                    'status_label' => $message->status_label,
                    'created_at' => $message->created_at->format('Y-m-d H:i:s'),
                    'message_preview' => strlen($message->message) > 50 ? substr($message->message, 0, 50) . '...' : $message->message,
                    'actions' => [
                        'view' => route('admin.contact-messages.show', $message),
                        'delete' => route('admin.contact-messages.destroy', $message)
                    ]
                ];
            })
        ]);
    }

    public function show(ContactMessage $contactMessage)
    {
        // Mark as read when viewed
        if ($contactMessage->status === ContactMessage::STATUS_NEW) {
            $contactMessage->update(['status' => ContactMessage::STATUS_READ]);
        }

        return view('admin.contact-messages.show', compact('contactMessage'));
    }

    public function updateStatus(Request $request, ContactMessage $contactMessage)
    {
        $request->validate([
            'status' => 'required|in:new,read,replied,closed'
        ]);

        $contactMessage->update(['status' => $request->status]);

        return response()->json([
            'success' => true,
            'message' => 'Status updated successfully'
        ]);
    }

    public function destroy(ContactMessage $contactMessage)
    {
        $contactMessage->delete();
        return redirect()->route('admin.contact-messages.index')->with('success', 'Message deleted successfully.');
    }
}
