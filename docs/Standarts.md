# Viewer
 Модуль который позволяет отображать сервисы.

 
##QuickStart 
 
 Для создание отображения существуею ViewerPipeLine который вы должны добавить себе в конфиг
 
 Пример:
```php
    'routes' => [
        [
            'name' => 'viewer',
            'path' => '/viewer[/{Resource-Name}]',
            'middleware' => \rollun\viewer\Pipe\ViewerPipe::class,
            'allowed_methods' => ['GET'],
        ],
    ],
```

Данный pipeLine будет искать сервис по имени Viewer{Service-Name} 
c помощью которого будет получать отображения для требуемого сервиса.

По умолчанию существует `DataStoreViewer` - который позволяет отобразить DataStore.

## Работа с модулем.

Вы можете писать свои Viewer, они должны реализовывать интерфейс ViewerInterface.

## DataStore
Если вы хотите отображать DataStore более специфически вы можете создать свой Viewer
который будет наследником DataStoreViewer и поместить его в конфигурацию  
```php
'Viewers' => [
        'DataStore' => [
            '{ViewerName}' => {Viewer::class}
        ]
    ]
```

Либо создать полностью свой Viewer если вам нужна более гибкая натсройка.