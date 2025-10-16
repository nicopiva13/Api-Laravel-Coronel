<?php

namespace App\Repository\Articulo;

use Illuminate\Support\Facades\DB;

class ArticuloObtenerArticulosNovedadRepository
{
    public function obtenerNovedades($hostIMG, $art_precio, $T, $condicion_fecha)
    {
        $sql = "SELECT top 2756 * 
			FROM (
			SELECT art_codtex, art_codnum, art_fecalta, art_fectip, 
			(CASE WHEN Adicional.adi_codigo IS NULL THEN '' ELSE Adicional.adi_codigo END) AS adi_codigo,
			(CASE WHEN Adicional.adi_descri IS NULL THEN '' ELSE Adicional.adi_descri END) AS adi_descri,
			ISNULL(art_CtrlMinoWEB,0) AS art_CtrlMino,
			ISNULL(art_CtrlMayoWEB,0) AS art_CtrlMayo,
			ISNULL( art_descriWeb , art_descri ) AS art_descri , 
			ISNULL( ada_codbarra , art_codbarra ) AS art_codbarra , art_embalaje AS embalaje,
			CASE WHEN (SELECT COUNT(*) FROM AdicionalxArtic WHERE ada_codtex = Articulo.art_codtex AND ada_codnum = Articulo.art_codnum) > 0 
				THEN REPLACE(ada_pathfoto, 'Z:\SISTEMAS\CORONEL\FOTOS\','$hostIMG')
				ELSE REPLACE(art_pathfoto, 'Z:\SISTEMAS\CORONEL\FOTOS\','$hostIMG')
			END AS fotoArticulo,
			art_precmayo, art_precmino, $art_precio  art_tipprod, art_rubro, art_linea,art_tip, 
			1 as cantidad, 
			ofe_dto1, ofe_dto2, ofe_dto3, ofe_dto4, ofe_dto5, ofe_dto6, ofe_desde, ofe_hasta, ofe_minimo,
			ISNULL(ofe_AplicaWEB,0) AS ofe_AplicaWEB, tpp_descri FROM (
				(SELECT Oferta.ofe_codtex, Oferta.ofe_codnum, Oferta.ofe_dto1, Oferta.ofe_dto2, Oferta.ofe_dto3, Oferta.ofe_dto4, Oferta.ofe_dto5, 
				Oferta.ofe_dto6, CONVERT(VARCHAR,Oferta.ofe_desde,103) AS ofe_desde, CONVERT(VARCHAR,Oferta.ofe_hasta, 103) AS ofe_hasta, 
				Oferta.ofe_minimo, Oferta.ofe_categoria, ofe_AplicaWEB FROM Oferta
				INNER JOIN Articulo ON (Oferta.ofe_codnum = Articulo.art_codnum AND Oferta.ofe_codtex = Articulo.art_codtex)
				LEFT JOIN AdicionalxArtic ON (art_codtex = AdicionalxArtic.ada_codtex AND art_codnum = AdicionalxArtic.ada_codnum 
				AND AdicionalxArtic.ada_vigencia=1) 
				LEFT JOIN Adicional ON (AdicionalxArtic.ada_adicional = Adicional.adi_codigo) 
				WHERE Oferta.ofe_secuencia = 4 AND Oferta.ofe_desde < SYSDATETIME() AND SYSDATETIME() <= ofe_hasta AND Oferta.ofe_AplicaWEB = 1)

				UNION 
	
				(SELECT DISTINCT Oferta.ofe_codtex,  Articulo.art_codnum AS ofe_codnum, Oferta.ofe_dto1, Oferta.ofe_dto2, Oferta.ofe_dto3, Oferta.ofe_dto4, Oferta.ofe_dto5, 
				Oferta.ofe_dto6, CONVERT(VARCHAR,Oferta.ofe_desde,103) AS ofe_desde, CONVERT(VARCHAR,Oferta.ofe_hasta, 103) AS ofe_hasta, 
				Oferta.ofe_minimo, Oferta.ofe_categoria, ofe_AplicaWEB FROM Oferta
				INNER JOIN Articulo ON (Oferta.ofe_codtex = Articulo.art_codtex AND Oferta.ofe_linea = Articulo.art_linea AND Oferta.ofe_rubro = Articulo.art_linea)
				LEFT JOIN AdicionalxArtic ON (art_codtex = AdicionalxArtic.ada_codtex AND art_codnum = AdicionalxArtic.ada_codnum 
				AND AdicionalxArtic.ada_vigencia=1) 
				LEFT JOIN Adicional ON (AdicionalxArtic.ada_adicional = Adicional.adi_codigo) 
				WHERE Oferta.ofe_secuencia = 3 AND Oferta.ofe_desde < SYSDATETIME() AND SYSDATETIME() <= ofe_hasta AND Oferta.ofe_AplicaWEB = 1)
	
				UNION 
				
				(SELECT DISTINCT Oferta.ofe_codtex,  Articulo.art_codnum AS ofe_codnum, Oferta.ofe_dto1, Oferta.ofe_dto2, Oferta.ofe_dto3, Oferta.ofe_dto4, Oferta.ofe_dto5, 
				Oferta.ofe_dto6, CONVERT(VARCHAR,Oferta.ofe_desde,103) AS ofe_desde, CONVERT(VARCHAR,Oferta.ofe_hasta, 103) AS ofe_hasta, 
				Oferta.ofe_minimo, Oferta.ofe_categoria, ofe_AplicaWEB FROM Oferta
				INNER JOIN Articulo ON (Oferta.ofe_linea = Articulo.art_linea AND Oferta.ofe_codtex = Articulo.art_codtex)
				LEFT JOIN AdicionalxArtic ON (art_codtex = AdicionalxArtic.ada_codtex AND art_codnum = AdicionalxArtic.ada_codnum 
				AND AdicionalxArtic.ada_vigencia=1) 
				LEFT JOIN Adicional ON (AdicionalxArtic.ada_adicional = Adicional.adi_codigo) 
				WHERE Oferta.ofe_secuencia = 2 AND Oferta.ofe_desde < SYSDATETIME() AND SYSDATETIME() <= ofe_hasta AND Oferta.ofe_AplicaWEB = 1)
				
				UNION 
				
				(SELECT DISTINCT  Oferta.ofe_codtex,  Articulo.art_codnum AS ofe_codnum, Oferta.ofe_dto1, Oferta.ofe_dto2, Oferta.ofe_dto3, Oferta.ofe_dto4, Oferta.ofe_dto5, 
				Oferta.ofe_dto6, CONVERT(VARCHAR,Oferta.ofe_desde,103) AS ofe_desde, CONVERT(VARCHAR,Oferta.ofe_hasta, 103) AS ofe_hasta, 
				Oferta.ofe_minimo, Oferta.ofe_categoria, ofe_AplicaWEB FROM Oferta
				INNER JOIN Articulo ON (Oferta.ofe_codtex = Articulo.art_codtex)
				LEFT JOIN AdicionalxArtic ON (art_codtex = AdicionalxArtic.ada_codtex AND art_codnum = AdicionalxArtic.ada_codnum 
				AND AdicionalxArtic.ada_vigencia=1) 
				LEFT JOIN Adicional ON (AdicionalxArtic.ada_adicional = Adicional.adi_codigo) 
				WHERE Oferta.ofe_secuencia = 1 AND Oferta.ofe_desde < SYSDATETIME() AND SYSDATETIME() <= ofe_hasta AND Oferta.ofe_AplicaWEB = 1)
				
				) AS t 
				
				RIGHT JOIN Articulo ON (t.ofe_codtex = Articulo.art_codtex AND t.ofe_codnum = Articulo.art_codnum)
				LEFT JOIN AdicionalxArtic ON (art_codtex = AdicionalxArtic.ada_codtex AND art_codnum = AdicionalxArtic.ada_codnum 
				AND AdicionalxArtic.ada_vigencia=1) 
				LEFT JOIN Adicional ON (AdicionalxArtic.ada_adicional = Adicional.adi_codigo) 
				Left Join TipProd ON art_tipprod = tpp_codigo
				WHERE art_vigencia = 1 AND art_tip <> 0 AND art_carrito = 1 $T AND art_preclista <> 0 $condicion_fecha
				
				) AS t;
				";
				
        return DB::select($sql);
    }
}