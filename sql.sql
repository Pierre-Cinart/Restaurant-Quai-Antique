CREATE DATABASE quai_antique;
USE quai_antique;
-- Création de la table des utilisateurs
CREATE TABLE  users (
    user_id INT AUTO_INCREMENT PRIMARY KEY,
    email VARCHAR(255) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    tel INT(10) ,
    allergies VARCHAR(255),
    number_of_guests INT(2) ,
    picture VARCHAR(255),
    jwt VARCHAR(255),
    confirm ENUM('n', 'y') DEFAULT 'n' NOT NULL,
    role ENUM('admin', 'client','super admin') DEFAULT 'client' NOT NULL,
    first_name VARCHAR(50) NOT NULL,
    last_name VARCHAR(50) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    CHECK (number_of_guests >= 1 AND number_of_guests <= 15)
);

-- Création de la table des informations des clients
CREATE TABLE  customer_info (
    customer_id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    phone_number VARCHAR(20),
    address VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(user_id)
);

-- Création de la table des catégories (boisson, entrée, plat, dessert)
CREATE TABLE  categories (
    category_id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(50) NOT NULL
);

-- Création de la table des plats
CREATE TABLE  dishes (
    dish_id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    description TEXT,
    price DECIMAL(10, 2) NOT NULL,
    category_id INT,
    picture VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (category_id) REFERENCES categories(category_id)
);


-- Création de la table des réservations
CREATE TABLE reservations (
    reservation_id INT AUTO_INCREMENT PRIMARY KEY,
    first_name VARCHAR(50) NOT NULL,
    last_name VARCHAR(50) NOT NULL,
    email VARCHAR(255),
    tel VARCHAR(20),
    number_of_guests INT NOT NULL,
    reservation_date DATE NOT NULL,
    reservation_time TIME NOT NULL,
    allergies TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    CHECK (number_of_guests >= 1 AND number_of_guests <= 15)
);


-- Création de la table des logs
CREATE TABLE  logs (
    log_id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    action_description TEXT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(user_id)
);

--Création de la table des horraires
CREATE TABLE   open (
    id INT AUTO_INCREMENT PRIMARY KEY,
    day VARCHAR(20),
    morning_start INT,
    morning_end INT,
    after_start INT,
    after_end INT
);

-- Création de la table home_pictures
CREATE TABLE  home_pictures (
    id INT AUTO_INCREMENT PRIMARY KEY,
    dish_id INT,
    FOREIGN KEY (dish_id) REFERENCES dishes(dish_id)
);

--Création de la table de vérification de tentatives de connexion
CREATE TABLE failed_login_attempts (
    id INT AUTO_INCREMENT PRIMARY KEY,
    ip_address VARCHAR(45) NOT NULL,
    attempt_timestamp TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    UNIQUE KEY ip_address_attempt_timestamp (ip_address, attempt_timestamp)
);
-----------------------------------------------------------------------------------------------------------------
--implementation d exemples


-- creation des horraires
INSERT INTO open (day, morning_start, morning_end, after_start, after_end)
VALUES 
    ('week', 1130, 1500, 1900, 2300),
    ('saturday', 1130, 1600, 1900, 0),
    ('sunday', 1130, 1500, NULL, NULL);
-- création des catégories d articles
INSERT INTO categories (title) VALUES 
    ('Starter'),
    ('Dish'),
    ('Dessert'),
    ('Drink');
-- creation d une liste de boissons
INSERT INTO dishes (title, description, price, category_id, picture) VALUES 
    ('Eau', 'Eau fraîche et pure.', 1.50, (SELECT category_id FROM categories WHERE title = 'Drink'), NULL),
    ('Coca-Cola', 'Boisson cola classique.', 2.00, (SELECT category_id FROM categories WHERE title = 'Drink'), NULL),
    ('Jus d''orange', 'Jus d''orange fraîchement pressé.', 2.50, (SELECT category_id FROM categories WHERE title = 'Drink'), NULL),
    ('Bière', 'Bière fraîche et rafraîchissante.', 3.00, (SELECT category_id FROM categories WHERE title = 'Drink'), NULL),
    ('Vin', 'Sélection fine de vins rouges et blancs.', 5.00, (SELECT category_id FROM categories WHERE title = 'Drink'), NULL),
    ('Café', 'Café noir et riche en saveur.', 2.00, (SELECT category_id FROM categories WHERE title = 'Drink'), NULL);
