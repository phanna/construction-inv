<nav class="navbar navbar-default navbar-static-top">
    <div class="container">
    <div class="navbar-header">
      <button class="navbar-toggle" type="button" data-toggle="collapse" data-target=".js-navbar-collapse">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
        <a class="navbar-brand" href="{{ url('/') }}">
            MWGROUP 
        </a>
    </div>


    <div class="collapse navbar-collapse js-navbar-collapse">
        <ul class="nav navbar-nav">
      	@if( Auth::check() )
       	    <?php  $dataPermission=Auth::user()->permission; 
    	  		$dataStr=substr($dataPermission,0,-1);
    			$arrDataPermission=(explode(",",$dataStr));
		      // print_r($arrDataPermission);
		    ?>
            @foreach(App\Tbl_menuses::where('status','0')->get() as $parents)
            <?php if(in_array($parents->id,$arrDataPermission)) {?>
                <li class="dropdown">
                	<a href="{{ $parents->link }}"  {!! ($parents->subMenus->count())?'href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"':'' !!}>
                		{{ strtoupper($parents->name) }} <span class="{{ ($parents->subMenus->count())?'caret':'' }}"></span>
                    </a>
                	<ul class="dropdown-menu">
                 	@if($parents->subMenus->count())
						@foreach($parents->subMenus as $obj)
                       		<?php 
								$subID=$parents->id.$obj->id;									
								if(in_array($subID,$arrDataPermission)){?>
                        		<li><a href="{{ $obj->url }}">{{ $obj->sub_name }}</a></li>
                        	<?php } ?>
                        @endforeach
                	@endif
                    </ul>
                </li>
                <?php } ?>
               
            @endforeach
        @endif
        		 <li><a href="{{ url('/meeting') }}">MEETING </a></li>
        </ul>
        <!-- Right Side Of Navbar -->
        <ul class="nav navbar-nav navbar-right">
           
            <!-- Authentication Links -->
            @if (Auth::guest())
                <li><a href="{{ url('/login') }}">Login</a></li>
            @else
                <?php if(Auth::user()->role_id==1){?> 
                    
                <?php }?>
               <?php /*?> <li><a href="{{ url('/reports') }}">Reports </a></li><?php */?>
               
                <li><a href="{{ url('/generalSetting') }}">Setting </a></li>
                
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                        {{ Auth::user()->name }} <span class="caret"></span>
                    </a>
                    <ul class="dropdown-menu" role="menu">
                        <li>
                            <a href="#" id="changePass"><i class="fa fa-btn fa-lock"></i>
                                Change Password
                            </a>
                        </li>
                        <li>
                            <a href="{{ url('/logout') }}"><i class="fa fa-btn fa-sign-out"></i>Logout</a>
                        </li>
                    </ul>
                </li>
            @endif
        </ul>
    </div>
    <!-- /.nav-collapse -->
</div>
</nav>
<div class="container-fluid">
	<div class="row sub_menu">
    	<div class="container">
        	<h4 class="company-name" style="padding-top: 6px;"><strong><span style="color: teal">1Residence Inventory</span></strong> </h4>
        </div>
    </div>
</div>
<div class="container">
               
</div>

