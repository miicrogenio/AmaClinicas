<?php
session_start();
include_once("../../../Config/ligar_bd.php");
include_once("../../../Controllers/Admin/GestaoFarmacia.php");

$venda= new GestaoFarmacia();

try {
        
        $idUser= $_SESSION['cod'];
    
        $venda->setCod_cliente(intval(filter_input(INPUT_POST, 'idcliente')));
        $venda->setForma_pagamento(filter_input(INPUT_POST, 'formapagamento'));
        $venda->setValor_factura(filter_input(INPUT_POST, 'valor_factura'));
        $venda->setDescontos(filter_input(INPUT_POST, 'desconto'));
        $venda->setValor_recebido(filter_input(INPUT_POST, 'valor_recebido'));
        $venda->setId_utilizador($idUser);
        $venda->setTroco(floatval(filter_input(INPUT_POST, 'troco')));
        $venda->setData_venda(date('m-d-Y'));
        $N_factura=date('Y').date('m').date('d').date('H.i.s');
        $venda->setN_factura($N_factura);
        $idvenda = $venda->inserir_venda(Ligar::chamar_bd());
        
        $idproduto = $_POST['codproduto'];
        $contar_prod = count($_POST['codproduto']);//erro mariano
        $quantidade = json_decode(filter_input(INPUT_POST, 'q'));
        $Subtotal = filter_input(INPUT_POST, 'total');
//       
        for ($i=0;$i<$contar_prod;$i++){
            $venda->setIdvenda($idvenda);
            $venda->setIdproduto($idproduto[$i]);
            $venda->setQtd_compra($quantidade[$i]);
            $venda->setTotal($Subtotal[$i]);
            $venda->inserir_venda_produtos(Ligar::chamar_bd());
        }
       /* 
        if ($idvenda>0){
            echo "sucesso";
        }else{
            echo "erro";
        }*/
        $a= filter_input(INPUT_POST, 'codproduto');
        echo "OU:".$idproduto[3]."+".filter_input(INPUT_POST, 'idcliente').filter_input(INPUT_POST, 'formapagamento');
        
    } catch (Exception $e) {
}



