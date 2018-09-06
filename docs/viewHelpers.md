# ViewHelper`ы для работы с rgrid
```
    Правила, описанные в этом документе, касаются исключительно viewhelper'ов, описанных
    в этом документе
```

Все компоненты библиотеки `rgrid` могут быть добавлены на страницу с помошью
viewHelper'ов.
ViewHelper`ы бывают двух видов: простые и настраиваемые.

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

## ViewHelper Dojo
Dojo и наш js код можно добавить на страницу с помощью viewhelper'а
`DojoLoaderViewHelper`. Этот хелпер доступен из view в виде методa `dojo()`.

    Этот хелпер необходим длоя работы других хелперов. Без него не будет
    работать наш js код. Он вызывается из кода других хелперов, но если он
    вызывается отдельно, то он должен быть первым вызванным хелпером.

Функционал  DojoLoaderViewHelper доступен через ряд методов, описанных ниже.
DojoLoaderViewHelper умеет делать следующее
* Добавлять на страницу загрузчик Dojo с помощью метода `render().`
    ```
    $view->dojo()->render()
    ```
* Регистрировать новые пакеты Dojo с помощью метода `register($packageName, $url)`,
где `$packageName` - имя пакета, а `$url` - его URL.
    ```
    $view->dojo()->register(‘myPackage, ‘my/package/location’)
    ```
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
```
    $view->dojo()->changeVersion(‘rgrid', ‘0.5.2’)
```
* Возвращать версии библиотек с помощью метода `getVersions()`. Этот метод
возвращает массив, в котором ключи это имена библиотек, а значения - версии
в виде строки semver.
```
    $view->dojo()->getVersions()
```
* Переключать дебаг режим Dojo с помощью метода `setDebug($isDebug)`, где `$isDebug` -
булева переменная, которая показывает, включать дебаг или нет
```
    $view->dojo()->setDebug(true)
```
# Создание виджетов для навигации
Виджеты для навигации могут создаваться с помощью NavbarHelper и LeftSideBarHelper.
Они, сответственно, создают navbar и боковое меню.

## NavbarHelper
NavbarHelper доступен из view в виде методa `addNavbar()`.
```
    $view->dojo()->addNavbar()
```
Настраивается этот хелпер с помощьбю конфига. Конфиг помещается на верхний
уровень файла конфига с ключом `navbar` (NavbarHelperFactory::KEY). Конфиг
описан [в доке по js компоненту NavMenu](https://github.com/rollun-com/rollun-rgrid/blob/master/docs/modules/NavigationVidgets.md#navmenu)
Пример конфига:
```
 NavbarHelperFactory::KEY => [
        [
            'label' => 'Тестовые страницы',
            'content' => [
                [
                    'label' => 'Тестовая главная',
                    'uri' => '/'
                ],
                [
                    'label' => 'Тестовая таблица',
                    'uri' => '/example-grid'
                ],
            ]
        ],
        [
            'label' => 'pane 2',
            'content' => [
                [
                    'label' => 'service 3',
                    'uri' => 'service/1/uri'
                ],
                [
                    'label' => 'service 4',
                    'content' => [
                        [
                            'label' => 'subservice 1',
                            'uri' => 'subservice/1/uri'
                        ],
                        [
                            'label' => 'subservice 2',
                            'uri' => 'subservice/1/uri'
                        ],
                    ]
                ],
            ]
        ],
    ],
```
## LeftSideBarHelper
 LeftSideBarHelper доступен из view в виде методa `addLsb($lsbConfig)`.
 ```
    $view->dojo()->addLsb($lsbConfig)
```
 lsbConfig описан [в доке по js компоненту NavPanes](https://github.com/rollun-com/rollun-rgrid/blob/master/docs/modules/NavigationVidgets.md#navmenu)
 LsbConfig следует размещать в контролллере страницы, к которой онотносится. Ключ
 конфига (LeftSideBarHelper::KEY_PARAMS) нужно разместить на верхнем уровне
 конфига параметров, которые добавляются в шаблон.
 Пример конфига:
 ```
 LeftSideBarHelper::KEY_PARAMS => [
                     [
                         'label' => 'pane 1',
                         'content' => [
                             [
                                 'label' => 'page 1',
                                 'uri' => 'service/1/uri'
                             ],
                             [
                                 'label' => 'page 2',
                                 'uri' => 'service/2/uri'
                             ],
                         ]
                     ],
                     [
                         'label' => 'pane 2',
                         'content' => [
                             [
                                 'label' => 'page 1',
                                 'uri' => 'service/1/uri'
                             ],
                             [
                                 'label' => 'page 2',
                                 'uri' => 'service/2/uri'
                             ],
                         ]
                     ],
                 ],
 ```
## Rgrid Helper
Добаляет на страницу ноду, в которую будет размещён rgrid, и скрипт, который
создаст rgrid после того, как будет отрисован весь html
* *Параметры* передаются с помощью метода `setParams($params)`. О параметрах
можно прочитать [в доке по фабрике компонента Rgrid](https://github.com/rollun-com/rollun-rgrid/blob/master/docs/composite/Prefabs.md#rgrid-prefab)
    ```
    $view->rgrid()->setParams($rgridParams)
    ```
* *Стартовая страница* задаётся с помощью метода `setStartPage($startPage)`, где
`$startPage` - номер желаемой страницы. Можно открыть *последнюю страницу*,
передав в параметре `$startPage` строку `'last'`
    ```
    $view->rgrid()->setStartPage('last')
    ```
* Добавление компонента на страницу выполняет метод `render()`
    ```
    $view->rgrid()->render()
    ```

Простейший конфиг выглядит так:
```
[
    [
        'id' => 'rgrid',
        'gridTarget' => 'api/datastore/my/store'// имя хранилища, которое отрисует таблица
    ]
]
```

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


