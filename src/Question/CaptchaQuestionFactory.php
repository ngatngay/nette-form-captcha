<?php

namespace NgatNgay\NetteFormCaptcha\Question;

    interface CaptchaQuestionFactory
    {
        public function get(): CaptchaQuestionData;
    }
