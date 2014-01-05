# Payments site

## Tasks
I implemented basic logic of payments site.
- You can login or signup
- Add/edit purchase methods
- Pay 
- Show your payments

## Install
This mini-application uses SQLite, so DB creates automatically.
Log-file creates automatically, too.

One you have to do is to change site prefix in file models/config.php if you'll install site not in root. Ex., if you install site on localhost/test_task, SITE_PREFIX = '/test_task'
Site uses simple authorization based only on sessions.

## Using
- Signup or login
- Add payment methods
- Pay
- View history of payments