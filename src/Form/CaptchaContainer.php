<?php

    namespace NgatNgay\NetteFormCaptcha\Form;

    use NgatNgay\NetteFormCaptcha\CaptchaFactory;
    use NgatNgay\NetteFormCaptcha\Services\CaptchaGenerator;
    use NgatNgay\NetteFormCaptcha\Services\CaptchaValidator;
    use Nette\Forms\Container;
    use Nette\Forms\Controls\HiddenField;
    use Nette\Forms\Controls\TextInput;

    class CaptchaContainer extends Container
    {
        private CaptchaValidator $validator;
        private CaptchaGenerator $generator;

        public function __construct(CaptchaFactory $factory)
        {
            $this->generator = $factory->createGenerator();
            $this->validator = $factory->createValidator();
            $security        = $this->generator->generate();

            // question
            $textInput = new TextInput($security->getQuestion());
            $textInput->setRequired(true);

            // anwser hash
            $hiddenField = new HiddenField($security->getHash());

            $this['question'] = $textInput;
            $this['hash']     = $hiddenField;
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
            return $this->addRule(function (): bool {
                return $this->verify() === true;
            }, $message);
        }

        public function verify(): bool
        {
            $form   = $this->getForm(true);
            assert($form !== null);

            $answer = $form->getHttpData($form::DATA_LINE, $this->getQuestion()->getHtmlName());
            $hash   = $form->getHttpData($form::DATA_LINE, $this->getHash()->getHtmlName());

            return $this->validator->validate($answer, $hash);
        }
    }