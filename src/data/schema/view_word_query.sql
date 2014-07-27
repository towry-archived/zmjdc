SELECT m.id, m.wid, m.uid, m.how, m.update, u.name, u.email, u.fakename, w.word, v.vup, v.vdown
FROM t_memory m
JOIN t_users u ON m.uid = u.id
JOIN t_words w ON m.wid = w.id
LEFT JOIN (

SELECT mid, SUM( vote =1 ) AS vup, SUM( vote =0 ) AS vdown
FROM t_vote group by mid
) AS v on v.mid = m.id WHERE m.wid = :wid

-- ------------------------------------------------


