[![Contributors][contributors-shield]][contributors-url]
[![Forks][forks-shield]][forks-url]
[![Stargazers][stars-shield]][stars-url]
[![Issues][issues-shield]][issues-url]
[![BSL License][license-shield]][license-url]
[![Localization][locale-shield]][locale-url]


<br />
<p align="center">
  <!--
  <a href="https://github.com/HouseHold/HouseHold">
    <img src="logo.png" alt="Logo" width="80" height="80">
  </a>
  -->

  <h3 align="center">HouseHold</h3>

  <p align="center">
    HouseHold is self-hosted web-based application to manage your home.
    <br />
    <strong> HouseHold is in Alpha and expirencing heavy development</strong>
    <br />
    <strong> Pre-Alpha coming 1st of April </strong>
    <!-- <a href="https://github.com/HouseHold/HouseHold"><strong>Explore the docs »</strong></a> -->
    <br />
    <br />
    <!-- TODO: <a href="https://github.com/github_username/repo">View Demo</a> -->
    <!-- · -->
    <a href="https://github.com/HouseHold/HouseHold/issues">Report Bug</a>
    ·
    <a href="https://github.com/HouseHold/HouseHold/issues">Request Feature</a>
  </p>
</p>


## Table of Contents

* [About the Project](#about-the-project)
  * [Built With](#built-with)
* [Getting Started](#getting-started)
  * [Prerequisites](#prerequisites)
  * [Installation](#installation)
* [Roadmap](#roadmap)
* [Contributing](#contributing)
* [License](#license)



## About The Project

HouseHold is a management system for home. Manage stock of your home
food supplies and many other.

At this stage this is fork [Grocy](https://github.com/grocy/grocy).
To be exact, this started due Grocy code being a mess according to me
and it doesnt support any other database than sqlite at time of writing this.

This project aims only providing same functionality as Grocy does.
There is no code borrowed or copied or anything from Grocy. This is
pure rewrite.

After basic functionality have been implemented HouseHold and Grocy paths
will separate HouseHold will start developing it own features. This meaning
some features added to Grocy after HouseHold release 1.0 will not maybe
added automatically into HouseHold.

### Built With

* [PHP 7.4](https://php.net)
* [Vue](https://vuejs.org/)
* [Symfony ](https://symfony.com/)

## Getting Started

This is not production ready. Do not use this is production, until 1.0.0 is released.
When 1.0.0 is released, there will be docker package available. For now there is nothing.

### Prerequisites

Please make sure following packages are installed:
* make
* docker
* docker-compose
```sh
sudo apt-get install make docker docker-compose -y
== OR ==
sudo yum install make docker docker-compose -y
== OR ==
sudo apk add make docker docker-compose
```

### Installation
 
1. Clone the repo
```sh
git clone --recurse-submodules -j8 https://github.com/HouseHold/HouseHold.git
```
2. Install dependencies.
```sh
make start
```

<strong> Notice: </strong> This is development guide and might not be up-to-date.

## Roadmap

See the [open issues](https://github.com/HouseHold/HouseHold/issues) for a list of proposed features (and known issues).

For now development progress can be seen here in simple steps.

- [x] Create CQRS, DDD, EventSourcing Core.
- [x] Setup Vue frontend.
- [x] Stock Management Backend (API).
- [ ] Stock Management Frontend.


<!-- CONTRIBUTING -->
## Contributing

Contributions are what make the community such an amazing place to be learn, inspire, and create. Any contributions you make are **greatly appreciated**. However, please follow following rules to contribute so we can keep code clean.

### Obtainign a copy

In order to submit a pull request, you will need to fork the project and obtain a fresh copy of the source code.

### Choosing the branch

- I am submitting a bugfix for a stavle release.
  - Please target lowest possible active stable branch.
- I am submitting a new feature.
  - Please target master branch.
- I am submitting a BC change.
  - Please target master branch.
  - Please provide deprecation for lowest possible active stable branch.


Please always create a new branch for your changes (i.e. do not commit directly into `master` in your fork), otherwise you would run into troubles with creating multiple pull requests.

### Coding standard.

Always follow the previous coding standard applied in the code. You will get it, if you just read it trough. Please also always run the phpcsfixer. Fixer can  be run with command `make cs`.

### Tests

Please always add tests for your changes.
- If you are fixing a bug, create test file into `tests/{Functional,Unit,Integration}/Ticket/GHxxxxxTest.php`. 
Part with `xxx` should be the ID of the ticket.
- If you are adding a feature, please provide a tests to cover it fully.


<!-- LICENSE -->
## License

Distributed under the BSL 1.1 License. See `LICENSE.md` for more information.

<small>_License might be change in future, but for now it will go under BSL 1.1 to
support single contributor effort develop the software._</small>


<!-- MARKDOWN LINKS & IMAGES -->
[activity-shield]: https://img.shields.io/github/commit-activity/m/HouseHold/HouseHold?label=commits
[activity-link]: https://github.com/HouseHold/HouseHold/commits/master
[contributors-shield]: https://img.shields.io/github/contributors/HouseHold/HouseHold.svg?style=flat-square
[contributors-url]: https://github.com/HouseHold/HouseHold/graphs/contributors
[forks-shield]: https://img.shields.io/github/forks/HouseHold/HouseHold.svg?style=flat-square
[forks-url]: https://github.com/HouseHold/HouseHold/network/members
[stars-shield]: https://img.shields.io/github/stars/HouseHold/HouseHold.svg?style=flat-square
[stars-url]: https://github.com/HouseHold/HouseHold/stargazers
[issues-shield]: https://img.shields.io/github/issues/HouseHold/HouseHold.svg?style=flat-square
[issues-url]: https://github.com/HouseHold/HouseHold/issues
[license-shield]: https://img.shields.io/badge/License-BSL%201.1-brightgreen.svg?style=flat-square
[license-url]: https://github.com/HouseHold/HouseHold/blob/master/LICENSE.txt
[locale-shield]: https://badges.crowdin.net/household/localized.svg
[locale-url]: https://crowdin.com/project/household
[product-screenshot]: images/screenshot.png
