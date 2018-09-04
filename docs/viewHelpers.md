# ViewHelper`ы в сервисе web-ui

ViewHelper`ы  в service-web-ui бывают двух видов: простые и настраиваемые
## Простые ViewHelper`ы:
* Представляют из себя invocable обьект.
* Такой обьект выполняет одно действие при рендеринге шаблона
* Alias такого viewHelper`а содержит глаголы и описывает результат его работы
## Настраиваемые ViewHelper`ы:
* Не  invocable обьект.
* Представляет из себя строитель, который в итоге возвращает сложный обьект при рендеринге шаблона
* Предоставляет возможность конфигурирования создаваемого обьекта через свой интерфейс.
* Обязан реализовывать метод render(), который будет возвращать результат работы viewHelper`а
* Alias такого viewHelper`а не содержит глаголы и являет собой название модуля, который в итоге вернет этот хелпер

# Создание виджетов для навигации
Виджеты для навигации могут создаваться с помощью NavbarHelper и LeftSideBarHelper.
Они, сответственно, создают navbar и боковое меню.

## NavbarHelper
NavbarHelper доступен из view в виде методa addNavbar().
Настраивается этот хелпер с помощьбю конфига. Конфиг помещается на верхний
уровень файла конфига с ключом navbar (NavbarHelperFactory::KEY). Конфиг
описан [в доке по js компоненту NavMenu](https://github.com/rollun-com/rollun-rgrid/blob/master/docs/modules/NavigationVidgets.md#navmenu)
## LeftSideBarHelper
 LeftSideBarHelper доступен из view в виде методa addLsb($lsbConfig). lsbConfig
 описан [в доке по js компоненту NavPanes](https://github.com/rollun-com/rollun-rgrid/blob/master/docs/modules/NavigationVidgets.md#navmenu)
## ViewHelper Dojo
Dojo и наш js код можно добавить на страницу с помощью viewhelper`а DojoLoaderViewHelper.
Этот хелпер доступен из view в виде методa dojo().
Функционал  DojoLoaderViewHelper доступен через ряд методов, описанных ниже.
Используeтся он, например, так:
```$view->dojo()->register(‘myPackage, ‘my/package/location’)```
Или
```$view->dojo()->render()```
DojoLoaderViewHelper умеет делать следующее
* Добавлять на страницу загрузчик Dojo с помощью метода `render().`
* Регистрировать новые пакеты Dojo с помощью метода `register($packageName, $url)`,
где `$packageName` - имя пакета, а `$url` - его URL.
* Регистрировать несколько пакетов за раз с помощью метода `multiRegister($packages)`,
где `$packages` - массив типа :
```
[
    [
        ‘name’ => ‘myCoolPackage’,
        ‘location’ => ‘my/cool/package/location’
    ],
    [
        ‘name’ => ‘myOtherPackage’,
        ‘location’ => ‘my/other/package/location’
    ],
//…
]
```
* Менять версии библиотек с помощью метода `changeVersion($libName, $version)`,
где `$libName` - имя библиотеки, версию которой вы хотите изменить, а `$version` -
строка с версией в формате semver.
* Возвращать версии библиотек с помощью метода getVersions(). Этот метод
возвращает массив, в котором ключи это имена библиотек, а значения - версии
в виде строки semver.
* Переключать дебаг режим Dojo с помощью метода `setDebug($isDebug)`, где `$isDebug` -
булева переменная, которая показывает, включать дебаг или нет

## Rgrid Helper
Добаляет на страницу ноду, в которую будет размещён rgrid, и скрипт, который
создаст rgrid после того, как будет отрисован весь html
* *Параметры* передаются с помощью метода `setParams($params)`. О параметрах
можно прочитать [в доке по фабрике компонента Rgrid](https://github.com/rollun-com/rollun-rgrid/blob/master/docs/composite/Prefabs.md#rgrid-prefab)
* *Стартовая страница* задаётся с помощью метода `setStartPage($startPage)`, где
`$startPage` - номер желаемой страницы. Можно открыть *последнюю страницу*,
передав в параметре `$startPage` строку `'last'`
* Добавление компонента на страницу выполняет метод `render()`

# Передача специфических значений в JS модули
Если в  js код нужно передать функцию, то нужно передать её имя в следующем виде:
`func{<имя функции>}`.
* Функция <имя функции> должна хранится в js конфиге

Запись выглядит следующим образом:
```
{
    ‘id’: ‘<имя функции>’,
    func: ‘<тело функции>’,
}
```
Встретив запись “func{<имя функции>}”, js фабрики будут пытаться достать
свойство `<имя функции>` из своего конфига.
Если в  js код нужно передать rql query, то сделать это можно, передав её
в следующем виде : `rql{<rql строка>}`
Фабрика превратит такую запись в rollun-rql query обьект и передаст его модулю


