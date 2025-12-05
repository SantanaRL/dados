SELECT DISTINCT	
	P.anoprj AS AnoProjeto,	
	P.codprj AS CodigoProjeto,
	ST.nomset AS NomeDepartamento,
	P.staatlprj AS SituacaoProjeto,	
	P.codpes_pd AS NumeroUSPPosDoutorando,	
	PD.nompesttd AS NomedoDoutorando,
	PD.numcpf AS CPFPosDoutorando,	
	S.codpesspv AS NumeroUSPSupervisor,	
	PS.nompesttd  AS NomedoSupervisor,	
	PS.numcpf AS CPFSupervisor,	
	P.titprj AS TituloProjeto,	
	convert(varchar(10), P.dtainiprj, 23) AS DataInicioProjeto,	
	convert(varchar(10), P.dtafimprj, 23) AS DataFimProjeto
FROM fflch.dbo.PDPROJETO P 	
	INNER JOIN fflch.dbo.PESSOA PD
		ON PD.codpes = P.codpes_pd 	
	INNER JOIN fflch.dbo.PDPROJETOSUPERVISOR S
		ON S.codprj = P.codprj 
		AND S.anoprj = P.anoprj 
	INNER JOIN fflch.dbo.PESSOA PS
		ON S.codpesspv = PS.codpes
	INNER JOIN fflch.dbo.SETOR ST 
		ON ST.codset = P.codsetprj
WHERE P.codsetprj in (__dep__)
	AND P.codmdl = 2 -- Pós-Doutorando
	AND P.staatlprj IN ('Encerrado', 'Ativo')
	AND P.dtafimprj = S.dtafimspv --Supervisor mais recente
	AND YEAR(P.dtafimprj) > __ano__
ORDER BY PD.nompes