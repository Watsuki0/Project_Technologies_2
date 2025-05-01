-- Table des utilisateurs
CREATE TABLE users (
                       id SERIAL PRIMARY KEY,
                       username VARCHAR(50) UNIQUE NOT NULL,
                       password VARCHAR(255) NOT NULL,
                       email VARCHAR(100) UNIQUE NOT NULL,
                       is_admin BOOLEAN DEFAULT FALSE
);

-- Table des jeux
CREATE TABLE games (
                       id SERIAL PRIMARY KEY,
                       title VARCHAR(100) NOT NULL,
                       description TEXT,
                       price DECIMAL(6,2) NOT NULL,
                       image VARCHAR(255)
);

-- Table des commandes
CREATE TABLE orders (
                        id SERIAL PRIMARY KEY,
                        user_id INTEGER REFERENCES users(id) ON DELETE CASCADE,
                        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Table de liaison commandes/jeux
CREATE TABLE order_items (
                             id SERIAL PRIMARY KEY,
                             order_id INTEGER REFERENCES orders(id) ON DELETE CASCADE,
                             game_id INTEGER REFERENCES games(id) ON DELETE CASCADE,
                             quantity INTEGER DEFAULT 1
);
