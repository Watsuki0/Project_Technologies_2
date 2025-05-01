CREATE OR REPLACE FUNCTION add_game(p_title VARCHAR, p_description TEXT, p_price DECIMAL, p_image VARCHAR)
RETURNS void AS $$
BEGIN
INSERT INTO games (title, description, price, image) VALUES (p_title, p_description, p_price, p_image);
END;
$$ LANGUAGE plpgsql;

CREATE OR REPLACE FUNCTION delete_game(p_id INTEGER)
RETURNS void AS $$
BEGIN
DELETE FROM games WHERE id = p_id;
END;
$$ LANGUAGE plpgsql;
