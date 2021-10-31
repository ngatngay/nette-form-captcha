# Nette Form Captcha

Simple Captcha

## Install

```
composer require ngatngay/nette-form-captcha:dev-master
```

## Setup

Config

```
extensions:
    captcha: NgatNgay\NetteFormCaptcha\DI\CaptchaExtension
    
captcha:
    autoload: yes
    type: question # or numeric
    questions:
        "Question 1?": "1"
        "Question 2?": "2"
       
```

## Form

```php
use Nette\Application\UI\Form;

public function createComponentForm()
{
    $form = new Form();
    
    $form->addCaptcha('captcha', 'Are you robot?');
    
    $form->addSubmit('send');
    
    $form->onSuccess[] = function (Form $form) {
        dump($form['captcha']);
    };
    
    return $form;
}
```

## Render

```
{control form}
```

## Example

![image](https://raw.githubusercontent.com/ngatngay/nette-form-captcha/master/screenshot.png)

![image](https://raw.githubusercontent.com/ngatngay/nette-form-captcha/master/screenshot2.png)

