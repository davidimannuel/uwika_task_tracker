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

<!-- ## How to Run the Project
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
    mv .env.dev .env
    ```
3. install depdencies
    ```bash
    composer install
    docker-compose -f compose.dev.yaml exec php-fpm composer install
    ```
4. build vite
    ```bash
    npm run build
    ```
5. run app via docker compose
    ```bash
    docker compose -f compose.dev.yaml up --build -d
    ```
6. database migrate
    ```bash
    docker-compose -f compose.dev.yaml exec php-fpm php artisan migrate
    ```
7. open http://127.0.0.1:8080/ in web browser -->
  
## Deployed App
open http://103.87.67.225/login