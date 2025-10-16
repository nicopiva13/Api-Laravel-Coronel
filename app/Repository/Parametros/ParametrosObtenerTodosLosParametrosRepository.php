<?php

namespace App\Repository\Parametros;

use Illuminate\Support\Facades\DB;

class ParametrosObtenerTodosLosParametrosRepository
{
    public function obtenerTodosLosParametros()
    {
        return DB::table('Parametro')
            ->select([
                'par_bckp','par_driver','par_internoC','par_internoV','par_barra','par_menu','par_fecpro',
                'par_periodo','par_ultcheqt','par_factpresup','par_tolerancia','par_internet','par_server',
                'par_nrodeposito','par_nroorden','par_estadimes','par_CDolar','par_CtrlCVCero','par_tiempo1',
                'par_tiempo2','par_dtofact','par_vendedor','par_categoria','par_condvta','par_formpago',
                'par_pidemail','par_minorista','par_mayorista','par_decimales','par_recibo','par_dtopres',
                'par_marcos','par_martop','par_bonmaxA','par_bonmaxB','par_impr','par_modifdtos','par_zona',
                'par_nrone','par_precio','par_dev','par_ajus','par_trans','par_codbarra','par_finan','par_diascheter',
                'par_banco','par_sucursal','par_tipcta','par_nrocta','par_regfa','par_toleranciaLN','par_toleranciaprec',
                'par_listaporc','par_renumera','par_asiento','par_tarjeta','par_impfac','par_impfacServ','par_catiibb',
                'par_Lcolor1','par_Lcolor2','par_Lcolor3','par_ivalp','par_ivaMa','par_ivaMi','par_initpath','par_espera',
                'par_nrorep','par_ci','par_nronecpa','par_CatDolar','par_actividad','par_subzona','par_concepto','par_MesResumen',
                'par_nropen','par_permiso','par_verifmenu','par_codtransf','par_deccant','par_PuertoET','par_ModeloET','par_ETxCodigo',
                'par_cajapredef','par_codcpp','par_pathcpp','par_vencseg','par_AlicGan','par_regimen','par_anioRG','par_NroRG',
                'par_NroTransfV','par_CodAct','par_recpreped','par_CtrlVencFA','par_DiasVencFA','par_NInsProd','par_HojaIVAvta',
                'par_HojaIVAcpa','par_presuppidep','par_diasvoferta','par_CtrlABM','par_diasNEnv','par_diasNPedCpa','par_NOblea',
                'par_impiva','par_codExtr','par_tipCtrlVencFA','par_clasificacion','par_clavezip','par_cantanios','par_diasNPedVta',
                'par_diasPresupVta','par_deposito','par_servdest','par_basedest','par_contradest','par_refremito','par_Fsistema',
                'par_Fcuotas','par_Ftasa','par_DiasFinan','par_redondP','par_artcero','par_ListaPDef','par_interesD','par_pidecupon',
                'par_condcpa','par_seccion','par_actZSVA','par_conceptounico','par_codartFis','par_nrodev','par_nrocaucion',
                'par_cobrador','par_busqueda','par_artpendped','par_limcred','par_ctrlejercicio','par_encabpresup','par_redondeoF',
                'par_fechaRef','par_DescriGrup','par_ActVariable','par_CF_CodEnt','par_diasCtrlFiscal','par_codartic','par_modifcat',
                'par_ajusta','par_condiva','par_codpos1','par_codpos2','par_SPPdivF','par_SPPdivP','par_SPPfp','par_SPPcv',
                'par_SPPDescriArt','par_SPPfpF','par_FechaCont','par_POTipo','par_POSocioCero','par_SPPIva','par_SPPImpPrep',
                'par_FArtInact','par_VarPago','par_CliHab','par_PrvHab','par_ArtHab','par_BorraImgMenu','par_SE_AsocC',
                'par_recalculo','par_CantCeroPresup','par_ComentaCli','par_SPRedondeo','par_libviajtot','par_HojaLibViaj',
                'par_codfab','par_actxprecvta','par_ConexAFIPWSAA','par_ConexAFIPWSFE','par_PedidoLCred','par_BorradoDto',
                'par_SPPtoVta','par_SE_Pref','par_SE_Pref1','par_SPDescriAbrev','par_FESpoolerImp','par_MonedaExt','par_expbalanza',
                'par_IvaSeccion','par_actEspecial','par_IvaMovIntCpa','par_SE_SocCli','par_PoliticaVta','par_BObsResumen',
                'par_SaldoRecibo','par_Replica','par_CostoOP','par_CantCeroF','par_RegCob','par_PieRemito','par_inmobiliaria',
                'par_RecalcFARecibo','par_molino','par_retgan','par_ApImpIntMa','par_ApImpIntMi','par_cantCombustible','par_fecven',
                'par_LiquidoP','par_StockRemito','par_accesorap','par_cambche','par_stockserv','par_tipoLP','par_AutorizaPresup',
                'par_PYNoFactura','par_DescripExt','par_CIAliIva','par_OpImpLogo','par_Adicional888','par_ConceptoACuenta',
                'par_fecpreDifCamb','par_importaRem','par_FabRempDef','par_CambioPrecioStock','par_ObservaRecibo',
                'par_AltaVincxProveedor','par_pwdmsg','par_ZonaColor','par_CtrlFechaCpaCaja','par_AstoCtaProvOP',
                'par_SEModeloRegCap','par_DepositoTAyuda','par_SleepRnd','par_PrecioArtCompuesto','par_PideEntregadoA',
                'par_PideObservacion','par_diaschep','par_SEGrupo','par_FiltroSeccion','par_ToleranciaNetoCpa',
                'par_ImputaMultSeccVTA','par_ImputaMultSeccCPA','par_TranBanExt','par_TranBanDep','par_TopSelect',
                'par_SaltaCtrlNetoIvaCpa','par_mesresumenCpa','par_RegimenFactM','par_TiempoEscritura','par_altaArtStockIni',
                'par_ProgramaxCli','par_SaldoVta','par_NetoObservaVta','par_AsientoReimPlanilla','par_lectplucant',
                'par_ImputaAutoNC','par_DiasVencArtInact','par_DiasVencPrecioArt','par_llamarFaCpa','par_NombreLogo',
                'par_inhabArtcUbi','par_ayudamarca','par_CtrlTotStockCpa','par_AvisoStockVta','par_AlicDespachoFiscal',
                'par_bloqueoact','par_terbloqueoact','par_BloqueoxCpbte','par_DiasAnulaCupon','par_ArtNuevxDescri',
                'par_codbarrarep','par_NOctrlfechacpbtePC','par_NoAstoLPServ','par_AplicaCtaCliDescriAd','par_SPPRemitaDEMO',
                'par_SPPTEsperaFact','par_retIIBB','par_finanGral','par_ArtMonedaExt','par_finped','par_SPPQuitaIVAPrep',
                'par_CtrlStockVtaSinStockIni','par_DiasCtrlVencCh3','par_ActCarritoxVigencia','par_DepDestFAnt',
                'par_multiplemoneda','par_PunitarioModelo','par_URLAfipQR','par_DiasVencDevol','par_AgrupArticDetCpbte',
                'par_SPPTxTipMov','par_CeroNoDivideIVA','par_Costofleteint','par_CtrlFechaCajaPC','par_ApInteresPeriodo',
                'par_ptovtaDIAutom','par_exportacion','par_CantMayPrep','par_ResumBanxCaja','par_apliFormaPago',
                'par_CambiaPrecComp','par_PrepPedDividido','par_ExportaDetArt','par_WEBURLQR','par_SPPCajaF',
                'par_DiasMarcaVencArt','par_ColorMarcaVencArt','par_SPPTipPrepara','par_PrepPedPaginado'
            ])
            ->first();
    }
}