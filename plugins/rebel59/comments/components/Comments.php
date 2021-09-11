<?php namespace Rebel59\Comments\Components;

use Cms\Classes\ComponentBase;
use Crypt;
use Rebel59\Comments\Models\Comment;
use Mail;
use Auth;
use Input;
use Cms\Classes\Page;
use Cms\Classes\Router;
use Cms\Classes\Theme;
use Rebel59\Comments\Models\Settings;

class Comments extends ComponentBase
{
    /**
     * Thee basefilename of the page that the component is located at.
     * @var string
     */
    public $pageName;

    /**
     * When creating or updating comments, the model to use.
     * @var Model
     */
    public $comment;

    /**
     * The collection of comments.
     * @var Collection
     */
    public $comments;

    /**
     * The html identifier that contains the comments.
     * @var String
     */
    public $htmlId;

    /**
     * The identifier of the parent to which a comment belongs.
     * @var String
     */
    public $parentId;

    /**
     * The identifier that determines if newly added comments should be prepended or appended to $htmlId.
     * @var String
     */
    public $location;

    public function componentDetails()
    {
        return [
            'name'        => 'rebel59.comments::lang.components.comments.title',
            'description' => 'rebel59.comments::lang.components.comments.description'
        ];
    }

    public function defineProperties()
    {
        return [
            'loadCss' => [
                'title'         => 'rebel59.comments::lang.components.comments.properties.loadCss.title',
                'description'   => 'rebel59.comments::lang.components.comments.properties.loadCss.description',
                'type'          => 'checkbox',
                'default'       => true,
                'group'         => 'rebel59.comments::lang.components.comments.properties.groups.assets'
            ],
            'loadJs' => [
                'title'         => 'rebel59.comments::lang.components.comments.properties.loadJs.title',
                'description'   => 'rebel59.comments::lang.components.comments.properties.loadJs.description',
                'type'          => 'checkbox',
                'default'       => true,
                'group'         => 'rebel59.comments::lang.components.comments.properties.groups.assets'
            ],
            'disableComments' => [
                'title'         => 'rebel59.comments::lang.components.comments.properties.disableComments.title',
                'description'   => 'rebel59.comments::lang.components.comments.properties.disableComments.description',
                'type'          => 'checkbox',
                'default'       => false,
                'group'         => 'rebel59.comments::lang.components.comments.properties.groups.disableComments'
            ],
            'disableGuestComments' => [
                'title'         => 'rebel59.comments::lang.components.comments.properties.disableGuestComments.title',
                'description'   => 'rebel59.comments::lang.components.comments.properties.disableGuestComments.description',
                'type'          => 'checkbox',
                'default'       => false,
                'group'         => 'rebel59.comments::lang.components.comments.properties.groups.disableComments'
            ],
            'registerPage' => [
                'title'         => 'rebel59.comments::lang.components.comments.properties.registerPage.title',
                'description'   => 'rebel59.comments::lang.components.comments.properties.registerPage.description',
                'type'          => 'dropdown',
                'group'         => 'rebel59.comments::lang.components.comments.properties.groups.disableComments'
            ],
            'listElement' => [
                'title'         => 'rebel59.comments::lang.components.comments.properties.listElement.title',
                'description'   => 'rebel59.comments::lang.components.comments.properties.listElement.description',
                'type'          => 'string',
                'default'       => '#comment-list',
                'group'         => 'rebel59.comments::lang.components.comments.properties.groups.sorting'
            ],
            'location' => [
                'title'         => 'rebel59.comments::lang.components.comments.properties.location.title',
                'description'   => 'rebel59.comments::lang.components.comments.properties.location.description',
                'type'          => 'dropdown',
                'options'       => [
                    '@' => 'rebel59.comments::lang.components.comments.properties.location.underComments',
                    '^' => 'rebel59.comments::lang.components.comments.properties.location.aboveComments'
                ],
                'group'         => 'rebel59.comments::lang.components.comments.properties.groups.sorting'
            ],
            'commentsPerPage' => [
                'title'             => 'rebel59.comments::lang.components.comments.properties.commentsPerPage.title',
                'description'       => 'rebel59.comments::lang.components.comments.properties.commentsPerPage.description',
                'type'              => 'string',
                'default'              => '10',
                'validationPattern' => '^[0-9]+$',
                'validationMessage' => 'rebel59.comments::lang.components.comments.properties.commentsPerPage.validation',
                'group'             => 'rebel59.comments::lang.components.comments.properties.groups.sorting'
            ],
            'pageNumber' => [
                'title'       => 'rebel59.comments::lang.components.comments.properties.pageNumber.title',
                'description' => 'rebel59.comments::lang.components.comments.properties.pageNumber.description',
                'type'        => 'string',
                'default'     => '{{ :page }}',
                'group'       => 'rebel59.comments::lang.components.comments.properties.groups.sorting'
            ],
            'unsubscribePage' => [
                'title'         => 'rebel59.comments::lang.components.comments.properties.unsubscribePage.title',
                'description'   => 'rebel59.comments::lang.components.comments.properties.unsubscribePage.description',
                'type'          => 'dropdown',
                'group'         => 'rebel59.comments::lang.components.comments.properties.groups.unsubscribe'
            ],
            'externalRelation' => [
                'title'         => 'rebel59.comments::lang.components.comments.properties.externalRelation.title',
                'description'   => 'rebel59.comments::lang.components.comments.properties.externalRelation.description',
                'type'          => 'dropdown',
                'placeholder'   => 'none',
                'group'         => 'rebel59.comments::lang.components.comments.properties.groups.relations'
            ],
            'externalRelationParam' => [
                'title'         => 'rebel59.comments::lang.components.comments.properties.externalRelationParam.title',
                'description'   => 'rebel59.comments::lang.components.comments.properties.externalRelationParam.description',
                'type'          => 'string',
                'default'       => 'slug',
                'group'         => 'rebel59.comments::lang.components.comments.properties.groups.relations'
            ],

        ];
    }

