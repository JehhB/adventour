# Adventour

This project is a full-stack mock travel website developed as the final project for CS222 (Web Programming) at Cagayan State University. It is built using PHP for the backend and Vue.js for the frontend.

## Development

### Requirements

Make sure you have the following tools installed on your system:

* Node.js and PNPM
* Composer
* Docker

### Running the Development Server

To start the development server, follow these steps:

1. Clone the repository:

```sh
git clone https://github.com/JehhB/adventour.git
cd adventour
```

2. Install the PHP dependencies:

```sh
cd public/lib
composer install
```

3. Go back to the project root directory:

```sh
cd ../..
```

4. Install the JavaScript dependencies:

```sh
pnpm install
```

5. Start the development server using Docker:

```sh
docker-compose up -f docker-compose.dev.yml
```

### Running the Compiler

If you want to compile the project, use the following steps:

1. Follow steps 1-4 from the "Running the Development Server" section.

2. Compile the frontend assets:

```sh
pnpm run dev
```

This will build the Vue.js frontend and generate the necessary assets for the website.

## Contributing

Contributions to this project are welcome. If you find any issues or have suggestions for improvement, please feel free to open an issue or submit a pull request.
License

This project is licensed under the MIT License.

