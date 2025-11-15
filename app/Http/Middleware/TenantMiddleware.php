<?php

namespace App\Http\Middleware;

use App\Models\Customer;
use App\Models\Equipment;
use App\Models\Inspection;
use Closure;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class TenantMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        // If user is not authenticated or is a super admin, skip tenant scoping
        if (!$user || $user->isSuperAdmin()) {
            return $next($request);
        }

        // Apply global scopes to multi-tenant models
        $organizationId = $user->organization_id;

        Customer::addGlobalScope('organization', function (Builder $builder) use ($organizationId) {
            $builder->where('organization_id', $organizationId);
        });

        Equipment::addGlobalScope('organization', function (Builder $builder) use ($organizationId) {
            $builder->where('organization_id', $organizationId);
        });

        Inspection::addGlobalScope('organization', function (Builder $builder) use ($organizationId) {
            $builder->where('organization_id', $organizationId);
        });

        return $next($request);
    }
}
