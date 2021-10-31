<?php

    namespace NgatNgay\NetteFormCaptcha\Services;

    final class CaptchaGenerated
    {
        public function __construct(
            private string $question,
            private string $hash
        )
        {
        }

        public function getQuestion(): string
        {
            return $this->question;
        }

        public function getHash(): string
        {
            return $this->hash;
        }
    }