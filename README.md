# Household

## Notice 
**UNDER HEAVY DEVELOPMENT**
Check other branches to follow the development.

To support this project, please leave a star!

## About HouseHold

HouseHold is a management system for home. Manage stock of your home
food supplies and many other. Any ideas are welcome in form of issue.

## Background

At this stage this is fork [Grocy](https://github.com/grocy/grocy.
To be exact, this started due Grocy code being a mess according to me
and it doesnt support any other database than sqlite at time of writing this.

This project aims only providing same functionality as Grocy does.
There is no code borrowed or copied or anything from Grocy. This is
pure rewrite.

After basic functionality have been implemented HouseHold and Grocy paths
will separate HouseHold will start developing it own features. This meaning
some features added to Grocy after HouseHold release 1.0 will not maybe
added automatically into HouseHold.

## Install
**This is not recommended to be used in production yet**

### Docker
**TBD**

### Manual
**TODO**

This is just a draft. It might work or it might not. Please
extend this guide as you see fit.

#### Requirements
- MariaDB 10.4
- PHP 7.4

#### Steps
Basically follow these steps with your own knowledge.
- Clone repository from `master`.
- Run `composer install`
- Run `yarn install`
- Edit `.env`
- Run `yarn encore production`
- Run `bin/console doctrine:migrations:migrate`

Now it should be running somewhere.

#### Update

- Run `git pull origin master`
- Run `rm -rf vendor node_modules`
- Run `composer install`
- Run `yarn install`
- Run `yarn encore production`
- Run `bin/console doctrine:migrations:migrate`

# License
GPLv3. Commercial licensing and support available on request.
