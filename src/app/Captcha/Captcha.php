<?php

namespace Captcha\app\Captcha;

use Illuminate\Support\Facades\Cache;

class Captcha
{
    private $HEIGHT;
    private $WIDTH;
    private $FONT;
    private $FONT_SIZE;
    private $IMAGE_TEXT;
    private $IMAGE;
    private $BG_COLOR;
    private $TEXT_COLOR;

    /**
     * Set option for image text
     * @param array $bgColor
     * @param array $textColor
     * @param int $width
     * @param int $height
     * @param string $font
     * @param int $fontSize
     * @return $this
     */
    public function setOption(array $bgColor=[0, 0, 0],array $textColor=[255, 25, 25], int $width=300, int $height=100, string $font='C:\Windows\Fonts\ALGER.TTF', int $fontSize=30){
        $this->WIDTH = $width;
        $this->HEIGHT = $height;
        $this->FONT = $font;
        $this->FONT_SIZE = $fontSize;
        $this->BG_COLOR = $bgColor;
        $this->TEXT_COLOR = $textColor;
        return $this;
    }


    /**
     * Create text for add to image
     * @param string $textType
     * @param int $maxLength
     * @return $this
     */
    public function imageText(string $textType='number', int $maxLength = 6): Captcha
    {
        $numbers = str_shuffle('0123456789');
        $alfaBet = str_shuffle('abcdefghijklmnopqrstuvwxyz');
        switch ($textType){
            case 'number': $this->IMAGE_TEXT = substr($numbers,0,$maxLength);break;
            case 'lowerBet': $this->IMAGE_TEXT = substr($alfaBet,0,$maxLength);break;
            case 'upperBet': $this->IMAGE_TEXT = substr(strtoupper($alfaBet),0,$maxLength);break;
            case 'mix': $this->IMAGE_TEXT = substr(str_shuffle(strtoupper($alfaBet).$alfaBet.$numbers),0,$maxLength);break;
        }
        return $this;
    }

    /**
     * Save the image to storage path or public path
     * @param bool $saveInStorage
     * @return string
     */
    public function save(bool $saveInStorage=false):string{
        $this->make();
        $imageName = request()->ip().'.png';
        if($saveInStorage){
            $imageName = 'app/public/'.$imageName;
        }
        $path = $saveInStorage == false ? public_path($imageName) : storage_path($imageName);
        imagepng($this->IMAGE, $path);
        imagedestroy($this->IMAGE);
        $this->saveTextInCache();
        return $imageName;
    }

    /**
     * Get image text
     * @return string
     */
    public function getText():string{
        return Cache::get(request()->ip()) ?? '';
    }

    /**
     * Make the captcha image
     * @return void
     */
    private function make():void{
        $this->IMAGE = imagecreate($this->WIDTH, $this->HEIGHT);
        $background_color = imagecolorallocate($this->IMAGE, $this->BG_COLOR[0],$this->BG_COLOR[1],$this->BG_COLOR[2]);
        $text_color = imagecolorallocatealpha($this->IMAGE, $this->TEXT_COLOR[0],$this->TEXT_COLOR[1],$this->TEXT_COLOR[2], 0);

        imagettftext($this->IMAGE, $this->FONT_SIZE, 0 ,((int)((30/100)*$this->WIDTH)), ((int)((60/100)*$this->HEIGHT)), $text_color, $this->FONT, $this->IMAGE_TEXT);
        $this->additionalTextToImage();
    }

    /**
     * Save the image text for validate
     * @return void
     */
    private function saveTextInCache():void{
        Cache::put(request()->ip(),$this->IMAGE_TEXT,now()->addMinutes(5));
    }

    /**
     * Add additional text to the image to avoid bots
     * @return void
     */
    private function additionalTextToImage():void{
        $textColor = imagecolorallocatealpha($this->IMAGE, 4, 4, 4, 20);
        for ($i = 1; $i<=$this->WIDTH; $i+=10){
            $x = $i*5;
            $y = rand(45,55);
            $angle = rand(0,360);
            $text ='!@#1$%%^2^&3*(789|4?5\6/';
            imagettftext($this->IMAGE, 30, abs($angle) ,$x, abs($y), $textColor, $this->FONT, str_shuffle($text));
            imagettftext($this->IMAGE, 30, abs($angle) ,$x, abs($y), $textColor, $this->FONT, str_shuffle($text));
        }
    }
}
