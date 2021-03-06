<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of OrdenEsMs
 *
 * @author Arellano
 */
class OrdenEsMController extends BaseController{
	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
    
	public function getIndex()
	{
            $ordern_es_ms = array();
            $ordern_es_ms = OrdenEsM::indexAllForViewLayout();
            return View::make('OrdenesMTemplate',['ordern_es_ms' => $ordern_es_ms]);
	}
        
        public function getIndexData()
        {
            $ordern_es_ms = array();
            $ordern_es_ms = OrdenEsM::all();
            return Response::json($ordern_es_ms);
        }
        
	/**
	 *fet
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
            echo "hola";
	}       
        
        public function showread()
        {   
            $step = 'start';
            return View::make('PortalTemplate',['step' => $step]);
        }        
        
        public function writeJsonFolio()
        {
            $ordenM = OrdenEsD::UPCFolioNotEnd();       
            $data_to_file_json = json_encode($ordenM);
            $fp = fopen("/home/developer/Projects/RFID/laravel/public/readsupcs.json","w+"); 
            if($fp == false) { 
               die("No se ha podido crear el archivo."); 
            }else{
                fwrite($fp, $data_to_file_json);
            }            
        }
        
        public function writeJsonTags()
        {       
            $ordenM = json_encode(Input::get('orden_es_ds'));       
            $fp = fopen("/home/developer/Projects/RFID/laravel/public/readsupcs.json","w+"); 
            if($fp == false) { 
               die("No se ha podido crear el archivo."); 
            }else{
                fwrite($fp, $ordenM);
            }
        }       
        
	/**
	*post
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{                     
            $idPending = OrdenEsM::idPending();           
            $handheld = isset($input['handheld']) ? (int) $input['handheld'] : 0;
            if($idPending == -1 || $handheld == 1){
                $input = Input::All();
                $ordenM = new OrdenEsM();                     
                //$ordenM->customer_id = Auth::user()->customer_id;
                $ordenM->customer_id = $input['customer_id'];
                $ordenM->warehouse_id = $input['warehouse_id'];
                $ordenM->folio = $input['folio'];
                $ordenM->type = $input['type'];
                $ordenM->pending = $input['pending'];
                $ordenM->created_at = $input['created_at'];
                $ordenM->updated_at = $input['updated_at'];
                $ordenM->save();
                return "yes save";
            }
            return "no save";       
	}

	public function storeHandheld()
	{         
            $input = Input::All();
            $ordenM = new OrdenEsM();                     
            $ordenM->customer_id = $input['customer_id'];
            $ordenM->warehouse_id = $input['warehouse_id'];
            $ordenM->folio = $input['folio'];
            $ordenM->type = $input['type'];
            $ordenM->pending = $input['pending'];
            $ordenM->created_at = $input['created_at'];
            $ordenM->updated_at = $input['updated_at'];
            $ordenM->save();
            return "yes save";      
	}        
        
	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
            $orden_es_ds = OrdenEsM::where('orden_es_m_id',$id)->get();
            return Response::Json($orden_es_ds);
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{		

	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{

	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{

	}
}
