<?php

namespace Captcha\app\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @method static Captcha setOption(array $bgColor=[0, 0, 0],array $textColor=[255, 255, 255], int $width=300, int $height=100, string $font='C:\Windows\Fonts\ALGER.TTF', int $fontSize=30)
 * @method static Captcha imageText(string $textType='number', int $maxLength = 6)
 * @method static Captcha getText()
 * @method static void make()
 * @method static string save(bool $saveInStorage=false)
 *
 * @see \Captcha\app\Captcha\Captcha
 */

class Captcha extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'Captcha\app\Captcha\Captcha';
    }
}
