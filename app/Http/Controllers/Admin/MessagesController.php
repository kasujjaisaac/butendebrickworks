<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContactMessage;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class MessagesController extends Controller
{
    public function index(Request $request): View
    {
        $filter = $request->query('filter', 'all');

        $query = ContactMessage::query()->latest();

        if ($filter === 'unread') {
            $query->unread();
        } elseif ($filter === 'read') {
            $query->where('is_read', true);
        }

        return view('admin.messages.index', [
            'pageTitle'  => 'Enquiries',
            'messages'   => $query->paginate(20)->withQueryString(),
            'filter'     => $filter,
            'totalCount' => ContactMessage::query()->count(),
            'unreadCount' => ContactMessage::query()->unread()->count(),
        ]);
    }

    public function show(ContactMessage $message): View
    {
        $message->markAsRead();

        return view('admin.messages.show', [
            'pageTitle' => 'Enquiry from ' . $message->name,
            'message'   => $message,
        ]);
    }

    public function destroy(ContactMessage $message): RedirectResponse
    {
        $message->delete();

        return redirect()->route('admin.messages.index')
            ->with('status', 'Enquiry deleted successfully.');
    }

    public function markAllRead(): RedirectResponse
    {
        ContactMessage::query()->unread()->update(['is_read' => true]);

        return redirect()->route('admin.messages.index')
            ->with('status', 'All enquiries marked as read.');
    }
}
