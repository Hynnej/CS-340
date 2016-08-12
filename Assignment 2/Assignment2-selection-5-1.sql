#1 Find all films with maximum length and minimum rental duration (compared to all other films). 
#In other words let L be the maximum film length, and let R be the minimum rental duration in the table film. You need to find all films with length L and rental duration R.
#You just need to return attribute film id for this query.

SELECT film_id
FROM film
WHERE length IN (SELECT MAX(length) FROM film) and rental_duration IN (SELECT min(rental_duration) FROM film)

#2 We want to find out how many actors have played in each film, so for each film return the film id, film title, and the number of actors who played in that film. Some films may have no actors, and your query does not need to return those films.

SELECT F.film_id, F.title, COUNT(A.actor_id) AS `NUMBER OF ACTORS`
FROM film F
INNER JOIN film_actor A ON A.film_id = F.film_id
GROUP BY F.film_id

#3 Find the average length of films for each language. Your query should return every language even if there is no films in that language. language refers to attribute language_id (not attribute original_language_id)

SELECT L.language_id, AVG(F.length) AS `AVERAGE LENGTH`
FROM language L
LEFT JOIN film F on F.language_id = L.language_id
GROUP BY L.language_id


#4 We want to find out how many of each category of film KEVIN BLOOM has started in so return a table with category.name and the count
#of the number of films that KEVIN was in which were in that category order by the category name ascending (Your query should return every category even if KEVIN has been in no films in that category).

SELECT C.name, KBC.film_count
FROM category C
LEFT JOIN (
SELECT C.name AS `category_name`, COUNT(F.film_id) AS `film_count`
FROM category C
INNER JOIN film_category FC ON FC.category_id = C.category_id
INNER JOIN film F ON F.film_id = FC.film_id
INNER JOIN film_actor FA ON FA.film_id = F.film_id
INNER JOIN actor A ON A.actor_id = FA.actor_id
WHERE A.first_name =  'KEVIN'
AND A.last_name =  'BLOOM'
GROUP BY C.name
) AS KBC ON KBC.category_name = C.name


#5 Find the film title of all films which do not feature both SCARLETT DAMON and BEN HARRIS(so you will not list a film if both of these actors have played in that film, but if only one or none of these actors have played in a film, that film should be listed).
#Order the results by title, descending (use ORDER BY title DESC at the end of the query)
#Warning, this is a tricky one and while the syntax is all things you know, you have to think oustide
#the box a bit to figure out how to get a table that shows pairs of actors in movies

SELECT F.title
FROM film F
INNER JOIN film_actor FA1 ON FA1.film_id = F.film_id
INNER JOIN actor A1 ON A1.actor_id = FA1.actor_id
INNER JOIN film_actor FA2 ON FA2.film_id = F.film_id
INNER JOIN actor A2 ON A2.actor_id = FA2.actor_id
WHERE A1.first_name <> "SCARLETT" AND
      A1.last_name <> "DAMON" AND
      A2.first_name <> "BEN" AND
      A2.last_name <> "HARRIS"
GROUP BY F.title DESC


