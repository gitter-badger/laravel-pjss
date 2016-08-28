<?php 
$uid = access()->user()->id;
$uname = access()->user()->name;
$email = access()->user()->email;
$uface = access()->user()->picture;
$ulink = 'http://www.projectsaas.com/';
$expire = 3600;
$key = '7bdb432341f75b3b74e38c636f70c03a';
$desstr = file_get_contents("http://api.uyan.cc?mode=des&uid=$uid&uname=".urlencode($uname)."&email=".urlencode($email)."&uface=".urlencode($uface)."&ulink=".urlencode($ulink)."&expire=$expire&key=".urlencode($key));
setCookie('syncuyan', $desstr, time() + $expire, '/');
?>

@section ('styles')
	@parent
@stop

@section ('scripts')
	@parent
	<!-- UY SCRIPT BEGIN -->
	{{ Html::script('//v2.uyan.cc/code/uyan.js?uid=903903') }}
	<!-- UY SCRIPT END -->
@stop

<div class="row">
	<div class="col-lg-12">
		<!-- UY BEGIN -->
        <div id="uyan_frame"></div>
        <!-- UY END -->
	</div>
</div>