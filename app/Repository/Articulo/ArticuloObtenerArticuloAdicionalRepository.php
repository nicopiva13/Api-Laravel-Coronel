<?php

namespace App\Repository\Articulo;

use Illuminate\Support\Facades\DB;

class ArticuloObtenerArticuloAdicionalRepository
{
    public function obtenerArticuloAdicional($hostIMG, $precioObtenido, $cli_categoria, $fabrica, $codigo, $adicional)
    {
        $sql = "SELECT art_codtex, art_codnum,
		(CASE WHEN Adicional.adi_codigo IS NULL THEN '' ELSE Adicional.adi_codigo END) AS adi_codigo,
		(CASE WHEN Adicional.adi_descri IS NULL THEN '' ELSE Adicional.adi_descri END) AS adi_descri,
		ISNULL(art_CtrlMinoWEB,0) AS art_CtrlMino,
		ISNULL(art_CtrlMayoWEB,0) AS art_CtrlMayo,
		adi_codigo AS adicod, 
		adi_codigo as adi_codigo, Adicional.adi_descri AS adicional,
		art_descriWeb AS articulo,
		ISNULL( art_descriWeb , art_descri ) AS art_descri , 
		ISNULL( ada_codbarra , art_codbarra ) AS art_codbarra , art_tipprod, TipProd.tpp_descri AS tipoProducto,
		art_tipprod, TipProd.tpp_descri AS art_tipodescri, art_rubro, rubro.rub_descri AS art_rubdescri, art_linea, rlf_lindescri AS art_lindescri, 
		fab_descri AS art_fabdescri, art_embalaje AS embalaje, 
		TipEmbalaje.tem_descri AS tipoEmbalaje,
		CASE WHEN (SELECT COUNT(*) FROM AdicionalxArtic WHERE ada_codtex = Articulo.art_codtex AND ada_codnum = Articulo.art_codnum) > 0 
			THEN REPLACE(ada_pathfoto, 'Z:\SISTEMAS\CORONEL\FOTOS\','$hostIMG')
			ELSE REPLACE(art_pathfoto, 'Z:\SISTEMAS\CORONEL\FOTOS\','$hostIMG')
		END AS fotoArticulo,
		$precioObtenido , art_tipprod, art_rubro, art_linea, 
		1 AS cantidad , 
		ofe_dto1, ofe_dto2, ofe_dto3, ofe_dto4, ofe_dto5, ofe_dto6, ofe_desde, ofe_hasta, ofe_minimo, ISNULL(ofe_AplicaWEB,0) AS ofe_AplicaWEB FROM 
		(
		(SELECT Oferta.ofe_codtex, Oferta.ofe_codnum, Oferta.ofe_dto1, Oferta.ofe_dto2, Oferta.ofe_dto3, Oferta.ofe_dto4, Oferta.ofe_dto5, 
		Oferta.ofe_dto6, CONVERT(VARCHAR,Oferta.ofe_desde,103) AS ofe_desde, CONVERT(VARCHAR,Oferta.ofe_hasta, 103) AS ofe_hasta, 
		Oferta.ofe_minimo, Oferta.ofe_categoria, ofe_AplicaWEB FROM Oferta
		INNER JOIN Articulo ON (Oferta.ofe_codnum = Articulo.art_codnum AND Oferta.ofe_codtex = Articulo.art_codtex)
		WHERE Oferta.ofe_secuencia = 4 AND Oferta.ofe_desde < SYSDATETIME() AND SYSDATETIME() <= ofe_hasta AND Oferta.ofe_AplicaWEB = 1 AND Oferta.ofe_categoria = '$cli_categoria')

		UNION 

		(SELECT DISTINCT Oferta.ofe_codtex,  Articulo.art_codnum AS ofe_codnum, Oferta.ofe_dto1, Oferta.ofe_dto2, Oferta.ofe_dto3, Oferta.ofe_dto4, Oferta.ofe_dto5, 
		Oferta.ofe_dto6, CONVERT(VARCHAR,Oferta.ofe_desde,103) AS ofe_desde, CONVERT(VARCHAR,Oferta.ofe_hasta, 103) AS ofe_hasta, 
		Oferta.ofe_minimo, Oferta.ofe_categoria, ofe_AplicaWEB FROM Oferta
		INNER JOIN Articulo ON (Oferta.ofe_codtex = Articulo.art_codtex AND Oferta.ofe_linea = Articulo.art_linea AND Oferta.ofe_rubro = Articulo.art_linea)
		WHERE Oferta.ofe_secuencia = 3 AND Oferta.ofe_desde < SYSDATETIME() AND SYSDATETIME() <= ofe_hasta AND Oferta.ofe_AplicaWEB = 1 AND Oferta.ofe_categoria = '$cli_categoria')

		UNION 
	
		(SELECT DISTINCT Oferta.ofe_codtex,  Articulo.art_codnum AS ofe_codnum, Oferta.ofe_dto1, Oferta.ofe_dto2, Oferta.ofe_dto3, Oferta.ofe_dto4, Oferta.ofe_dto5, 
		Oferta.ofe_dto6, CONVERT(VARCHAR,Oferta.ofe_desde,103) AS ofe_desde, CONVERT(VARCHAR,Oferta.ofe_hasta, 103) AS ofe_hasta, 
		Oferta.ofe_minimo, Oferta.ofe_categoria, ofe_AplicaWEB FROM Oferta
		INNER JOIN Articulo ON (Oferta.ofe_linea = Articulo.art_linea AND Oferta.ofe_codtex = Articulo.art_codtex)
		WHERE Oferta.ofe_secuencia = 2 AND Oferta.ofe_desde < SYSDATETIME() AND SYSDATETIME() <= ofe_hasta AND Oferta.ofe_AplicaWEB = 1 AND Oferta.ofe_categoria = '$cli_categoria')
		
		UNION 
		
		(SELECT DISTINCT Oferta.ofe_codtex,  Articulo.art_codnum AS ofe_codnum, Oferta.ofe_dto1, Oferta.ofe_dto2, Oferta.ofe_dto3, Oferta.ofe_dto4, Oferta.ofe_dto5, 
		Oferta.ofe_dto6, CONVERT(VARCHAR,Oferta.ofe_desde,103) AS ofe_desde, CONVERT(VARCHAR,Oferta.ofe_hasta, 103) AS ofe_hasta, 
		Oferta.ofe_minimo, Oferta.ofe_categoria, ofe_AplicaWEB FROM Oferta
		INNER JOIN Articulo ON (Oferta.ofe_codtex = Articulo.art_codtex)
		WHERE Oferta.ofe_secuencia = 1 AND Oferta.ofe_desde < SYSDATETIME() AND SYSDATETIME() <= ofe_hasta AND Oferta.ofe_AplicaWEB = 1 AND Oferta.ofe_categoria = '$cli_categoria')
		
		) as t 
		RIGHT JOIN Articulo on (t.ofe_codtex = Articulo.art_codtex AND t.ofe_codnum = Articulo.art_codnum)
		LEFT JOIN TipEmbalaje ON (Articulo.art_tipemb = TipEmbalaje.tem_codigo) 
		LEFT JOIN AdicionalxArtic ON (art_codtex = AdicionalxArtic.ada_codtex AND art_codnum = AdicionalxArtic.ada_codnum 
		AND AdicionalxArtic.ada_vigencia=1) 
		LEFT JOIN Adicional ON (AdicionalxArtic.ada_adicional = Adicional.adi_codigo) 
		LEFT JOIN TipProd ON (Articulo.art_tipprod = tpp_codigo)
		LEFT JOIN Rubro ON (Articulo.art_rubro = Rubro.rub_codigo)
		LEFT JOIN Fabrica ON (Articulo.art_codtex = Fabrica.fab_codigo)
		LEFT JOIN RubxLineaxFabrica ON (Articulo.art_linea = rlf_linea and Articulo.art_codtex = rlf_fabrica AND rlf_rubro = '0')
		WHERE art_vigencia = 1 AND art_carrito = 1 AND art_codtex='$fabrica' AND art_codnum='$codigo' AND adi_codigo='$adicional';";

        return DB::select($sql);
    }
}