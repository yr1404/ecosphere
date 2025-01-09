# Landing page of EcoSphere  
<!-- [![GitHub stars](https://img.shields.io/github/stars/yr1404/website_with_navbar)](https://github.com/yr1404/website_with_navbar/stargazers) -->

This repository contains the code for a basic website template with a responsive navigation bar. The template is built using HTML, CSS, and JavaScript, and it provides a simple and clean layout that can be customized for various purposes.

## Features

- Mobile-friendly design
- Easily customizable and extensible
- Integrated automated WhatsApp messaging and email functionality for efficient customer communication.
- The data entered by the user in the Get In Touch! form is stored in a database.

## Setting up locally
- git clone https://github.com/yr1404/ecosphere.git
- create your api keys from twilio and brevo account and add them in .env file (TWILIO_SID, TWILIO_AUTH_TOKEN, BREVO_API_KEY)
- install php and composer
- composer require vlucas/phpdotenv
- composer require twilio/sdk
- sudo apt-get install php8.1-curl
- composer require getbrevo/brevo-php
- Also, add your DB credentials(DB_HOST, DB_NAME, DB_USERNAME, DB_PASSWORD) in the .env file.
- php -S localhost:8080 `(locally hosting php)`

### Website Link&nbsp; [![box-arrow-up-right](https://github.com/yr1404/website_with_navbar/assets/106465753/aef5ea09-8e41-4a57-a6a2-13fd0e8ecfde)](https://yr1404.github.io/ecosphere/)

### To be added
- Display all data present in the db.
