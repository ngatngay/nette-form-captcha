<?php

    namespace NgatNgay\NetteFormCaptcha\Question;

    final class CaptchaQuestionData
    {
        public function __construct(
            public string $question,
            public string $answer
        )
        {
        }

        public function getQuestion(): string
        {
            return $this->question;
        }

        public function getAnswer(): string
        {
            return $this->answer;
        }
    }
