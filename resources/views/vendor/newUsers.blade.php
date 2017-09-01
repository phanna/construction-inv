<style>
    .alert { margin:0px; padding:15px 15px 0px;}
</style>
<div class="alert alert-info"><h4 align="center">Enter Staff info:</h4></div>
<div class="panel panel-default" style="border:none; padding:0px 0px;">
    <div class="panel-body" >
        <form class="form-horizontal" id="addUsersForms" method="POST">
            {{ csrf_field() }}
            <input type="hidden" id="userID" name="userID" value="{{ isset($selectEditUser[0])?$selectEditUser[0]->id:''}}">
            <div class="form-group">
                <label for="name" class="col-md-4 control-label">Name</label>
                <div class="col-md-6">
                    <input id="name" type="text" class="form-control" name="name" value="{{ isset($selectEditUser[0])?$selectEditUser[0]->name:''}}" required>
                </div>
            </div>

            <div class="form-group">
                <label class="col-md-4 control-label">E-Mail Address</label>
                <div class="col-md-6">
                    <input id="email" type="email" class="form-control" placeholder="abc@gmail.com" name="email" value="{{ isset($selectEditUser[0])?$selectEditUser[0]->email:''}}" required>
                    <label for="email"></label>
                </div>
            </div>
            <div class="form-group">
                <label for="position" class="col-md-4 control-label" >Position</label>
                <div class="col-md-6">
                    <input id="position" type="text" class="form-control" name="position" value="{{ isset($selectEditUser[0])?$selectEditUser[0]->position:''}}">
                </div>
            </div>
            <div class="form-group">
                <label for="position" class="col-md-4 control-label" >Telephone</label>
                <div class="col-md-6">
                    <input id="telephone" type="number" class="form-control" name="telephone" value="{{ isset($selectEditUser[0])?$selectEditUser[0]->telephone:''}}">
                </div>
            </div>
            <div class="form-group">
                <label class="col-md-4 control-label">Select Department</label>
                <div class="col-md-6">
                    <select name="dept_id" class="form-control" required>
                        <option value="">--Select--</option>
                        @foreach($department as $dept)
                            <option value="{{ $dept->id}}" 
                            @if(isset($selectEditUser[0]))
                                @if($selectEditUser[0]->dept_id==$dept->id)
                                    selected
                                @endif
                            @endif
                            >
                                {{ $dept->department_name }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="form-group">
                <label class="col-md-4 control-label">Select Role</label>
                <div class="col-md-6">
                    <select name="role" class="form-control" required>
                        <option value="">--Select--</option>
                        @foreach($role as $r)
                            <option value="{{ $r->id}}" 
                            @if(isset($selectEditUser[0]))
                                @if($selectEditUser[0]->role_id==$r->id)
                                    selected
                                @endif
                            @endif
                            >{{ $r->role_name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            @if(!isset($selectEditUser))
                <div class="form-group">
                    <label for="password" class="col-md-4 control-label">Password</label>
                    <div class="col-md-6">
                        <input id="password" type="password" class="form-control" name="password">
                    </div>
                </div>
            @endif
            <div class="form-group">
                <div class="col-md-6 col-md-offset-4">
                    <button type="submit" class="btn btn-primary" id="tbnSubmitNewUser">
                        <i class="fa fa-btn fa-user"></i> Submit
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
<script>
    $(function(){
        var validator = $("form#addUsersForms").validate({
                ignore: [],
                framework: 'bootstrap',
                errorPlacement: function(error, element) {
                    // Append error within linked label
                    $( element )
                    .closest( "form" )
                    .find( "label[for='" + element.attr( "id" ) + "']" )
                    .append( error );
                },
                errorElement: "span",
                rules: {
                    name: {
                        required: true,
                    },
                    email:{
                        required: true,
                        remote: {
                            url: "/user/emailExist",
                            type: "get",
                            data: {
                                  checkEmail: function() {
                                    return $( "#email" ).val();
                                  },
                                  userid: function() {
                                    return $( "#userID" ).val();
                                  }
                                }
                            
                        }
                    },
                    password:{
                        required: true,
                    },
                    role:{
                        required:true,
                    }
                },
                messages: {
                    name: {
                        required: "(Required)",
                    },
                    email: {
                        required: "(Required)",
                        remote: "(Email already exist)"
                    },
                    password: {
                        required: "(Required)",
                    },
                    role: {
                        required: "(Required)",
                    }
                }
            });
    });
</script>