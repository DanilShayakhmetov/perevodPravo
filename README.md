# Translator CRM (Yii2 + Vue SPA)

## 📌 Описание проекта

Демонстрационный проект CRM для работы с переводчиками.
Позволяет:

* хранить список переводчиков
* учитывать их занятость
* учитывать рабочие дни (включая выходные)
* получать список доступных переводчиков через API
* отображать данные на фронтенде (Vue SPA)

---

## 🧱 Стек технологий

### Backend

* PHP 8+
* Yii2 Advanced
* MySQL
* Docker

### Frontend

* Vue 3
* Vite
* Fetch API

---

## 📁 Структура проекта

```
project/
├── backend/          # Yii2 API
├── common/           # Общие модели
├── console/          # Миграции
├── frontend/vue/     # Vue SPA
├── docker/           # Docker конфигурация
```

---

## 🚀 Запуск проекта

### 1. Клонирование

```bash
git clone <repo-url>
cd app
```

---

### 2. Запуск backend (Docker)

```bash
docker-compose up --build
```

Проверка:

```
http://localhost:21080/backend/web/index.php?r=translator/index
```

---

### 3. Применение миграций

```bash
docker exec -it app_backend_1 php yii migrate
```

---

### 4. Запуск frontend (Vue SPA)

```bash
cd frontend-vue
npm install
npm run dev
```

Открыть:

```
http://localhost:5173
```

---

## 🔌 API

### Получить всех переводчиков

```
GET /backend/web/index.php?r=translator/index
```

---

### Получить доступных переводчиков по дню

```
GET /backend/web/index.php?r=translator/available?day=1
```

#### Параметры:

* `day` — день недели (1–7)

---

### Пример ответа

```json
{
  "status": "ok",
  "data": [
    {
      "id": 1,
      "name": "Ivan Ivanov",
      "language": "en",
      "is_busy": 0,
      "schedules": [
        { "day_of_week": 1, "is_working": 1 }
      ]
    }
  ]
}
```

---

## 🗄️ Структура базы данных

### translator

| поле     | тип     | описание       |
| -------- | ------- | -------------- |
| id       | int     | ID             |
| name     | string  | Имя            |
| language | string  | Язык           |
| is_busy  | boolean | Занят/свободен |

---

### translator_schedule

| поле          | тип  | описание           |
| ------------- | ---- | ------------------ |
| id            | int  | ID                 |
| translator_id | int  | Связь с translator |
| day_of_week   | int  | День недели (1–7)  |
| is_working    | bool | Рабочий день       |

---

## 🔗 Связи

* Один переводчик → много записей расписания
* Используется relation:

```php
public function getSchedules()
{
    return $this->hasMany(TranslatorSchedule::class, ['translator_id' => 'id']);
}
```

---

## 🌐 CORS

Для работы Vue SPA включен CORS:

```php
'as corsFilter' => [
    'class' => \yii\filters\Cors::class,
    'cors' => [
        'Origin' => ['http://localhost:5173'],
        'Access-Control-Request-Method' => ['GET','POST','OPTIONS'],
    ],
],
```

---

