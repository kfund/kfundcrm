<?php namespace Rebel59\Comments\Models;

use Model;
use Auth;
use Html;
use Markdown;

/**
 * Comment Model
 */
class Comment extends Model
{
    use \October\Rain\Database\Traits\Validation;
    use \October\Rain\Database\Traits\NestedTree;


    /**
     * @var string The database table used by the model.
     */
    public $table = 'rebel59_comments_comments';

    /**
     * @var array The rules that the model is validated by.
     */
    public $rules = [
        'content' => 'required',
        'author_name' => 'required',
        'author_email' => 'required',
    ];

    public $fillable = [
        'content',
        'user_id',
        'author_email',
        'author_name',
        'notify',
        'page_name'
    ];

    public function scopeListFrondEnd($query, $options){
        extract(array_merge([
            'page'      => '1',
            'perPage'   => '10',
            'pageName'       => null,
            'relationType' => null,
            'relationParam' => null,
            'modelSlug' => null,
            'sortOrder' => null,
        ], $options));

        /*
         *  Load comments based on external relation (if available) or URL.
         */
        if($relationType && $relationParam && $modelSlug){

            $relationModel = $relationType::where($modelSlug, $relationParam)->first();
            $query->where('attachment_type', $relationType)
                ->where('attachment_id', $relationModel->id);
        }else{
            $query->where('page_name', $pageName);
        }

        $query->where('parent_id', null);

        return $query->paginate($perPage, $page);
    }
}
