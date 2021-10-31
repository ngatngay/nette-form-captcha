<?php

    namespace NgatNgay\NetteFormCaptcha\DI;

    use NgatNgay\NetteFormCaptcha\Captcha;
    use NgatNgay\NetteFormCaptcha\Form\CaptchaBinder;
    use NgatNgay\NetteFormCaptcha\Question\CaptchaQuestionData;
    use NgatNgay\NetteFormCaptcha\Question\CaptchaQuestionImage;
    use NgatNgay\NetteFormCaptcha\Question\CaptchaQuestionNumeric;
    use NgatNgay\NetteFormCaptcha\Question\CaptchaQuestionText;
    use Nette\DI\CompilerExtension;
    use Nette\PhpGenerator\ClassType;
    use Nette\PhpGenerator\PhpLiteral;
    use Nette\Schema\Expect;
    use Nette\Schema\Schema;

    class CaptchaExtension extends CompilerExtension
    {
        public const DATA_QUESTION = [
            CaptchaQuestionData::NUMERIC,
            CaptchaQuestionData::TEXT,
            CaptchaQuestionData::IMAGE
        ];


        public function getConfigSchema(): Schema
        {
            return Expect::structure([
                'autoload'  => Expect::bool()->default(true),
                'type'      => Expect::anyOf(...self::DATA_QUESTION)->default(CaptchaQuestionData::NUMERIC),
                'questions' => Expect::arrayOf('string')
            ]);
        }


        public function loadConfiguration(): void
        {
            $builder = $this->getContainerBuilder();

            // add data question factory
            $dataQuestion = $builder->addDefinition($this->prefix('data'));

            switch ($this->config->type) {
                case CaptchaQuestionData::TEXT:
                    $dataQuestion->setFactory(CaptchaQuestionText::class, [$this->config->questions]);
                    break;
                case CaptchaQuestionData::IMAGE:
                    $dataQuestion->setFactory(CaptchaQuestionImage::class);
                    break;
                default:
                    $dataQuestion->setFactory(CaptchaQuestionNumeric::class);
            }

            // add factory
            $builder->addDefinition($this->prefix('factory'))
                ->setFactory(Captcha::class);
        }

        public function afterCompile(ClassType $class): void
        {
            if ($this->config->autoload == true) {

                $method = $class->getMethod('initialize');
                $method->addBody(
                    '?::bind($this->getService(?));',
                    [
                        new PhpLiteral(CaptchaBinder::class),
                        $this->prefix('factory'),
                    ]
                );
            }
        }
    }