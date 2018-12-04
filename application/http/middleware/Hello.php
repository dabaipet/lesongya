<?php

/**
 *-------------LeSongya--------------
 * Explain:
 * File name: Hello.php
 * Date: 2018/12/4
 * Author: 王海鹏
 * Project name: 乐送呀
 *-----------------------------------------
 */
namespace app\http\middleware;

class Hello
{
    public function handle($request, \Closure $next)
    {
        $request->hello = 'ThinkPHP';

        return $next($request);
    }
}