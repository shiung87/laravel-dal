<?php

namespace App\Services;

use App\Models\TrafficLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TrafficTracker
{
    /**
     * Record a traffic hit / page visit.
     */
    public static function track(
        Request $request,
        ?string $categorySlug = null,
        ?string $searchQuery = null,
        ?string $countryFilter = null,
        ?string $approverFilter = null
    ): void {
        try {
            $user = Auth::user();
            $userAgent = $request->userAgent() ?? '';
            $device = self::detectDevice($userAgent);

            TrafficLog::create([
                'user_id'         => $user?->id,
                'user_name'       => $user?->name,
                'department_id'   => $user?->department_id,
                'department_name' => $user?->department?->name ?? $user?->department_name,
                'path'            => '/' . ltrim($request->path(), '/'),
                'category_slug'   => $categorySlug ?: $request->query('category'),
                'search_query'    => $searchQuery ?: $request->query('search'),
                'country_filter'  => $countryFilter ?: $request->query('country'),
                'approver_filter' => $approverFilter ?: $request->query('approver'),
                'ip_address'      => $request->ip(),
                'user_agent'      => $userAgent,
                'device'          => $device,
                'created_at'      => now(),
            ]);
        } catch (\Throwable $e) {
            // Silently catch so tracking never blocks application flow
            report($e);
        }
    }

    /**
     * Simple device detector based on User-Agent.
     */
    private static function detectDevice(string $userAgent): string
    {
        $ua = strtolower($userAgent);
        if (str_contains($ua, 'ipad') || str_contains($ua, 'tablet') || (str_contains($ua, 'android') && !str_contains($ua, 'mobile'))) {
            return 'tablet';
        }
        if (str_contains($ua, 'mobile') || str_contains($ua, 'iphone') || str_contains($ua, 'android') || str_contains($ua, 'phone')) {
            return 'mobile';
        }
        return 'desktop';
    }
}
