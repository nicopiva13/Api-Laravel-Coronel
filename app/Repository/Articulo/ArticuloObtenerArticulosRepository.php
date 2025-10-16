<?php

namespace App\Repository\Articulo;

use Illuminate\Support\Facades\DB;

class ArticuloObtenerArticulosRepository
{
    public function obtenerArticulos($hostIMG, $art_precio, $precioObtenido, $order_by, $params, $query, $busquedas, $paginacion)
    {
        $sql = "SELECT * FROM (SELECT art_codtex, art_codnum,
		(CASE WHEN Adicional.adi_codigo IS NULL THEN '' ELSE Adicional.adi_codigo END) AS adi_codigo,
		(CASE WHEN Adicional.adi_descri IS NULL THEN '' ELSE Adicional.adi_descri END) AS adi_descri,
		ISNULL(art_CtrlMinoWEB,0) AS art_CtrlMino, ISNULL(art_CtrlMayoWEB,0) AS art_CtrlMayo,
		ISNULL( art_descriWeb , art_descri ) AS art_descri, ISNULL( ada_codbarra , art_codbarra ) AS art_codbarra , art_embalaje AS embalaje,
		CASE WHEN (SELECT COUNT(*) FROM AdicionalxArtic WHERE ada_codtex = Articulo.art_codtex AND ada_codnum = Articulo.art_codnum) > 0 THEN REPLACE(ada_pathfoto, 'Z:\SISTEMAS\CORONEL\FOTOS\','$hostIMG')
		ELSE REPLACE(art_pathfoto, 'Z:\SISTEMAS\CORONEL\FOTOS\','$hostIMG')
		END AS fotoArticulo, art_aliva, $precioObtenido, $art_precio, art_tipprod, art_rubro, art_linea, 1 AS cantidad,ROW_NUMBER() OVER (PARTITION BY art_codtex, art_codnum, Adicional.adi_codigo ORDER BY ofe_secuencia DESC ) AS Seq, ROW_NUMBER() OVER($order_by) AS numeroFilas, ofe_secuencia, ofe_dto1, ofe_dto2, ofe_dto3, ofe_dto4, ofe_dto5, ofe_dto6, ofe_desde, ofe_hasta, ofe_minimo, ISNULL(ofe_AplicaWEB,0) AS ofe_AplicaWEB FROM (	 
		(SELECT  Oferta.ofe_codtex, Oferta.ofe_codnum, Oferta.ofe_secuencia, Oferta.ofe_dto1, Oferta.ofe_dto2, Oferta.ofe_dto3, Oferta.ofe_dto4, Oferta.ofe_dto5, Oferta.ofe_dto6, CONVERT(VARCHAR,Oferta.ofe_desde,103) AS ofe_desde, CONVERT(VARCHAR,Oferta.ofe_hasta, 103) AS ofe_hasta, Oferta.ofe_minimo, Oferta.ofe_categoria, ofe_AplicaWEB FROM Oferta
		INNER JOIN Articulo ON (Oferta.ofe_codnum = Articulo.art_codnum AND Oferta.ofe_codtex = Articulo.art_codtex)
		LEFT JOIN AdicionalxArtic ON (art_codtex = AdicionalxArtic.ada_codtex AND art_codnum = AdicionalxArtic.ada_codnum AND AdicionalxArtic.ada_vigencia=1) 
		LEFT JOIN Adicional ON (AdicionalxArtic.ada_adicional = Adicional.adi_codigo) 
		WHERE Oferta.ofe_secuencia = 4 AND Oferta.ofe_desde < SYSDATETIME() AND SYSDATETIME() <= ofe_hasta AND Oferta.ofe_AplicaWEB = 1 AND Oferta.ofe_categoria = '$params->cli_categoria')
		
		UNION 
		(SELECT DISTINCT Oferta.ofe_codtex, Articulo.art_codnum AS ofe_codnum, Oferta.ofe_secuencia, Oferta.ofe_dto1, Oferta.ofe_dto2, Oferta.ofe_dto3, Oferta.ofe_dto4, Oferta.ofe_dto5, 
		Oferta.ofe_dto6, CONVERT(VARCHAR,Oferta.ofe_desde,103) AS ofe_desde, CONVERT(VARCHAR,Oferta.ofe_hasta, 103) AS ofe_hasta, Oferta.ofe_minimo, Oferta.ofe_categoria, ofe_AplicaWEB FROM Oferta 
		INNER JOIN Articulo ON (Oferta.ofe_codtex = Articulo.art_codtex AND Oferta.ofe_linea = Articulo.art_linea AND Oferta.ofe_rubro = Articulo.art_linea)
		LEFT JOIN AdicionalxArtic ON (art_codtex = AdicionalxArtic.ada_codtex AND art_codnum = AdicionalxArtic.ada_codnum AND AdicionalxArtic.ada_vigencia=1) 
		LEFT JOIN Adicional ON (AdicionalxArtic.ada_adicional = Adicional.adi_codigo) 
		WHERE Oferta.ofe_secuencia = 3 AND Oferta.ofe_desde < SYSDATETIME() AND SYSDATETIME() <= ofe_hasta AND Oferta.ofe_AplicaWEB = 1 AND Oferta.ofe_categoria = '$params->cli_categoria')
			
		UNION 
						
		(SELECT DISTINCT Oferta.ofe_codtex, Articulo.art_codnum AS ofe_codnum, Oferta.ofe_secuencia, Oferta.ofe_dto1, Oferta.ofe_dto2, Oferta.ofe_dto3, Oferta.ofe_dto4, Oferta.ofe_dto5, Oferta.ofe_dto6, CONVERT(VARCHAR,Oferta.ofe_desde,103) AS ofe_desde, CONVERT(VARCHAR,Oferta.ofe_hasta, 103) AS ofe_hasta, Oferta.ofe_minimo, Oferta.ofe_categoria, ofe_AplicaWEB FROM Oferta
		INNER JOIN Articulo ON (Oferta.ofe_linea = Articulo.art_linea AND Oferta.ofe_codtex = Articulo.art_codtex)
		LEFT JOIN AdicionalxArtic ON (art_codtex = AdicionalxArtic.ada_codtex AND art_codnum = AdicionalxArtic.ada_codnum AND AdicionalxArtic.ada_vigencia=1) 
		LEFT JOIN Adicional ON (AdicionalxArtic.ada_adicional = Adicional.adi_codigo) 
		WHERE Oferta.ofe_secuencia = 2 AND Oferta.ofe_desde < SYSDATETIME() AND SYSDATETIME() <= ofe_hasta AND Oferta.ofe_AplicaWEB = 1 AND Oferta.ofe_categoria = '$params->cli_categoria')
						
		UNION 
						
		(SELECT DISTINCT Oferta.ofe_codtex, Articulo.art_codnum AS ofe_codnum, Oferta.ofe_secuencia, Oferta.ofe_dto1, Oferta.ofe_dto2, Oferta.ofe_dto3, Oferta.ofe_dto4, Oferta.ofe_dto5, Oferta.ofe_dto6, CONVERT(VARCHAR,Oferta.ofe_desde,103) AS ofe_desde, CONVERT(VARCHAR,Oferta.ofe_hasta, 103) AS ofe_hasta, Oferta.ofe_minimo, Oferta.ofe_categoria, ofe_AplicaWEB FROM Oferta
		INNER JOIN Articulo ON (Oferta.ofe_codtex = Articulo.art_codtex)
		LEFT JOIN AdicionalxArtic ON (art_codtex = AdicionalxArtic.ada_codtex AND art_codnum = AdicionalxArtic.ada_codnum AND AdicionalxArtic.ada_vigencia=1) 
		LEFT JOIN Adicional ON (AdicionalxArtic.ada_adicional = Adicional.adi_codigo) 
		WHERE Oferta.ofe_secuencia = 1 AND Oferta.ofe_desde < SYSDATETIME() AND SYSDATETIME() <= ofe_hasta AND Oferta.ofe_AplicaWEB = 1 AND Oferta.ofe_categoria = '$params->cli_categoria')
		) AS t 
		RIGHT JOIN Articulo ON (t.ofe_codtex = Articulo.art_codtex AND t.ofe_codnum = Articulo.art_codnum)
		LEFT JOIN AdicionalxArtic ON (art_codtex = AdicionalxArtic.ada_codtex AND art_codnum = AdicionalxArtic.ada_codnum AND AdicionalxArtic.ada_vigencia=1) 
		LEFT JOIN Adicional ON (AdicionalxArtic.ada_adicional = Adicional.adi_codigo) 
		WHERE art_vigencia = 1 AND art_carrito = 1 $busquedas->Q $query->tipoProducto $query->rubro $query->linea $query->fabrica $query->codbarra $query->codfab $query->codinterno AND art_preclista >= $params->precioMin AND art_preclista <= $params->precioMax) AS t WHERE Seq = 1 and numeroFilas between $paginacion->min and $paginacion->max";

        return DB::select($sql);
    }

    public function obtenerArticulosPrimerBusqueda($hostIMG, $art_precio, $precioObtenido, $order_by, $params, $query, $busquedas, $paginacion)
    {
        $sql = "SELECT * FROM (SELECT *, ROW_NUMBER() OVER(PARTITION BY art_codtex, art_codnum, adi_codigo ORDER BY ofe_secuencia DESC) AS filas, ROW_NUMBER() OVER($order_by) AS numeroFilas FROM (SELECT *,ISNULL(art_linea, '') + ' ' + ISNULL(fab_descri, '') + ' ' + ISNULL(rlf_lindescri, '') + ' ' + ISNULL(rub_descri, '') + ' ' + ISNULL(tpp_descri, '') + ' ' + ISNULL(art_descriWeb, '') + ' ' + ISNULL(rub_descri, '') + ' ' + ISNULL(tpp_descri, '') + ' ' + ISNULL(art_descriWeb, '') + ' ' + ISNULL(art_descriabrev, '') + ' ' + ISNULL(adi_descri, '') + ' ' + ISNULL(art_codbarra, '') + ' ' + ISNULL(art_codtex, '') + CAST(ISNULL(art_codnum, '') AS VARCHAR(50)) + ' ' + ISNULL(art_descri, '') AS concatenado FROM (SELECT art_codtex, art_codnum, fab_descri, rlf_lindescri, rub_descri, tpp_descri, art_descriWeb, art_descriabrev,(CASE WHEN Adicional.adi_codigo IS NULL THEN '' ELSE Adicional.adi_codigo END) AS adi_codigo,(CASE WHEN Adicional.adi_descri IS NULL THEN '' ELSE Adicional.adi_descri END) AS adi_descri,ISNULL(art_CtrlMinoWEB, 0) AS art_CtrlMino,ISNULL(art_CtrlMayoWEB, 0) AS art_CtrlMayo,art_descri AS art_descri,art_aliva,ISNULL(ada_codbarra, art_codbarra) AS art_codbarra,art_embalaje AS embalaje, CASE WHEN (SELECT COUNT(*) FROM AdicionalxArtic WHERE ada_codtex = Articulo.art_codtex AND ada_codnum = Articulo.art_codnum) > 0 THEN REPLACE(ada_pathfoto, 'Z:\SISTEMAS\CORONEL\FOTOS\','$hostIMG')
		ELSE REPLACE(art_pathfoto, 'Z:\SISTEMAS\CORONEL\FOTOS\','$hostIMG')
		END AS fotoArticulo,$precioObtenido, $art_precio, art_tipprod, art_rubro, art_linea, 1 AS cantidad,
		ROW_NUMBER() OVER (PARTITION BY art_codtex, art_codnum, Adicional.adi_codigo ORDER BY ofe_secuencia DESC) AS Seq,ofe_secuencia,ofe_dto1, ofe_dto2, ofe_dto3, ofe_dto4, ofe_dto5, ofe_dto6, ofe_desde, ofe_hasta, ofe_minimo, ISNULL(ofe_AplicaWEB, 0) AS ofe_AplicaWEB FROM(
		(SELECT  Oferta.ofe_codtex, Oferta.ofe_codnum, Oferta.ofe_secuencia, Oferta.ofe_dto1, Oferta.ofe_dto2, Oferta.ofe_dto3, Oferta.ofe_dto4, Oferta.ofe_dto5, 
		Oferta.ofe_dto6, CONVERT(VARCHAR,Oferta.ofe_desde,103) AS ofe_desde, CONVERT(VARCHAR,Oferta.ofe_hasta, 103) AS ofe_hasta, Oferta.ofe_minimo, Oferta.ofe_categoria, ofe_AplicaWEB FROM Oferta
		INNER JOIN Articulo ON (Oferta.ofe_codnum = Articulo.art_codnum AND Oferta.ofe_codtex = Articulo.art_codtex)
		LEFT JOIN AdicionalxArtic ON (art_codtex = AdicionalxArtic.ada_codtex AND art_codnum = AdicionalxArtic.ada_codnum AND AdicionalxArtic.ada_vigencia=1) LEFT JOIN Adicional ON (AdicionalxArtic.ada_adicional = Adicional.adi_codigo) WHERE Oferta.ofe_secuencia = 4 AND Oferta.ofe_desde < SYSDATETIME() AND SYSDATETIME() <= ofe_hasta AND Oferta.ofe_AplicaWEB = 1 AND Oferta.ofe_categoria = '$params->cli_categoria')
		
		UNION 
		
		(SELECT DISTINCT  Oferta.ofe_codtex, Articulo.art_codnum AS ofe_codnum, Oferta.ofe_secuencia, Oferta.ofe_dto1, Oferta.ofe_dto2, Oferta.ofe_dto3, Oferta.ofe_dto4, Oferta.ofe_dto5, 
		Oferta.ofe_dto6, CONVERT(VARCHAR,Oferta.ofe_desde,103) AS ofe_desde, CONVERT(VARCHAR,Oferta.ofe_hasta, 103) AS ofe_hasta, Oferta.ofe_minimo, Oferta.ofe_categoria, ofe_AplicaWEB FROM Oferta
		INNER JOIN Articulo ON (Oferta.ofe_codtex = Articulo.art_codtex AND Oferta.ofe_linea = Articulo.art_linea AND Oferta.ofe_rubro = Articulo.art_linea)
		LEFT JOIN AdicionalxArtic ON (art_codtex = AdicionalxArtic.ada_codtex AND art_codnum = AdicionalxArtic.ada_codnum AND AdicionalxArtic.ada_vigencia=1) 
		LEFT JOIN Adicional ON (AdicionalxArtic.ada_adicional = Adicional.adi_codigo) 
		WHERE Oferta.ofe_secuencia = 3 AND Oferta.ofe_desde < SYSDATETIME() AND SYSDATETIME() <= ofe_hasta AND Oferta.ofe_AplicaWEB = 1 AND Oferta.ofe_categoria = '$params->cli_categoria') 
		
		UNION 
					
		(SELECT DISTINCT  Oferta.ofe_codtex, Articulo.art_codnum AS ofe_codnum, Oferta.ofe_secuencia, Oferta.ofe_dto1, Oferta.ofe_dto2, Oferta.ofe_dto3, Oferta.ofe_dto4, Oferta.ofe_dto5, Oferta.ofe_dto6, CONVERT(VARCHAR,Oferta.ofe_desde,103) AS ofe_desde, CONVERT(VARCHAR,Oferta.ofe_hasta, 103) AS ofe_hasta, Oferta.ofe_minimo, Oferta.ofe_categoria, ofe_AplicaWEB FROM Oferta
		INNER JOIN Articulo ON (Oferta.ofe_linea = Articulo.art_linea AND Oferta.ofe_codtex = Articulo.art_codtex)
		LEFT JOIN AdicionalxArtic ON (art_codtex = AdicionalxArtic.ada_codtex AND art_codnum = AdicionalxArtic.ada_codnum AND AdicionalxArtic.ada_vigencia=1) 
		LEFT JOIN Adicional ON (AdicionalxArtic.ada_adicional = Adicional.adi_codigo) 
		WHERE Oferta.ofe_secuencia = 2 AND Oferta.ofe_desde < SYSDATETIME() AND SYSDATETIME() <= ofe_hasta AND Oferta.ofe_AplicaWEB = 1 AND Oferta.ofe_categoria = '$params->cli_categoria') 
					
		UNION 
					
		(SELECT DISTINCT  Oferta.ofe_codtex, Articulo.art_codnum AS ofe_codnum, Oferta.ofe_secuencia, Oferta.ofe_dto1, Oferta.ofe_dto2, Oferta.ofe_dto3, Oferta.ofe_dto4, Oferta.ofe_dto5, 
		Oferta.ofe_dto6, CONVERT(VARCHAR,Oferta.ofe_desde,103) AS ofe_desde, CONVERT(VARCHAR,Oferta.ofe_hasta, 103) AS ofe_hasta, Oferta.ofe_minimo, Oferta.ofe_categoria, ofe_AplicaWEB FROM Oferta
		INNER JOIN Articulo ON (Oferta.ofe_codtex = Articulo.art_codtex)
		LEFT JOIN AdicionalxArtic ON (art_codtex = AdicionalxArtic.ada_codtex AND art_codnum = AdicionalxArtic.ada_codnum AND AdicionalxArtic.ada_vigencia=1) 
		LEFT JOIN Adicional ON (AdicionalxArtic.ada_adicional = Adicional.adi_codigo) 
		WHERE Oferta.ofe_secuencia = 1 AND Oferta.ofe_desde < SYSDATETIME() AND SYSDATETIME() <= ofe_hasta AND Oferta.ofe_AplicaWEB = 1 AND Oferta.ofe_categoria = '$params->cli_categoria') 
		) AS t 
		RIGHT JOIN Articulo ON (t.ofe_codtex = Articulo.art_codtex AND t.ofe_codnum = Articulo.art_codnum)
		LEFT JOIN AdicionalxArtic ON (art_codtex = AdicionalxArtic.ada_codtex AND art_codnum = AdicionalxArtic.ada_codnum AND AdicionalxArtic.ada_vigencia = 1)
		LEFT JOIN Adicional ON (AdicionalxArtic.ada_adicional = Adicional.adi_codigo)
		LEFT JOIN RubxLineaxFabrica ON (Articulo.art_codtex = RubxLineaxFabrica.rlf_fabrica AND art_linea = rlf_linea AND art_rubro = rlf_rubro)
		LEFT JOIN Fabrica ON (fab_codigo = art_codtex)
		LEFT JOIN TipProd ON (tpp_codigo = art_tipprod)
		LEFT JOIN Rubro ON (rub_codigo = art_rubro)
		WHERE art_vigencia = 1 AND art_carrito = 1 $query->tipoProducto $query->rubro $query->linea $query->fabrica $query->codbarra $query->codfab $query->codinterno AND art_preclista >= '$params->precioMin' AND art_preclista <= '$params->precioMax'
		) AS subquery_interna 
		) AS subquery_externa 
		$busquedas->Q_busqueda 
		) as subquery_externa2 WHERE subquery_externa2.filas = 1 and subquery_externa2.numeroFilas between $paginacion->min and $paginacion->max";

