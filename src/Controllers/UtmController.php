<?php

namespace Fairhypo\Agroutm\Controllers;

use App\Http\Controllers\Controller;
use Fairhypo\Agroutm\Models\Utm;
use Fairhypo\Agroutm\Models\UtmHost;

class UtmController extends Controller
{
    protected $utms;
    protected $hosts;

    public function __construct()
    {
        $this->utms = Utm::get();
    }

    public function index($request)
    {
        $input = $request->all();
        $utms_get = array_intersect_key($input, array_flip($this->utms->pluck('name')->toArray()));
        $cookies = [];

        if( count($utms_get) != 0 ) {

            // Если есть старые utm куки - удаляем их
            $utms_cookies = array_intersect_key($request->cookie(), array_flip($this->utms->pluck('name')->toArray()));
            if( count($utms_cookies) != 0 ) {
                foreach( $utms_cookies as $cookie_name => $cookie_value ) {
                    $cookies[] = cookie()->forget($cookie_name);
                }
            }

            // Есть ли параметр utm_source
            if( array_key_exists('utm_source', $utms_get) ) {
                foreach( $utms_get as $utm_name => $utm_value ) {
                    $cookies[] = cookie()->make($utm_name, $utm_value, 259200);
                }
            } else {
                $referrer = url()->previous();
                if( empty($referrer) ) {
                    // тут если заход прямой, нужен текущий урл
                    $cookies[] = cookie()->make('utm_source', 'DD', 259200);
                    $cookies[] = cookie()->make('utm_campaign', $request->url(), 259200);
                } else {
                    $host = parse_url($referrer, PHP_URL_HOST);
                    if( $utm_host = UtmHost::where('url', $host)->first() ) {
                        // тут выводим значения из пивот-таблицы в куки
                        foreach( $utm_host->utms as $utm ) {
                            $cookies[] = cookie()->make($utm->name, $utm->pivot->value, 259200);
                        }
                    } else {
                        $cookies[] = cookie()->make('utm_source', 'ND', 259200);
                        $cookies[] = cookie()->make('utm_campaign', $referrer, 259200);
                    }
                }
            }
        }

        return $cookies;
    }
}
