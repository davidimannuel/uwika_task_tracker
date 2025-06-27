# Task Tracker

## Project Overview
**Task Tracker** is a web-based application designed to help users manage and track their tasks efficiently. This project is developed as part of the final assessment (UAS) for the courses **Rekayasa Perangkat Lunak (RPL)**, **Interaksi Manusia dan Komputer (IMK)**, and **Pemrograman Web** at **Universitas Widya Kartika**.

---

## Developer Information
- **Name:** David Prastiya Imannuel  
- **NRP:** 31123022  

---

## Tech Stack
This project is built using the following technologies:
- **PHP**: Backend programming language.
- **Laravel**: PHP framework for building robust web applications.
- **Livewire**: A full-stack framework for Laravel that simplifies building dynamic interfaces.
- **PostgreSQL**: Relational database for storing application data.

---

## Features
- Task creation, editing, and deletion.
- Real-time updates using Livewire.
- User-friendly interface designed with IMK principles.
- Secure and efficient data storage with PostgreSQL.

---

## How to Run the Project
### Prerequisites
Ensure you have the following installed:
- Docker and Docker Compose

### Steps
1. Clone the repository:
    ```bash
    git clone <repository-url>
    cd uwika_task_tracker
    ```
2. Copy the env
    ```bash
    cp .env.dev .env
    ```
3. Build docker
    ```bash
    docker compose -f compose.dev.yaml build --no-cache
    ```
4. Run docker compose
    ```bash
    docker compose -f compose.dev.yaml up -d
    ```
5. Open workspace container to run neccesary command
    ```bash
    docker exec -it uwika-task-tracker-development-workspace bash
    ```
5. After inside workpsace container run some commands
    ```bash
    composer install # install laravel project depedencies
    php artisan migrate # migrate
    npm run dev -- --host # run npm --host for expose
    ```
5. After running open http://127.0.0.1:8080/ in web browser

6. Stop application
    ```bash
    docker compose -f compose.dev.yaml down
    ```
  
## How to deploy
### Prerequisites
Ensure you have the following installed:
- Docker and Docker Compose

### Steps
1. Clone the repository:
    ```bash
    git clone <repository-url>
    cd uwika_task_tracker
    ```
2. Copy the env, and dont forget to adjust
    ```bash
    cp .env.dev .env
    ```
3. Build docker
    ```bash
    docker compose -f compose.prod.yaml build --no-cache
    ```
4. Run docker compose
    ```bash
    docker compose -f compose.prod.yaml up -d
    ```
5. After running please check on the browser
6. Stop application
    ```bash
    docker compose -f compose.prod.yaml down
    ```

## Deployed App
open http://103.87.67.225/login