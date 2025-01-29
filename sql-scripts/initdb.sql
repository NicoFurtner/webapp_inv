-- Tabelle 'users'
CREATE TABLE IF NOT EXISTS users (
    id SERIAL PRIMARY KEY,
    username VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL
);

-- Tabelle 'investment'
CREATE TABLE IF NOT EXISTS investment (
    id SERIAL PRIMARY KEY,
    user_id INT REFERENCES users(id) ON DELETE CASCADE,
    investment_type VARCHAR(255),
    amount DECIMAL(15,2),
    investment_date DATE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
