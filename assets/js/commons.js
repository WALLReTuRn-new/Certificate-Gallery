//$(document).ready(function(){
$ = jQuery;
$(function() {
   //$("#submit_gallery").hide();
   // $("#InputName").on('change',function(e){
    //    alert('change');
    //});
    $('#TypeGallerySelect,#ThemeGallerySelect').on('change',function(){
       // $("#submit_gallery").show();
    });
    $("#InputName,#DescriptionGallery,#ShortcodeInGallery").on("input", function() {
       // $("#submit_gallery").show();
    });

   $( "#gallery_edit" ).on( "submit", function(e) {
      var dataString = $(this).serializeArray();
      //console.log($(this).serialize());

      // alert(dataString); return false;
      $.ajax({
         type: "POST",
         url: '\/wp-admin\/admin-ajax.php',
         data: {
            action: 'submit_form',
            dataString:dataString,
            id_gallery: getUrlParameter('id_gallery')
         },
         success: function (response) {
//console.log(response);
            //if(response === '"true"'){
               $("#gallery_edit").html("<div id='message'></div>");
               $("#message")
                   .html("<h2>Contact Form Submitted!</h2>")
                   .append("<p>We will be redirect soon.</p>")
                   .hide()
                   .fadeIn(1500, function () {
                      $("#message").append(
                          "Redirect Now"
                      );
                      window.location.href = "\/wp-admin\/admin.php?page=certificates_gallery";
                   });
            //}else{
              // alert("Writing Error");
           // }

         }
      });

      e.preventDefault();
   });

   var getUrlParameter = function getUrlParameter(sParam) {
      var sPageURL = window.location.search.substring(1),
          sURLVariables = sPageURL.split('&'),
          sParameterName,
          i;
      for (i = 0; i < sURLVariables.length; i++) {
         sParameterName = sURLVariables[i].split('=');
         if (sParameterName[0] === sParam) {
            return sParameterName[1] === undefined ? true : decodeURIComponent(sParameterName[1]);
         }
      }
      return false;
   };
});

