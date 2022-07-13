<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Documents;
use App\Models\Comments;
use App\Http\Requests\CommentRequest;
use League\CommonMark\Node\Block\Document;

class CommentsController extends Controller
{
    //
    public function store(Documents $document, CommentRequest $request, $referenceNo)
    {
        $data = $request->validated();
        $comment = new Comments;

        $temp = Documents::where('referenceNo', $referenceNo)->pluck('id')->first();

        $comment->documents_id = $temp;
        $comment->author = $data['author'];
        $comment->text = $data['text'];
        $comment->save();

        return redirect()->back();
    }
}
