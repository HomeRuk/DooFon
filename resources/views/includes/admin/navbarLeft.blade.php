@if(Request::url() === url('/admin/map'))
    <li class="active"><a href="{{ url('/admin/map') }}"><i class="fa fa-map-marker"></i> แผนที่</a></li>
    <li><a href="{{ url('/admin/devices/') }}"><i class="fa fa-mobile"></i> รายการอุปกรณ์IoT</a></li>
    <li><a href="{{ url('/admin/model_predicts') }}"><i class="fa fa-database"></i> โมเดลพยากรณ์</a></li>
    <li><a href="{{ url('/admin/report') }}"><i class="fa fa-cloud"></i> รายงานสภาพอากาศ</a></li>
    <li><a href="{{ url('/admin/AccountManagement') }}"><i class="fa fa-cloud"></i> จัดบัญชีผู้ใช้</a></li>
@elseif(Request::url() === url('/admin/devices/'))
    <li><a href="{{ url('/admin/map') }}"><i class="fa fa-map-marker"></i> แผนที่</a></li>
    <li class="active"><a href="{{ url('/admin/devices/') }}"><i class="fa fa-mobile"></i> รายการอุปกรณ์IoT</a></li>
    <li><a href="{{ url('/admin/model_predicts') }}"><i class="fa fa-database"></i> โมเดลพยากรณ์</a></li>
    <li><a href="{{ url('/admin/report') }}"><i class="fa fa-cloud"></i> รายงานสภาพอากาศ</a></li>
    <li><a href="{{ url('/admin/AccountManagement') }}"><i class="fa fa-users"></i> จัดบัญชีผู้ใช้</a></li>
@elseif(Request::url() === url('/admin/model_predicts'))
    <li><a href="{{ url('/admin/map') }}"><i class="fa fa-map-marker"></i> แผนที่</a></li>
    <li><a href="{{ url('/admin/devices/') }}"><i class="fa fa-mobile"></i> รายการอุปกรณ์IoT</a></li>
    <li class="active"><a href="{{ url('/admin/model_predicts') }}"><i class="fa fa-database"></i> โมเดลพยากรณ์</a></li>
    <li><a href="{{ url('/admin/report') }}"><i class="fa fa-cloud"></i> รายงานสภาพอากาศ</a></li>
    <li><a href="{{ url('/admin/AccountManagement') }}"><i class="fa fa-users"></i> จัดบัญชีผู้ใช้</a></li>
@elseif(Request::url() === url('/admin/report'))
    <li><a href="{{ url('/admin/map') }}"><i class="fa fa-map-marker"></i> แผนที่</a></li>
    <li><a href="{{ url('/admin/devices/') }}"><i class="fa fa-mobile"></i> รายการอุปกรณ์IoT</a></li>
    <li><a href="{{ url('/admin/model_predicts') }}"><i class="fa fa-database"></i> โมเดลพยากรณ์</a></li>
    <li class="active"><a href="{{ url('/admin/report') }}"><i class="fa fa-cloud"></i> รายงานสภาพอากาศ</a></li>
    <li><a href="{{ url('/admin/AccountManagement') }}"><i class="fa fa-users"></i> จัดบัญชีผู้ใช้</a></li>
@elseif(Request::url() === url('/admin/report'))
    <li><a href="{{ url('/admin/map') }}"><i class="fa fa-map-marker"></i> แผนที่</a></li>
    <li><a href="{{ url('/admin/devices/') }}"><i class="fa fa-mobile"></i> รายการอุปกรณ์IoT</a></li>
    <li><a href="{{ url('/admin/model_predicts') }}"><i class="fa fa-database"></i> โมเดลพยากรณ์</a></li>
    <li><a href="{{ url('/admin/report') }}"><i class="fa fa-users"></i> รายงานสภาพอากาศ</a></li>
    <li class="active"><a href="{{ url('/admin/AccountManagement') }}"><i class="fa fa-cloud"></i> จัดบัญชีผู้ใช้</a></li>
@else
    <li><a href="{{ url('/admin/map') }}"><i class="fa fa-map-marker"></i> แผนที่</a></li>
    <li><a href="{{ url('/admin/devices/') }}"><i class="fa fa-mobile"></i> รายการอุปกรณ์IoT</a></li>
    <li><a href="{{ url('/admin/model_predicts') }}"><i class="fa fa-database"></i> โมเดลพยากรณ์</a></li>
    <li><a href="{{ url('/admin/report') }}"><i class="fa fa-cloud"></i> รายงานสภาพอากาศ</a></li>
    <li><a href="{{ url('/admin/AccountManagement') }}"><i class="fa fa-users"></i> จัดบัญชีผู้ใช้</a></li>
@endif