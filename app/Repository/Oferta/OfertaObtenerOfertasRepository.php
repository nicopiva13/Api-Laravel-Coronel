<?php

namespace App\Repository\Oferta;

use Illuminate\Support\Facades\DB;

class OfertaObtenerOfertasRepository
{
    public function obtenerOfertas($order_by, $TIPPROD, $art_precio, $hostIMG, $CAT, $min, $max)
	{
		$sql = "SELECT ofe_preclista, ofe_codtex, ofe_codnum, ofe_adicod, ofe_adidescri, ofe_artdescri, ofe_fotoArticulo, 
        ofe_precmino, ofe_precmayo, precioInicial, ofe_cantidad, ofe_codbarra, ofe_embalaje,
        ofe_dto1, ofe_dto2, ofe_dto3, ofe_dto4, ofe_dto5, ofe_dto6, 
        ofe_desde, ofe_hasta, ofe_minimo, ofe_categoria FROM (
		SELECT ofe_preclista, ofe_codtex,ofe_codnum, ofe_adicod, ofe_adidescri, ofe_artdescri, ofe_fotoArticulo, ofe_precmino,
			ofe_precmayo, precioInicial, ofe_cantidad, ofe_codbarra, ofe_dto1, ofe_dto2, ofe_dto3, ofe_dto4, ofe_dto5, 
			ofe_dto6, ofe_desde, ofe_hasta, ofe_minimo, ofe_categoria, ofe_embalaje,
			ROW_NUMBER() OVER (PARTITION BY ofe_codtex, ofe_codnum, ofe_adicod ORDER BY ofe_secuencia DESC ) AS filas,
			ROW_NUMBER() OVER ($order_by ) AS Seq FROM (
		
		
		SELECT Articulo.art_codtex as ofe_codtex, Articulo.art_codnum as ofe_codnum, Adicional.adi_codigo as ofe_adicod,
		 Adicional.adi_descri as ofe_adidescri,  ISNULL( art_descriWeb , art_descri ) AS ofe_artdescri , Articulo.art_embalaje as ofe_embalaje,
		CASE WHEN (SELECT COUNT(*) FROM AdicionalxArtic WHERE ada_codtex = Articulo.art_codtex AND ada_codnum = Articulo.art_codnum) > 0 
			THEN REPLACE(ada_pathfoto, 'Z:\SISTEMAS\CORONEL\FOTOS\','$hostIMG')
			ELSE REPLACE(art_pathfoto, 'Z:\SISTEMAS\CORONEL\FOTOS\','$hostIMG')
		END AS ofe_fotoArticulo, ofe_secuencia, Articulo.art_precmino as ofe_precmino, Articulo.art_precmayo as ofe_precmayo,Articulo.art_preclista as ofe_preclista,
		$art_precio, 1 as ofe_cantidad,
		art_codbarra as ofe_codbarra, Oferta.ofe_dto1, Oferta.ofe_dto2, Oferta.ofe_dto3, Oferta.ofe_dto4, Oferta.ofe_dto5, 
		Oferta.ofe_dto6, CONVERT(VARCHAR,Oferta.ofe_desde,103) as ofe_desde, CONVERT(VARCHAR,Oferta.ofe_hasta, 103) as ofe_hasta, Oferta.ofe_minimo, Oferta.ofe_categoria  from Oferta
		INNER JOIN Articulo on(Oferta.ofe_codnum = Articulo.art_codnum AND Oferta.ofe_codtex = Articulo.art_codtex)
		LEFT JOIN AdicionalxArtic ON (art_codtex = AdicionalxArtic.ada_codtex AND art_codnum = AdicionalxArtic.ada_codnum 
		AND AdicionalxArtic.ada_vigencia=1) 
		LEFT JOIN Adicional ON (AdicionalxArtic.ada_adicional = Adicional.adi_codigo) 
		WHERE Oferta.ofe_secuencia = 4 AND IsNull(ofe_AplicaWEB,0) <>  0  AND Oferta.ofe_desde < SYSDATETIME() AND SYSDATETIME() <= ofe_hasta AND Articulo.art_vigencia = 1 AND Articulo.art_carrito = 1  $TIPPROD

		UNION 

		(SELECT DISTINCT Articulo.art_codtex as ofe_codtex, Articulo.art_codnum as ofe_codnum, Adicional.adi_codigo as ofe_adicod,
		 Adicional.adi_descri as ofe_adidescri,  ISNULL( art_descriWeb , art_descri ) AS ofe_artdescri , Articulo.art_embalaje as ofe_embalaje,
		CASE WHEN (SELECT COUNT(*) FROM AdicionalxArtic WHERE ada_codtex = Articulo.art_codtex AND ada_codnum = Articulo.art_codnum) > 0 
			THEN REPLACE(ada_pathfoto, 'Z:\SISTEMAS\CORONEL\FOTOS\','$hostIMG')
			ELSE REPLACE(art_pathfoto, 'Z:\SISTEMAS\CORONEL\FOTOS\','$hostIMG')
		END AS ofe_fotoArticulo, ofe_secuencia, Articulo.art_precmino as ofe_precmino, Articulo.art_precmayo as ofe_precmayo, Articulo.art_preclista as ofe_preclista,
		$art_precio, 1 as ofe_cantidad,
		art_codbarra as ofe_codbarra, Oferta.ofe_dto1, Oferta.ofe_dto2, Oferta.ofe_dto3, Oferta.ofe_dto4, Oferta.ofe_dto5, 
		Oferta.ofe_dto6, CONVERT(VARCHAR,Oferta.ofe_desde,103) as ofe_desde, CONVERT(VARCHAR,Oferta.ofe_hasta, 103) as ofe_hasta, Oferta.ofe_minimo, Oferta.ofe_categoria  from Oferta
		INNER JOIN Articulo on(Oferta.ofe_codtex = Articulo.art_codtex AND Oferta.ofe_linea = Articulo.art_linea
		AND Oferta.ofe_rubro = Articulo.art_rubro)
		LEFT JOIN AdicionalxArtic ON (art_codtex = AdicionalxArtic.ada_codtex AND art_codnum = AdicionalxArtic.ada_codnum 
		AND AdicionalxArtic.ada_vigencia=1) 
		LEFT JOIN Adicional ON (AdicionalxArtic.ada_adicional = Adicional.adi_codigo) 
		WHERE Oferta.ofe_secuencia = 3 AND IsNull(ofe_AplicaWEB,0) <> 0  AND Oferta.ofe_desde < SYSDATETIME() AND SYSDATETIME() <= ofe_hasta AND Articulo.art_vigencia=1 AND Articulo.art_carrito = 1  $TIPPROD)

		UNION 
		
		(SELECT DISTINCT Articulo.art_codtex as ofe_codtex, Articulo.art_codnum as ofe_codnum, Adicional.adi_codigo as ofe_adicod,
		 Adicional.adi_descri as ofe_adidescri,  ISNULL( art_descriWeb , art_descri ) AS ofe_artdescri , Articulo.art_embalaje as ofe_embalaje,
		CASE WHEN (SELECT COUNT(*) FROM AdicionalxArtic WHERE ada_codtex = Articulo.art_codtex AND ada_codnum = Articulo.art_codnum) > 0 
			THEN REPLACE(ada_pathfoto, 'Z:\SISTEMAS\CORONEL\FOTOS\','$hostIMG')
			ELSE REPLACE(art_pathfoto, 'Z:\SISTEMAS\CORONEL\FOTOS\','$hostIMG')
		END AS ofe_fotoArticulo, ofe_secuencia, Articulo.art_precmino as ofe_precmino, Articulo.art_precmayo as ofe_precmayo, Articulo.art_preclista as ofe_preclista,
		$art_precio, 1 as ofe_cantidad,
		art_codbarra as ofe_codbarra, Oferta.ofe_dto1, Oferta.ofe_dto2, Oferta.ofe_dto3, Oferta.ofe_dto4, Oferta.ofe_dto5, 
		Oferta.ofe_dto6, CONVERT(VARCHAR,Oferta.ofe_desde,103) as ofe_desde, CONVERT(VARCHAR,Oferta.ofe_hasta, 103) as ofe_hasta, Oferta.ofe_minimo, Oferta.ofe_categoria  from Oferta
		INNER JOIN Articulo on(Oferta.ofe_linea = Articulo.art_linea AND Oferta.ofe_codtex = Articulo.art_codtex)
		LEFT JOIN AdicionalxArtic ON (art_codtex = AdicionalxArtic.ada_codtex AND art_codnum = AdicionalxArtic.ada_codnum 
		AND AdicionalxArtic.ada_vigencia=1) 
		LEFT JOIN Adicional ON (AdicionalxArtic.ada_adicional = Adicional.adi_codigo) 
		WHERE Oferta.ofe_secuencia = 2 AND IsNull(ofe_AplicaWEB,0) <> 0   AND Oferta.ofe_desde < SYSDATETIME() AND SYSDATETIME() <= ofe_hasta AND Articulo.art_vigencia = 1 AND Articulo.art_carrito = 1  $TIPPROD)
		
		UNION 
		
		(SELECT DISTINCT Articulo.art_codtex as ofe_codtex, Articulo.art_codnum as ofe_codnum, Adicional.adi_codigo as ofe_adicod,
		 Adicional.adi_descri as ofe_adidescri,  ISNULL( art_descriWeb , art_descri ) AS ofe_artdescri , Articulo.art_embalaje as ofe_embalaje,
		CASE WHEN (SELECT COUNT(*) FROM AdicionalxArtic WHERE ada_codtex = Articulo.art_codtex AND ada_codnum = Articulo.art_codnum) > 0 
			THEN REPLACE(ada_pathfoto, 'Z:\SISTEMAS\CORONEL\FOTOS\','$hostIMG')
			ELSE REPLACE(art_pathfoto, 'Z:\SISTEMAS\CORONEL\FOTOS\','$hostIMG')
		END AS ofe_fotoArticulo, ofe_secuencia, Articulo.art_precmino as ofe_precmino, Articulo.art_precmayo as ofe_precmayo, Articulo.art_preclista as ofe_preclista,
		$art_precio, 1 as ofe_cantidad,
		art_codbarra as ofe_codbarra, Oferta.ofe_dto1, Oferta.ofe_dto2, Oferta.ofe_dto3, Oferta.ofe_dto4, Oferta.ofe_dto5, 
		Oferta.ofe_dto6, CONVERT(VARCHAR,Oferta.ofe_desde,103) as ofe_desde, CONVERT(VARCHAR,Oferta.ofe_hasta, 103) as ofe_hasta, Oferta.ofe_minimo, Oferta.ofe_categoria  from Oferta
		INNER JOIN Articulo on(Oferta.ofe_codtex = Articulo.art_codtex)
		LEFT JOIN AdicionalxArtic ON (art_codtex = AdicionalxArtic.ada_codtex AND art_codnum = AdicionalxArtic.ada_codnum 
		AND AdicionalxArtic.ada_vigencia=1) 
		LEFT JOIN Adicional ON (AdicionalxArtic.ada_adicional = Adicional.adi_codigo) 
		WHERE Oferta.ofe_secuencia = 1 AND IsNull(ofe_AplicaWEB,0) <> 0  AND Oferta.ofe_desde < SYSDATETIME() AND SYSDATETIME() <= ofe_hasta AND Articulo.art_vigencia= 1 AND Articulo.art_carrito = 1  $TIPPROD)
		) as t WHERE (ofe_dto1 + ofe_dto2 + ofe_dto3 + ofe_dto4 + ofe_dto5 + ofe_dto6) <> 0 AND  $CAT)as v 
		 WHERE Seq BETWEEN $min AND $max
		 AND filas = 1
		 $order_by ;";

		return DB::select($sql);
	}
}