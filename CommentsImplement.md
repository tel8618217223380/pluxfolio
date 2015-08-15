

## Intensedebate ##

## Disqus ##

## Комментарии ВКонтакте ##

  1. Перейдите по ссылке http://vkontakte.ru/developers.php?o=-1&p=Comments.
  1. Произведите необходимые настройки системы комментирования и скопируйте сгенерированый системой код.
  1. Вставьте часть кода, идущую после ` <!-- Put this script tag to the <head> of your page --> ` между тегами `<head>` и `</head>`
  1. Вставьте часть кода, идущую после ` <!-- Put this div tag to the place, where the Comments block will be --> ` после `</div>` в файле **article.php** (/themes/_ваша`_`тема_/). См. приведенный ниже код:
```
<?php $plxShow->artContent(); ?>
</div>
```
  1. Сохраните файл **article.php** и перезапишите существующий на вашем сайте

## Facebook Connect ##

  1. Перейдите по ссылке http://developers.facebook.com/setup/ и создайте профиль сайта.
  1. Скачайте файл **xd\_receiver.htm** и поместите его в корень сайта, чтобы facebook смог авторизовать ваш сайт. Пример: http://mysite.ru/xd_receiver.htm
  1. Нажмите кнопку "Test Setup and Continue"
  1. На странице "Facebook Connect Playground" произведите необходимые настройки системы комментирования и скопируйте сгенерированый системой код.
  1. Вставьте полученный код после `</div>` в файле **article.php** (/themes/_ваша`_`тема_/). См. приведенный ниже код:
```
<?php $plxShow->artContent(); ?>
</div>
```
  1. Сохраните файл **article.php** и перезапишите существующий на вашем сайте