# JobPulse

## Requirements

- There will be 3 types of User : Main Owner of The System, Companies and Candidates.

- For the Main System Owner Company  and Job Providing Companies, you have to maintain Roles & Permissions(Optional).

- For The Owner of the system, you have to develop these Modules:
- - Frontend: Home Page, About Page, Jobs Page, Contact Page, Login Page.
- - The Login Route will be different for the Main Owner.
- - Backend: Dashboard, Companies, Jobs, Employee(Optional), Blogs, Pages Plugins, Accounts Settings
- - - Main System Owner Company can only login in the site.

- Candidates can apply to the posted jobs under any company. Before applying candidates must be logged in into the system.

- - For The Candidates, you have to develop these Modules:
- - Job providing companies can register and login in the site.
- - Frontend Part: Login, Registration and Forget Password
- - Backend: Dashboard, Jobs, Profiles, Accounts Settings

- For The Job Providing Companies, you have to develop these Modules:
- - Frontend Part: Login, Registration and Forget Password
- - Backend: Dashboard, Jobs, Employee(Optional), Blogs , Plugins, Accounts Settings.
- - For Job Providing company, Blogs Feature on backend, need to add just as a plugin. No need to develop as a whole functional feature.
- - Employee module is declared as optional for Owner of the system and Companies but you have to keep it as a plugin. If you do not develop this feature with Roles and Permissions then just keep this as plugin card like other plugins.

## How to use it

1. Run git clone https://github.com/masumbillah21/JobPulse
2. Run cd JobPulse
3. Run `npm install`
4. Run `composer install`
5. Run `cp .env.example .env`
    - Create a database
    - In .env file add your database login credentials
6. Add APP_NAME & APP_URL
7. Run `php artisan key:generate`
8. Run `php artisan migrate:refresh --seed`
9. Run `php artisan serve`
10. Open new termial and run `npm run dev`
Go to your site link. (For localhost: http://127.0.0.1:8000/)

Live Site: https://jobpulse.masum-billah.com/

Super Admin:
Email: `mbillah21@yahoo.com`
password: `12345678`

System Admin:
Email: `mbillah21@gmail.com`
password: `12345678`
