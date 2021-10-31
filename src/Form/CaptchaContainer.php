<?php

namespace NgatNgay\NetteFormCaptcha\Form;

    use Nette\Forms\Container;
    use Nette\Forms\Controls\HiddenField;
    use Nette\Forms\Controls\TextInput;
    use Nette\Utils\Html;
    use NgatNgay\NetteFormCaptcha\CaptchaFactory;
    use NgatNgay\NetteFormCaptcha\Question\CaptchaQuestionData;
    use NgatNgay\NetteFormCaptcha\Services\CaptchaGenerator;
    use NgatNgay\NetteFormCaptcha\Services\CaptchaValidator;

    class CaptchaContainer extends Container
    {
        private CaptchaGenerator $generator;
        private CaptchaValidator $validator;

        public function __construct(CaptchaFactory $factory)
        {
            $this->generator = $factory->createGenerator();
            $this->validator = $factory->createValidator();
            $question = $this->generator->generate();

            // question label
            $questionLabel = match ($question->getType()) {
                CaptchaQuestionData::IMAGE => Html::el('img')->src($question->getQuestion()),
                default => $question->getQuestion(),
            };

            // question display
            $textInput = new TextInput($questionLabel);
            $textInput->setRequired(true);

            // anwser hash
            $hiddenField = new HiddenField($question->getHash());

            $this['question'] = $textInput;
            $this['hash'] = $hiddenField;
        }

        public function getQuestion(): TextInput
        {
            return $this['question'];
        }

        public function getHash(): HiddenField
        {
            return $this['hash'];
        }

        public function addRule($validator, $message = null): TextInput
        {
            return $this->getQuestion()
                ->addRule($validator, $message);
        }

        public function setRequired($message): TextInput
        {
            return $this->addRule(fn(): bool => true === $this->verify(), $message);
        }

        public function verify(): bool
        {
            $form = $this->getForm(true);
            $answer = $form->getHttpData($form::DATA_LINE, $this->getQuestion()->getHtmlName());
            $hash = $form->getHttpData($form::DATA_LINE, $this->getHash()->getHtmlName());

            return $this->validator->validate($answer, $hash);
        }
    }
