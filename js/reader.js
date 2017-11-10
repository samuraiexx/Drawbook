var $overlay = $('<div id="overlay" tabindex="0"></div>');
var $image = $("<img>");
var page;
var project_id;
var total_pages;

$overlay.append($image);

//Add overlay
$("body").append($overlay);

// Function that gets page's image name from database and update the image
function ajax_load_page(project_id, page){
    $.ajax({
        method: "POST",
        url : "js/reader_ajax.php",
        data : { project_id : project_id, page :  page},
        success : function(response) {
            // Use  data-id attr in order to set this
            var imageLocation = "img/pages/" + response + ".jpg";
            //Update overlay with the image linked in the link
            $image.attr("src", imageLocation);
        }
    });
    $overlay.animate({scrollTop : 0}, 200);
        //$overlay.scrollTop(0);
}

//Capture the click event on a link to an image
$(".image-container span").click(function(event){
    event.preventDefault();

    // Reading images names of each page from database
    project_id = $(this).closest( ".image-container").attr("data-id");
    total_pages = $(this).closest( ".image-container").attr("data-totalPages");
    //Hide body's scrollbar, show div's scrollbar and adjust elements width
    var scrollbarWidth = $('body').ScrollBarWidth();
    $("body").css("overflow", "hidden").css("margin-right", scrollbarWidth + "px");
    $("#head").css("right", scrollbarWidth + "px");

    //Show the overlay.
    $overlay.show();

    $overlay.scrollTop(0);
    $overlay.focus();
    page = 1;
    ajax_load_page(project_id, page);
});

//When overlay is clicked
$overlay.click(function(){
    //Hide the overlay
    $overlay.hide();

    //Adjust body and #head to adjust width because of body scroll
    $("body").css("overflow", "visible").css("margin-right", 0);
    $("#head").css("right", 0);
}).children().click(function () {
    if (page != total_pages)
        page++;
    else
        return;
    ajax_load_page(project_id, page);
    return false;
});

// Changes page when arrows are pressed
$overlay.keydown(function(e){
    if (e.keyCode == '37') {
        if (page != 1)
            page--;
        else
            return;
    }
    else if (e.keyCode == '39') {
        if (page != total_pages)
            page++;
        else
            $overlay.click(); // Closes overlay
    }
    else if (e.keyCode == '27') { // esc
        $overlay.click();
    }
    else return;
    ajax_load_page(project_id, page);
});

//Prevent scroll click bug
$overlay.on("mousedown" , function(e){if(e.button==1)return false});

// GET SCROLLBAR WIDTH FUNCTION //
(function($) {
    $.fn.ScrollBarWidth = function() {
        if (this.get(0).scrollHeight > this.height()) { //check if element has scrollbar
            var inner = document.createElement('p');
            inner.style.width = "100%";
            inner.style.height = "200px";
            var outer = document.createElement('div');
            outer.style.position = "absolute";
            outer.style.top = "0px";
            outer.style.left = "0px";
            outer.style.visibility = "hidden";
            outer.style.width = "200px";
            outer.style.height = "150px";
            outer.style.overflow = "hidden";
            outer.appendChild(inner);
            document.body.appendChild(outer);
            var w1 = inner.offsetWidth;
            outer.style.overflow = 'scroll';
            var w2 = inner.offsetWidth;
            if (w1 == w2) w2 = outer.clientWidth;
            document.body.removeChild(outer);
            return (w1 - w2);
        }
    }
})(jQuery);