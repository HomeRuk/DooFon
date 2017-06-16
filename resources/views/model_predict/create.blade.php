@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-6 col-md-offset-3">
            <div class="panel panel-custom-horrible-blue">
                <div class="panel-heading"><h4>Create Model Weather</h4></div>      
                <div class="panel-body">
                    @if (count($errors) > 0)
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif
                    <form class="form-horizontal" role="form" method="POST" action="{{ url('model_predict') }}" accept-charset="UTF-8" enctype="multipart/form-data" onsubmit="return validate();">
                        {{ csrf_field() }}
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="data">Upload file : Support file (arff)</label>
                                <input class="form-control input-lg" type="file" id="data" name="data" required autofocus >
                            </div>
                        </div>
                        
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="sel0">Mode : (2Hour) </label>
                                <select class="form-control input-lg" id="selMode" name="selMode" >
                                    <!--<option value="1" selected>1 Hour</option>-->
                                    <option value="2">2 Hour</option>
                                </select>
                            </div>
                        </div>
                        
                        <div class="col-md-12">
                            <a href="../../../app/Http/Controllers/Model_PredictController.php"></a>
                            <div class="form-group">
                                <label for="sel1">Model :</label>
                                <select class="form-control input-lg" id="selModel" name="selModel" >
                                    <option value="0" selected>--- Please Select Model ---</option>
                                    <option value="RandomForest">RandomForest</option>
                                </select>
                            </div>
                        </div>
                        <div id="option">

                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <input class="btn btn-lg btn-primary btn-block" type="submit" value="Predict">
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('footer')
<script>
    function validate()
    {
        var sel = document.getElementById("selModel");
        var selectedValue = sel.options[sel.selectedIndex].value;
        if (selectedValue === "0") {
            swal({
                title: 'Error',
                text: 'Please select a Model',
                type: 'error',
                timer: 2000
            });
            return false;
        }
    }
</script>
<script>
    $(document).ready(function () {
        $('#selModel').change(function () {
            if ($(this).val() === '0') {
                $('#option').html('');
            } else if ($(this).val() === 'RandomForest') {
                $('#option').html('<div class="col-md-12">\n\
                                        <div class="form-group" >\n\
                                            <label for="sel1">Debug :</label>\n\
                                                <select class="form-control input-lg" id="debug" name="debug">\n\
                                                    <option value=" ">FALSE</option>\n\
                                                    <option value="-D">TRUE</option>\n\
                                                </select>\n\
                                        </div>\n\
                                   </div>\n\
                                  <div class="col-md-12">\n\
                                        <div class="form-group" >\n\
                                            <label for="maxDepth">maxDepth</label>\n\
                                                <input class="form-control input-lg" type="number" min="0" step="1" value="0" name="maxDepth" id="maxDepth" required="required" >\n\
                                        </div>\n\
                                  </div>\n\
                                  <div class="col-md-12">\n\
                                        <div class="form-group" >\n\
                                            <label for="numFeatures">numFeatures</label>\n\
                                                <input class="form-control input-lg" type="text" value="0" name="numFeatures" id="numFeatures" required="required" >\n\
                                        </div>\n\
                                  </div>\n\
                                  <div class="col-md-12">\n\
                                        <div class="form-group" >\n\
                                            <label for="numTrees">numTrees</label>\n\
                                                <input class="form-control input-lg" type="number" min="0" step="1" value="10" name="numTrees" id="numTrees" required="required" >\n\
                                        </div>\n\
                                  </div>\n\
                                  <div class="col-md-12">\n\
                                        <div class="form-group" >\n\
                                            <label for="seed">seed</label>\n\
                                                <input class="form-control input-lg" type="text" value="1" name="seed" id="seed" required="required" >\n\
                                        </div>\n\
                                  </div>\n\
                                 ');
            } else if ($(this).val() === 'J48') {
                $('#option').html('');
            }
        });
    });
</script>   


@if (session()->has('status')) 

<script>
    swal({
        title: '{{ session()->get('status') }}',
        text: 'Save success',
        type: 'success',
        timer: 2000
    });
</script>

@endif
@if (count($errors) > 0)

<script>
    swal({
        title: 'Error',
        text: 'Please Check Data',
        type: 'error',
        timer: 2000
    });
</script>

@endif

@endsection
