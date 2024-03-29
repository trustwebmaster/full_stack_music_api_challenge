# ZATEC FULL STACK CODING CHALLENGE

Welcome to the ZATEC Full Stack Coding Challenge! This project is a full-stack application built with Laravel (backend) and Vue.js (frontend). Follow the instructions below to set up and run the project on your local machine.

## Requirements
Ensure you have the following prerequisites installed on your machine:
- PHP version **8.1** or above
- Node.js version **14.0** or above

## Installation

### Backend

1. **Clone the Project:**
   ```bash
   git clone https://github.com/trustwebmaster/full_stack_music_api_challenge.git

2. **Navigate to Project Directory:**
   ```bash
   cd full_stack_music_api_challenge
   
3. **Install Laravel Dependencies:**
   ```bash
   composer install

4. **Create Database:**
    Create a new database for your project.

5. **Configure Environment:**
   Duplicate the .env.example file to create a new .env file.
   Open .env and set up your database connection and other configuration parameters.

6. **Run Laravel with Docker:**
   ```bash
   ./vendor/bin/sail up

  The Laravel project will be accessible at http://localhost:8000.

### FRONTEND
1. **Navigate to Vue.js Folder:**
   ```bash
    cd frontend

2. **Install Vue.js Dependencies:**
    ```bash 
    npm install

3. **Configure Vue.js Environment:**
   Duplicate the frontend/.env.example file to create a new frontend/.env file.
   Open frontend/.env and specify the API URL according to your Laravel backend.

4. **Run Vue.js with Docker:**
   ./vendor/bin/sail up

The Vue.js frontend will be accessible at http://localhost:5173.

###Project Access
Once both backend and frontend are set up using Docker, you can access the full application. Open your web browser and go to http://localhost:5173 for the Vue.js frontend.
