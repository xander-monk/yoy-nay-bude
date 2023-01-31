 <?php
document::$snippets['head_tags']['cropperjs'] = '<link rel="stylesheet" href="'. document::href_rlink(FS_DIR_APP . 'ext/jquery-jcrop/cropper.min.css') .'">' . PHP_EOL;
document::$snippets['foot_tags']['cropperjs'] = '<script src="'. document::href_rlink(FS_DIR_APP . 'ext/jquery-jcrop/cropper.min.js') .'"></script>' . PHP_EOL; ?>
<div class="widget col-md-4">
    <div class="panel panel-default">
        <div class="panel-heading">
            <div class="panel-title"><?php echo language::translate('title_images', 'Images'); ?></div>
        </div>
        <div class="panel-body">
            <div class="draggable-items-hidden"></div>
            <div class="draggable-items row">

            <?php if (isset($product->data['id']) && !empty($product->data['images'])) {
                foreach ($product->data['images'] as $image) {  ?>
                <div id="<?php echo $image['id']; ?>" class="picture col-md-6" draggable="true">
                    <div id="<?php echo $image['id']; ?>" class="image-box text-center" data-type="image-image-box">
                    <?php echo functions::form_draw_hidden_field('images['.$image['id'].'][id]', true); ?>
                    <?php echo functions::form_draw_hidden_field('images['.$image['id'].'][filename]', $image['filename']); ?>
                    <?php echo '<img class=" draggable_img img-fluid " style="cursor:pointer;" src="'. document::href_link(WS_DIR_APP . functions::image_thumbnail(FS_DIR_APP . 'images/' . $image['filename'], $product_image_width, $product_image_height, settings::get('product_image_clipping'))) .'" alt="" />'; ?>
                        <div class="overlay">
                            <i id="delete" class="fa fa-trash" data-pic="<?php echo $image['id']; ?>"></i>
                        </div>
                    </div>
                </div>
            <?php } } ?>
        </div>
    </div>
</div>
</div>

<!-- new picture item template -->
<!-- new picture item template -->
<script type="text/html" id="new_pic-template">
     <div id="%%idunique%%" class="picture input col-md-6" draggable="%%draggable%%">
        <?php  echo functions::form_draw_file_field('new_images[]','id="%%idunique%%" style="display:none"'); ?>
            <div class="image-box text-center" data-type="image-image-box">
             <?php echo '<img id="%%idunique%%" data-type="noimage" class="draggable_img img-fluid" style="cursor:pointer;" src="'. document::href_link(WS_DIR_APP . functions::image_thumbnail(FS_DIR_APP . '%%img%%', $product_image_width, $product_image_height, settings::get('product_image_clipping'))) .'" alt="" />';  ?>
             <div class="overlay">
                  <i id="add" data-pic="%%idunique%%" class="fa fa-plus"></i>
                  <i id="crop" style="display:none;" data-pic="%%idunique%%" class="fa fa-crop"></i>
                  <i id="delete" style="display:none;" data-pic="%%idunique%%"  class="fa fa-trash"></i>
               </div>
            </div>  
        </div>
</script>
<!-- new picture item template -->
<!-- new picture item template -->

 <script>
$(document).ready(function() {
add_img_block();
check_actions();
 dragables_start();
});
function check_actions () {

$(document).on("click","#add", function(e) {
     var picEl = e.currentTarget.dataset.pic;
     var imgEl = document.getElementById(picEl).querySelectorAll('img')[0];
     var inputEl = document.getElementById(picEl).querySelectorAll('input')[0];
     inputEl.click();
});

$(document).on("click","#crop", function(e) {
    var picEl = e.currentTarget.dataset.pic;
    start_crop(picEl);
});

$(document).on("click","#delete", function(e) { 
     var picEl = e.currentTarget.dataset.pic;
     document.getElementById(picEl).remove();
});

}
 function add_img_block() {
var template = $('#new_pic-template').text();
    template = template.replaceAll('%%idunique%%', Date.now());
    template = template.replaceAll('%%img%%', 'images/no_image.png');
    template = template.replaceAll('%%draggable%%', "true");
    $(template).appendTo('.draggable-items').hide().fadeIn(500);
} 

