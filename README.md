# LawnStarter Test

Hello, my name is Pedro, and I did this test project for the LawnStarter interview process.

Thank you for taking a look and for this opportunity. I hope you enjoy it!

## Stack

The stack used for this project was Laravel, React, Inertia and Tailwind.
And the environment was set using Laravel Sail.

## Some notes about the implementation

In order to make the event/queue, I used a cron that runs every five minutes which will dispatch a job to the queue.
This job will perform the statistics of the code, and will store in a cache.
Then, the endpoint (which I made public) will just get the information from the cache that will be updated during the cycles.

Note that the environment is set to be `sync` for simplicity. We could put also in a redis, or even database.

I also implemented mocks #5 and #6 to show movies and people.

Besides that, I used a cache to store the retrieved information from the API, and run it faster in the same next requests.

Also, I used query parameters that are used in the controllers. With that, the system allows you to share the URL to someone else, and get the same results.

## How to run

1. In order to run, first, install all PHP dependencies: `composer install`

2. Copy env.example file to a new env file: `cp .env.example .env`

3. Then, install NPM dependencies: `npm i`

4. Afther that, use Sail to build and start the main app: `vendor/bin/sail up`

5. Keep `sail up` always executing, and in another terminal, run the migrations: `vendor/bin/sail php artisan migrate`

6. Run the following command and keep always executing: `npm run dev`

7. In order to create events every 5 minutes, also run and keep executing the following command: `vendor/bin/sail php artisan schedule:work`

## How to navigate

Once the app is ready, just access http://localhost.

You should register your user, and start using the application.

`/sw-starter` is the main page
`/api/sw-starter/statistics` is the open endpoint to find the statistics
