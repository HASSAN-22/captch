
### Laravel simple captcha

<h1>usage:</h1>

<p>You can use the "Captcha" facade to create an image and get the route<br>
</p>
<code>$path = \Captcha\app\Facades\Captcha::setOption()->imageText('number',4)->save()</code><br>
or<br>
<code>
$captcha = new Captcha\app\Captcha\Captcha();<br>
$path = $captcha ->setOption()->imageText()->save();
</code>

## setOption function
<p>This function performs a series of basic settings and has 6 inputs</p>
## parameters

| Parameter | type                                                                                    |                                       Description                                       |
|-----------|-----------------------------------------------------------------------------------------|:---------------------------------------------------------------------------------------:|
| bgColor   |Array|  You can set the color of the image, RGB color type default = [0,0,0]            |
| textColor |Array|  Set the color of the description text in RGB color type default = [255,255,255] |
| width     |int|  Specifies the width of the image  default = 300                                   |
| height    |int| Specifies the height of the image default = 100                                  |
| font      |string|  set the text font default = 'C:\Windows\Fonts\ALGER.TTF'                       |
| fontSize  |int|  customizes the text font size default = 30                                        |

### usage:
<code>setOption([0,0,0],[255,255,255],300,100,'C:\Windows\Fonts\ALGER.TTF',30)</code>


### imageText() function
<p>This function has two parameters and with this parameter you specify what the text of the image should be and how length it should be
The first parameter has these four values</p>
## Parameter

| Parameter  | type  |                                                          Description |
|-------------|----|---------------------------------------------------------------------|
| textType    | string | with this parameter you specify what the text of the image should be |
| maxLength   | integer |                                          Uses only lowercase letters |

## Values for textType

| Value    |                                       Description                                       |
|----------|:---------------------------------------------------------------------------------------:|
| number   | You only use the number       |
| lowerBet | Uses only lowercase letters |
| upperBet | You only use capital letters                  |
| mix      | uses uppercase and lowercase letters and numbers                 |

### usage: <code>imageText('lowerBet', 5)</code>

## save function
<p>This function saves the image and returns the path of the image, and it has a parameter that specifies whether the image should be saved in local storage or public storage.
</p>

### usage: <code>save(false or true)</code>
<hr>
<b> for validation you can use this</b><br>

### usage

<code>
$captchaText = \Captcha\app\Facades\Captcha::getText();<br>
$request->validate([
'captcha'=>["required","in:$captchaText "]
]);
</code>
