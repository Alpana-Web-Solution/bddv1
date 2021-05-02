<p align="center"><a href="https://alpana.org" target="_blank"><img src="https://res.cloudinary.com/debjit/image/upload/v1598972041/149_50_logo_uas3uf.png" width="150"></a></p>

## This is a Blood Donation Diary MVP software. Please let me know if you found any problem or needed any feature.

## I am building a more feature rich and stable version of this Web App as a Android app. Please stay updated.

## Here is the tutorial for hosting on heroku, (vercel is coming soon).
[Deploy on Heroku](https://debjit012.medium.com/how-did-i-host-my-blood-donation-diary-app-on-heroku-for-free-be03f8f4e1c9)




### What technical achievement are you most proud of?

 - This Web App will help you to manage your online Blood Donation Diary efficiently and save you time.
 - Any person with internet can request a donation.
 - All admin will get an email with requisition details.
 - You have a full list of the donor, donation, contact and patient for reference.
 - You can immediately share a donation certificate with to donor.
 - Share requisition to any social media platform, with complete control over every SEO settings.

### Tell us about you. 

I am a cancer survivor. Learning web development just to survive.

### Why made this app?

I have seen people buying blood literally next to me when I was in a hospital bed. They are so helpless. One parent needed blood for their 12yrs old son fighting with Leukemia. And they need whole blood, plasma on weekly basis. But blood Bank does not have enough stock or just refues. And they have to buy from the 3rd party blood bank / broker . It's a hart broken moment for me. I can not donate blood but can help them with creating solution for them.

### Please describe your project in detail:

With this app, my small group of friends can manage every donation we did, check everyone's blood donation, automate creating donation certificate, new email on every requisition and so on. Before using this app, we have to check a diary and contact all our friends about their availability which takes time and a lot of unnecessary effort and delay to their time-critical situation.

I have created this app to solve the problem of my own blood donation group, and found my small app can solve a big problem for every Blood Donation Group.
Every blood donation group has a ledger or diary manage by a single or two members. But the problem is it is not acceptable to everyone all the time. But this app is custom and made for specifically one purpose, to manage blood donation and donors.
I can not donate blood after surviving cancer. But I am proud that I can make their life a little easier.

This web app has 3 pages and also act as a website.

I will also add a blog and newsletter.

### What is your business model? (How are you going to make money?)

I have no idea about making any money from this app. 
But I will ask people for donation for the SASS application. But no worry I am able to run my web app for free so it can be deployed free without any issue.

## THE SOFTWARE IS PROVIDED “AS IS”, WITHOUT WARRANTY OF ANY KIND.

I will add more feature in time.You can discuss in github section. Thank you.

## Alpana Blood Donation Diary All Features

Alpana Blood Donation Diary is a simple app to manage your Groups / NGO's blood donations entry. I have created this app to help the local group manage with there blood donation.

- [x] [Simple, easy to use.](https://alpana.org/bdd).
- [x] [Multi Langual](https://alpana.org/bdd) (Bangla, English, or any other languages)
- [x] Search donor based on requisition for fast communication.
- [x] Anyone can post a requisition, No registration is required (Manual confirmation needed).
- [ ] An admin gets an email with the information (If enable).

## Admin can -

- [x] Admin can accept or delete the requisition.
- [x] Admin can accept the blood donation entry.
- [x] Admin can see all the donations.
- [x] Admin can manage any registered member.
- [x] Admin can download certificate for every donation made.
- [x] Admin can see who is available to donate.

## Member can -

- [x] Self-care, User can manually add their blood donation from the profile page.
- [x] Members can Opt-out from donating blood, with the date limitation.
- [x] Request member for blood donation and Send email asking donation.
- [x] User can download there own certificate from site.
- [x] User can request help on an open acpeted requisition.

## Otehr Site features

- [ ] [Real-time event broadcasting](https://alpana.org/bdd) is coming soon.
- [ ] Push notification
- [ ] Send SMS notification.

I am actively adding and updating this website, more feature coming soon.

Alpana Blood Donation Diary is ready to deploy app. You can take advantage of free hosting service to host a free website.

## Installation (Production)

Go to the directory and install required file for production

```bash
composer install --no-dev --prefer-dist --optimize-autoloader --no-interaction
```

Copy the env file 

```bash
copy .env.example .env
```
Generate key 

```bash
php artisan key:generate
```
Set the dattabase value in App/config/database.php or .env or your deployment enviornment.

Migrate the database

```bash
php artisan migrate --seed
```
Your app is ready to use. Use default username and password for admin is-

```bash
email: admin@admin.com
password : password
```
Now Link your storage for uploads
```bash
php artisan storage:link
```

## Hosting

Alpana Blood Donation Diary is created on laravel php framework. Please ask your hosting provider for laravel support.
- [x] Free Backend Hosting Provider [Heroku](https://heroku.com) and [Vercel](https://vercel.com) Setup tutorail(Will be update);

- [ ] Cpanel Web Hosting Supported. Tutorial will be update shortly.

## Security Vulnerabilities and Bugs

If you discover a security vulnerability within Alpana Blood Donation Diary, please send an e-mail to Debjit Biswas via [hi@debjit.in](mailto:hi@debjit.in). All security vulnerabilities will be promptly addressed.

## License

<a rel="license" href="http://creativecommons.org/licenses/by-nc/4.0/"><img alt="Creative Commons License" style="border-width:0" src="https://i.creativecommons.org/l/by-nc/4.0/88x31.png" /></a><br />This work is licensed under a <a rel="license" href="http://creativecommons.org/licenses/by-nc/4.0/">Creative Commons Attribution-NonCommercial 4.0 International License</a>.
