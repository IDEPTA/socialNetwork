	-- открываем транзакцию
BEGIN;
	-- первый запрос
UPDATE post_likes 
SET feedback_type = false
WHERE id = 1;
	-- создаем сэйв пойнт
SAVEPOINT savepoint;
	-- второй запрос
UPDATE post_likes 
SET feedback_type = false
WHERE id = 2;
	-- закрываем транзакцию и откатываемся до сейв пойнта
ROLLBACK TO savepoint;

SELECT * FROM post_likes WHERE id < 5 ORDER BY id asc

