<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SiteSetting;
use App\Support\EditableSiteContent;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class HomeContentController extends Controller
{
    public function edit(): View
    {
        return view('admin.home.edit', [
            'pageTitle' => 'Homepage Content',
            'company' => EditableSiteContent::company(),
            'stats' => EditableSiteContent::stats(),
            'capabilities' => EditableSiteContent::capabilities(),
            'process' => EditableSiteContent::process(),
            'heroSlides' => EditableSiteContent::heroSlides(),
            'testimonials' => EditableSiteContent::testimonials(),
            'partners' => EditableSiteContent::partners(),
        ]);
    }

    public function updateCompany(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:160'],
            'short_name' => ['required', 'string', 'max:20'],
            'tagline' => ['required', 'string', 'max:200'],
            'founded' => ['required', 'string', 'max:20'],
            'years' => ['required', 'string', 'max:20'],
            'mission' => ['required', 'string', 'max:500'],
            'vision' => ['required', 'string', 'max:500'],
            'history' => ['required', 'string', 'max:500'],
            'story' => ['required', 'array', 'min:1'],
            'story.*' => ['nullable', 'string', 'max:1000'],
            'emails' => ['required', 'array', 'min:1'],
            'emails.*' => ['nullable', 'email', 'max:160'],
            'phones' => ['required', 'array', 'min:1'],
            'phones.*' => ['nullable', 'string', 'max:40'],
            'primary_phone_href' => ['required', 'string', 'max:40'],
            'whatsapp_href' => ['required', 'string', 'max:40'],
            'address' => ['required', 'string', 'max:255'],
            'address_hint' => ['nullable', 'string', 'max:255'],
            'hours' => ['required', 'string', 'max:255'],
            'facebook' => ['nullable', 'url', 'max:255'],
            'map_url' => ['nullable', 'url', 'max:255'],
            'map_embed' => ['nullable', 'url', 'max:500'],
            'meta_description' => ['required', 'string', 'max:500'],
            'logo_upload' => ['nullable', 'image', 'max:4096'],
            'hero_image_upload' => ['nullable', 'image', 'max:6144'],
            'about_image_upload' => ['nullable', 'image', 'max:6144'],
        ]);

        $company = EditableSiteContent::company();
        $emails = $this->cleanSimpleList($validated['emails']);
        $phones = $this->cleanSimpleList($validated['phones']);
        $story = $this->cleanSimpleList($validated['story']);

        if ($emails === []) {
            throw ValidationException::withMessages(['emails' => 'At least one email address is required.']);
        }

        if ($phones === []) {
            throw ValidationException::withMessages(['phones' => 'At least one phone number is required.']);
        }

        if ($story === []) {
            throw ValidationException::withMessages(['story' => 'Add at least one company story paragraph.']);
        }

        $company = array_merge($company, [
            'name' => trim($validated['name']),
            'short_name' => trim($validated['short_name']),
            'tagline' => trim($validated['tagline']),
            'founded' => trim($validated['founded']),
            'years' => trim($validated['years']),
            'mission' => trim($validated['mission']),
            'vision' => trim($validated['vision']),
            'history' => trim($validated['history']),
            'story' => $story,
            'emails' => $emails,
            'phones' => $phones,
            'primary_phone_href' => preg_replace('/\D+/', '', $validated['primary_phone_href']) ?: '',
            'whatsapp_href' => preg_replace('/\D+/', '', $validated['whatsapp_href']) ?: '',
            'address' => trim($validated['address']),
            'address_hint' => trim((string) ($validated['address_hint'] ?? '')),
            'hours' => trim($validated['hours']),
            'facebook' => trim((string) ($validated['facebook'] ?? '')),
            'map_url' => trim((string) ($validated['map_url'] ?? '')),
            'map_embed' => trim((string) ($validated['map_embed'] ?? '')),
            'meta_description' => trim($validated['meta_description']),
        ]);

        if ($request->hasFile('logo_upload')) {
            $company['logo_path'] = $this->storePublicImage($request->file('logo_upload'), $company['logo_path'] ?? null);
        }

        if ($request->hasFile('hero_image_upload')) {
            $company['hero_image'] = $this->storePublicImage($request->file('hero_image_upload'), $company['hero_image'] ?? null);
        }

        if ($request->hasFile('about_image_upload')) {
            $company['about_image'] = $this->storePublicImage($request->file('about_image_upload'), $company['about_image'] ?? null);
        }

        $company['socials'] = $this->buildSocials($company);

        $this->storeSetting('company', $company);

        return back()->with('status', 'Company and media settings updated.');
    }

    public function updateStats(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'items' => ['required', 'array', 'min:1'],
            'items.*.value' => ['nullable', 'string', 'max:40'],
            'items.*.label' => ['nullable', 'string', 'max:80'],
        ]);

        $items = $this->cleanStructuredItems($validated['items'], ['value', 'label']);

        if ($items === []) {
            throw ValidationException::withMessages(['items' => 'Add at least one stat card.']);
        }

        $this->storeSetting('stats', $items);

        return back()->with('status', 'Homepage stats updated.');
    }

    public function updateCapabilities(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'items' => ['required', 'array', 'min:1'],
            'items.*.title' => ['nullable', 'string', 'max:160'],
            'items.*.description' => ['nullable', 'string', 'max:500'],
        ]);

        $items = $this->cleanStructuredItems($validated['items'], ['title', 'description']);

        if ($items === []) {
            throw ValidationException::withMessages(['items' => 'Add at least one capability card.']);
        }

        $this->storeSetting('capabilities', $items);

        return back()->with('status', 'What we do content updated.');
    }

    public function updateProcess(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'items' => ['required', 'array', 'min:1'],
            'items.*.title' => ['nullable', 'string', 'max:160'],
            'items.*.description' => ['nullable', 'string', 'max:500'],
        ]);

        $items = $this->cleanStructuredItems($validated['items'], ['title', 'description']);

        if ($items === []) {
            throw ValidationException::withMessages(['items' => 'Add at least one process step.']);
        }

        $this->storeSetting('process', $items);

        return back()->with('status', 'How we work steps updated.');
    }

    public function updateHeroSlides(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'items' => ['required', 'array', 'min:1'],
            'items.*.headline' => ['nullable', 'string', 'max:180'],
            'items.*.body' => ['nullable', 'string', 'max:500'],
            'items.*.primary.label' => ['nullable', 'string', 'max:80'],
            'items.*.primary.link' => ['nullable', 'string', 'max:255'],
            'items.*.secondary.label' => ['nullable', 'string', 'max:80'],
            'items.*.secondary.link' => ['nullable', 'string', 'max:255'],
        ]);

        $items = collect($validated['items'])
            ->map(function (array $item): array {
                return [
                    'headline' => trim($item['headline'] ?? ''),
                    'body' => trim($item['body'] ?? ''),
                    'primary' => [
                        'label' => trim($item['primary']['label'] ?? ''),
                        'link' => trim($item['primary']['link'] ?? ''),
                    ],
                    'secondary' => [
                        'label' => trim($item['secondary']['label'] ?? ''),
                        'link' => trim($item['secondary']['link'] ?? ''),
                    ],
                ];
            })
            ->filter(fn (array $item) => $item['headline'] !== '' && $item['body'] !== '')
            ->values()
            ->all();

        if ($items === []) {
            throw ValidationException::withMessages(['items' => 'Add at least one hero slide.']);
        }

        $this->storeSetting('hero_slides', $items);

        return back()->with('status', 'Hero slides updated.');
    }

    public function updateTestimonials(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'items' => ['required', 'array', 'min:1'],
            'items.*.name' => ['nullable', 'string', 'max:120'],
            'items.*.role' => ['nullable', 'string', 'max:120'],
            'items.*.quote' => ['nullable', 'string', 'max:700'],
        ]);

        $items = $this->cleanStructuredItems($validated['items'], ['name', 'role', 'quote']);

        if ($items === []) {
            throw ValidationException::withMessages(['items' => 'Add at least one client review.']);
        }

        $this->storeSetting('testimonials', $items);

        return back()->with('status', 'Client reviews updated.');
    }

    public function updatePartners(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'items' => ['required', 'array', 'min:1'],
            'items.*.name' => ['nullable', 'string', 'max:120'],
            'items.*.type' => ['nullable', 'string', 'max:120'],
        ]);

        $items = $this->cleanStructuredItems($validated['items'], ['name', 'type']);

        if ($items === []) {
            throw ValidationException::withMessages(['items' => 'Add at least one partner entry.']);
        }

        $this->storeSetting('partners', $items);

        return back()->with('status', 'Client and partner entries updated.');
    }

    private function storeSetting(string $key, array $value): void
    {
        SiteSetting::putValue($key, $value);
        EditableSiteContent::flushCache();
    }

    private function cleanSimpleList(array $items): array
    {
        return array_values(array_filter(array_map(
            fn ($item) => trim((string) $item),
            $items
        )));
    }

    private function cleanStructuredItems(array $items, array $requiredKeys): array
    {
        return collect($items)
            ->map(function (array $item) {
                return collect($item)
                    ->map(fn ($value) => is_string($value) ? trim($value) : $value)
                    ->all();
            })
            ->filter(function (array $item) use ($requiredKeys): bool {
                foreach ($requiredKeys as $key) {
                    if (($item[$key] ?? '') === '') {
                        return false;
                    }
                }

                return true;
            })
            ->values()
            ->all();
    }

    private function buildSocials(array $company): array
    {
        $socials = [];

        if (! empty($company['facebook'])) {
            $socials[] = [
                'name' => 'Facebook',
                'href' => $company['facebook'],
                'icon' => 'facebook',
            ];
        }

        if (! empty($company['whatsapp_href'])) {
            $socials[] = [
                'name' => 'WhatsApp',
                'href' => 'https://wa.me/'.$company['whatsapp_href'],
                'icon' => 'whatsapp',
            ];
        }

        if (! empty($company['emails'][0] ?? null)) {
            $socials[] = [
                'name' => 'Email',
                'href' => 'mailto:'.$company['emails'][0],
                'icon' => 'mail',
            ];
        }

        return $socials;
    }

    private function storePublicImage(UploadedFile $file, ?string $currentPath = null): string
    {
        $storedPath = $file->store('site-content', 'public');

        $this->deleteStoredPublicImage($currentPath);

        return '/storage/'.$storedPath;
    }

    private function deleteStoredPublicImage(?string $path): void
    {
        if (! is_string($path) || $path === '') {
            return;
        }

        if (str_starts_with($path, '/storage/')) {
            Storage::disk('public')->delete(substr($path, strlen('/storage/')));
        }

        if (str_starts_with($path, 'storage/')) {
            Storage::disk('public')->delete(substr($path, strlen('storage/')));
        }
    }
}
