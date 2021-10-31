<?php

namespace NgatNgay\NetteFormCaptcha;

    use NgatNgay\NetteFormCaptcha\Services\CaptchaGenerator;
    use NgatNgay\NetteFormCaptcha\Services\CaptchaValidator;

    interface CaptchaFactory
    {
        public function createValidator(): CaptchaValidator;

        public function createGenerator(): CaptchaGenerator;
    }
