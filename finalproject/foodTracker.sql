-- 
-- 
SET foreign_key_checks = 0;
DROP TABLE IF EXISTS `food`;
DROP TABLE IF EXISTS `recipe`;
DROP TABLE IF EXISTS `recipe_ingredients`;
DROP TABLE IF EXISTS `weekly_menu`;
DROP TABLE IF EXISTS `shopping_list`;
SET FOREIGN_KEY_CHECKS = 1;

-- Creates a table called food, which keeps infomation on the food.

CREATE TABLE `food` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `calories` int NOT NULL,
  `protein_grams` int NOT NULL,
  `fat_grams` int NOT NULL,
  `carbs_grams` int NOT NULL,
  `serving_size_grams` int NOT NULL,	
  PRIMARY KEY (`id`),
  Unique KEY `name` (name)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Create a table called recipe, which tracks the recipes in the database

CREATE TABLE `recipe` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `total_calories` int DEFAULT 0,
  `total_protein_grams` int DEFAULT 0,
  `total_fat_grams` int DEFAULT 0,
  `total_carbs_grams` int DEFAULT 0,
  `total_servings` int NOT NULL,  
  PRIMARY KEY (`id`),
  Unique KEY `name` (name)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


-- Create a table called recipe_ingredients, which tracks what food is required for a recipe

CREATE TABLE `recipe_ingredients` (
  `food_id` int(11) NOT NULL,
  `recipe_id` int(11) NOT NULL,
  `servings` int(11) NOT NULL,
  Unique KEY `colCombo` (food_id, recipe_id),
  CONSTRAINT `food_id_food` FOREIGN KEY (`food_id`) REFERENCES `food` (`id`),
  CONSTRAINT `recipe_id_recipes` FOREIGN KEY (`recipe_id`) REFERENCES `recipe` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


-- Create a table called weekly_menu, which tracks food for the week.

CREATE TABLE `weekly_menu` (
 `date` DATE NOT NULL,
 `meal_type` varchar(255) NOT NULL,
 `recipe_id` int(11) NOT NULL,
   Unique KEY `colCombo` (date, meal_type),
  CONSTRAINT `recipe_id_recipe` FOREIGN KEY (`recipe_id`) REFERENCES `recipe` (`id`)	
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Create a table called shopping_list which helps to buy groceries for recipes in weekly menu.

CREATE TABLE `shopping_list` (
 `food_id` int(11) NOT NULL,
 `quantity` int(11) DEFAULT 0,
  CONSTRAINT `food_id_foods` FOREIGN KEY (`food_id`) REFERENCES `food` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- insert the following into the food table:


INSERT INTO food (name, calories, protein_grams, fat_grams, carbs_grams, serving_size_grams)
     VALUES ('grapes', 62, 1, 0, 16, 92);

INSERT INTO food (name, calories, protein_grams, fat_grams, carbs_grams, serving_size_grams)
     VALUES ('chicken breast', 165, 31, 4, 0, 100);

INSERT INTO food (name, calories, protein_grams, fat_grams, carbs_grams, serving_size_grams)
     VALUES ('rice, white, long-grain', 130, 3, 0, 28, 100);

INSERT INTO food (name, calories, protein_grams, fat_grams, carbs_grams, serving_size_grams)
     VALUES ('chedder cheese', 113, 7, 9, 0, 28);

INSERT INTO food (name, calories, protein_grams, fat_grams, carbs_grams, serving_size_grams)
     VALUES ('ground beef, 93/7', 160, 22, 8, 0, 112);

INSERT INTO food (name, calories, protein_grams, fat_grams, carbs_grams, serving_size_grams)
     VALUES ('egg, whole', 70, 6, 5, 0, 50);

INSERT INTO food (name, calories, protein_grams, fat_grams, carbs_grams, serving_size_grams)
     VALUES ('milk, 2%', 124 , 8, 5, 12, 246);

INSERT INTO food (name, calories, protein_grams, fat_grams, carbs_grams, serving_size_grams)
     VALUES ('banana, medium', 110, 1, 0, 30, 126);

INSERT INTO food (name, calories, protein_grams, fat_grams, carbs_grams, serving_size_grams)
     VALUES ('green beans', 31, 2, 0, 7, 100);

INSERT INTO food (name, calories, protein_grams, fat_grams, carbs_grams, serving_size_grams)
     VALUES ('beans, black, low-sodium canned', 114, 8, 0, 20, 127);

INSERT INTO food (name, calories, protein_grams, fat_grams, carbs_grams, serving_size_grams)
     VALUES ('avocado', 50, 0, 5, 3, 30);

INSERT INTO food (name, calories, protein_grams, fat_grams, carbs_grams, serving_size_grams)
     VALUES ('rolled oats', 150, 5, 3, 28, 40);

INSERT INTO food (name, calories, protein_grams, fat_grams, carbs_grams, serving_size_grams)
     VALUES ('cashew', 157, 5, 12, 9, 28);

-- insert the following into the recipe table:

INSERT INTO recipe(name, total_servings)
     VALUES ('cheesy chicken and rice', 2);

INSERT INTO recipe(name, total_servings)
     VALUES ('scrambled eggs', 2);

INSERT INTO recipe(name, total_servings)
     VALUES ('chicken and rice', 2);

INSERT INTO recipe(name, total_servings)
     VALUES ('scrambled eggs with cheese', 1);

INSERT INTO recipe(name, total_servings)
     VALUES ('oatmeal', 1);



-- insert the following into the recipe_ingredients:

INSERT INTO recipe_ingredients(food_id, recipe_id, servings)
     VALUES ((SELECT id
        FROM food
        WHERE name = 'egg, whole'
        ),
        (SELECT id 
        FROM recipe 
        WHERE name = 'scrambled eggs'), 1);

INSERT INTO recipe_ingredients(food_id, recipe_id, servings)
     VALUES ((SELECT id
        FROM food
        WHERE name = 'egg, whole'
        ),
        (SELECT id 
        FROM recipe 
        WHERE name = 'scrambled eggs with cheese'), 1);

INSERT INTO recipe_ingredients(food_id, recipe_id, servings)
     VALUES ((SELECT id
        FROM food
        WHERE name = 'chedder cheese'
        ),
        (SELECT id 
        FROM recipe 
        WHERE name = 'scrambled eggs with cheese'), 1);

INSERT INTO `recipe_ingredients` (`food_id`, `recipe_id`, `servings`) VALUES
(3, 3, 1),
(11, 4, 1),
(2, 1, 2),
(4, 1, 1),
(3, 1, 2),
(7, 5, 1),
(12, 5, 1);

INSERT INTO `weekly_menu` (`date`, `meal_type`, `recipe_id`) VALUES
('2016-07-04', 'lunch', 3),
('2016-07-05', 'breakfast', 4),
('2016-07-04', 'breakfast', 5);

