function checkForm(form)
{

  form.myButton.disabled = true;
  return true;
}

$(".updatestatus").click(function(){
    var status = $(this).children("i").attr("status");
    var section_id = $(this).attr("section_id");
    $.ajax({
        type:'POST',
        url:'/admin/updatestatus',
        data:{
            status:status,
            section_id:section_id
        },
        success:function(data){
            if(data['status'] == 0){
                $("#section-"+data['section_id']).html("<i class='fas fa-toggle-off' aria-hidden='true' status='Inactive'></i>");
            }else if(data['status'] == 1){
                $("#section-"+data['section_id']).html("<i class='fas fa-toggle-on' aria-hidden='true' status='Active'></i>");
            }
        },error:function(){
            alert("Erorr");
        }

    });
});

$(".updatecategory").click(function(){
    var status = $(this).text();
    var category_id = $(this).attr("category_id");
    $.ajax({
        type:'POST',
        url:'/admin/updatecategory',
        data:{
            status:status,
            category_id:category_id
        },
        success:function(data){
            if(data['status'] == 0){
                $("#category-"+data['category_id']).html("<a href='javascript:void(0)' class='updatecategory' >In Active</a>");
            }else if(data['status'] == 1){
                $("#category-"+data['category_id']).html("<a href='javascript:void(0)' class='updatecategory' >Active</a>");
            }
        },error:function(){
            alert("Erorr");
        }

    });
});

//update cms status
$(".updatebanner").click(function(){
    var status = $(this).text();
    var banner_id = $(this).attr("banner_id");
    $.ajax({
        type:'POST',
        url:'/admin/updatecms',
        data:{
            status:status,
            banner_id:banner_id
        },
        success:function(data){
            if(data['status'] == 0){
                $("#banner-"+data['banner_id']).html("<a href='javascript:void(0)' class='updatebanner' >In Active</a>");
            }else if(data['status'] == 1){
                $("#banner-"+data['banner_id']).html("<a href='javascript:void(0)' class='updatebanner' >Active</a>");
            }
        },error:function(){
            alert("Erorr");
        }

    });
});

//append category level

$("#section_id").change(function(){
    var section_id = $(this).val();
   // alert(section_id);
   $.ajax({
    type:'post',
    url:'/admin/append-categorylevel',
    data:{
        section_id : section_id
    },
    success:function(data){
        $("#appendcategorylevel").html(data);
    },error:function(){
        alert("error");
    }
   });
});

//update product status



$(".updateproduct").click(function(){
    var status = $(this).text();
    var product_id = $(this).attr("product_id");
    $.ajax({
        type:'POST',
        url:'/admin/updateproduct',
        data:{
            status:status,
            product_id:product_id
        },
        success:function(data){
            if(data['status'] == 0){
                $("#product-"+data['product_id']).html("<a href='javascript:void(0)' class='updateproduct' >In Active</a>");
            }else if(data['status'] == 1){
                $("#product-"+data['product_id']).html("<a href='javascript:void(0)' class='updateproduct' >Active</a>");
            }
        },error:function(){
            alert("Erorr");
        }

    });
});

//update attribute
$(".updateattriute").click(function(){
    var status = $(this).text();
    var attribute_id = $(this).attr("attribute_id");
    $.ajax({
        type:'POST',
        url:'/admin/updateattribute',
        data:{
            status:status,
            attribute_id:attribute_id
        },
        success:function(data){
            if(data['status'] == 0){
                $("#attribute-"+data['attribute_id']).html("In Active");
            }else if(data['status'] == 1){
                $("#attribute-"+data['attribute_id']).html("Active");
            }
        },error:function(){
            alert("Erorr");
        }

    });
});


//update subscription status
$(".updatesubscriber").click(function(){
    var status = $(this).text();
    var subscriber_id = $(this).attr("subscriber_id");
    $.ajax({
        type:'POST',
        url:'/admin/updateemailsub',
        data:{
            status:status,
            subscriber_id:subscriber_id
        },
        success:function(data){
            if(data['status'] == 0){
                $("#subscriber-"+data['subscriber_id']).html("In Active");
            }else if(data['status'] == 1){
                $("#subscriber-"+data['subscriber_id']).html("Active");
            }
        },error:function(){
            alert("Erorr");
        }

    });
});

//update rating status
$(".updaterating").click(function(){
    var status = $(this).children("i").attr("status");
    var rating_id = $(this).attr("rating_id");
    $.ajax({
        type:'POST',
        url:'/admin/updaterating',
        data:{
            status:status,
            rating_id:rating_id
        },
        success:function(data){
            if(data['status'] == 0){
                $("#rating-"+data['rating_id']).html("<i class='fas fa-toggle-off' aria-hidden='true' status='Inactive'></i>");
            }else if(data['status'] == 1){
                $("#rating-"+data['rating_id']).html("<i class='fas fa-toggle-on' aria-hidden='true' status='Active'></i>");
            }
        },error:function(){
            alert("Erorr");
        }

    });
});

$(document).ready(function(){
    $("#image").change(function(e){
        let reader = new FileReader();
        reader.onload = function(e){
            $("#showImage").attr('src',e.target.result);
        }
        reader.readAsDataURL(e.target.files['0']);
    });
});
//delete confirmation
// $(".confirm_delete").click(function(){
//     var name = $(this).attr("name");
//     if(confirm("Are you sure to delete this "+ name + "?")){
//         return true;
//     }else{
//         return false;
//     }
// });

$(".confirm_delete").click(function(){
    var record = $(this).attr("record");
    var recordid = $(this).attr("recordid");
    //event.preventDefault();
    swal({
        title: `Are you sure you want to delete this record?`,
        text: "If you delete this, it will be gone forever.",
        icon: "warning",
        buttons: true,
        dangerMode: true,
    })
    .then((willDelete) => {
      if (willDelete) {
        window.location.href="/admin/delete-"+record+"/"+recordid;
      }
    });

});

$(document).ready(function(){
    var maxField = 10; //Input fields increment limitation
    var addButton = $('.add_button'); //Add button selector
    var wrapper = $('.field_wrapper'); //Input field wrapper
    var fieldHTML = '<div style="margin-top:10px;margon-left:2px"><input id="size" type="text" name="size[]" value="" placeholder="size" style="width: 120px" required/>&nbsp;<input id="code" type="text" name="code[]" value="" placeholder="code" style="width: 120px" required/>&nbsp;<input id="price" type="number" name="price[]" value="" placeholder="price" style="width: 120px" required/>&nbsp;<input id="stock" type="number" name="stock[]" value="" placeholder="stock" style="width: 120px" required/><a href="javascript:void(0);" class="remove_button">Delete</a></div>'; //New input field html
    var x = 1; //Initial field counter is 1

    //Once add button is clicked
    $(addButton).click(function(){
        //Check maximum number of input fields
        if(x < maxField){
            x++; //Increment field counter
            $(wrapper).append(fieldHTML); //Add field html
        }
    });

    //Once remove button is clicked
    $(wrapper).on('click', '.remove_button', function(e){
        e.preventDefault();
        $(this).parent('div').remove(); //Remove field html
        x--; //Decrement field counter
    });
});


function html_table_to_excel(type) {
    var data = document.getElementById("newsletter_subscriber");

    var file = XLSX.utils.table_to_book(data, { sheet: "sheet1" });

    XLSX.write(file, { bookType: type, bookSST: true, type: "base64" });

    XLSX.writeFile(file, "history." + type);
}
