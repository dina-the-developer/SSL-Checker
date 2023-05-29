<?php
/**
 *  Template Name: SSL Checker 2022
 *
 * @package AppviewX
 * @subpackage AppviewX
 * @since AppviewX 1.0
**/

get_header(); 

?>
<link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght@400" rel="stylesheet" />
<style type="text/css">
  .pageContainer{
    padding: 80px 0px;
  }
  .pageFormContainer .form-control{
    border-top-left-radius: 25px;
    border-bottom-left-radius: 25px;
  }
  #status .media{
    padding: 20px;
    margin-bottom: 20px;
  }
  #status .media .imgPart{
    padding-bottom: 20px;
    color:  green;
  }
  .lds-dual-ring {
    display: inline-block;
    width: 50px;
    height: 50px;
  }
  .lds-dual-ring:after {
    content: " ";
    display: block;
    width: 35px;
    height: 35px;
    margin: 5% auto;
    border-radius: 50%;
    border: 3px solid #EE4137;
    border-color: #EE4137 transparent #EE4137 transparent;
    animation: lds-dual-ring 1.2s linear infinite;
  }
  @keyframes lds-dual-ring {
    0% {
      transform: rotate(0deg);
    }
    100% {
      transform: rotate(360deg);
    }
  }
</style>

<div class="pageContainer">

  <?php //while ( have_posts() ) : the_post(); ?>

    <?php //the_content(); ?> 
    
  <?php //endwhile; ?>

  <div class="pageFormContainer col-sm-8 col-center">
    <h1 class="text-center">SSL Checker</h1>
    <div class="form-group">
      <div class="input-group mb-3">
        <input type="text" class="form-control" id="domain" placeholder="Web Address" aria-label="Web Address" aria-describedby="checkSSL">
        <div class="input-group-append">
          <button class="btn btn-primary" type="button" id="checkSSL"><i class="fa fa-arrow-right"></i></button>
        </div>
      </div>
    </div>
    <div id="status"></div>
  </div>





</div>

<?php get_footer(); ?>

<script type="text/javascript">
  jQuery(function($){

    console.log("hi");

    $("#checkSSL").on("click", function(){

      var domain = $("#domain").val();

      jQuery.ajax({
        url: '<?php echo get_template_directory_uri(); ?>/page-templates/ssl-information.php',
        type: 'POST',
        dataType: 'json',
        headers: { 'Accept': 'application/json' },
        data: {
          domain: domain
        },
        beforeSend: function(){
          $('#status').html('<div class="lds-dual-ring text-center"></div><p class="text-center">Give us a moment. We re retireving the information!!!</p>').show().addClass('text-center');            
        },
        success: function(response) {
          $("#status").hide().removeClass('text-center');
          console.log(JSON.stringify(response));
          var expirationDate = new Date(response["validTo_time_t"]*1000);
          //$('#status').show().html('<div class="certificateInformation"> <div class="media serverCertificateDetails border"> <div class="imgPart"> <span class="material-symbols-outlined">check_circle</span> </div> <div class="media-body"> <h5 class="mt-0">SSL Server Certificate</h5> <p><b>Common Name:</b> '+response["subject"].CN+'</p> <p><b>Issuing CA:</b> '+response["issuer"].CN+'</p> <p><b>Organization:</b> '+response["subject"].O+'</p> <p><b>Valid:</b> '+expirationDate+'</p> <p><b>Key Size:</b> </p> </div> </div> </div>');
          $("#status").show().html('<pre><code>'+response+'</code></pre>');

        },
        error: function(err) {
          console.log(err);
           $('#status').show().html("Error: "+JSON.stringify(err.responseText));
        }
      });

    });
      

  });
</script>


?>