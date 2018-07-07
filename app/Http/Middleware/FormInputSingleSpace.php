<?php

namespace App\Http\Middleware;

use Closure;

class FormInputSingleSpace
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  params  $inputsName
     * @return mixed
     */
    public function handle($request, Closure $next, ...$inputsName)
    {
        $inputs = $request->only($inputsName);

        foreach ($inputs as $key => $val)
        {
            $request->merge([$key => single_space($val)]);
        }

        return $next($request);
    }
}
