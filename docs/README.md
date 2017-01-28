#rollun-viewer

Библиотека предоставляет набор шаблонов и DSDojoHtmlParamResolver.
DSDojoHtmlParamResolver позволит отобажать DataStore используя компонент dojo DataStoreView.
Это дает возможность использовать фильтры, и удобно работать с даными которые находятся в хранилище.

## QuickStart

Что бы использовать даную библиотеку, скопируйте конфиги
 
* `actionRender.viewer.global.php`
* `actionRender.ds.global.php`
* `actionRender.global.php`

Так же скопируйте шаблоны 
* `app::api-rest.html.twig`
* `layout::default.html.twig`
* `layout::dojo.html.twig`

> Так же вам нужно что мы имя роута для dataStore называлось `api-rest`. 
Либо вы можете изменить на ваше в шаблонах при создании url.

Теперь вы можете просматривать dataStore используя Dojo DataStoreViewer.