        return DB::select($sql);
    }

    public function obtenerArticulosSegundaBusqueda($hostIMG, $art_precio, $precioObtenido, $order_by, $params, $query, $busquedas, $paginacion)
    {
        $sql = "SELECT * FROM (SELECT *, ROW_NUMBER() over(PARTITION BY art_codtex, art_codnum, adi_codigo ORDER BY ofe_secuencia DESC) as filas, ROW_NUMBER() OVER($order_by) AS numeroFilas FROM (SELECT *,
		ISNULL(art_linea, '') + ' ' + ISNULL(fab_descri, '') + ' ' + ISNULL(rlf_lindescri, '') + ' ' +
		ISNULL(rub_descri, '') + ' ' + ISNULL(tpp_descri, '') + ' ' + ISNULL(art_descriWeb, '') + ' ' +
		ISNULL(rub_descri, '') + ' ' + ISNULL(tpp_descri, '') + ' ' + ISNULL(art_descriWeb, '') + ' ' +
		ISNULL(art_descriabrev, '') + ' ' + ISNULL(adi_descri, '') + ' ' + ISNULL(art_codbarra, '') + ' ' +
		ISNULL(art_codtex, '') + ' ' + CAST(ISNULL(art_codnum, '') AS VARCHAR(50)) + ' ' + ISNULL(art_descri, '') AS concatenado FROM (SELECT art_codtex, art_codnum,fab_descri,rlf_lindescri,rub_descri,tpp_descri,art_descriWeb, 
		art_descriabrev,(CASE WHEN Adicional.adi_codigo IS NULL THEN '' ELSE Adicional.adi_codigo END) AS adi_codigo,
		(CASE WHEN Adicional.adi_descri IS NULL THEN '' ELSE Adicional.adi_descri END) AS adi_descri,
		ISNULL(art_CtrlMinoWEB, 0) AS art_CtrlMino,ISNULL(art_CtrlMayoWEB, 0) AS art_CtrlMayo,art_descri AS art_descri, art_aliva,ISNULL(ada_codbarra, art_codbarra) AS art_codbarra,art_embalaje AS embalaje,
		CASE WHEN (SELECT COUNT(*) FROM AdicionalxArtic WHERE ada_codtex = Articulo.art_codtex AND ada_codnum = Articulo.art_codnum) > 0 
		THEN REPLACE(ada_pathfoto, 'Z:\SISTEMAS\CORONEL\FOTOS\','$hostIMG')
		ELSE REPLACE(art_pathfoto, 'Z:\SISTEMAS\CORONEL\FOTOS\','$hostIMG')
		END AS fotoArticulo,$precioObtenido, $art_precio, art_tipprod, art_rubro, art_linea, 1 AS cantidad,
		ROW_NUMBER() OVER (PARTITION BY art_codtex, art_codnum, Adicional.adi_codigo ORDER BY ofe_secuencia DESC) AS Seq,ofe_secuencia,ofe_dto1, ofe_dto2, ofe_dto3, ofe_dto4, ofe_dto5, ofe_dto6, ofe_desde, ofe_hasta, ofe_minimo, 
		ISNULL(ofe_AplicaWEB, 0) AS ofe_AplicaWEB FROM(
		(SELECT  Oferta.ofe_codtex, Oferta.ofe_codnum, Oferta.ofe_secuencia, Oferta.ofe_dto1, Oferta.ofe_dto2, Oferta.ofe_dto3, Oferta.ofe_dto4, Oferta.ofe_dto5, Oferta.ofe_dto6, CONVERT(VARCHAR,Oferta.ofe_desde,103) AS ofe_desde, CONVERT(VARCHAR,Oferta.ofe_hasta, 103) AS ofe_hasta, Oferta.ofe_minimo, Oferta.ofe_categoria, ofe_AplicaWEB FROM Oferta
		INNER JOIN Articulo ON (Oferta.ofe_codnum = Articulo.art_codnum AND Oferta.ofe_codtex = Articulo.art_codtex)
		LEFT JOIN AdicionalxArtic ON (art_codtex = AdicionalxArtic.ada_codtex AND art_codnum = AdicionalxArtic.ada_codnum AND AdicionalxArtic.ada_vigencia=1) 
		LEFT JOIN Adicional ON (AdicionalxArtic.ada_adicional = Adicional.adi_codigo) 
		WHERE Oferta.ofe_secuencia = 4 AND Oferta.ofe_desde < SYSDATETIME() AND SYSDATETIME() <= ofe_hasta AND Oferta.ofe_AplicaWEB = 1 AND Oferta.ofe_categoria = '$params->cli_categoria')
				
		UNION 
				
		(SELECT DISTINCT  Oferta.ofe_codtex, Articulo.art_codnum AS ofe_codnum, Oferta.ofe_secuencia, Oferta.ofe_dto1, Oferta.ofe_dto2, Oferta.ofe_dto3, Oferta.ofe_dto4, Oferta.ofe_dto5, 
		Oferta.ofe_dto6, CONVERT(VARCHAR,Oferta.ofe_desde,103) AS ofe_desde, CONVERT(VARCHAR,Oferta.ofe_hasta, 103) AS ofe_hasta, Oferta.ofe_minimo, Oferta.ofe_categoria, ofe_AplicaWEB FROM Oferta
		INNER JOIN Articulo ON (Oferta.ofe_codtex = Articulo.art_codtex AND Oferta.ofe_linea = Articulo.art_linea AND Oferta.ofe_rubro = Articulo.art_linea)
		LEFT JOIN AdicionalxArtic ON (art_codtex = AdicionalxArtic.ada_codtex AND art_codnum = AdicionalxArtic.ada_codnum AND AdicionalxArtic.ada_vigencia=1) 
		LEFT JOIN Adicional ON (AdicionalxArtic.ada_adicional = Adicional.adi_codigo) 
		WHERE Oferta.ofe_secuencia = 3 AND Oferta.ofe_desde < SYSDATETIME() AND SYSDATETIME() <= ofe_hasta AND Oferta.ofe_AplicaWEB = 1 AND Oferta.ofe_categoria = '$params->cli_categoria') 
				
		UNION 
							
		(SELECT DISTINCT  Oferta.ofe_codtex, Articulo.art_codnum AS ofe_codnum, Oferta.ofe_secuencia, Oferta.ofe_dto1, Oferta.ofe_dto2, Oferta.ofe_dto3, Oferta.ofe_dto4, Oferta.ofe_dto5, 
		Oferta.ofe_dto6, CONVERT(VARCHAR,Oferta.ofe_desde,103) AS ofe_desde, CONVERT(VARCHAR,Oferta.ofe_hasta, 103) AS ofe_hasta, Oferta.ofe_minimo, Oferta.ofe_categoria, ofe_AplicaWEB FROM Oferta
		INNER JOIN Articulo ON (Oferta.ofe_linea = Articulo.art_linea AND Oferta.ofe_codtex = Articulo.art_codtex)
		LEFT JOIN AdicionalxArtic ON (art_codtex = AdicionalxArtic.ada_codtex AND art_codnum = AdicionalxArtic.ada_codnum AND AdicionalxArtic.ada_vigencia=1) 
		LEFT JOIN Adicional ON (AdicionalxArtic.ada_adicional = Adicional.adi_codigo) 
		WHERE Oferta.ofe_secuencia = 2 AND Oferta.ofe_desde < SYSDATETIME() AND SYSDATETIME() <= ofe_hasta AND Oferta.ofe_AplicaWEB = 1 AND Oferta.ofe_categoria = '$params->cli_categoria') 
							
		UNION 
							
		(SELECT DISTINCT  Oferta.ofe_codtex, Articulo.art_codnum AS ofe_codnum, Oferta.ofe_secuencia, Oferta.ofe_dto1, Oferta.ofe_dto2, Oferta.ofe_dto3, Oferta.ofe_dto4, Oferta.ofe_dto5, 
		Oferta.ofe_dto6, CONVERT(VARCHAR,Oferta.ofe_desde,103) AS ofe_desde, CONVERT(VARCHAR,Oferta.ofe_hasta, 103) AS ofe_hasta, Oferta.ofe_minimo, Oferta.ofe_categoria, ofe_AplicaWEB FROM Oferta
		INNER JOIN Articulo ON (Oferta.ofe_codtex = Articulo.art_codtex)
		LEFT JOIN AdicionalxArtic ON (art_codtex = AdicionalxArtic.ada_codtex AND art_codnum = AdicionalxArtic.ada_codnum AND AdicionalxArtic.ada_vigencia=1) 
		LEFT JOIN Adicional ON (AdicionalxArtic.ada_adicional = Adicional.adi_codigo) 
		WHERE Oferta.ofe_secuencia = 1 AND Oferta.ofe_desde < SYSDATETIME() AND SYSDATETIME() <= ofe_hasta AND Oferta.ofe_AplicaWEB = 1 AND Oferta.ofe_categoria = '$params->cli_categoria') 
		) AS t 
		RIGHT JOIN Articulo ON (t.ofe_codtex = Articulo.art_codtex AND t.ofe_codnum = Articulo.art_codnum)
		LEFT JOIN AdicionalxArtic ON (art_codtex = AdicionalxArtic.ada_codtex AND art_codnum = AdicionalxArtic.ada_codnum AND AdicionalxArtic.ada_vigencia = 1)
		LEFT JOIN Adicional ON (AdicionalxArtic.ada_adicional = Adicional.adi_codigo)
		LEFT JOIN RubxLineaxFabrica ON (Articulo.art_codtex = RubxLineaxFabrica.rlf_fabrica AND art_linea = rlf_linea AND art_rubro = rlf_rubro)
		LEFT JOIN Fabrica ON (fab_codigo = art_codtex)
		LEFT JOIN TipProd ON (tpp_codigo = art_tipprod)
		LEFT JOIN Rubro ON (rub_codigo = art_rubro)
		WHERE art_vigencia = 1 AND art_carrito = 1 $query->tipoProducto $query->rubro $query->linea $query->fabrica $query->codbarra $query->codfab $query->codinterno  AND art_preclista >= '$params->precioMin' AND art_preclista <= '$params->precioMax'
		) AS subquery_interna 
		) AS subquery_externa 
		$busquedas->Q_busquedaPalabras 
		) as subquery_externa2
		where subquery_externa2.filas = 1 and subquery_externa2.numeroFilas between $paginacion->min and $paginacion->max";

        return DB::select($sql);
    }

    public function obtenerArticulosTerceraBusqueda($hostIMG, $art_precio, $precioObtenido, $order_by, $params, $query, $busquedas, $paginacion)
    {
        $sql = "SELECT * FROM (SELECT *, ROW_NUMBER() over(PARTITION BY art_codtex, art_codnum, adi_codigo ORDER BY ofe_secuencia DESC) as filas,ROW_NUMBER() OVER($order_by) AS numeroFilas FROM (SELECT *,ISNULL(art_linea, '') + ' ' + ISNULL(fab_descri, '') + ' ' + ISNULL(rlf_lindescri, '') + ' ' + ISNULL(rub_descri, '') + ' ' + ISNULL(tpp_descri, '') + ' ' + ISNULL(art_descriWeb, '') + ' ' + ISNULL(rub_descri, '') + ' ' + ISNULL(tpp_descri, '') + ' ' + ISNULL(art_descriWeb, '') + ' ' + ISNULL(art_descriabrev, '') + ' ' + ISNULL(adi_descri, '') + ' ' + ISNULL(art_codbarra, '') + ' ' + ISNULL(art_codtex, '') + ' ' + CAST(ISNULL(art_codnum, '') AS VARCHAR(50)) + ' ' + ISNULL(art_descri, '') AS concatenado FROM (SELECT art_codtex, art_codnum,fab_descri,rlf_lindescri,
        rub_descri,tpp_descri,art_descriWeb, art_descriabrev,(CASE WHEN Adicional.adi_codigo IS NULL THEN '' ELSE Adicional.adi_codigo END) AS adi_codigo,(CASE WHEN Adicional.adi_descri IS NULL THEN '' ELSE Adicional.adi_descri END) AS adi_descri,ISNULL(art_CtrlMinoWEB, 0) AS art_CtrlMino,ISNULL(art_CtrlMayoWEB, 0) AS art_CtrlMayo,art_descri AS art_descri, art_aliva,ISNULL(ada_codbarra, art_codbarra) AS art_codbarra,art_embalaje AS embalaje,CASE WHEN (SELECT COUNT(*) FROM AdicionalxArtic WHERE ada_codtex = Articulo.art_codtex AND ada_codnum = Articulo.art_codnum) > 0 THEN REPLACE(ada_pathfoto, 'Z:\SISTEMAS\CORONEL\FOTOS\','$hostIMG')
		ELSE REPLACE(art_pathfoto, 'Z:\SISTEMAS\CORONEL\FOTOS\','$hostIMG') END AS fotoArticulo,$precioObtenido, $art_precio, art_tipprod, art_rubro, art_linea, 1 AS cantidad, ROW_NUMBER() OVER (PARTITION BY art_codtex, art_codnum, Adicional.adi_codigo ORDER BY ofe_secuencia DESC) AS Seq,ofe_secuencia,ofe_dto1, ofe_dto2, ofe_dto3, ofe_dto4, ofe_dto5, ofe_dto6, ofe_desde, ofe_hasta, ofe_minimo, ISNULL(ofe_AplicaWEB, 0) AS ofe_AplicaWEB FROM((SELECT  Oferta.ofe_codtex, Oferta.ofe_codnum, Oferta.ofe_secuencia, Oferta.ofe_dto1, Oferta.ofe_dto2, Oferta.ofe_dto3, Oferta.ofe_dto4, Oferta.ofe_dto5, Oferta.ofe_dto6, CONVERT(VARCHAR,Oferta.ofe_desde,103) AS ofe_desde, CONVERT(VARCHAR,Oferta.ofe_hasta, 103) AS ofe_hasta, Oferta.ofe_minimo, Oferta.ofe_categoria, ofe_AplicaWEB FROM Oferta
		INNER JOIN Articulo ON (Oferta.ofe_codnum = Articulo.art_codnum AND Oferta.ofe_codtex = Articulo.art_codtex)
		LEFT JOIN AdicionalxArtic ON (art_codtex = AdicionalxArtic.ada_codtex AND art_codnum = AdicionalxArtic.ada_codnum AND AdicionalxArtic.ada_vigencia=1) 
		LEFT JOIN Adicional ON (AdicionalxArtic.ada_adicional = Adicional.adi_codigo) 
		WHERE Oferta.ofe_secuencia = 4 AND Oferta.ofe_desde < SYSDATETIME() AND SYSDATETIME() <= ofe_hasta AND Oferta.ofe_AplicaWEB = 1 AND Oferta.ofe_categoria = '$params->cli_categoria')
				
		UNION 
		
		(SELECT DISTINCT Oferta.ofe_codtex, Articulo.art_codnum AS ofe_codnum, Oferta.ofe_secuencia, Oferta.ofe_dto1, Oferta.ofe_dto2, Oferta.ofe_dto3, Oferta.ofe_dto4, Oferta.ofe_dto5, Oferta.ofe_dto6, CONVERT(VARCHAR,Oferta.ofe_desde,103) AS ofe_desde, CONVERT(VARCHAR,Oferta.ofe_hasta, 103) AS ofe_hasta, Oferta.ofe_minimo, Oferta.ofe_categoria, ofe_AplicaWEB FROM Oferta
		INNER JOIN Articulo ON (Oferta.ofe_codtex = Articulo.art_codtex AND Oferta.ofe_linea = Articulo.art_linea AND Oferta.ofe_rubro = Articulo.art_linea)
		LEFT JOIN AdicionalxArtic ON (art_codtex = AdicionalxArtic.ada_codtex AND art_codnum = AdicionalxArtic.ada_codnum AND AdicionalxArtic.ada_vigencia=1) 
		LEFT JOIN Adicional ON (AdicionalxArtic.ada_adicional = Adicional.adi_codigo) 
		WHERE Oferta.ofe_secuencia = 3 AND Oferta.ofe_desde < SYSDATETIME() AND SYSDATETIME() <= ofe_hasta AND Oferta.ofe_AplicaWEB = 1 AND Oferta.ofe_categoria = '$params->cli_categoria') 
				
		UNION 
							
		(SELECT DISTINCT  Oferta.ofe_codtex, Articulo.art_codnum AS ofe_codnum, Oferta.ofe_secuencia, Oferta.ofe_dto1, Oferta.ofe_dto2, Oferta.ofe_dto3, Oferta.ofe_dto4, Oferta.ofe_dto5, Oferta.ofe_dto6, CONVERT(VARCHAR,Oferta.ofe_desde,103) AS ofe_desde, CONVERT(VARCHAR,Oferta.ofe_hasta, 103) AS ofe_hasta, Oferta.ofe_minimo, Oferta.ofe_categoria, ofe_AplicaWEB FROM Oferta
		INNER JOIN Articulo ON (Oferta.ofe_linea = Articulo.art_linea AND Oferta.ofe_codtex = Articulo.art_codtex)
		LEFT JOIN AdicionalxArtic ON (art_codtex = AdicionalxArtic.ada_codtex AND art_codnum = AdicionalxArtic.ada_codnum AND AdicionalxArtic.ada_vigencia=1) 
		LEFT JOIN Adicional ON (AdicionalxArtic.ada_adicional = Adicional.adi_codigo) 
		WHERE Oferta.ofe_secuencia = 2 AND Oferta.ofe_desde < SYSDATETIME() AND SYSDATETIME() <= ofe_hasta AND Oferta.ofe_AplicaWEB = 1 AND Oferta.ofe_categoria = '$params->cli_categoria') 
							
		UNION 
							
		(SELECT DISTINCT  Oferta.ofe_codtex, Articulo.art_codnum AS ofe_codnum, Oferta.ofe_secuencia, Oferta.ofe_dto1, Oferta.ofe_dto2, Oferta.ofe_dto3, Oferta.ofe_dto4, Oferta.ofe_dto5, Oferta.ofe_dto6, CONVERT(VARCHAR,Oferta.ofe_desde,103) AS ofe_desde, CONVERT(VARCHAR,Oferta.ofe_hasta, 103) AS ofe_hasta, Oferta.ofe_minimo, Oferta.ofe_categoria, ofe_AplicaWEB FROM Oferta
		INNER JOIN Articulo ON (Oferta.ofe_codtex = Articulo.art_codtex)
		LEFT JOIN AdicionalxArtic ON (art_codtex = AdicionalxArtic.ada_codtex AND art_codnum = AdicionalxArtic.ada_codnum AND AdicionalxArtic.ada_vigencia=1) 
		LEFT JOIN Adicional ON (AdicionalxArtic.ada_adicional = Adicional.adi_codigo) 
		WHERE Oferta.ofe_secuencia = 1 AND Oferta.ofe_desde < SYSDATETIME() AND SYSDATETIME() <= ofe_hasta AND Oferta.ofe_AplicaWEB = 1 AND Oferta.ofe_categoria = '$params->cli_categoria') 
		) AS t 
		RIGHT JOIN Articulo ON (t.ofe_codtex = Articulo.art_codtex AND t.ofe_codnum = Articulo.art_codnum)
		LEFT JOIN AdicionalxArtic ON (art_codtex = AdicionalxArtic.ada_codtex AND art_codnum = AdicionalxArtic.ada_codnum AND AdicionalxArtic.ada_vigencia = 1)
		LEFT JOIN Adicional ON (AdicionalxArtic.ada_adicional = Adicional.adi_codigo)
		LEFT JOIN RubxLineaxFabrica ON (Articulo.art_codtex = RubxLineaxFabrica.rlf_fabrica AND art_linea = rlf_linea AND art_rubro = rlf_rubro)
		LEFT JOIN Fabrica ON (fab_codigo = art_codtex)
		LEFT JOIN TipProd ON (tpp_codigo = art_tipprod)
		LEFT JOIN Rubro ON (rub_codigo = art_rubro)
		WHERE art_vigencia = 1 AND art_carrito = 1 $query->tipoProducto $query->rubro $query->linea $query->fabrica $query->codbarra $query->codfab $query->codinterno AND art_preclista >= '$params->precioMin' AND art_preclista <= '$params->precioMax'
		) AS subquery_interna 
		) AS subquery_externa 
		$busquedas->Q_busquedaSubstring 
		) as subquery_externa2
		where subquery_externa2.filas = 1 and subquery_externa2.numeroFilas between $paginacion->min and $paginacion->max";

        return DB::select($sql);
    }
}
