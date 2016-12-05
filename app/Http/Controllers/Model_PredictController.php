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
        // Check upload 
        if (!($request->hasFile('data'))) {
            return back();
        }
        $genfilename = time() . '_' . str_random(10);
        $newfilename = $genfilename . '.' . $request->file('data')->getClientOriginalExtension();
        $request->file('data')->move(public_path() . '/weka/arff/test/', $newfilename);

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
                    . public_path() . '/weka/arff/test/' . $genfilename . '.arff'
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

        $model = new Model_Predict();
        $model->modelname = $request->selModel;
        $model->file = $genfilename;
        $model->save();
        $request->session()->flash('status', 'Training Success');
        //return back();
        //return redirect()->action('Model_PredictController@index');
        return redirect(url('model_predict/'.$model->id));
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
        $arffFile = public_path() . '\\weka\\arff\\test\\' . $modelPredict->file . '.arff';
        $modelFile = public_path() . '\\weka\\model\\RandomForest\\' . $modelPredict->file . '.model';
        $textFile = public_path() . '\\weka\\output\\RandomForest\\' . $modelPredict->file . '.txt';
        File::delete($arffFile,$modelFile,$textFile);
        $modelPredict->delete();
        return redirect()->action('Model_PredictController@index');
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
