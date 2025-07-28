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
