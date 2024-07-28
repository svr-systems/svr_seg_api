<?php

namespace App\Http\Middleware;

use App\Http\Controllers\GenController;
use Closure;
use Illuminate\Http\Request;

class SanitizeEmptyStrToNull {
  public function handle(Request $request, Closure $next) {
    foreach ($request->input() as $key => $value) {
      if (GenController::empty($value)) {
        $request->request->set($key, null);
      }
    }

    return $next($request);
  }
}