    public function getRegisterPageOptions()
    {
        return Page::sortBy('baseFileName')->lists('baseFileName', 'baseFileName');
    }

    public function getExternalRelationOptions(){
        if($relations = Settings::get('relations')){
            $options = [];
            foreach($relations as $relation){
                $options[$relation['model']] = $relation['plugin'];
            }
            return $options;
        }


        return [];
    }

    public function getUnsubscribePageOptions()
    {
        return Page::sortBy('baseFileName')->lists('baseFileName', 'baseFileName');
    }

    public function onRender(){
        $this->loadAssets();
        $this->prepareVars();
    }

    protected function loadAssets(){
        if($this->property('loadCss')){
            $this->addCss('assets/css/rebel59.comments.css');
        }

        if($this->property('loadJs')){
            $this->addJs('assets/js/rebel59.comments.js');
        }
    }

    protected function prepareVars(){
        $this->pageName = $this->page->baseFileName;
        $this->comments = $this->page['comments'] = $this->loadComments();
        $this->pageParam = $this->page['pageParam'] = $this->paramName('pageNumber');

        $this->disableComments = $this->page['disableComments'] = $this->property('disableComments');

        $this->disableGuestComments = $this->page['disableGuestComments'] = $this->property('disableGuestComments');
        $this->registerPage = $this->page['registerPage'] = $this->property('registerPage');


    }

    protected function loadComments(){

        $comments = Comment::listFrondEnd([
            'page'  =>  $this->property('pageNumber'),
            'perPage'  =>  $this->property('commentsPerPage'),
            'pageName' => $this->pageName,
            'relationType' => $this->property('externalRelation'),
            'relationParam' => $this->param($this->property('externalRelationParam')),
            'modelSlug' => $this->property('externalRelationParam'),
        ]);
        return $comments;
    }

    /**
     * Retrieves data from the AJAX request when a new comment is saved.
     * Checks are in place to determine whether a comment is a reply and if the parent
     * user is subscribed to receive notifications.
     *
     * @return array
     */
    public function onStoreComment(){
        $this->pageName = $this->page->baseFileName;

        $this->location = $this->property('location');
        $this->htmlId = $this->property('listElement');

        $this->comment = new Comment([
            'content' => Input::get('content'),
            'notify' => Input::get('notify'),
            'page_name' => $this->pageName
        ]);

        if($user = Auth::getUser()){
            $this->comment->user_id = $user->id;
            $this->comment->author_name = $user->name . ' ' . $user->surname;
            $this->comment->author_email = $user->email;
        }else {
            $this->comment->user_id = 0;
            $this->comment->author_name = Input::get('author_name');
            $this->comment->author_email = Input::get('author_email');
        }

        $this->comment->save();

        $this->checkParent();

        $this->comment = $this->checkExternalRelation($this->comment);

        $this->page['comment'] = $this->comment;
        $this->page['auth'] = Auth::check();

        return [
            $this->location.$this->htmlId => $this->renderPartial('::comment.htm'),
        ];
    }

