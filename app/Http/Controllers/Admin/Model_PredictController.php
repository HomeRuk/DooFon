<?php

namespace App\Http\Controllers\Admin;

use File;
use PDF;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\ModelRequest;
use App\Model_Predict;
use Alert;

class Model_PredictController extends Controller
{

    public function index(Request $request)
    {
        $searchModelName = $request->get('search');
        $model = Model_Predict::where('modelname', 'like', '%' . $searchModelName . '%')->orderBy('id', 'asc')->paginate(10);
        return view('admin.model_predict.index', [
            'models' => $model,
        ]); //admin/model_predict/index.blade.php
    }

    public function create()
    {
        return view('admin.model_predict.create');
    }

    public function store(ModelRequest $request)
    {
        ini_set('max_execution_time', 300);
        set_time_limit(0);

        // Check upload 
        if (!($request->hasFile('data'))) {
            return redirect()->action('Admin\Model_PredictController@index');
        }

        try {
            $genfilename = str_random(10);
            $newfilename = $genfilename . '.' . $request->file('data')->getClientOriginalExtension();
            $request->file('data')->move(public_path() . '/weka/arff/train/', $newfilename);
        } catch (\Exception $e) {
            Alert::error('อัพโหลดไฟล์ฝึกสอนล้มเหลว!', 'ผลการทำงาน')->persistent('ปิด')->autoclose(3500);
            return redirect()->action('Admin\Model_PredictController@index');
        }
        try {
            // Count time exce
            $time_start = microtime(true);
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
                return redirect()->action('Admin\Model_PredictController@index');
            }
        } catch (\Exception $e) {
            Alert::error('ประมวลผลฝึกสอนโมเดลพยากรณ์ฝนตก ล้มเหลว!', 'ผลการทำงาน')->persistent('ปิด')->autoclose(3500);
            return redirect()->action('Admin\Model_PredictController@index');
        }

        $time_end = microtime(true);
        $execution_time = ($time_end - $time_start);
        try {
            // Save To DB
            $model = new Model_Predict();
            $model->modelname = $genfilename;
            $model->model = $request->selModel;
            $model->exetime = $execution_time;
            $model->save();
        } catch (\Exception $e) {
            Alert::error('ฝึกสอนโมเดลพยากรณ์ฝนตก ผิดพลาด!', 'ผลการทำงาน')->persistent('ปิด')->autoclose(3500);
            return redirect()->action('Admin\Model_PredictController@index');
        }
        Alert::success('ฝึกสอนโมเดลพยากรณ์ฝนตก สำเร็จ !', 'ผลการทำงาน')->persistent('ปิด')->autoclose(3500);
        return redirect()->action('Admin\Model_PredictController@show', ['id' => $model->id]);
    }

    public function show($id)
    {
        $model = Model_Predict::findOrFail($id);

        $textFile = public_path() . '/weka/output/RandomForest/' . $model->modelname . '.txt';
        if (!File::exists($textFile)) {
            abort(404);
        }
        $text = file($textFile);
        //$text = File::get($textFile);
        return view('admin.model_predict.show', [
            'model' => $model,
            'texts' => $text,
        ]); //model_predict/show.blade.php
    }

    public function destroy($id)
    {
        $model = Model_Predict::findOrFail($id);
        $arffFile = public_path() . '/weka/arff/train/' . $model->modelname . '.arff';
        $modelFile = public_path() . '/weka/model/RandomForest/' . $model->modelname . '.model';
        $textFile = public_path() . '/weka/output/RandomForest/' . $model->modelname . '.txt';
        /*
         Check document in DB and realFile
        */
        // Delete File Document for Realfile
        if ($model->modelname && File::exists($arffFile) && File::exists($modelFile) && File::exists($textFile)) {
            File::delete($arffFile, $modelFile, $textFile);
        }
        // Delete File Document for DB
        try {
            $model->delete();
        } catch (\Exception $e) {
            Alert::error('ลบรายการโมเดลพยากรณ์ฝนตก ผิดพลาด !', 'ผลการทำงาน')->persistent('ปิด')->autoclose(3500);
            return redirect()->action('Admin\Model_PredictController@index');
        }

        Alert::success('ลบรายการโมเดลพยากรณ์ฝนตก สำเร็จ !', 'ผลการทำงาน')->persistent('ปิด')->autoclose(3500);
        return redirect()->action('Admin\Model_PredictController@index');
    }

    // Download Data Arff
    public function downloadArff($id)
    {
        $model = Model_Predict::findOrFail($id);
        $arffFile = public_path() . '/weka/arff/train/' . $model->modelname . '.arff';
        /*
        Check document in DB and realFile
        */
        if (empty($model->modelname) || !File::exists($arffFile)) {
            abort(404);
        }
        return response()->download($arffFile);
    }

    // Download Prediction Model
    public function downloadModel($id)
    {
        $model = Model_Predict::findOrFail($id);
        $modelFile = public_path() . '/weka/model/RandomForest/' . $model->modelname . '.model';
        /*
         Check document in DB and realFile
        */
        if (empty($model->modelname) || !File::exists($modelFile)) {
            abort(404);
        }
        return response()->download($modelFile);
    }

    // Download Report TXT
    public function downloadTXT($id)
    {
        $model = Model_Predict::find($id);
        $textFile = public_path() . '/weka/output/RandomForest/' . $model->modelname . '.txt';
        /*
         Check document in DB and realFile
        */
        if (empty($model->modelname) || !File::exists($textFile)) {
            abort(404);
        }
        return response()->download($textFile);
    }

    // Download Report PDF
    public function downloadPDF($id)
    {
        $model = Model_Predict::findOrFail($id);
        $textFile = public_path() . '/weka/output/RandomForest/' . $model->modelname . '.txt';
        /*
           Check document in DB and realFile
        */
        if (empty($model->modelname) || !File::exists($textFile)) {
            abort(404);
        }
        $text = file($textFile);
        //$text = File::get($textFile);
        $pdf = PDF::loadView('admin.model_predict.modelpdf', ['model' => $model, 'texts' => $text]);
        return $pdf->download($model->modelname . '.pdf');
    }

    // Download Report PDF
    public function streamPDF($id)
    {
        $model = Model_Predict::findOrFail($id);
        $textFile = public_path() . '/weka/output/RandomForest/' . $model->modelname . '.txt';
        /*
           Check document in DB and realFile
        */
        if (empty($model->modelname) || !File::exists($textFile)) {
            abort(404);
        }
        $text = file($textFile);
        //$text = File::get($textFile);
        $pdf = PDF::loadView('admin.model_predict.modelpdf', ['model' => $model, 'texts' => $text]);
        return $pdf->stream($model->modelname . '.pdf');
    }

}
