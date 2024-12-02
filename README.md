# LawnStarter Test

Hello, my name is Pedro, and I did this test project for the LawnStarter interview process.

Thank you for taking a look and for this opportunity. I hope you enjoy it!

## Stack

The stack used for this project was Laravel, React, Inertia and Tailwind.
And the environment was set using Laravel Sail.

## Some important notes about the implementation

I was facing some slowness using the `swapi.dev` even though it was working as expected. I saw there's another version, called `swapi.tech`, which has more resources, and seems faster. However, when I tried to [`get people/id`](https://swapi.tech/api/people/1) with the `tech` version, it didn't return the `films` property (different from the films, which returned `characters`, which seems like a bug). Because of that, I still used `swapi.dev`. Documentation says that each request makes the next slower, so, sometimes, it times out.

In order to make the event/queue, I used a cron that runs every five minutes which will dispatch a job to the queue.
This job will perform the statistics of the code, and will store in a cache.
Then, the endpoint (which I made public) will just get the information from the cache that will be updated during the cycles.

Note that the environment is set to be `sync` for simplicity. We could put also in a redis, or even database.

A middleware was used to store the searches that happens on each request.

I also implemented mocks #5 and #6 to show movies and people.

Besides that, I used a cache to store the retrieved information from the API, and run it faster in the same next requests.

Also, I used query parameters that are used in the controllers. With that, the system allows you to share the URL to someone else, and get the same results.

## How to run

1. In order to run, first, install all PHP dependencies: `composer install`

2. Copy env.example file to a new env file: `cp .env.example .env`

3. Then, install NPM dependencies: `npm i`

4. Afther that, use Sail to build and start the main app: `vendor/bin/sail up`

5. Run the app encrypt: `vendor/bin/sail php artisan key:generate`

6. Keep `sail up` always executing, and in another terminal, run the migrations: `vendor/bin/sail php artisan migrate`

7. Run the following command and keep always executing: `npm run dev`

8. In order to create events every 5 minutes, also run and keep executing the following command: `vendor/bin/sail php artisan schedule:work`

## How to navigate

Once the app is ready, just access http://localhost.

You should register your user, and start using the application.

`/sw-starter` is the main page
`/api/sw-starter/statistics` is the open endpoint to find the statistics

## Questions

### What are you hoping to find in your next position that would make us the right next step in your career?

> From what I've heard during the interview, the company is growing. With that, growth expectation comes to place allowing me to grow up together, professionally and personally.
> Besides, the company's philosophies and values are truthy and admirable and it's culture is strong.

> All those things make me believe it's the right place to work at.

### What have you learned so far about us that has excited you?

> I've learn that the company has been awarded as great places to work in Austin several times.
> Besides, there's the company tech stack, which is Laravel and React. Two tools that I really enjoy working with.

### Have you worked in an environment where developers own delivering features all the way to production? We have QA (Quality Assurance) and a Product Operations team, however, they exist to provide support to engineers. Are you comfortable going to a place where the quality buck stops with the engineers and you have the ability to deploy and observe your own code in production?

> Yes. I worked like this in my previous company. We also had QA teams to support, but the ownership of the deliveries and monitoring were part of the developers jobs. So, I'm very comfortable with this approach.

### What is the next technology or subject you are hoping to learn about?

> If I have the chance to work more with React Native, it would be awesome for me.

## Feedback

### What parts of this did you enjoy?

> I enjoyed all of it. There's a lot of different approaches we can go for, either in backend and frontend.

> The idea of using the SWApi is great!

> I like the company openness for any kind of technology. You're looking for software engineers and not developers tied to any language or techs.

### What parts of this did you dislike?

> Nothing I can think of.

### Any other comments/feedback?

> Just a comment. There are two SWApi available. I ended up using `swapi.dev` instead of `swapi.tech`. I was worried about making this wrong if I selected one over another. Hope this one is correct.
