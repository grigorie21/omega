SELECT
`user`.id,
`user`.full_name,
`user`.birthday_date,
`user`.created_at,
`user`.user_type_id,
`user`.organization,
`user_type`.title AS user_type_title,
 GROUP_CONCAT(`t1`.id) AS role_arr
FROM
`user`
LEFT JOIN
(
SELECT
`role`.id,
`role`.title AS role_title,
`user_m2m_role`.user_id
FROM
`user_m2m_role`
LEFT JOIN
`role`
ON
`user_m2m_role`.role_id = `role`.id
) AS t1
ON t1.user_id = `user`.id
LEFT JOIN
`user_type`
ON
`user`.user_type_id = `user_type`.id
GROUP BY `user`.id



