$(document).ready(function () {
            
            $('#to_country').click(function () {
                var from_country = $('select[name=c_from]').val();
                var to_country = $('select[name=to_country]').val();
                if(from_country == '' || from_country == 'undefined'){
                    alert('From Country Cannot be blank');
                    return false;
                }

                if(to_country =='' || to_country =='undefined'){
                    alert('To Country Cannot be blank');
                    return false;
                }

                if(from_country == to_country){
                    alert('To Country and From country cannot be Same');
                    return false;
                }

                $.ajax({
                    'url' : '/conversion-factor',
                    'type' : 'GET',
                    'data': { 
                    'from_country':from_country , 
                    'to_country':to_country
                },
                    error: function() {
                        alert('oops something went wrong');
                    },
                    'success' : function(data) {
                        if (data.status == 200) {
                            localStorage.cf = data.cf;
                        }
                    }
                });
            });

            $('#c_amount').on('input', function() {
                $('#converted-value').show();
                var cf = localStorage.getItem('cf');
                var amount = $('#c_amount').val();
                var ca = (amount/cf).toFixed(2);
                var html = '<label for="c_amount" class="col-md-4 control-label">Converted Amount</label><span id = "amount_cv">'+ca+'</span>';
                $('#converted-value').html(html);
            });


            $('.confirm-delete').click(function(){
                alert('are you sure to perform this action');
            });

        });