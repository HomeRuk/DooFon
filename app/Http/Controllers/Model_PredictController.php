<?php

namespace App\Http\Controllers;

use File;
use PDF;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Requests\ModelRequest;
use App\Model_Predict;

class Model_PredictController extends Controller {

    public function __construct() {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        $count = Model_Predict::count();
        $model = Model_Predict::paginate(10);
        return view('model_predict.index', [
            'models' => $model,
        ]); //model_predict/index.blade.php
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        return view('model_predict.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ModelRequest $request) {
        ini_set('max_execution_time', 300); 
        set_time_limit(0);
        // Count time exce
        $time_start = microtime(true); 
        // Check upload 
        if (!($request->hasFile('data'))) {
            return back();
        }
        $genfilename = time() . '_' . str_random(10);
        $newfilename = $genfilename . '.' . $request->file('data')->getClientOriginalExtension();
        $request->file('data')->move(public_path() . '/weka/arff/train/', $newfilename);

        // Train RandomForest
        $model = $request->selModel;
        $I = $request->numTrees;
        $K = $request->numFeatures;
        $S = $request->seed;
        $depth = $request->maxDepth;
        $D = $request->debug;
        if ($model === "RandomForest") {
            $RandomForest = 'java -cp '
                    . public_path() . '/weka/weka.jar weka.classifiers.trees.RandomForest -t '
                    . public_path() . '/weka/arff/train/' . $genfilename . '.arff'
                    . ' -I ' . $I
                    . ' -K ' . $K
                    . ' -S ' . $S
                    . ' -depth ' . $depth
                    . ' ' . $D
                    . ' -d ' . public_path() . '/weka/model/RandomForest/' . $genfilename . '.model '
                    . ' -v -i> ' . public_path() . '/weka/output/RandomForest/' . $genfilename . '.txt';
            //dump($RandomForest); 
            exec($RandomForest);
        } else {
            return back();
        }
        $time_end = microtime(true);
        $execution_time = ($time_end - $time_start);
        // Save To DB
        $model = new Model_Predict();
        $model->mode = $request->selMode;
        $model->file = $genfilename;
        $model->modelname = $request->selModel;
        $model->exetime = $execution_time;
        $model->save();
        $request->session()->flash('status', 'Training Success');
        
        return redirect(url('model_predict/'.$model->id));
        //return back();
        //return redirect()->action('Model_PredictController@index');
        //$execution_time_format = number_format($execution_time, 2, '.', '');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id) {
        $model = Model_Predict::find($id);
        $textFile = public_path() . '\\weka\\output\\RandomForest\\' . $model->file . '.txt';
        $text = file($textFile);
        //$text = File::get($textFile);
        return view('model_predict.detail', [
            'model' => $model,
            'texts' => $text,
        ]);
    }
    
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) {
        $modelPredict = Model_Predict::find($id);
        $arffFile = public_path() . '\\weka\\arff\\train\\' . $modelPredict->file . '.arff';
        $modelFile = public_path() . '\\weka\\model\\RandomForest\\' . $modelPredict->file . '.model';
        $textFile = public_path() . '\\weka\\output\\RandomForest\\' . $modelPredict->file . '.txt';
        File::delete($arffFile,$modelFile,$textFile);
        $modelPredict->delete();
        return redirect()->action('Model_PredictController@index');
    }
    
    // Download Data Arff
    public function downloadArff($id) {
        $model = Model_Predict::find($id);
        $arffFile = public_path() . '\\weka\\arff\\train\\' . $model->file . '.arff';
        return response()->download($arffFile);
    }
    
    // Download Prediction Model
    public function downloadModel($id) {
        $model = Model_Predict::find($id);
        $modelFile = public_path() . '\\weka\\model\\RandomForest\\' . $model->file . '.model';
        return response()->download($modelFile);
    }
    
    // Download Report TXT
    public function downloadTXT($id) {
        $model = Model_Predict::find($id);
        $textFile = public_path() . '\\weka\\output\\RandomForest\\' . $model->file . '.txt';
        return response()->download($textFile);
    }
    
    // Download Report PDF
    public function downloadPDF($id) {
        $model = Model_Predict::find($id);
        $textFile = public_path() . '\\weka\\output\\RandomForest\\' . $model->file . '.txt';
        $text = file($textFile);
        //$text = File::get($textFile);
        $pdf = PDF::loadView('model_predict.modelpdf', ['model' => $model,'texts' => $text]);
        //return $pdf->stream($model->file.'.pdf');
        return $pdf->download($model->file.'.pdf');
    }
    
    // Download Report PDF
    public function streamPDF($id) {
        $model = Model_Predict::find($id);
        $textFile = public_path() . '\\weka\\output\\RandomForest\\' . $model->file . '.txt';
        $text = file($textFile);
        //$text = File::get($textFile);
        $pdf = PDF::loadView('model_predict.modelpdf', ['model' => $model,'texts' => $text]);
        return $pdf->stream($model->file.'.pdf');
    }
    
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    /*
    public function edit($id) {
        //
    }
     */

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    /*
    public function update(Request $request, $id) {
        //
    }
    */
}
