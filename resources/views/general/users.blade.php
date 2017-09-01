@extends('layouts.app')

@section('content')
<style>
   .glyphicon-plus{
        left: 6px;
        color: #fff;
        top: -2px;
    }
</style>
<div class="container">
    <div class="row">
        <div class="panel panel-default summary">
            <div class="panel-body">
                <div class="col-md-12">
                    <h3>Users</h3>
                    <hr/>
                    <div class="row">
                        <div class="col-md-12">
                            <button type="button" class="btn btn-info" id="addUsers">
                                Add User</button>
                            <a href="/generalSetting" class="btn btn-default">Back</a>
                            <hr/>
                            <div class="table-responsive" style="overflow-x: visible;">
                            <table class="table table-striped table-bordered" id="itable">
                                <thead>
                                    <tr>
                                        <th >#</th>
                                        <th>User Name</th>
                                        <th>Email</th>
                                        <th>Department</th>
                                        <th>Position</th>
                                        <th>Telephon</th>
                                        <th>Role</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php $x = 1;?>
                                @foreach(App\User::orderBy('id','desc')->get() as $user)
                                <?php 
                                    $arrayobj=$user->getRoleName();
                                    $arrayDept = $user->getDeptName();
                                ?>
                                    <tr>
                                        <td>{{ $x }}</td>
                                        <td>{{ $user->name }}</td>
                                        <td>{{ $user->email }}</td>
                                        <td>{{ $arrayDept[$user->dept_id] }}</td>
                                        <td>{{ $user->position }}</td>
                                        <td>{{ $user->telephone }}</td>
                                        <td>{{ $arrayobj[$user->role_id] }}</td>
                                        <td style="text-align: center;">
                                            <a href="#" class="editUser" id="edit_{{$user->id}}">Edit</a> |
                                            <a href="#" class="deleteUser" id="delete_{{$user->id}}">Delete</a>
                                        </td>
                                    </tr>
                                    <?php $x++; ?>
                                @endforeach
                                </tbody>
                            </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- add new users -->
<div class="modal fade" id="addNewUsers" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog " role="document">
        <div class="modal-content ">
            <div class="modal-header">
                <button type="button"  class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel"></h4>
            </div>
            <div class="modal-body">

            </div>
        </div>
    </div>
</div>
@endsection

@section('jquery')
    <script>
        $(function () {
            
            //submit new user
            $(document).on('submit', "#addUsersForms",function (e) {
                e.preventDefault();
                var formData = new FormData(this);
                $.ajax({
                    type: "POST",
                    processData: false,
                    contentType: false,
                    url: "/createNewUser",
                    data: formData,
                    success: function (response) {
                       $('#addNewUsers').modal('toggle');
                       window.setTimeout(function(){ document.location.reload(true); }, 100);
                    },
                    error: function () {
                        alert('SYSTEM ERROR, TRY LATER AGAIN');
                    }
                });
            });
            //show model new users
            $(document).on('click', "#addUsers",function () {
                var url = "/addUser";
                $('.modal-body').load(url,function(result){
                    $('#addNewUsers').modal({show:true});
                });
            });
            //edit user 
            $(document).on('click', ".editUser",function () {
                var get_Id=$(this).attr('id');
                var id=get_Id.substr(5,get_Id.length);
                var url = "/editUser/"+id;
                $('.modal-body').load(url,function(result){
                    $('#addNewUsers').modal({show:true});
                });
            });
            //delete user
            $(document).on('click','.deleteUser',function(){
                var get_id = $(this).attr('id');
                var id = get_id.substr(7,get_id.length);
                if(confirm("Are you sure want to delete?")==true){
                    $.ajax({
                        type: "get",
                        url: "/user/deleteUser",
                        data: {user_id:id},
                        success: function (response) {
                           if(response == 'yes'){
                                swal({
                                    title:"Delete data Success",
                                    text:"This update ready!",
                                    type:"success",  
                                    timer: 1000,   
                                    showConfirmButton: false
                                });
                                window.setTimeout(function(){ document.location.reload(true); }, 1000);
                            }
                        }
                    });
                }
            });
        });
    </script>
@endsection

