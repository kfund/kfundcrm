Dropzone.autoDiscover = false;
$(document).ready( function () {

    $("#dzUpload").dropzone({
        url: saveFileRoute,
        addRemoveLinks: true,
        autoProcessQueue: false,
        uploadMultiple: true,
        maxFiles: 10,
        parallelUploads: 10,
        init:function(){

            var submitButton = document.querySelector("#submit-all")
            myDropzone = this; // closure

            submitButton.addEventListener("click", function() {
                myDropzone.processQueue(); // Tell Dropzone to process all queued files.
            });

            this.on("addedfile", function() {
                $(".dz-remove").text(remove_trans);
            });

            this.on("sending", function(file, xhr, formData){
                formData.append("category_id", intranetVue.selected_category);
            });

            this.on("complete",function (file) {
                this.removeThumbnail();
                this.removeAllFiles();
                intranetVue.getFiles(intranetVue.selected_category); // refresh table after upload
            })
        },
        success: function (file, response) {
            var imgName = response;
            file.previewElement.classList.add("dz-success");
        },
        error: function (file, response) {
            file.previewElement.classList.add("dz-error");
        }
    });

    Dropzone.prototype.removeThumbnail = function () {
        $(".dz-preview").fadeOut('slow');
        $(".dz-preview:hidden").remove();
    };
     var intranetVue = new Vue({
        el: '#intranetVue',
        data:{
            categories: intranet_categories,
            root_categories: [],
            displayed_categories: [],
            active_category: null, // used for file fetching and visually displaying parent category in list
            selected_category: null, // used for file saving, file fetching.
            path_history:[]
        },
        created:function () {
            this.categories.forEach((item) => {
                if(item.parent_id == 0)
                    this.root_categories.push(item);
            });
            this.displayed_categories = this.root_categories;
            this.active_category = this.root_categories[0];
            this.selected_category = this.root_categories[0].id;

            this.getFiles(null);
        },
        methods:{
            /**
             *
             * @param cat
             * cat is either null or selected category
             * if null then active_category.id is used as param for post request
             * Mostly selected category will be used but active will be as fallback in some cases
             *
             */
            getFiles:function(cat){

                if(cat != null)
                    this.selected_category = cat;

                $.ajax({
                    url: getFilesRoute,
                    type: 'post',
                    dataType: 'json',
                    beforeSend: function (request) {
                        return request.setRequestHeader('X-CSRF-Token', $("meta[name='_token']").attr('content'));
                    },
                    data: {  category_id: cat == null ? this.selected_category : cat},
                    success: function (response) {
                        datatable.clear();
                        var files = [];
                        response["files"].forEach((item) => {
                            files.push([item.id,response['category_name'],item.original_filename]);
                        });
                        datatable.rows.add(files);
                        datatable.draw();
                    },
                    error: function (error) {


                    }
                });
            },
            deleteFile:function(id){
                Swal.fire({
                    title: file_delete_trans,
                    text: are_you_sure_trans + "?",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: delete_trans,
                    cancelButtonText: back_trans,
                }).then((result)=>{
                    if(result.value){
                        $.ajax({
                            url: deleteFileRoute,
                            type: 'post',
                            dataType: 'json',
                            beforeSend: function (request) {
                                return request.setRequestHeader('X-CSRF-Token', $("meta[name='_token']").attr('content'));
                            },
                            data: { file_id: id},
                            success: function (response) {
                                if (response.status){
                                    intranetVue.getFiles(null);
                                    Swal.fire({icon: 'success', text: file_deleted_trans + '!'});
                                }else{
                                    Swal.fire({icon: 'error', text: response.error});
                                }
                            },
                            error: function (error) {


                            }
                        });
                    }
                });
            },
            moveFile:function(id, kategorija, ime){
                fileModal.id = id;
                fileModal.category_title = kategorija;
                fileModal.original_filename = ime;
                $("#fileModal").modal('show');
            },
            selectCategory:function (category) {
                this.selected_category = category.id;
                if(category.categories != undefined && category.categories.length > 0){
                    var history = [];
                    this.displayed_categories.forEach((item) => {
                        if(item.id == category.id)
                            item.selected = true;
                        else
                            item.selected = false;
                       history.push(item);
                    });
                    this.path_history.push(history);
                    this.active_category = category;
                    this.displayed_categories = [];
                    this.displayed_categories.push(category);
                    category.categories.forEach((item) => {
                        this.displayed_categories.push(item);
                    })
                    this.getFiles(null);
                }else{

                    this.getFiles(category.id);
                }
            },
            deleteCategory:function(id){
                Swal.fire({
                    title: category_delete_trans,
                    text: are_you_sure_trans + "?",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: delete_trans,
                    cancelButtonText: back_trans,
                }).then((result)=>{
                    if(result.value){
                        $.ajax({
                            url:  deleteCategoryRoute,
                            type: 'post',
                            dataType: 'json',
                            beforeSend: function (request) {
                                return request.setRequestHeader('X-CSRF-Token', $("meta[name='_token']").attr('content'));
                            },
                            data: {category_id: id},
                            success: function (response) {
                                if (response.status) {
                                    Swal.fire({icon: 'success', text: category_deleted_trans + '!'});
                                    setTimeout(function () { // wait 1 second and reload
                                        window.location.reload(true);
                                    }, 1000);
                                }else{
                                    Swal.fire({icon: 'error', text: response.error});
                                }
                            },
                            error: function (error) {

                            }
                        });
                    }
                });
            },
            editCategory:function(id, title){
                editCategory.id = id;
                editCategory.category_title = title;
                $("#editCategory").modal('show');
            },
            // Share file on email
            shareFile: function(file_id){
                shareFile.file_id = file_id;
                $("#shareFile").modal('show');
            },
            back(){
                if(this.path_history.length == 1){
                    this.active_category = this.root_categories[0];
                    this.selected_category = this.root_categories[0].id;
                }
                this.displayed_categories = this.path_history.pop();

                this.displayed_categories.forEach((item)=>{
                   if(item.id == this.active_category.parent_id){
                       this.active_category = item;
                       this.selected_category = item.id;
                   }
                });
                this.getFiles(null);
            }
        }
    });

    var categoryModal = new Vue({
        el: '#categoryModal',
        data:{
            category_list: category_list,
            selected_category: 0,
            category_title: ""
        },
        created:function(){
        },
        methods:{
            submitForm(){
                $.ajax({
                    url: save_category_route,
                    type: 'post',
                    dataType: 'json',
                    beforeSend: function (request) {
                        return request.setRequestHeader('X-CSRF-Token', $("meta[name='_token']").attr('content'));
                    },
                    data: {category_title:this.category_title, selected_category: this.selected_category},
                    success: function (response) {
                        if (response.status) {
                            $("#categoryModal").modal("toggle");
                            Swal.fire({icon: 'success', text: category_created_trans + '!'});
                            setTimeout(function () { // wait 1 second and reload
                                window.location.reload(true);
                            }, 1000);

                        }else{
                            Swal.fire({icon: 'error', text: response.error});
                        }
                    },
                    error: function (error) {

                    }
                });
            }
        }
    });

    var editCategory = new Vue({
        el: '#editCategory',
        data:{
            id: 0,
            category_title: ""
        },
        methods:{
            edit(){
                $.ajax({
                    url: editCategoryRoute,
                    type: 'post',
                    dataType: 'json',
                    beforeSend: function (request) {
                        return request.setRequestHeader('X-CSRF-Token', $("meta[name='_token']").attr('content'));
                    },
                    data: {
                        category_id: this.id,
                        category_title: this.category_title
                    },
                    success: function (response) {
                        if (response.status) {
                            $("#editCategory").modal("toggle");
                            Swal.fire({icon: 'success', text: category_name_changed_trans + '!'});
                            setTimeout(function () { // wait 1 seconds and reload
                                window.location.reload(true);
                            }, 1000);

                        }else{
                            Swal.fire({icon: 'error', text: response.error});
                        }
                    },
                    error: function (error) {
                    }
                });
            }
        }
    });

    var fileModal = new Vue({
        el: '#fileModal',
        data:{
            id: 0,
            category_title: '',
            original_filename: '',
            category_list: category_list,
            selected_category: 0
        },
        methods:{
            move(){
                $.ajax({
                    url: moveFileRoute,
                    type: 'post',
                    dataType: 'json',
                    beforeSend: function (request) {
                        return request.setRequestHeader('X-CSRF-Token', $("meta[name='_token']").attr('content'));
                    },
                    data: {
                        id: this.id,
                        selected_category: this.selected_category
                    },
                    success: function (response) {
                        if (response.status) {
                            $("#fileModal").modal("toggle");
                            Swal.fire({icon: 'success', text: file_moved_trans + '!'});
                            setTimeout(function () { // wait 1 seconds and reload
                                window.location.reload(true);
                            }, 1000);
                        }else {
                            Swal.fire({icon: 'error', text: response.error});
                        }
                    },
                    error: function (error) {

                    }
                });
            }
        }
    });

    var shareFile = new Vue({
        el:'#shareFile',
        data:{
            file_id: 0,
            recepient_emails: ""
        },
        methods:{
            share(){
                $.ajax({
                    url: emailShareRoute,
                    type: 'post',
                    dataType: 'json',
                    beforeSend: function (request) {
                        return request.setRequestHeader('X-CSRF-Token', $("meta[name='_token']").attr('content'));
                    },
                    data: {
                        file_id: this.file_id,
                        recepient_emails: this.recepient_emails
                    },
                    success: function (response) {
                        if (response.status) {
                            $("#shareFile").modal("toggle");
                            Swal.fire({icon: 'success', text: file_sent_trans + '!'});
                            window.location.reload(true);
                        }else{
                            Swal.fire({icon: 'error', text: response.error});
                        }
                    },
                    error: function (error) {

                    }
                });
            }
        }
    });

    var datatable = $('#tablica').DataTable({
        language: {
            'search': search_trans,
            'lengthMenu': show_trans + ' _MENU_ '+ files_per_page_trans,
            "info": showing_trans + " _START_ " + to_trans + " _END_ " + of_trans + " _TOTAL_ " + entries_trans,
            'paginate': {
                'next': next_trans,
                'previous': previous_trans
            }
        },
        pageLength: 10,
        data: files,
        columns: [
            {title: "ID"},
            {title: category_trans, orderable: false},
            {title: name_trans},
            {
                title: options_trans,
                render: function (data, type, row, meta) {
                    var viewBtn = ' <a href="' + readFile + '/' + row[0] + '" class="confirm-alert m-r-md" data-toggle="tooltip" data-placement="top" data-delay="100" title="' + view_file_trans +'">\n' +
                        '                        <i style="font-size:16px;vertical-align: middle;" class="icon-eye"></i>\n' +
                        '                    </a>';

                    var deleteBtn = '<a href="#" class="confirm-alert m-r-md delete-file" data-id="' + row[0] + '" data-toggle="tooltip" data-delay="100" title="' + delete_file_trans +'">\n' +
                        '                        <i style="font-size:17.5px;color:red;vertical-align: middle;" class="icon-trash-o"></i>\n' +
                        '                    </a>';

                    var shareFileBtn = '<a href="#" class="confirm-alert m-r-md share-file" data-id="' + row[0] + '" data-toggle="tooltip" data-delay="100" title="' + send_the_file_via_email_trans +'">\n' +
                        '                        <i style="font-size:16.5px;vertical-align: middle;color:#17a2b8;" class="icon-envelope-o"></i>\n' +
                        '                    </a>';

                    var moveFileBtn = '<a href="#" class="confirm-alert move-file" data-id="' + row[0] + '" data-kategorija="' + row[1] + '" data-ime="' + row[2] + '" data-toggle="tooltip" data-delay="100" title="' + move_file_to_another_category_trans +'">\n' +
                        '                        <i style="font-size:16.5px;vertical-align: middle; color:#28a745;" class="icon-files-o"></i>\n' +
                        '                    </a>';

                    return viewBtn + deleteBtn + shareFileBtn + moveFileBtn;
                },
                orderable: false
            },
        ],
        columnDefs: [
            {
                data: null,
                targets: -1,
                class: 'text-center'
            }
        ],
        drawCallback: function (settings) {
            $(".dataTables_filter input").addClass("form-control");
            $(".dataTables_paginate a").addClass('btn btn-primary');
            $("#tablica th").css('background','#A2D9F7');
            $("#tablica_filter label").addClass('table-search');
            $("#tablica_filter input").attr('placeholder', search_by_id_or_name_trans);
            $(".delete-file").on( "click", function() {
                var id = $(this).data("id");
                intranetVue.deleteFile(id);
            });
            $(".move-file").on( "click", function() {
                var id = $(this).data("id");
                var kategorija = $(this).data("kategorija");
                var ime = $(this).data("ime");
                intranetVue.moveFile(id, kategorija, ime);
            });
            $(".share-file").on("click",function () {
                var file_id = $(this).data('id');
                intranetVue.shareFile(file_id);
            })
        }
    });
});
