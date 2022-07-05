$(document).ready(function(){
    // $("#sort").on('change',function(){
    //     document.getElementById("shortproduct").submit();
    // });
    $('#requiresize').hide();

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $("#sort").on('change',function(){
        var sort = $(this).val();
        var url = $("#url").val();
        $.ajax({
            url:url,
            method:"post",
            data:{sort:sort,url:url},
            success:function(data){
                $('.filter_products').html(data);
            }
        });
    });

    $("#price").on('change',function(){

        var size = $(this).val();
        if(size == ""){
            alert("please select size");
            return false;
        }
        var product_id = $(this).attr("product-id");
        $.ajax({
            url:'/getproductprice',
            data:{size:size,product_id:product_id},
            type:'post',
            success:function(data){
                if(data['discount'] > 0){
                    $('.getPrice').html("<del>Rs. "+data['product_price'] + "</del> Rs. " + data['final_price']);
                }else{
                    $('.getPrice').html("Rs. "+data['product_price']);
                }

            },error:function(){
                alert("erorr");
            }
        });


    });

    //update cart item

    $(document).on('click','.btnItemUpdate',function(){
        if($(this).hasClass('qtyMinus')){
            var quantity = $(this).prev().val();
            if(quantity <=1){
                alert("Item Quntity must be 1 or greater!");
                return false;
            }else{
                new_qty = parseInt(quantity) - 1;
            }
        }
        if($(this).hasClass('qtyPlus')){
            var quantity = $(this).prev().prev().val();
            new_qty = parseInt(quantity) + 1;
        }
        var cartid = $(this).data('cartid');
        $.ajax({
            data:{"cartid":cartid,"qty":new_qty},
            url:'/update-cart-item-qty',
            type:'post',
            success:function(data){
                $(".totalcartitem").html(data.totalcartitem);
                if(data.status == true){
                    $('#AppendCartItem').html(data.view);
                }else{
                    alert(data.message);
                }
            },error:function(){
                alert("error");
            }
        });
    });


    //delete cart item

    $(document).on('click','.btnItemDelete',function(){
        var cartid = $(this).data('cartid');
        var result = confirm("want to delete this cart item");
        if(result){
            $.ajax({
                data:{"cartid":cartid},
                url:'/delete-cart-item',
                type:'post',
                success:function(data){
                    $('#AppendCartItem').html(data.view);
                    $(".totalcartitem").html(data.totalcartitem);
                },error:function(){
                    alert("error");
                }
            });
        }

    });

    //delete address confirm

    $(".deleteaddress").click(function(){
        var result = confirm("Want to delete this Address?");
        if(!result){
            return false;
        }
    });


    //cancel order

    $(".btncancelorder").click(function(){
        var reason = $("#reason").val();
        if(reason == ""){
            alert("Please select Reason for cancel the order");
            return false;
        }
        var result = confirm("Want to cancel this order?");
        if(!$result){
            return false;
        }
    });

        $("#returnExchange").change(function(){
            var returnexchange = $(this).val();//alert(returnexchange);
            if(returnexchange == 'Exchange'){
                $('#requiresize').show();
            }else{
                $('#requiresize').hide();
            }
        });

        $("#return_product").change(function(){
            var data = $(this).val();
            var returnexchange = $("#returnExchange").val();
            if(returnexchange == 'Exchange'){
                $.ajax({
                    type:'post',
                    url:'/getproductsize',
                    data:{
                        data:data
                    },
                    success:function(resp){
                        $('#productsize').html(resp);
                    },
                    error:function(){
                        alert("error");
                    }
                });
            }
        });
      //return order

      $(".btnreturnorder").click(function(){
        var returnexchange = $("#returnExchange").val();
        var comment = $("#comment").val();
        var reason = $("#returnReason").val();
        var product = $("#return_product").val();
        if(returnexchange == ""){
            alert("Please select you want to return or exchange?");
            return false;
        }
        if(product == ""){
            alert("Please select Product for return the order");
            return false;
        }
        if(reason == ""){
            alert("Please select Comment for return the order");
            return false;
        }
        var result = confirm("Want to return/Exchange this order?");
        if(!$result){
            return false;
        }
    });


});


function addSubscribe(){
    var email = $("#subscriber_email").val();
    var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
    // if ($("#email-add").length > 0) {

    // }
    if(regex.test(email) == false){
        alert("Please enter valid Email!");
        return false;
    }
    $.ajax({
        type:'post',
        url:'add-sub-email',
        data:{
            email:email
        },
        success:function(resp){
            if(resp == "exists"){
                alert("Subscriber Email is already Exists");
            }else if(resp =="save"){
                alert("Thanks for subscribing!");
            }
        },
        error:function(){
            alert("error");
        }
    });

}



