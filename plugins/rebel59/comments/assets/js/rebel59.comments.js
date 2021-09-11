+function ($) {

    CommentManager = function () {

        // Init
        this.init()
    }

    CommentManager.prototype.init = function() {
        var self = this

        /*
         * Bind validation handlers
         */
        $(window).on('ajaxInvalidField', function(event, fieldElement, fieldName, errorMsg, isFirst) {
            $(fieldElement).closest('.form-group').addClass('has-warning');
        });

        $(document).on('ajaxPromise', '[data-request]', function() {
            $(this).closest('form').find('.form-group.has-warning').removeClass('has-warning');
        });

        $('form').on('ajaxSuccess', function(ev, context, data, status, jqXHR) {
            self.clearFields();
        });

        $('[data-action="edit"]').on('click', function(event) {
            event.preventDefault();
            var id = $(this).data('comment-id');
            self.editComment(id);
        });

        $('[data-action="cancel"]').on('click', function(event) {
            event.preventDefault();
            var id = $(this).data('comment-id');
            self.restoreComment(id);
        });
    }

    CommentManager.prototype.clearFields = function() {
        $('form').trigger("reset");
    }

    CommentManager.prototype.editComment = function(id) {
        $comment = $('#comment-'+id);
        $comment.find('.comment').first().addClass('edit');

        var content = $comment.find('.comment-content').first().html();

        content = content.replace(/<br\s*[\/]?>/gi, '');

        var textarea = $('<textarea name="content" class="form-control" rows="3"></textarea>');

        textarea.html(content);
        $comment.find('.comment-content').first().html(textarea);

        $comment.find('[data-action="save"]').first().on('click', function(event){
            event.preventDefault();
            content = $comment.find('[name=content]').first().val();
            $.oc.commentmanager.saveComment(id, content);
        });

    }

    CommentManager.prototype.restoreComment = function(id) {
        $comment = $('#comment-'+id);

        var content = $comment.find('textarea').first().val();

        content = content.replace(/(?:\r\n|\r|\n)/g, '<br />');

        $comment.find('.comment-content').first().html(content);
        $comment.find('.edit').first().removeClass('edit');

    }


    CommentManager.prototype.saveComment = function(id, html) {

        $.request('onUpdateComment', {
            data: {comment_id : id, content: html}
        })

        $comment = $('#comment-'+id);
        $comment.find('.edit').first().removeClass('edit');

    }

    CommentManager.prototype.cancelReply = function(id) {
        $('[data-reply-to="'+id+'"]').remove();
        $('#comment-'+id+' [data-action="reply"]').show();
    }

    $(document).ready(function(){
        $.oc.commentmanager = new CommentManager;
    })

}(window.jQuery);


