<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Admin Dashboard') }}
        </h2>
    </x-slot>

   {{--  <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    You're logged in!

                </div>
            </div>
        </div>
    </div> --}}
    
    <div class="container py-2">
        <div class="row">
            <div class="col-md-12 py-2">
                <button class="btn btn-danger float-right" type="button" id="resetAllWinners">
                    Reset All Winners
                </button>        
            </div>
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header lead">Lucky Draw</div>
                    <div class="card-body">
                        <form action="{{ url('draw') }}" method="post" id="draw_form">
                            @csrf
                            <div class="form-group">
                                <label for="prizeType">Prize Types <i class="text-danger">*</i></label>
                                <select class="form-control" id="prizeType" name="prizeType">
                                    <option selected disabled>Please Select</option>
                                    <option value="third prize 1">Third Prize - 1st Winner</option>
                                    <option value="third prize 2">Third Prize - 2nd Winner</option>
                                    <option value="third prize 3">Third Prize - 3rd Winner</option>
                                    <option value="second prize 1">Second Prize - 1st Winner</option>
                                    <option value="second prize 2">Second Prize - 2nd Winner</option>
                                    <option value="first prize">First Prize</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="generateRandomly">Generate Randomly:</label>
                                <select class="form-control" id="generateRandomly" name="generateRandomly" onchange="onChangeGenerateRandomly(this.value)">
                                    <option selected disabled>Please Select</option>
                                    <option value="yes">Yes</option>
                                    <option value="no">No</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="winningNumber">Winner Number</label>
                                <input disabled type="number" class="form-control remove-arrow" id="winningNumber" name="winningNumber" autocomplete="off">
                            </div>
                            <button type="submit" class="btn btn-primary">Draw</button>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header lead">
                        Lucky Draw Winners
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <label for="thirdPrize">Third Prize Winners</label>
                            <div class="bg-light border rounded px-3 py-1" id="thirdPrizeWinners">
                                <div class="thirdprize1"></div>
                                <div class="thirdprize2"></div>
                                <div class="thirdprize3"></div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="secondPrize">Second Prize Winners</label>
                            <div class="bg-light border rounded px-3 py-1" id="secondPrizeWinners">
                                <div class="secondprize1"></div>
                                <div class="secondprize2"></div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="firstPrize">First Prize Winner</label>
                            <div class="bg-light border rounded px-3 py-1" id="firstPrizeWinner">
                                <div class="firstprize"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // arrow function es6
        // let c_prize_type = prize_type.replace(/\b\w/g, c => c.toUpperCase());
        window.onload = function(){
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                url: '{!! url('/onLoad') !!}',
                method: 'post',
                dataType: 'json',
                success: function(res){
                    const len = res.length;

                    for(let a = 0; a < len; a++){
                        let prize_type = res[a].prize_type;
                        let c_prize_type = prize_type.replace(/\b\w/g, function(c){
                            return c.toUpperCase();
                        });
                      
                        let trim_prize_type = prize_type.replace(/\s+/g, '').trim();

                        $('.'+trim_prize_type).html(
                            `
                            <div class="form-inline">
                            <h6 class="text-primary">
                                ${res[a].user} - won the ${c_prize_type}
                            </h6>
                            </div>
                            `
                        );
                    }
                },
                error: function(res){
                    console.log(res);
                }
            })
        }

        function onChangeGenerateRandomly(value){
           if(value == 'yes'){
            $('#winningNumber').attr('disabled', 'disabled').val('');            
           } else {
            $('#winningNumber').removeAttr('disabled');            
           }
        }

        function loadData(data){
            const id = data.member_id;

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                url: `{!! url('/loadData') !!}/${id}`,
                method: 'post',
                dataType: 'json',
                success: function(res){
                    let prize_type = res.prize_type;
                    let c_prize_type = prize_type.replace(/\b\w/g, function(c){
                            return c.toUpperCase();
                        });
                    let trim_prize_type = prize_type.replace(/\s+/g, '').trim();

                    $('.'+trim_prize_type).html(
                        `<h6 class="text-primary">
                            ${res.user} - won the ${c_prize_type}
                        </h6>`
                    );
                },
                error:function(res){
                    console.log(res);
                }
            })
        }

        $(function(){
            $(document).on('click', '#resetAllWinners', function(e){
                Swal.fire({
                    icon: 'warning',
                    title: 'All winners will be reset.',
                    text: 'Do you wish to proceed?',
                    showCancelButton: true,
                    confirmButtonText: 'Reset',
                    confirmButtonColor: '#d33',
                }).then((result) => {
                    if(result.isConfirmed){
                        $.ajaxSetup({
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            }
                        });
                        $.ajax({
                            url: '{!! url('/resetAllWinners') !!}',
                            method: 'post',
                            success: function(res){
                                console.log(res);
                                Swal.fire({
                                    position: 'top-end',
                                    icon: res,
                                    title: 'Success',
                                    text: 'All winners have been reset.',
                                    showConfirmButton: false,
                                    timer: 1500,
                                }).then((result) => {
                                   if(result){
                                        window.location.assign(`{!! ('/dashboard') !!}`);
                                    } 
                                });
                            },
                            error: function(res){
                                console.log(res);
                            }
                        })                
                    }
                });
            });

            $(document).on('submit', '#draw_form', function(e){
                e.preventDefault();
                const form = $(this).serialize();                 

                $.ajaxSetup({
                    headers: {
                        // 'X-CSRF-TOKEN': CSRF_TOKEN
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                $.ajax({
                    url: this.action,
                    method: 'POST',
                    data: form,
                    dataType: 'json',
                    success:function(res){
                        Swal.fire('Congratulations!', `Winner number is '${res.winning_number}'`, 'success');
                        loadData(res);
                    },
                    error:function(res){
                        console.log(res);
                        const errors = res.responseJSON.errors;

                        let eKey = '';
                        let err = '';

                        for(let key of Object.keys(errors)){
                            if(!eKey && !err){
                                eKey += errors[key];
                                err += key;
                            } else {
                                eKey += '<br>' + errors[key];
                                err += '<br>' + key;
                            }
                        }
                        Swal.fire('An error occured', eKey , 'error');
                    }
                })
            })
        })
    </script>

</x-app-layout>
