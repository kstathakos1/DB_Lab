SELECT concat(u.first_name,' ',u.last_name) AS Name_teacher, count(r.rental_id) as Number_rented_Books
FROM user u
inner join rental r on u.username = r.username
where YEAR(CURRENT_DATE)-year(u.birth_date)<=40 AND (u.status='teacher' or u.status='operator')
group by u.username
order by count(r.rental_id) desc
;