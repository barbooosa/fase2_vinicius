<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class EnsureFuncionario
{
	public function handle(Request $request, Closure $next)
	{
		$user = $request->user();
		if (!$user || $user->role !== 'funcionario') {
			return response()->json(['message' => 'Acesso restrito a funcionários'], 403);
		}
		return $next($request);
	}
} 