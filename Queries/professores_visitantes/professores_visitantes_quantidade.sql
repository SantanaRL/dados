-- Query para contabilizar as Universidades dos professores visitantes por ano
  SELECT distinct count (o.nomorgpnt) AS Quantidade, o.nomorgpnt
    from fflch.dbo.INTERCAMPROFVISITANTE i
    JOIN fflch.dbo.ORGAOPRETENDENTE o ON o.codorgpnt = i.codorgpntori
    WHERE i.codundpesrsp = 8
    AND i.dtainiatvitb BETWEEN '__ano__-01-01 00:00:00.000' AND '__ano__-12-31 00:00:00.000'
    GROUP BY o.nomorgpnt
    ORDER BY Quantidade desc