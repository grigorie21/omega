SELECT
user_id,
GROUP_CONCAT(role_id) AS roleArr
FROM
`user_m2m_role`
GROUP BY
user_id
