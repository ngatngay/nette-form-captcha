<?php

    namespace NgatNgay\NetteFormCaptcha;

    use NgatNgay\NetteFormCaptcha\Question\CaptchaQuestionFactory;
    use NgatNgay\NetteFormCaptcha\Services\CaptchaGenerator;
    use NgatNgay\NetteFormCaptcha\Services\CaptchaValidator;

    class Captcha implements CaptchaFactory
    {
        public function __construct(
            private CaptchaQuestionFactory $captchaQuestionFactory
        )
        {
        }

        public function createValidator(): CaptchaValidator
        {
            return new CaptchaValidator($this->createGenerator());
        }

        public function createGenerator(): CaptchaGenerator
        {
            return new CaptchaGenerator($this->captchaQuestionFactory);
        }
    }