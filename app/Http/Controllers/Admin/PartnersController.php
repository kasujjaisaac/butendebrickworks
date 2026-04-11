<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SiteSetting;
use App\Support\EditableSiteContent;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class PartnersController extends Controller
{
    public function index(Request $request): View
    {
        $allPartners = EditableSiteContent::partners();
        $perPage     = 20;
        $page        = max(1, (int) $request->input('page', 1));

        $items    = (new Collection($allPartners))->forPage($page, $perPage);
        $partners = new LengthAwarePaginator(
            $items,
            count($allPartners),
            $perPage,
            $page,
            ['path' => $request->url(), 'query' => $request->query()]
        );

        return view('admin.partners.index', [
            'pageTitle' => 'Partners',
            'partners'  => $partners,
        ]);
    }

    public function create(): View
    {
        return view('admin.partners.create', ['pageTitle' => 'Add Partner']);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name'  => ['required', 'string', 'max:120'],
            'type'  => ['nullable', 'string', 'max:120'],
            'logo'  => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
        ]);

        $partners   = EditableSiteContent::partners();
        $partners[] = [
            'name' => $validated['name'],
            'type' => $validated['type'] ?? '',
            'logo' => $this->handleLogo($request),
        ];

        SiteSetting::putValue('partners', $partners);
        EditableSiteContent::flushCache();

        return redirect()->route('admin.partners.index')
            ->with('status', 'Partner added successfully.');
    }

    public function edit(int $partner): View
    {
        $partners = EditableSiteContent::partners();

        abort_if(! isset($partners[$partner]), 404);

        return view('admin.partners.edit', [
            'pageTitle' => 'Edit Partner',
            'partner'   => $partners[$partner],
            'index'     => $partner,
        ]);
    }

    public function update(Request $request, int $partner): RedirectResponse
    {
        $validated = $request->validate([
            'name'  => ['required', 'string', 'max:120'],
            'type'  => ['nullable', 'string', 'max:120'],
            'logo'  => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
        ]);

        $partners = EditableSiteContent::partners();
        abort_if(! isset($partners[$partner]), 404);

        $existing = $partners[$partner];

        if ($request->hasFile('logo')) {
            // Delete old storage logo if applicable
            $oldLogo = $existing['logo'] ?? null;
            if ($oldLogo && str_starts_with($oldLogo, '/storage/')) {
                Storage::disk('public')->delete(str_replace('/storage/', '', $oldLogo));
            }
            $existing['logo'] = $this->handleLogo($request);
        }

        $existing['name'] = $validated['name'];
        $existing['type'] = $validated['type'] ?? '';
        $partners[$partner] = $existing;

        SiteSetting::putValue('partners', array_values($partners));
        EditableSiteContent::flushCache();

        return redirect()->route('admin.partners.index')
            ->with('status', 'Partner updated successfully.');
    }

    public function destroy(int $partner): RedirectResponse
    {
        $partners = EditableSiteContent::partners();
        abort_if(! isset($partners[$partner]), 404);

        $logo = $partners[$partner]['logo'] ?? null;
        if ($logo && str_starts_with($logo, '/storage/')) {
            Storage::disk('public')->delete(str_replace('/storage/', '', $logo));
        }

        array_splice($partners, $partner, 1);
        SiteSetting::putValue('partners', array_values($partners));
        EditableSiteContent::flushCache();

        return redirect()->route('admin.partners.index')
            ->with('status', 'Partner removed.');
    }

    private function handleLogo(Request $request): ?string
    {
        if (! $request->hasFile('logo')) {
            return null;
        }

        $path = $request->file('logo')->store('partners', 'public');

        return '/storage/' . $path;
    }
}
