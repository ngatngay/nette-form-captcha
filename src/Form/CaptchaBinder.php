<?php

    namespace NgatNgay\NetteFormCaptcha\Form;

    use NgatNgay\NetteFormCaptcha\CaptchaFactory;
    use Nette\Forms\Container;

    final class CaptchaBinder
    {
        public static function bind(CaptchaFactory $factory): void
        {
            Container::extensionMethod(
                'addCaptcha',
                function (
                    Container $container,
                    string    $name,
                    string    $requireMessage
                ) use ($factory): CaptchaContainer {
                    $captcha = $container[$name] = new CaptchaContainer($factory);
                    $captcha->setRequired($requireMessage);

                    return $captcha;
                }
            );
        }
    }