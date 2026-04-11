<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AdminUsersController extends Controller
{
    public function index(Request $request): View
    {
        $query = User::query()
            ->where('is_admin', false)
            ->withCount(['quotations', 'orders'])
            ->latest();

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(fn($q) => $q->where('name', 'like', "%{$search}%")
                ->orWhere('email', 'like', "%{$search}%")
                ->orWhere('organisation', 'like', "%{$search}%"));
        }

        return view('admin.users.index', [
            'pageTitle' => 'Clients',
            'users'     => $query->paginate(25)->withQueryString(),
            'total'     => User::where('is_admin', false)->count(),
        ]);
    }

    public function show(User $user): View
    {
        abort_if($user->is_admin, 404);

        $user->load([
            'quotations.product',
            'orders.quotation.product',
            'orders.directProduct',
        ]);

        return view('admin.users.show', [
            'pageTitle' => $user->name,
            'user'      => $user,
        ]);
    }
}
