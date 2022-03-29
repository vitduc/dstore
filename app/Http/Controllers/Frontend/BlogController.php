<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\ArticleModel;
use App\Models\CommentModel;
use App\Models\ContactModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use Illuminate\Support\Facades\Validator;


class BlogController extends Controller
{
    public function blog()
    {
        $data = ArticleModel::orderBy('created_at', 'DESC')->paginate(12);
        $blog_new = ArticleModel::orderByDesc('created_at')
            ->take(4)
            ->get();
        return view('frontend.modules.blog', compact('data', 'blog_new'));
    }

    public function blog_detail($id)
    {
        $data = ArticleModel::find($id);
        $id_cmt = $data->id;
        $data_cmt =  DB::table('blog as b')
            ->join('comment as c', 'b.id', '=', 'c.id_blog')
            ->where('c.id_blog', $id_cmt)
            ->select([
                'c.name',
                'c.comment',
                'c.created_at',
            ])
            ->get();

        $blog_new = ArticleModel::orderByDesc('created_at')
            ->take(4)
            ->get();
        return view('frontend.modules.blog-detail', compact('data', 'data_cmt', 'blog_new'));
    }

    public function store_cmt(Request $request)
    {
        $validator = Validator::make($request->all(),
            [
                'comment' => 'required'
            ],
            [
                'comment.required' => '*Hãy nhập nội dung bình luận*'
            ]);
        $name = $request->has('name') ? $request->name : "";
        $comment = $request->has('comment') ? $request->comment : "";
        $id_blog = $request->has('id_blog') ? $request->id_blog : "";
        if($validator->fails()){
            return response()->json(['error'=>$validator->errors()->first()]);
        }
        $cmt = CommentModel::create([
            'name' => $name,
            'comment' => $comment,
            'id_blog' => $id_blog
        ]);
        $comments = CommentModel::where('id_blog', $id_blog)->get();
        return view('frontend.modules.list-cmt', compact('comments'));
        
    }


    public function contact()
    {
        return view('frontend.modules.contact');
    }

    public function store_contact(Request $request)
    {
        $this->validate(
            $request,
            [
                'name' => 'required',
                'email' => 'required',
                'phone' => 'required',
                'content' => 'required'
            ],
            [
                'name.required' => 'Bạn chưa nhập tên!',
                'email.required' => 'Bạn chưa nhập email!',
                'phone.required' => 'Bạn chưa nhập số điện thoại!',
                'content.required' => 'Bạn chưa nhập nội dung!'
            ]
        );
        $message = "";
        $type_alert = "";
        $name = $request->has('name') ? $request->name : "";
        $email = $request->has('email') ? $request->email : "";
        $phone = $request->has('phone') ? $request->phone : "";
        $content = $request->has('content') ? $request->content : "";


        $article = ContactModel::create([
            'name' => $name,
            'email' => $email,
            'phone' => $phone,
            'content' => $content
        ]);
        if ($article) {
            $message = "Bạn đã gửi liên hệ thành công";
            $type_alert = "success";
        } else {
            $message = "Lỗi";
            $type_alert = "error";
        }

        return redirect()->route('contact')
            ->with('message', $message)
            ->with('type_alert', $type_alert);
    }
}
