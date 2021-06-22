//
// jQuery(function ($) {
//
//         $(document).ready(function () {
//                 $('body').on('click', '#submit', function () {
//                         console.log('hello world');
//                         var comment = $('textarea.comment').val();
//                         console.log(comment);
//                         preventDefault();
//                         //event.preventDefault();
//                         alert('123');
//                         var $data = {};
// // переберём все элементы input, textarea и select формы с id="myForm "
//                         $('#comments').find ('input, textearea,text, select').each(function() {
//                                 // добавим новое свойство к объекту $data
//                                 // имя свойства – значение атрибута name элемента
//                                 // значение свойства – значение свойство value элемента
//                                 $data[this.name] = $(this).val();
//                                 console.log($data);
//                         });
//
//                         ;
//
//
//
//                 });
//         });
// });
jQuery(function ($) {
    $(document).ready(function () {
        $('form').submit(function (event) {
            preventDefault();
            $.ajax({
                type: $(this).attr('method'),
                url: $(this).attr('action'),
                data: new FormData(this),
                contentType: false,
                processData: false,
                success: function (result) {
                    alert(result);
                }
            });
        });
    });
});






console.log(1234);