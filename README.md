# SIGR - SISTEMA DE INFORMACIÓN PARA LA GENERACIÓN DE REPORTES

This project was generated with [Angular CLI](https://github.com/angular/angular-cli) version 9.0.0-rc.7

## Demo

[Live view](https://unilibre.bisont.co)

## Requirements

1. Xampp (for local purposes)
   - [Donwload on this page](https://www.apachefriends.org/es/index.html)
2. MySql
   - Content in the Xampp program
3. PHP
   - Content in the Xampp program
4. NodeJS
   - You should install [NodeJS](https://nodejs.org/en/)
5. NPM

   - Install npm
     - npm is installed with Node.js
     - npm is distributed with Node.js- which means that when you download Node.js, you automatically get npm installed on your computer.
   - Check that you have node and npm installed

   ```
   node -v
   ```

   - To confirm that you have npm installed you can run this command in your terminal:

   ```
   npm -v
   ```

6. Angular (angular-cli)
   - You can run this command in your terminal:
   ```
   npm install -g @angular/cli
   ```

## Quick start (development purposes)

1. Go to the folder project on your computer (terminal)
2. Install packages
   ```
   npm install
   ```
3. After all packages are installed
   ```
   npm start
   ```
4. We need to open another terminal for comunication with the backend (PHP):
   ```
   php -S 127.0.0.1:8000
   ```
5. Create a database with the following requirements:

   - User: `root`
   - Password: `Only if you have a password in the xampp user configuration`
   - Name: `unilibre_db`

6. Import the database from `localhost/phpmyadmin` in your web browser

   - The database can be found in the path of the project folder `unilibre.cpanel.reports.v2/backend/sql/unilibre_db.sql`
   - Import the file and the database will be uploaded

7. After all this process you can visit the path in your web browser `localhost:4200`

## Quick start (production purposes)

1. Go to the folder project on your computer (terminal)
2. Install packages (if you don't have the node_modules installed)
   ```
   npm install
   ```
3. We need to open another terminal for comunication with the backend (PHP):
   ```
   php -S 127.0.0.1:8000
   ```
4. Create a database with the following requirements (if you don't have the database installed):

   - User: `root`
   - Password: `Only if you have a password in the xampp user configuration`
   - Name: `unilibre_db`

5. Import the database from `localhost/phpmyadmin` in your web browser (if you don't have the database installed):

   - The database can be found in the path of the project folder `unilibre.cpanel.reports.v2/backend/sql/unilibre_db.sql`
   - Import the file and the database will be uploaded

6. Run this command on your terminal (this command generates a production folder called **app**):

   ```
   ng build --prod
   ```

7. After the production folder was generated can be found in the path of the project folder `unilibre.cpanel.reports.v2/app`

8. Copy the contents of the folder and paste into the path `C:\xampp\htdocs` or where you have installed xampp

9. After all this process you can visit the path in your web browser `localhost/app`

## Credentials

Administrator role:

- User: `jecorrales@bisont.co`
- Password: `1088025076_dev`

Generator role:

- User: `jdcastano@bisont.co`
- Password: `1225088503`

## Remember:

> You have to start the MySQL and APACHE server from XAMPP.

## Authors

1. [Juan Diego Castaño Franco](https://github.com/juand9724) Systems engineer student
2. [Johan Esteban Corrales Aguirre](https://github.com/jecorrales3) Systems engineer student

## Template

A mobile first design of a responsive admin template built with angular and bootstrap by [Mohamed Azouaoui](https://github.com/azouaoui-med/lightning-admin-angular) and this code is released under the MIT license