$('.draggable-items').on('change', 'input[type="file"]', function(element) {
     console.log(element);
    var oFReader = new FileReader();
    oFReader.readAsDataURL(this.files[0]);
    var files = this.files;
    if ((/^image\/\w+/.test(files[0].type)) !== true) { alert ('Please choose an image file.'); return; }
    window.originalfile = files[0];
    oFReader.onload = function(e){ }
    oFReader.onloadend = function(e) {
        $(element.currentTarget.parentElement).find('img')[0].src = e.target.result;
        $(element.currentTarget.parentElement).fadeIn(800);
        $(element.currentTarget.parentElement).find('#add').hide();
        $(element.currentTarget.parentElement).find('#crop').show();
        $(element.currentTarget.parentElement).find('#delete').show();
        add_img_block();
        dragables_start();
     }
});
 
 
/* --------------- **/
/* Dragable images **/
/* --------------- **/
function dragables_start() {
    const draggables = document.querySelectorAll('.picture')
    const containers = document.querySelectorAll('.draggable-items')
    draggables.forEach(draggable => {
      draggable.addEventListener('dragstart', (e) => {
        draggable.classList.add('dragging')
;
      })
      draggable.addEventListener('dragend', (e) => {
        draggable.classList.remove('dragging')
        $(draggable).find('.main-image-tag').remove();
if (draggable.previousElementSibling == null) { }
      })
    })
    containers.forEach(container => {
      container.addEventListener('dragover', e => {
        e.preventDefault()
        const afterElement = getDragAfterElement(container, e.clientY)
        const draggable = document.querySelector('.dragging')
        if (afterElement == null) {
          container.appendChild(draggable)
        } else {
          container.insertBefore(draggable, afterElement)
        }
      })
    })
    function getDragAfterElement(container, y) {
      const draggableElements = [...container.querySelectorAll('.picture:not(.dragging)')]
      return draggableElements.reduce((closest, child) => {
        const box = child.getBoundingClientRect()
        const offset = y - box.top - box.height / 2
        if (offset < 0 && offset > closest.offset) {
          return { offset: offset, element: child }
        } else {
          return closest
        }
      }, { offset: Number.NEGATIVE_INFINITY }).element
    }
}


/* --------------- **/
/* Crop Image      **/
/* --------------- **/
function start_crop (picid) {

  $.featherlight('#modal-cropper',{closeOnClick:false, width:640,
        afterContent: function(){
        var crop = this.$content.find('.crop')[0];
        var InputElement = $('#'+picid).find(":input")[0];
        var img = $(document).find("#"+picid+" img");
        var result = this.$content.find('.result')[0],
            img_w = this.$content.find('#img_w')[0],
            img_h = this.$content.find('#img_h')[0],
            flip_v = this.$content.find('.flip_v')[0],
            flip_h = this.$content.find('.flip_h')[0],
            rotate_r45 = this.$content.find('.rotate_r45')[0],
            rotate_l45 = this.$content.find('.rotate_l45')[0];
            rotate_r = this.$content.find('.rotate_r')[0],
            rotate_l = this.$content.find('.rotate_l')[0];
           var src= result.querySelector("img");
               src.setAttribute('src',img.attr('src'));

     const cropper = new Cropper(src, {
     // aspectRatio: 16 / 9,
      width: 800, height: 800,
        viewMode: 0,
        fillColor: '#ccdd',
      
      crop(event) {
        /* console.log(event.detail.x);
        console.log(event.detail.y);
        console.log(event.detail.width);
        console.log(event.detail.height);
        console.log(event.detail.rotate);
        console.log(event.detail.scaleX);
        console.log(event.detail.scaleY); */
      },
        });
 

// assumes ctx is defined
// returns true if pixel is fully transparent
   

  /*     var canvas = cropper.getCroppedCanvas();
    var ctx = canvas.getContext("2d");
   console.log(ctx.getImageData(12, 12, 1, 1).data); */
       
        flip_v.addEventListener('click', e => { cropper.scaleX(-(cropper.imageData.scaleX));  });
		flip_h.addEventListener('click', e => { cropper.scaleY(-(cropper.imageData.scaleY)); });
		rotate_r45.addEventListener('click', e => { cropper.rotate(-45) });
		rotate_l45.addEventListener('click', e => { cropper.rotate(45) });
		rotate_r.addEventListener('click', e => { cropper.rotate(-1) });
		rotate_l.addEventListener('click', e => { cropper.rotate(1) });


    crop.addEventListener('click', e => {
  
		  e.preventDefault();
		  // get result to data uri
		  let imgSrc = cropper.getCroppedCanvas({fillColor: 'white'}).toDataURL();
		  img.attr('src',imgSrc);
		  crop_process(imgSrc,InputElement); 
		  $.featherlight.close(); 
		});
    }
  });
}
 


