<?php

    namespace NgatNgay\NetteFormCaptcha\Question;

    use Gregwar\Captcha\CaptchaBuilder;


    class CaptchaQuestionImage implements CaptchaQuestionFactory
    {
        public function get(): CaptchaQuestionData
        {
            $builder = new CaptchaBuilder;
            $builder->build();

            // base64 image
            $question = $builder->inline();
            $answer   = $builder->getPhrase();

            return new CaptchaQuestionData(
                CaptchaQuestionData::IMAGE,
                $question,
                $answer
            );
        }
    }