    /**
     * Checks whether the comment has a parent and sets the comment as a child of
     * of that parent with NestedTree's makeChildOf() method.
     */
    protected function checkParent(){
        if($this->parentId = Input::get('parent_id')){

            $this->htmlId = '#comment-' . $this->parentId . '>.reply-form';
            $this->location = '';

            $this->page['reply'] = true;

            if(! $parent = Comment::find($this->parentId)){
                return;
            }

            $this->comment->makeChildOf($this->parentId);

            if($parent->notify){
                $this->notifyParent($parent);
            }

        }
    }

    /**
     * Retrieves the comment's ($parent) author details to send an email notification to
     * the user. An unsubscribe link gets sent along with the encrypted comment id to disable
     * reply notifications for that comment.
     *
     * @param Comment $parent
     */
    protected function notifyParent($parent){
        if($parent->user) {
            $email = $parent->user->email;
            $name = $parent->user->name . " " . $parent->user->surname;
        }else{
            $email = $parent->author_email;
            $name = $parent->author_name;
        }

        $site = $this->pageUrl($this->property('unsubscribePage'), ['token' => Crypt::encrypt($parent->id)]);

        $data = [
            'site' => $site,
            'name' => $parent->author_name,
            'comment' => $this->comment,
            'url' => $_SERVER['HTTP_HOST'] . '/' . $this->getRouter()->getUrl()
        ];

        if(isset($email) && isset($name)){
            Mail::send('rebel59.comments::notifications.reply', $data, function ($message) use ($email, $name) {
                $message->to($email, $name);
            });
        }
    }

    /**
     * Uses the externalRelation property to determine if the comment should be attached to
     * an external model. This relation can then be retrieved by accessing the "comments"
     * relation for the given model.
     *
     * If no external model is defined, the comment model is returned without change.
     *
     * @param Comment $comment
     * @return Comment $comment
     */
    protected function checkExternalRelation($comment){

        if($this->property('externalRelation')){

            $type = $this->property('externalRelation');
            $param = $this->property('externalRelationParam');

            $class = $type::where($param, $this->param($param))->first();

            $comment->attachment_type = $type;
            $comment->attachment_id = $class->id;

            $comment->save();
        }

        return $comment;
    }

    /**
     *
     * Updates an existing comment for authenticated users.chrom
     *
     * @return array|bool
     */
    public function onUpdateComment(){

        $comment = Comment::find(Input::get('comment_id'));

        if(!Auth::check() || Auth::getUser()->id != $comment->user_id){
            return false;
        }

        $comment->update([
           'content' => Input::get('content')
        ]);


        $html = "#comment-" . $comment->id;
        $this->page['comment'] = $comment;
        $this->page['auth'] = Auth::check();

        return [
            $html => $this->renderPartial('::comment.htm'),
        ];
    }

    /**
     * TODO #2:  Find secure way to delete comment without authentication
     *
     * Retrieves and deletes the comment if the comment has no children.
     *
     * @return array|bool
     */
    public function onDeleteComment(){

        if($comment = Comment::find(Input::get('comment_id'))){
            // Comments with children can not be deleted
            if($comment->getChildCount() > 0){
                return false;
            }

            // Checks if comment also belongs to the Authenticated user
            if($comment->user_id != 0 && Auth::getUser()->id != $comment->user_id){
                return false;
            }

            $html = '#comment-' . $comment->id;
            $comment->delete();

            return [
                $html => $this->renderPartial('::delete.htm'),
            ];
        }
    }

    /**
     * Retrieves input data from AJAX request and appends the reply.htm partial
     * to the parent comment.
     *
     * @return array
     */
    public function onCreateReply(){
        $htmltag = "@#comment-" . Input::get('parent_id');
        $this->page['parent_id'] = Input::get('parent_id');
        $this->page['auth'] = Auth::check();
        return [
            $htmltag => $this->renderPartial('::reply.htm'),
        ];
    }
}
