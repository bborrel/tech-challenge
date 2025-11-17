# DocuPet technical challenge

## Introduction

- The stack is dockerized, powered by FrankenPHP 1 (including Mercure) and PostgreSQL 16.
- The application is based on Symfony 7.3, created as a webapp and leveraging for its:
    - backend: Doctrine-ORM 3.5, Mercure
    - frontend: AssetMapper 7.3, Tailwind CSS 4.1 and Symfony UX's Twig Components 2 + Live Components 2.

## System requirements

MacOS
- Docker engine (comes with Docker Desktop)
- git

## Website Installation

1. `git clone TBD`
1. `cd tech-challenge`
1. `docker compose up --wait`
1. `docker compose exec php bash`
    1. `./bin/console doctrine:fixtures:load`
        1. `yes`
    1. `composer tailwind-build`
    1. `composer asset-compile`

## Website Usage

Once the stack services are running and healthy:
1. Browse to https://localhost
1. Accept the unsecure connection (due to OS not trusting the certificate)
