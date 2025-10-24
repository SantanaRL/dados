-- Query para contabilizar os departamentos que convidaram os professores visitantes por ano
SELECT count(*) AS qtd, s.nomset
FROM fflch.dbo.INTERCAMPROFVISITANTE i
INNER JOIN fflch.dbo.SETOR s ON (i.codsetpesrsp = s.codset AND i.codundpesrsp = s.codund)
WHERE codundpesrsp = 8 AND s.codund = 8
AND i.dtainiatvitb BETWEEN '__ano__-01-01 00:00:00.000' AND '__ano__-12-31 00:00:00.000'
GROUP BY s.nomset