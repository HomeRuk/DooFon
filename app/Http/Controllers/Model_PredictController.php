<?php

namespace App\Http\Controllers;

use File;
use PDF;
use App\Http\Requests\ModelRequest;
use App\Model_Predict;

class Model_PredictController extends Controller {

    public function __construct() {
        $this->middleware('auth');
    }

    public function index() {
        $model = Model_Predict::paginate(10);
        return view('model_predict.index', [
            'models' => $model,
        ]); //model_predict/index.blade.php
    }

    public function create() {
        return view('model_predict.create');
    }

    public function store(ModelRequest $request) {
        ini_set('max_execution_time', 300); 
        set_time_limit(0);
        // Count time exce
        $time_start = microtime(true); 
        // Check upload 
        if (!($request->hasFile('data'))) {
            return back();
        }
        //$genfilename = time() . '_' . str_random(10);
        $genfilename = str_random(10);
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
                    . $D
                    . '-d ' . public_path() . '/weka/model/RandomForest/' . $genfilename . '.model '
                    . ' -v -i > ' . public_path() . '/weka/output/RandomForest/' . $genfilename . '.txt';
            dump($RandomForest); 
            exec($RandomForest);
        } else {
            return back();
        }
        
        $time_end = microtime(true);
        $execution_time = ($time_end - $time_start);
        // Save To DB
        $model = new Model_Predict();
        //$model->mode = $request->selMode;
        $model->modelname = $genfilename;
        $model->model = $request->selModel;
        $model->exetime = $execution_time;
        $model->save();
        $request->session()->flash('status', 'Training Success');
        
        return redirect(url('model_predict/'.$model->id));
        //return back();
        //return redirect()->action('Model_PredictController@index');
        //$execution_time_format = number_format($execution_time, 2, '.', '');
    }

    public function show($id) {
        $model = Model_Predict::find($id);
        //$model = Model_Predict::where('modelname', '=', $modelname)->get();
        $textFile = public_path() . '/weka/output/RandomForest/' . $model->modelname . '.txt';
        $text = file($textFile);
        //$text = File::get($textFile);
        return view('model_predict.show', [
            'model' => $model,
            'texts' => $text,
        ]);
    }

    public function destroy($id) {
        $modelPredict = Model_Predict::find($id);
        //$modelPredict = Model_Predict::where('modelname', '=', $modelname)->get();
        $arffFile = public_path() . '/weka/arff/train/' . $modelPredict->modelname . '.arff';
        $modelFile = public_path() . '/weka/model/RandomForest/' . $modelPredict->modelname . '.model';
        $textFile = public_path() . '/weka/output/RandomForest/' . $modelPredict->modelname . '.txt';
        File::delete($arffFile,$modelFile,$textFile);
        $modelPredict->delete();
        return redirect()->action('Model_PredictController@index');
    }
    
    // Download Data Arff
    public function downloadArff($id) {
        $model = Model_Predict::find($id);
        //$model = Model_Predict::where('modelname', '=', $modelname)->get();
        $arffFile = public_path() . '/weka/arff/train/' . $model->modelname . '.arff';
        return response()->download($arffFile);
    }
    
    // Download Prediction Model
    public function downloadModel($id) {
        $model = Model_Predict::find($id);
        //$model = Model_Predict::where('modelname', '=', $modelname)->get();
        $modelFile = public_path() . '/weka/model/RandomForest/' . $model->modelname . '.model';
        return response()->download($modelFile);
    }
    
    // Download Report TXT
    public function downloadTXT($id) {
        $model = Model_Predict::find($id);
        //$model = Model_Predict::where('modelname', '=', $modelname)->get();
        $textFile = public_path() . '/weka/output/RandomForest/' . $model->modelname . '.txt';
        return response()->download($textFile);
    }
    
    // Download Report PDF
    public function downloadPDF($id) {
        $model = Model_Predict::find($id);
        //$model = Model_Predict::where('modelname', '=', $modelname)->get();
        $textFile = public_path() . '/weka/output/RandomForest/' . $model->modelname . '.txt';
        $text = file($textFile);
        //$text = File::get($textFile);
        $pdf = PDF::loadView('model_predict.modelpdf', ['model' => $model,'texts' => $text]);
        //return $pdf->stream($model->file.'.pdf');
        return $pdf->download($model->modelname.'.pdf');
    }
    
    // Download Report PDF
    public function streamPDF($id) {
        $model = Model_Predict::find($id);
        //$model = Model_Predict::where('modelname', '=', $modelname)->get();
        $textFile = public_path() . '/weka/output/RandomForest/' . $model->modelname . '.txt';
        $text = file($textFile);
        //$text = File::get($textFile);
        $pdf = PDF::loadView('model_predict.modelpdf', ['model' => $model,'texts' => $text]);
        return $pdf->stream($model->modelname.'.pdf');
    }

}
