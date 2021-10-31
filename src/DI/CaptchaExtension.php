<?php

    namespace NgatNgay\NetteFormCaptcha\DI;

    use NgatNgay\NetteFormCaptcha\Captcha;
    use NgatNgay\NetteFormCaptcha\CaptchaFactory;
    use NgatNgay\NetteFormCaptcha\Form\CaptchaBinder;
    use NgatNgay\NetteFormCaptcha\Question\CaptchaQuestionNumeric;
    use NgatNgay\NetteFormCaptcha\Question\CaptchaQuestionText;
    use Nette\DI\CompilerExtension;
    use Nette\PhpGenerator\ClassType;
    use Nette\PhpGenerator\PhpLiteral;
    use Nette\Schema\Expect;
    use Nette\Schema\Schema;

    class CaptchaExtension extends CompilerExtension
    {
        public const DATASOURCE_NUMERIC   = 'numeric';
        public const DATASOURCE_QUESTIONS = 'question';

        public const DATASOURCES = [
            self::DATASOURCE_NUMERIC,
            self::DATASOURCE_QUESTIONS,
        ];


        public function getConfigSchema(): Schema
        {
            return Expect::structure([
                'autoload'  => Expect::bool()->default(true),
                'type'      => Expect::anyOf(...self::DATASOURCES)->default(self::DATASOURCE_NUMERIC),
                'questions' => Expect::arrayOf('string')
            ]);
        }


        public function loadConfiguration(): void
        {
            $builder = $this->getContainerBuilder();


            // add data question factory
            $dataSource = $builder->addDefinition($this->prefix('type'));

            if ($this->config->type === self::DATASOURCE_QUESTIONS) {
                $dataSource->setFactory(CaptchaQuestionText::class, [$this->config->questions]);
            } else {
                $dataSource->setFactory(CaptchaQuestionNumeric::class);
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