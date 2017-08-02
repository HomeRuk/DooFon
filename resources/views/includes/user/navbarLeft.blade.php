@if(Request::url() === url('/user/map/'))
    <li class="active"><a href="{{ url('/user/map') }}"><i class="fa fa-btn fa-map-marker"></i>แผนที่</a></li>
    <li><a href="{{ url('/user/devices/') }}"><i class="fa fa-btn fa-mobile"></i>รายการอุปกรณ์IoT</a></li>
    <li><a href="{{ url('/user/profile/') }}"><i class="fa fa-btn fa-user"></i>ข้อมูลส่วนตัว</a></li>
@elseif(Request::url() === url('/user/devices/'))
    <li><a href="{{ url('/user/map') }}"><i class="fa fa-btn fa-map-marker"></i>แผนที่</a></li>
    <li class="active"><a href="{{ url('/user/devices/') }}"><i class="fa fa-btn fa-mobile"></i>รายการอุปกรณ์IoT</a></li>
    <li><a href="{{ url('/user/profile/') }}"><i class="fa fa-btn fa-user"></i>ข้อมูลส่วนตัว</a></li>
@elseif(Request::url() === url('/user/profile/'))
    <li><a href="{{ url('/user/map') }}"><i class="fa fa-btn fa-map-marker"></i>แผนที่</a></li>
    <li><a href="{{ url('/user/devices/') }}"><i class="fa fa-btn fa-mobile"></i>รายการอุปกรณ์IoT</a></li>
    <li class="active"><a href="{{ url('/user/profile/') }}"><i class="fa fa-btn fa-user"></i>ข้อมูลส่วนตัว</a></li>
@else
    <li><a href="{{ url('/user/map') }}"><i class="fa fa-btn fa-map-marker"></i>แผนที่</a></li>
    <li><a href="{{ url('/user/devices/') }}"><i class="fa fa-btn fa-mobile"></i>รายการอุปกรณ์IoT</a></li>
    <li><a href="{{ url('/user/profile/') }}"><i class="fa fa-btn fa-user"></i>ข้อมูลส่วนตัว</a></li>
@endif