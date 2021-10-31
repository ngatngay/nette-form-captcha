<?php

    namespace NgatNgay\NetteFormCaptcha\Question;

    use Nette\InvalidArgumentException;

    class CaptchaQuestionText implements CaptchaQuestionFactory
    {

        public function __construct(
            private array $questions
        )
        {
        }

        public function get(): CaptchaQuestionData
        {
            if (empty($this->questions)) {
                throw new InvalidArgumentException('Question empty');
            }

            $question = array_rand($this->questions);
            $answer   = $this->questions[$question];

            return new CaptchaQuestionData(
                CaptchaQuestionData::TEXT,
                $question,
                $answer
            );
        }
    }