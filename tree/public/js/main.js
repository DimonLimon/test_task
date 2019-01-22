$(function() {
    init();
});

function init() {
    $(document).on('click', '.init-add-form', initAddForm);
    $(document).on('click', '.init-delete-form', initDeleteForm);
    $(document).on('click', '.glyphicon-plus', initChildList);
    $(document).on('click', '.glyphicon-minus', initDeleteChildList);
    $(document).on('submit', '.add-form', addBranch);
    $(document).on('submit', '.delete-form', deleteBranch);
}

function initAddForm() {
    var addFormVCnt = $('.add-form-cnt'),
        deleteFormVCnt = $('.delete-form-cnt');

    deleteFormVCnt.removeClass('active').addClass('nested');
    if(addFormVCnt.hasClass('nested')){
        addFormVCnt.removeClass('nested').addClass('active');
    }else{
        addFormVCnt.removeClass('active').addClass('nested');
    }
}

function initDeleteForm() {
    var deleteFormVCnt = $('.delete-form-cnt'),
        addFormVCnt = $('.add-form-cnt');

    addFormVCnt.removeClass('active').addClass('nested');
    if(deleteFormVCnt.hasClass('nested')){
        deleteFormVCnt.removeClass('nested').addClass('active');
    }else{
        deleteFormVCnt.removeClass('active').addClass('nested');
    }
}

function  initChildList() {
    var li = $(this).parent(),
        id = li.attr('data-id'),
        name = li.text();

    $(this).addClass('glyphicon-minus').removeClass('glyphicon-plus');
    $.ajax({
        type: "GET",
        url: '/index/child/',
        data: {'id' : id},
        success: function(data){
            var json = JSON.parse(data),
                html = '';
            html = '<ul class="active list-unstyled">';

            for (var item in json['branches']) {
                if(json['branches'][item].hasChildren){
                    html += '<li data-id="' + item + '">' +
                        ' <span class="icon expand-icon glyphicon glyphicon-plus"></span>' +
                        ' <span class="icon node-icon"></span>' + json['branches'][item].name + '</li>';
                }else{
                    html +=  '<li data-id="' + item + '">' + json['branches'][item].name + '</li>';
                }
            }
            html += '</ul>';
            li.append(html);
            $("#selectable-output").append('<p>Selected branch ' +  name + '</p>');
        }
    });

}

function  initDeleteChildList() {
    var li = $(this).parent(),
        childList = li.find('.list-unstyled');
    $(this).addClass('glyphicon-plus').removeClass('glyphicon-minus');
    childList.remove();
    $("#selectable-output").append('<p>Selected branch ' +  li.text() + '</p>');

}

function addBranch(e) {
    e.preventDefault();
    var form = $(this).serialize(),
        select = $( ".add-form .selectpicker option:selected"),
        parent_id = select.attr('data-id');

    if(parent_id){
        form += "&parent_id=" + parent_id;
    }else{
        form += "&parent_id=0";
    }

    $.ajax({
        type: "GET",
        url: $(this).attr('action'),
        data: form,
        success: function(data){
            var json = JSON.parse(data);
            select.append('<oprion data-id="'+ json['id'] +'">' + json['name'] + '</oprion>').selectpicker('refresh');
            $("#selectable-output").append('<p>Add new branch ' +  json['name'] + '</p>');
        }
    });
}

function deleteBranch(e) {
    e.preventDefault();
    var select = $(".delete-form .selectpicker option:selected"),
        name = select.val(),
        id = select.attr('data-id');
    $.ajax({
        type: "GET",
        url: $(this).attr('action'),
        data: {'id': id},
        success: function(data){
            select.remove().selectpicker('refresh');
            $("#selectable-output").append('<p>Delete branch ' +  name + '</p>');
        }
    });
}