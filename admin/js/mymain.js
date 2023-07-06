// Select all for checkboxes // Do not delete for blog-posts & comments
$(document).ready(function(){
    $(".col-pages-box #select-all").click(function(){
        $(".col-page-box input[type='checkbox']").prop('checked',this.checked);
    });
});

// Select all for checkboxes // Do not delete for users
$(document).ready(function(){
    $(".col-pages-box #select-all").click(function(){
        $(".table input[type='checkbox']").prop('checked',this.checked);
    });
});


// Set class active on an element
$(document).ready(function(){
    $(".users-pages .header-nav .users-a").click(function(){
        if(!$(this).hasClass('active')){
            $(".users-a").removeClass("active");
            $(this).addClass("active");
        }
        $(".users-a").addClass("active");
    });
});


// Set class active on an element
// var divContainer = document.querySelector("users-drop-1");
// var activeElement = divContainer.getElementsByClassName("users-a");

// for (var i=0; i< activeElement.length; i++){
//     activeElement[i].addEventListener("click", function(){
//         var current = document.getElementsByClassName("active");

//         if (current.length > 0){
//             current[0].className = current[0].className.replace("active", "");
//         }

//         this.current += " active ";
//     });
// }


//
// let form = document.querySelector('#comheader')
// form.addEventListener("focus", function(event){

//     //target is used to get current element
//     event.target.className = "getheader";
// }, 
// true
// );

//add blur event 
// form.addEventListener("blur", function(event){

//     //target is used to get current element
//     event.target.style.background = "";
// }, 
// true
// );


// document.querySelector("#comheader").addEventListener("click", function(){
//     document.querySelector("a").setAttribute("class", "getheader");;
//     // document.querySelector("h5").style.color = "#fff";
//  });