-- création d une liste d entrées
INSERT INTO dishes (title, description, price, category_id, picture) VALUES 
    ('Salade César', 'Salade verte avec du poulet grillé, du parmesan et une vinaigrette crémeuse.', 5.50, (SELECT category_id FROM categories WHERE title = 'Starter'), 'starter1.jpg'),
    ('Soupe à l\'oignon', 'Soupe à l\'oignon traditionnelle gratinée avec du fromage.', 4.50, (SELECT category_id FROM categories WHERE title = 'Starter'), 'starter2.jpg'),
    ('Bruschetta', 'Pain grillé garni de tomates fraîches, d\'ail, de basilic et d\'huile d\'olive.', 4.50, (SELECT category_id FROM categories WHERE title = 'Starter'), 'starter3.jpg'),
    ('Escargots', 'Escargots cuits au beurre à l\'ail et aux herbes.', 6.00, (SELECT category_id FROM categories WHERE title = 'Starter'), 'starter4.jpg'),
    ('Assiette de fromages', 'Sélection de fromages fins avec des fruits secs et des noix.', 7.00, (SELECT category_id FROM categories WHERE title = 'Starter'), 'starter5.jpg');
-- creation d exemples de plats 
INSERT INTO dishes (title, description, price, category_id, picture) VALUES 
    ('Raclette', 'Un plat traditionnel savoyard composé de fromage fondu, de pommes de terre et de charcuterie.', 15.00, (SELECT category_id FROM categories WHERE title = 'Dish'), 'dish1.jpg'),
    ('Fondue savoyarde', 'Un plat emblématique de la région savoyarde, où le fromage fondu est dégusté avec du pain.', 20.00, (SELECT category_id FROM categories WHERE title = 'Dish'), 'dish2.jpg'),
    ('Tartiflette', "Un plat savoyard à base de pommes de terre, de reblochon, d'oignons et de lardons.", 18.00, (SELECT category_id FROM categories WHERE title = 'Dish'), 'dish3.jpg');
INSERT INTO dishes (title, description, price, category_id, picture) VALUES 
    ('Tarte aux myrtilles', 'Une délicieuse tarte aux myrtilles des montagnes savoyardes, avec une pâte croustillante et une garniture généreuse de myrtilles fraîches.', 6.00, (SELECT category_id FROM categories WHERE title = 'Dessert'), 'dessert1.jpg'), 
    ('Beignets de pommes de terre', 'Des beignets croustillants et dorés à base de pommes de terre râpées et assaisonnées, une spécialité savoyarde incontournable.', 6.50, (SELECT category_id FROM categories WHERE title = 'Dessert'), 'dessert2.jpg'), 
    ('Gâteau de Savoie', 'Un gâteau moelleux et léger à base de farine, de sucre, de beurre et d\'oeufs, parfumé à la vanille, une spécialité sucrée savoyarde.', 5.00, (SELECT category_id FROM categories WHERE title = 'Dessert'), 'dessert3.jpg'), 
    ('Sablés de Chartreuse', 'Des sablés fondants et parfumés à la Chartreuse, une liqueur emblématique de la région savoyarde, parfaits pour accompagner un café.', 4.50, (SELECT category_id FROM categories WHERE title = 'Dessert'), 'dessert4.jpg'), 
    ('Tourte aux Noix', 'Une tourte croustillante et savoureuse, garnie de cerneaux de noix, de miel des montagnes et d\'une touche de rhum, une spécialité sucrée typique de la Savoie.', 7.00, (SELECT category_id FROM categories WHERE title = 'Dessert'), 'dessert5.jpg');
--creation exemple de reservation
INSERT INTO reservations (first_name, last_name, email, tel, number_of_guests, reservation_date, reservation_time)
VALUES ('Pierre', 'Dupont', NULL, '0320240049', 3, '2024-02-20', '12:00');

-- creation de l affichage des images sur la page d accueil 
INSERT INTO home_pictures (dish_id) VALUES (7);
INSERT INTO home_pictures (dish_id) VALUES (8);
INSERT INTO home_pictures (dish_id) VALUES (9);