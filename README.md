![Gamer Oasis Logo](public/asset/images/menu/logo/logo.png)


## Gamer Oasis

Gamer Oasis is a Laravel-based e-commerce platform tailored for gaming enthusiasts. The application offers a wide range of Gaming Console, Laptop products, an intuitive user interface, and a seamless shopping experience.

## Features:
+ User-Friendly Interface: Easy-to-navigate platform for gamers of all levels.
+ Product Management: Add, edit, and delete gaming products.
+ Cart & Checkout: Fully functional shopping cart and secure checkout process.
+ Admin Dashboard: Manage orders, users, and products efficiently.
+ Authentication System: Secure login and registration using Laravel's built-in authentication.
+ Responsive Design: Fully optimized for mobile and desktop.

## Prerequisites
Before starting, ensure you have the following installed:

PHP >= 8.2.12

XAMPP

MySQL

Git

## Installation

Follow these steps to set up the project:

1. Clone the Repository

 + git clone https://github.com/HoangNguyen49/Gamer-Oasis.git

 + cd Gamer-Oasis

2. Access this link to download env file and product images:

  https://drive.google.com/drive/folders/1E-MKF3pbH_19O1gXcuCAqKq0mZ6zzQdR?usp=sharing

 + copy .env file into Gamer-Oasis 

 + in folder storage/app/public -> create new folder asset/images

 + copy folder "product" into storage/app/public/asset/images

 + php artisan storage:link

3. System Requirements:

 + XAMPP (downloadable from [Apache Friends](https://www.apachefriends.org/))
 + Start module Apache and MySQL (Apache port: 80, 443 / MySQL port 3306)

4. Database:

 + Download database gamer_oasis from drive link in section 2 

 + Open XAMPP after start modules Apache and MySQL, Click "Admin" at MySQL 

 + This url will show after you click "Admin" http://localhost/phpmyadmin/

 + Click "Import" to import file "gameroasis.sql" 

5. Install Dependencies

 + cd Gamer-Oasis run composer install

### Starting the Application

1. Run the Development Server

 + php artisan serve

2. Access the Application Open your browser and visit: http://127.0.0.1:8000

## Seeded Data

By default, the application comes with some pre-populated data for testing:

Admin Account:

Email: admin@gmail.com

Password: 12345678

Test Products: A collection of gaming products for demonstration.

## Additional Commands

Clear and Cache Configurations:

php artisan config:cache

php artisan cache:clear

Run Unit Tests:

php artisan test

## Contributing
If you'd like to contribute to the project:

1. Fork the repository.
2. Create a new branch for your feature/fix.
3. Submit a pull request with a detailed description.

## License

This project is licensed under the MIT License. Feel free to use and modify it as per your requirements.

## Enjoy building with Gamer Oasis! 🚀