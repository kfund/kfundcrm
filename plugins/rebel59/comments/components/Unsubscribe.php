<?php namespace Rebel59\Comments\Components;

use Cms\Classes\ComponentBase;
use Flash;
use Crypt;
use Rebel59\Comments\Models\Comment;

class Unsubscribe extends ComponentBase
{
    public function componentDetails()
    {
        return [
            'name'        => 'rebel59.comments::lang.components.unsubscribe.title',
            'description' => 'rebel59.comments::lang.components.unsubscribe.description'
        ];
    }

    public function defineProperties()
    {
        return [
            'token' => [
                'title'       => 'rebel59.comments::lang.components.unsubscribe.properties.token.title',
                'description' => 'rebel59.comments::lang.components.unsubscribe.properties.token.description',
                'default'     => '{{ :token }}',
                'type'        => 'string'
            ]
        ];
    }

    public function onRun(){
        $this->unsubscribeUser();
    }

    /**
     * Decrypts token and uses this to disable email notifications for this comment.
     */
    protected function unsubscribeUser(){

        if($token = $this->param('token')){

            $id = Crypt::decrypt($token);

            if($comment = Comment::find($id)) {

                $comment->notify = false;

                if ($comment = $comment->save()) {
                    Flash::success('Email notifications for this thread have succesfully been turned off.');
                }
            }else{
                Flash::error('This comment no longer exists.');
            }

        }else{
            Flash::error('Invalid token supplied.');
        }
    }

}
