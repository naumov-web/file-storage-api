<?php

namespace App\Http\Middleware;

use App\Models\User\Model;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

/**
 * Class Access
 * @package App\Http\Middleware
 */
final class Access
{
    /**
     * Handle request via middleware
     *
     * @param Request $request
     * @param \Closure $next
     * @return void
     */
    public function handle($request, Closure $next)
    {
        /**
         * @var Model $user
         */
        $user = auth()->user();

        if (!$user) {
            return $next($request);
        }

        $roleSystemNames = $user->getRoleSystemNames();
        $routeName = $request->route()->getName();

        if (!$this->checkRouteName($routeName, $roleSystemNames)) {
            abort(
                response()->json(
                    [
                        'success' => false,
                        'message' => __('messages.forbidden')
                    ],
                    Response::HTTP_FORBIDDEN
                )
            );
        }

        return $next($request);
    }

    private function checkRouteName(string $routeName, array $roleSystemNames): bool
    {
        $schema = config('access.access_schema');

        if (isset($schema[$routeName])) {
            $availableRoles = $schema[$routeName]['roles'];

            foreach ($roleSystemNames as $roleSystemName) {
                if (in_array($roleSystemName, $availableRoles)) {
                    return true;
                }
            }

            return false;
        }

        return true;
    }
}
