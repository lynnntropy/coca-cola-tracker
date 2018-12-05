# Coca Cola Tracker

This a web app that allows you to track the remaining stock of of the 
Christmas-themed rewards on http://novogodisnjapromocija.coca-cola.rs.

## Requirements

- [PHP](http://php.net/)
- [Composer](https://getcomposer.org/)
- [Node.js](https://nodejs.org/en/)
- [Yarn](https://yarnpkg.com/en/)

## Getting Started

### Backend

```bash
# cd into the backend project
cd backend/

# install dependencies
composer install

# make a local copy of the .env file 
# (make sure to also fill it in with your environment data)
cp .env .env.local

# run the development server 
php bin/console server:run
```

### Frontend

```bash
# install dependencies
yarn 

# run the development server 
yarn serve 

# build for production and put the output in dist/
yarn build 
```

## Built With

### Backend

- PHP
- Symfony

### Frontend

- Vue.js
- Sass
- Webpack
- Yarn


## Authors

* **Veselin Romić (OmegaVesko)**

## License

This project is licensed under the GPL v3 - see the [LICENSE](LICENSE) file for details.
