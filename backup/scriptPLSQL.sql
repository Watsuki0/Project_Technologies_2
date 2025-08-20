CREATE OR REPLACE PROCEDURE add_game(p_title VARCHAR, p_description TEXT, p_price DECIMAL, p_image VARCHAR)
LANGUAGE PLPGSQL
AS $$
BEGIN
INSERT INTO games (title, description, price, image) VALUES (p_title, p_description, p_price, p_image);
END;
$$;


CREATE OR REPLACE PROCEDURE delete_game(p_id INTEGER)
LANGUAGE PLPGSQL
AS $$
BEGIN
DELETE FROM games WHERE id = p_id;
END;
$$;


CREATE OR REPLACE FUNCTION add_order(p_user_id INTEGER)
RETURNS INTEGER
LANGUAGE plpgsql
AS $$
DECLARE
new_order_id INTEGER;
BEGIN
INSERT INTO orders (user_id)
VALUES (p_user_id)
    RETURNING id INTO new_order_id;

RETURN new_order_id;
END;
$$;


CREATE OR REPLACE PROCEDURE add_order_item(
    p_order_id INTEGER,
    p_game_id INTEGER,
    p_quantity INTEGER
)
LANGUAGE plpgsql
AS $$
BEGIN
INSERT INTO order_items (order_id, game_id, quantity)
VALUES (p_order_id, p_game_id, p_quantity);
END;
$$;


CREATE OR REPLACE PROCEDURE delete_order(p_id INTEGER)
LANGUAGE plpgsql
AS $$
BEGIN
DELETE FROM order_items WHERE order_id = p_id;
DELETE FROM orders WHERE id = p_id;
END;
$$;


CREATE OR REPLACE PROCEDURE add_user(
    p_username VARCHAR,
    p_email VARCHAR,
    p_password VARCHAR,
    p_is_admin BOOLEAN
)
LANGUAGE plpgsql
AS $$
BEGIN
INSERT INTO users (username, email, password, is_admin)
VALUES (p_username, p_email, p_password, p_is_admin);
END;
$$;


CREATE OR REPLACE PROCEDURE delete_user(p_id INTEGER)
LANGUAGE plpgsql
AS $$
BEGIN
DELETE FROM users WHERE id = p_id;
END;
$$;
