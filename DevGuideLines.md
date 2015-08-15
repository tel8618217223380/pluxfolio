## Текущее ограничение размера архива ##
До версии 1.5 размер архива системы не должен превышать 500кб.

## Рефакторинг и чистка кода ##
Рефакторинг и чистку кода от закомментированных более 2 версий назад кусков кода следует проводить каждые 0.5 мажорных версий. Т.е. данному правилу будут подвержены версии: 0.5, 1.0, 1.5 и т.д.

При работе над данными версиями не рекомендуется добавлять новый функционал, сосредоточившись над улучшением работы и уменьшением размера архива.

## Минорные версии ##
Минорные версии (версии, у которых меняется второй и более знак после точки) следует считать заплатками, т.е. направленными на исправление различного рода ошибок системы. При разработке минорных версий крайне не рекомендуется добавлять новый функционал.

## Roadmap разработки к версии 2.0 ##
  1. Удалить из библиотек все неиспользуемые функции
  1. Переписать систему для использования в качестве хранилища файлов формата json
  1. Добавить возможность отключения функции блога
  1. Добавить возможность построения двухуровневого меню