/* --------------- **/
/* Crop Process    **/
/* --------------- **/
function crop_process (dataUrl, InputElement, picid) {
	
       var bytes =  atob(dataUrl.split(',')[1]);  
       var mime = dataUrl.split(',')[0].split(':')[1].split(';')[0]; 
       var max = bytes.length; 
       var ia = new Uint8Array(max); 
       for (var i = 0; i < max; i++) { ia[i] = bytes.charCodeAt(i); }; 
        
   let container = new DataTransfer(); 
 
 
  let file = new File([ia], "crop_"+window.originalfile.name, {type:mime, lastModified:new Date().getTime()}); 
       container.items.add(file); 
       let myFileList = container.files;  
        
      InputElement.files = myFileList;  
	  console.log(InputElement);	  
}
 



</script>
<style>
 
.picture {position:relative;}.picture.col-md-6:first-of-type { grid-column: span 12 !important; }.image-box { position: relative; height:100%;} .draggable_img { position: relative; top: 0; left: 0; width: 100%; height: auto; object-fit: cover; border-width: 2px !important; border-color: #dee2e6 !important; border-style: dashed !important }  .overlay { position: absolute; top: 0; bottom: 0; left: 0; border:12px transparent solid; display: flex; flex-wrap: wrap; align-content: center; justify-content: center; right: 0; width: 100%; height: 100%; opacity: 0; transition: .5s ease; background-color: rgb(172 172 172 / 79%); } .overlay .fa { border-radius:20px;border:2px solid white; padding:10px; margin:2px; color: #fff; } .overlay .fa-crop { background:#1010bc; } .overlay .fa-trash { background:#b30000; } .picture:hover .overlay { opacity: 1; cursor:pointer; } /*** draggable **/ .picture { padding: 1rem; background-color: white; border: 1px solid #cccccc; cursor: move; transition: transform .2s; /* Animation */ } .picture.dragging { opacity: .10; background:#dddddd; -webkit-box-shadow: 7px 11px 10px -2px rgba(0,0,0,0.63); box-shadow: 7px 11px 10px -2px rgba(0,0,0,0.63); transform: scale(0.9); } .picture.col-md-6:first-of-type:before {  position: absolute;
    content: "<?php echo language::translate('title_main_image', ' Main Image');?>";
    left: 0px;
    top: 0px;
    font-size: 13px;
    background: #ebecef;
    padding: 5px 14px;
    z-index:2;
    border-radius: 0px 0px 23px;}
</style>


<style>.result img { max-width: 100%; }.crop_button {margin-bottom:10px;float: right;}.hide { display: none; }
 div.images > div > div.input-group, #images > div.new-images > div > div.input-group { flex-direction: column-reverse !important; }
</style>   
<div id="modal-cropper" class="modal-cropper text-center" style="display:none;">
    <div class="row">
        <div class="col-md-12 text-center">
            <div class="result"><img src="" style="max-height:75vh;"/></div>
        </div>
    </div>
   
    <button style="margin-top:10px;" class="btn btn-default flip_h" id="flip_h"><i class="fa fa-arrows-h"></i></button>
    <button style="margin-top:10px;" class="btn btn-default flip_v" id="flip_v"><i class="fa fa-arrows-v"></i></button>
    <button style="margin-top:10px;" class="btn btn-default rotate_l45" id="rotate_l45">-45º <i class="fa fa-rotate-left"></i></button>
    <button style="margin-top:10px;" class="btn btn-default rotate_r45" id="rotate_r45">45º <i class="fa fa-rotate-right"></i></button>
    <button style="margin-top:10px;" class="btn btn-default rotate_l" id="rotate_l">-1º <i class="fa fa-rotate-left"></i></button>
    <button style="margin-top:10px;" class="btn btn-default rotate_r" id="rotate_r">1º <i class="fa fa-rotate-right"></i></button>
    <button style="margin-top:10px;" class="btn btn-default crop" id="getCroped"><i class="fa fa-crop"></i> Crop Image</button>
    <button style="margin-top:10px;" class="btn btn-danger" onclick="$.featherlight.close();" id="cancelcrop">Cancel</button>
</div>

