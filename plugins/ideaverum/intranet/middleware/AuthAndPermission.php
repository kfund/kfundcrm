<?php
/**
 * Created by PhpStorm.
 * User: Dino
 * Date: 24.11.2019.
 * Time: 11:26
 */

namespace IdeaVerum\Intranet\Middleware;
use Backend\Facades\BackendAuth;
use Closure;


class AuthAndPermission {
    public function handle($request, Closure $next){
        $user = BackendAuth::getUser();
        if(isset($user) && $user->hasAccess('ideaverum.intranet.access_intranet'))
            return $next($request);

        return redirect()->back();
    }
}
