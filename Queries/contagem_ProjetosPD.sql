SELECT DISTINCT 
	P.codsetprj as CodDepartamento,
	ST.nomset as NomeDepartamento, 
	count(*) as projetos
FROM fflch.dbo.PDPROJETO P 	
	INNER JOIN fflch.dbo.PESSOA PD
		ON PD.codpes = P.codpes_pd 	
	INNER JOIN fflch.dbo.PDPROJETOSUPERVISOR S
		ON S.codprj = P.codprj 
		AND S.anoprj = P.anoprj 
	LEFT JOIN fflch.dbo.SETOR ST 
		ON ST.codset = P.codsetprj
WHERE P.codund =8
	AND P.codmdl = 2 -- Pós-Doutorando
	AND P.staatlprj IN ('Encerrado', 'Ativo')
	AND P.dtafimprj = S.dtafimspv --Supervisor mais recente
	AND YEAR(P.dtafimprj) > __ano__
GROUP BY P.codsetprj, ST.codset