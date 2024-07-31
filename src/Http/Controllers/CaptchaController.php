<?php

namespace Infomap\Viewmap\Http\Controllers;

use Illuminate\Http\Request;

class CaptchaController extends Controller
{
    public function capthcaFormValidate(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'captcha' => 'required'
        ]);

        // Validate the captcha
        if (!capchaRule::validateCaptcha($request->captcha)) {
            return redirect()->back()->withErrors(['captcha' => 'Invalid captcha. Please try again.']);
        }

        // success message
        return redirect()->back()->with('captcha_success', 'Hi, we received your request.');
    }


    public function reloadCaptcha()
    {
        $configCaptchaType = config('captcha.CAPTCHA_TYPE');

        // Initialize variable to store captcha type
        $captchaType = '';

        // If the config number is 0, set captcha type to 'flat' (alphanumeric)
        // If it's 1, set captcha type to 'math'
        if ($configCaptchaType == 0) {
            $captchaType = 'alphanumeric';
        } else {
            $captchaType = 'math';
        }

        // the generated type will be stored in the captchaImage
        $captchaImage = captcha_img($captchaType);

        // Return JSON response with the generated captcha image
        return response()->json(['captcha' => $captchaImage]);
    }

    public static function generateCaptcha()
    {
        $configCaptchaType = config('captcha.CAPTCHA_TYPE');

        // If the config number is 0, generate a 'flat' (alphanumeric) captcha,
        // otherwise, generate a 'math' captcha
        if ($configCaptchaType == 0) {
            return captcha_img('alphanumeric');
        } else {
            return captcha_img('math');
        }
    }
}
