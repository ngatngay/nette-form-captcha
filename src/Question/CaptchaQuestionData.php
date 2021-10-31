<?php

    namespace NgatNgay\NetteFormCaptcha\Question;

    final class CaptchaQuestionData
    {
        const NUMERIC = 'numeric';
        const TEXT    = 'text';
        const IMAGE   = 'image';


        public function __construct(
            public string $type,
            public string $question,
            public string $answer
        )
        {
        }

        public function getType(): string
        {
            return $this->type;
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
