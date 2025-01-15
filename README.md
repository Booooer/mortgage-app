# Laravel API Skeleton ☠️

Скелет Laravel проекта для REST API

## Создание приложения

Для инициализации нового приложения из скелетона нужно добавить репозиторий в глобальный конфиг своего композера:

```bash
composer config --global --editor
```
Добавить репозиторий скелетона (на своей машине эту операцию нужно проделать только один раз... и на всю жизнь...)
```json
{
  "config": {},
  "repositories": [
    {
      "type": "vcs",
      "url": "git@git.digital.72dom.online:dom-dev/skeleton-app.git"
    }
  ]
}
```
А затем выполнить команду:
```bash
composer create-project dom-dev/skeleton-app my-not-uninteresting-project --remove-vcs
```

Затем после установки всех зависимостей перейдём в каталог с созданным проектом:

```bash
cd ./my-not-uninteresting-project
```

Далее подключаем гит репозиторий для нашего нового проекта:

```bash
git init --initial-branch=master
git remote add origin git@git.digital.72dom.online:<PROJECT_URL_SCOPE.git>
git add . 
git commit -m "Initial commit"
git push -u origin master
```
Настраиваем окружение в .env (обращаем внимание на форвард-порты в систему и настройки дебагера):
```dotenv
FORWARD_DB_PORT=
FORWARD_REDIS_PORT=
VITE_PORT=
APP_PORT=

CLOCKWORK_ENABLE=

XDEBUG=false
XDEBUG_PORT=9008
```

Добавь alias в ~/.bashrc (после не забудь выполнить `source ~/.bashrc`):
```bash
alias sail='[ -f sail ] && sh sail || sh vendor/bin/sail'
```
После этого запускаем sail:
```bash
sail up -d
```
Затем выполним инициализацию базы данных:

```bash
sail artisan migrate --seed
```

И теперь приложение должно работать по ссылке http://127.0.0.1:[APP_PORT]
