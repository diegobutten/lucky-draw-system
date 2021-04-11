@if($modal != 'create')
    <form method="post" action="{{ url('/addLuckyNumber') }}" class="add_lucky_number">
        @csrf
        <div class="modal" id="myModal{{ $member->id }}">
            <div class="modal-dialog">
                <div class="modal-content">

                    <!-- Modal Header -->
                    <div class="modal-header">
                        <h4 class="modal-title">User - {{ $member->user }}</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>

                    <!-- Modal body -->
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Input Lucky Number:</label>
                            <input type="text" name="winning_number" autocomplete="off" class="form-control input_wn{{ $member->id }}">
                        </div>
                        <input type="hidden" name="member_id" value="{{ $member->id }}">
                    </div>

                    <!-- Modal footer -->
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success">Submit</button>
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                    </div>

                </div>
            </div>
        </div>
    </form>

    <script>
        $("#myModal"+{!! $member->id !!}).on('shown.bs.modal',function() {
            $(".input_wn"+{!! $member->id !!}).focus();
        });
        $("#myModal"+{!! $member->id !!}).on('hidden.bs.modal',function() {
            $(".input_wn"+{!! $member->id !!}).val('');
        });
    </script>
@else
    <form method="post" action="{{ url('/addNewUser') }}" class="add_new_user">
        @csrf
        <div class="modal" id="myModal">
            <div class="modal-dialog">
                <div class="modal-content">

                    <!-- Modal Header -->
                    <div class="modal-header">
                        <h4 class="modal-title">Add New User</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>

                    <!-- Modal body -->
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Input User:</label>
                            <input type="text" name="user" autocomplete="off" class="form-control input_wn">
                        </div>
                        <div class="form-group">
                            <label>Input Lucky Number:</label>
                            <input type="text" name="winning_number" autocomplete="off" class="form-control">
                        </div>
                        <input type="hidden" name="member_id" value="">
                    </div>

                    <!-- Modal footer -->
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success">Submit</button>
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                    </div>

                </div>
            </div>
        </div>
    </form>        

    <script>
                
    </script>
@endif