# rollun-viewer

---
## [Оглавление](https://github.com/rollun-com/rollun-skeleton/blob/master/docs/Contents.md)

---

Каркас для создания приложений. 

* [Стандарты](https://github.com/rollun-com/rollun-skeleton/blob/master/docs/Standarts.md)

* [Quickstart](https://github.com/avz-cmf/saas/blob/master/docs/Quickstart.md)


### Установить NPM Зависимости

1) Установите себе [npm](https://www.npmjs.com/)  

2) Установите модуль компосера для загрузки npm зависимотей выполнив команду:  
       
       `composer global require fxp/composer-asset-plugin`

3) Что бы установить все зависимости выполните команду:  
       
        `composer install`
        
4) Следуйте инструкциям  

    > В случае возникновения ошибки   
    " Warning: Permanently added 'github.com,192.30.253.113' (RSA) to the list of known hosts.  
    Permission denied (publickey).  
    fatal: Could not read from remote repository.  
    Please make sure you have the correct access rights and the repository exists. "
    
    1) Создайте учетную записть на github (Если таковой нет)
    
    2) Сгенерируйте rsa key.
        > Для пользователей Win. После того как ключи были сгенерированы выполните следующее шаги.
        1) Перейдите в дерикторию Git/bin
      
        2) Запустите bash.exe/bash 
        
        3) выполните команду `ssh-agent -s`
        > Она выведеть пимерно след  
        SSH_AUTH_SOCK=/tmp/ssh-edDsfL0S0UiH/agent.4988; export SSH_AUTH_SOCK;
        SSH_AGENT_PID=7116; export SSH_AGENT_PID;
        echo Agent pid 7116;
        
        4) Скопиртуйте две первые строки и выполните их из под bash.
        
        5) Теперь запустите `ssh-add {path-to-ssh-rsa}`
        > Вместое {path-to-ssh-rsa} подставте путь к rsa ключу.
        
        6) Теперь запустите `ssh-add -l`, что бы убедится что ключ добавлен.
        > Команда должна вернуть что то подобного вида
        4096 89:12:b8:ff:6a:dx:d5:78:ff:d1:23:1a:f6:bq:82:97 /d/openserver/.ssh/rsa2 (RSA)
    
    3) Добавте публичный rsa ключ в учетную запись на github.
    
    4) Проделайте шаг `3` основного списка `Установить NPM Зависимости` еще раз.
      
