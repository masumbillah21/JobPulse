# JobPulse

## Video

https://drive.google.com/drive/folders/1gBqgdxYcaIZjlgu3cxHvjfWJcc8HBpO9

## How to use it

1. Run git clone https://github.com/masumbillah21/JobPulse
2. Run cd JobPulse
3. Run `npm install`
4. Run `composer install`
5. Run `cp .env.example .env`
    - Create a database
    - In .env file add your database login credentials
    - Added your SMTP credentials in .env file to make email work
6. Add APP_NAME & APP_URL
7. Run `php artisan key:generate`
8. Run `php artisan migrate:refresh --seed`
9. Run `php artisan serve`
10. Open new termial and run `npm run dev`

- Go to your site link. (For localhost: http://127.0.0.1:8000/)
- To login as sytem user: http://127.0.0.1:8000/admin/login

- Live Site: https://jobpulse.masum-billah.com/
- System User Login Url: https://jobpulse.masum-billah.com/admin/login
- Other User Login Url: https://jobpulse.masum-billah.com/login

- Super Admin: `mbillah21@yahoo.com` password: `12345678`
- System Admin: `mbillah21@gmail.com` password: `12345678`

## Technology Used

- Laravel 10
- VueJs with Inertia
- TypeScript
- Tailwind css
- For Chart: ChartJs
- For Rich Text: ckeditor5
- For Data Table: vue3-datatable
- For Icon: Font Awesome 5
